<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Session extends Model
{
    use SoftDeletes, Auditable;
    
    protected $table = 'user_sessions';
    
    protected $fillable = [
        'start_at',
        'end_at',
        'expected_end_date',
        'session_status',
        'session_category',
        'user_id',
        'created_by',
        'note',
        'note_updated_by',
        'session_owner',
        'custom_internet_cost',
        'custom_overtime_rate'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'expected_end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function noteUpdater()
    {
        return $this->belongsTo(User::class, 'note_updated_by');
    }

    public function payment()
    {
        return $this->hasOne(SessionPayment::class);
    }

    public function drinks()
    {
        return $this->hasMany(SessionDrink::class);
    }

    public function overtimes()
    {
        return $this->hasMany(SessionOvertime::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(SessionAuditLog::class);
    }

    /**
     * إنشاء مدفوعة تلقائياً إذا لم تكن موجودة
     */
    public function ensurePaymentExists()
    {
        if (!$this->payment) {
            $this->payment()->create([
                'total_price' => 0,
                'amount_bank' => 0,
                'amount_cash' => 0,
                'payment_status' => 'pending',
                'remaining_amount' => 0
            ]);
            
            // إعادة تحميل العلاقة
            $this->load('payment');
            
            \Log::info('Created payment for session', [
                'session_id' => $this->id,
                'payment_id' => $this->payment->id
            ]);
        }
        
        return $this->payment;
    }

    /**
     * تنسيق المدة بالدقائق والساعات والثواني
     */
    public function formatDuration($endTime = null)
    {
        $endTime = $endTime ?? now();
        $duration = $this->start_at->diff($endTime);
        
        $parts = [];
        
        if ($duration->days > 0) {
            $parts[] = $duration->days . ' يوم';
        }
        
        if ($duration->h > 0) {
            $parts[] = $duration->h . ' ساعة';
        }
        
        if ($duration->i > 0) {
            $parts[] = $duration->i . ' دقيقة';
        }
        
        if ($duration->s > 0 && count($parts) == 0) {
            $parts[] = $duration->s . ' ثانية';
        }
        
        // إذا لم تكن هناك أجزاء، اعرض "أقل من دقيقة"
        if (empty($parts)) {
            return 'أقل من دقيقة';
        }
        
        return implode(' و ', $parts);
    }

    /**
     * حساب تكلفة الإنترنت للجلسة
     */
    public function calculateInternetCost()
    {
        // إذا كانت هناك تكلفة مخصصة، استخدمها
        if ($this->custom_internet_cost !== null) {
            return $this->custom_internet_cost;
        }

        // حساب التكلفة تلقائياً بناءً على الوقت الفعلي
        $publicPrices = \App\Models\PublicPrice::first();
        $startTime = $this->start_at;
        
        // تحديد وقت الانتهاء: إما وقت الانتهاء الفعلي أو الوقت الحالي
        $endTime = $this->end_at ?? now();
        
        // حساب المدة بالدقائق ثم تحويلها إلى ساعات
        $durationInMinutes = $startTime->diffInMinutes($endTime);
        $durationInHours = $durationInMinutes / 60;
        
        // التأكد من أن المدة لا تقل عن دقيقة واحدة
        if ($durationInMinutes < 1) {
            $durationInMinutes = 1;
            $durationInHours = 1/60;
        }
        
        switch ($this->session_category) {
            case 'hourly':
                $rate = $publicPrices->hourly_rate ?? 5.00;
                $cost = $durationInHours * $rate;
                return round($cost, 2);
            case 'overtime':
                $hour = $startTime->hour;
                $isNight = $hour >= 18 || $hour <= 6;
                $rate = $isNight ? ($publicPrices->price_overtime_night ?? 7.00) : ($publicPrices->price_overtime_morning ?? 5.00);
                $cost = $durationInHours * $rate;
                return round($cost, 2);
            case 'subscription':
                return 0;
            default:
                return 0;
        }
    }

    /**
     * التحقق من وجود تكلفة مخصصة
     */
    public function hasCustomInternetCost()
    {
        return $this->custom_internet_cost !== null;
    }

    /**
     * تحديث تاريخ بداية الجلسة وإعادة حساب التكلفة
     */
    public function updateStartTime($newStartTime)
    {
        $oldStartTime = $this->start_at;
        
        \Log::info('Starting updateStartTime method', [
            'session_id' => $this->id,
            'old_start_time' => $oldStartTime,
            'new_start_time_input' => $newStartTime
        ]);
        
        // التأكد من أن $newStartTime هو كائن Carbon
        if (!$newStartTime instanceof \Carbon\Carbon) {
            $newStartTime = \Carbon\Carbon::parse($newStartTime);
        }
        
        \Log::info('Parsed new start time', [
            'session_id' => $this->id,
            'parsed_new_start_time' => $newStartTime
        ]);
        
        // تحديث تاريخ البداية
        $this->start_at = $newStartTime;
        $result = $this->save();
        
        \Log::info('Save result', [
            'session_id' => $this->id,
            'save_result' => $result,
            'current_start_at' => $this->start_at
        ]);
        
        // إعادة تحميل النموذج للتأكد من حفظ التغييرات
        $this->refresh();
        
        \Log::info('After refresh', [
            'session_id' => $this->id,
            'refreshed_start_at' => $this->start_at
        ]);
        
        // إذا لم تكن هناك تكلفة مخصصة، أعد حساب التكلفة
        if (!$this->hasCustomInternetCost()) {
            $newInternetCost = $this->calculateInternetCost();
            
            \Log::info('Recalculated internet cost', [
                'session_id' => $this->id,
                'new_internet_cost' => $newInternetCost
            ]);
            
            // تحديث تكلفة الإنترنت في الدفعة المرتبطة
            if ($this->payment) {
                $this->load('overtimes');
                $drinksCost = $this->drinks->sum('price');
                $overtimeCost = $this->calculateOvertimeCost();
                $totalCost = $newInternetCost + $drinksCost + $overtimeCost;
                $totalPaid = $this->payment->amount_bank + $this->payment->amount_cash;
                $remainingAmount = max(0, $totalCost - $totalPaid);
                
                // تحديث حالة الدفع بناءً على المبالغ المدفوعة
                $paymentStatus = 'pending';
                if ($totalPaid >= $totalCost) {
                    $paymentStatus = 'paid';
                    $remainingAmount = 0;
                } elseif ($totalPaid > 0) {
                    $paymentStatus = 'partial';
                }
                
                $this->payment->update([
                    'total_price' => $totalCost,
                    'payment_status' => $paymentStatus,
                    'remaining_amount' => $remainingAmount
                ]);
                
                \Log::info('Updated payment in Session model', [
                    'session_id' => $this->id,
                    'payment_id' => $this->payment->id,
                    'new_internet_cost' => $newInternetCost,
                    'drinks_cost' => $drinksCost,
                    'new_total_price' => $totalCost,
                    'remaining_amount' => $remainingAmount
                ]);
            }
        }
        
        // تسجيل التغيير في سجل التدقيق
        try {
            $this->auditLogs()->create([
                'action' => 'start_time_updated',
                'action_type' => 'session',
                'old_values' => ['start_at' => $oldStartTime ? $oldStartTime->format('Y-m-d H:i:s') : null],
                'new_values' => ['start_at' => $newStartTime->format('Y-m-d H:i:s')],
                'description' => 'تم تحديث تاريخ بداية الجلسة',
                'user_id' => auth()->id()
            ]);
            
            \Log::info('Created audit log successfully', [
                'session_id' => $this->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating audit log for start time update', [
                'session_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return $this;
    }

    /**
     * حساب إجمالي تكلفة الإنترنت لجميع الجلسات
     */
    public static function getTotalInternetRevenue()
    {
        return self::sum(\DB::raw('CASE 
            WHEN custom_internet_cost IS NOT NULL THEN custom_internet_cost 
            ELSE (
                CASE 
                    WHEN session_category = "hourly" THEN 
                        TIMESTAMPDIFF(MINUTE, start_at, COALESCE(end_at, NOW())) / 60.0 * (SELECT hourly_rate FROM public_prices LIMIT 1)
                    WHEN session_category = "overtime" THEN 
                        TIMESTAMPDIFF(MINUTE, start_at, COALESCE(end_at, NOW())) / 60.0 * (
                            CASE 
                                WHEN HOUR(start_at) >= 18 OR HOUR(start_at) <= 6 THEN (SELECT price_overtime_night FROM public_prices LIMIT 1)
                                ELSE (SELECT price_overtime_morning FROM public_prices LIMIT 1)
                            END
                        )
                    ELSE 0
                END
            )
        END'));
    }

    /**
     * الحصول على إحصائيات المشروبات للجلسة
     */
    public function getDrinksStats()
    {
        $totalDrinks = $this->drinks->count();
        $totalCost = $this->drinks->sum('price');
        
        return [
            'total_count' => $totalDrinks,
            'total_cost' => $totalCost
        ];
    }

    /**
     * الحصول على التاريخ المتوقع للانتهاء
     */
    public function getExpectedEndDate()
    {
        // إذا كانت الجلسة منتهية بالفعل، ارجع وقت الانتهاء الفعلي
        if ($this->end_at) {
            return $this->end_at;
        }

        // إذا كان هناك تاريخ متوقع محدد يدوياً، استخدمه
        if ($this->expected_end_date) {
            return $this->expected_end_date;
        }

        switch ($this->session_category) {
            case 'hourly':
                // الجلسات الساعية تنتهي بعد ساعة واحدة
                return $this->start_at->addHour();
                

                
            case 'subscription':
                // الجلسات الاشتراكية تنتهي بعد 30 يوم
                return $this->start_at->addDays(30);
                
            case 'overtime':
                // الجلسات الإضافية تنتهي بعد 4 ساعات
                return $this->start_at->addHours(4);
                
            default:
                // الجلسات الأخرى تنتهي بعد ساعة واحدة
                return $this->start_at->addHour();
        }
    }

    /**
     * حساب الأيام المتبقية حتى التاريخ المتوقع للانتهاء
     */
    public function getDaysUntilExpectedEnd()
    {
        $expectedEndDate = $this->getExpectedEndDate();
        
        if (!$expectedEndDate) {
            return null;
        }

        $now = now();
        $diffInDays = $now->diffInDays($expectedEndDate, false);
        
        // إذا كان التاريخ المتوقع في الماضي، ارجع قيمة سالبة
        if ($expectedEndDate->isPast()) {
            return -$diffInDays;
        }
        
        return $diffInDays;
    }

    /**
     * التحقق من كون الجلسة متأخرة
     */
    public function isOverdue()
    {
        // إذا كانت الجلسة منتهية بالفعل، فهي ليست متأخرة
        if ($this->end_at) {
            return false;
        }

        $expectedEndDate = $this->getExpectedEndDate();
        
        if (!$expectedEndDate) {
            return false;
        }

        return $expectedEndDate->isPast();
    }

    /**
     * تحديث التاريخ المتوقع للانتهاء
     */
    public function updateExpectedEndDate($expectedEndDate)
    {
        $oldExpectedEndDate = $this->expected_end_date;
        
        // التأكد من أن $expectedEndDate هو كائن Carbon
        if (!$expectedEndDate instanceof \Carbon\Carbon) {
            $expectedEndDate = \Carbon\Carbon::parse($expectedEndDate);
        }
        
        // التأكد من أن التاريخ المتوقع بعد تاريخ البداية
        if ($expectedEndDate <= $this->start_at) {
            throw new \InvalidArgumentException('تاريخ انتهاء الجلسة يجب أن يكون بعد تاريخ البداية');
        }
        
        $this->expected_end_date = $expectedEndDate;
        $this->save();
        
        // تسجيل التغيير في سجل التدقيق
        try {
            $this->auditLogs()->create([
                'action' => 'expected_end_date_updated',
                'action_type' => 'session',
                'old_values' => ['expected_end_date' => $oldExpectedEndDate ? $oldExpectedEndDate->format('Y-m-d H:i:s') : null],
                'new_values' => ['expected_end_date' => $expectedEndDate->format('Y-m-d H:i:s')],
                'description' => 'تم تحديث التاريخ المتوقع لانتهاء الجلسة',
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating audit log for expected end date update', [
                'session_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return $this;
    }

    /**
     * إنهاء الجلسة يدوياً
     */
    public function endSessionManually($endTime = null)
    {
        if ($this->session_status === 'completed') {
            throw new \InvalidArgumentException('الجلسة منتهية بالفعل');
        }
        
        if ($this->session_status === 'cancelled') {
            throw new \InvalidArgumentException('لا يمكن إنهاء جلسة ملغية');
        }
        
        $oldEndTime = $this->end_at;
        
        // تحديد وقت الانتهاء
        if ($endTime) {
            if (!$endTime instanceof \Carbon\Carbon) {
                $endTime = \Carbon\Carbon::parse($endTime);
            }
            
            // التأكد من أن وقت الانتهاء بعد وقت البداية
            if ($endTime <= $this->start_at) {
                throw new \InvalidArgumentException('وقت انتهاء الجلسة يجب أن يكون بعد وقت البداية');
            }
        } else {
            $endTime = now();
        }
        
        $this->end_at = $endTime;
        $this->session_status = 'completed';
        $this->save();
        
        // تسجيل التغيير في سجل التدقيق
        try {
            $this->auditLogs()->create([
                'action' => 'session_ended_manually',
                'action_type' => 'session',
                'old_values' => ['end_at' => $oldEndTime ? $oldEndTime->format('Y-m-d H:i:s') : null],
                'new_values' => ['end_at' => $endTime->format('Y-m-d H:i:s')],
                'description' => 'تم إنهاء الجلسة يدوياً',
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating audit log for manual session end', [
                'session_id' => $this->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return $this;
    }

    /**
     * التحقق من كون الجلسة من نوع اشتراك
     */
    public function isSubscription()
    {
        return $this->session_category === 'subscription';
    }

    /**
     * الحصول على الأيام المتبقية حتى انتهاء الجلسة
     */
    public function getRemainingDays()
    {
        if ($this->end_at) {
            return 0; // الجلسة منتهية
        }
        
        $expectedEndDate = $this->getExpectedEndDate();
        
        if (!$expectedEndDate) {
            return null;
        }
        
        $now = now();
        $diffInDays = $now->diffInDays($expectedEndDate, false);
        
        return max(0, $diffInDays);
    }

    /**
     * حساب تكلفة ساعات العمل الإضافية
     */
    public function calculateOvertimeCost()
    {
        // استخدام cost من كل overtime إذا كان محسوباً
        $totalCost = $this->overtimes->sum('cost');
        
        // إذا كان هناك overtimes بدون cost (بيانات قديمة)، احسبها بالطريقة القديمة
        $overtimesWithoutCost = $this->overtimes->filter(function ($overtime) {
            return $overtime->cost == 0 && $overtime->total_hour > 0;
        });
        
        if ($overtimesWithoutCost->count() > 0) {
            // حساب التكلفة للبيانات القديمة
            $totalHours = $overtimesWithoutCost->sum('total_hour');
            
            // استخدام السعر المخصص إذا كان موجوداً
            if ($this->custom_overtime_rate !== null) {
                $totalCost += round($totalHours * $this->custom_overtime_rate, 2);
            } else {
                // استخدام السعر الافتراضي من PublicPrice
                $publicPrices = \App\Models\PublicPrice::first();
                $defaultRate = $publicPrices->overtime_rate ?? 5.00;
                $totalCost += round($totalHours * $defaultRate, 2);
            }
        }
        
        return round($totalCost, 2);
    }

    /**
     * التحقق من وجود سعر مخصص للـ overtime
     */
    public function hasCustomOvertimeRate()
    {
        return $this->custom_overtime_rate !== null;
    }
}
