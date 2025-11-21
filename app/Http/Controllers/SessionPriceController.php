<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionPayment;
use App\Models\PublicPrice;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class SessionPriceController extends Controller
{
    /**
     * تحديث تكلفة الإنترنت للجلسة (AJAX)
     */
    public function updateInternetCost(Request $request, Session $session): JsonResponse
    {
        try {
            // تسجيل معلومات الجلسة للتشخيص
            \Log::info('Updating internet cost for session (AJAX)', [
                'session_id' => $session->id,
                'session_category' => $session->session_category,
                'start_time' => $session->start_at->format('Y-m-d H:i:s'),
                'end_time' => $session->end_at ? $session->end_at->format('Y-m-d H:i:s') : 'active',
                'current_time' => now()->format('Y-m-d H:i:s')
            ]);
            
            // حساب التكلفة الجديدة
            $newCost = $session->calculateInternetCost();
            
            // تسجيل التكلفة المحسوبة
            \Log::info('Calculated internet cost', [
                'session_id' => $session->id,
                'calculated_cost' => $newCost,
                'old_custom_cost' => $session->custom_internet_cost
            ]);
            
            // تحديث تكلفة الإنترنت المخصصة
            $session->update([
                'custom_internet_cost' => $newCost
            ]);
            
            // إعادة تحميل الجلسة
            $session->refresh();
            
            // تحديث المدفوعة إذا كانت موجودة
            if ($session->payment) {
                $session->load('overtimes');
                $drinksCost = $session->drinks->sum('price');
                $overtimeCost = $session->calculateOvertimeCost();
                $totalCost = $newCost + $drinksCost + $overtimeCost;
                $totalPaid = $session->payment->amount_bank + $session->payment->amount_cash;
                $remainingAmount = max(0, $totalCost - $totalPaid);
                
                // تحديث حالة الدفع بناءً على المبالغ المدفوعة
                $paymentStatus = 'pending';
                if ($totalPaid >= $totalCost) {
                    $paymentStatus = 'paid';
                    $remainingAmount = 0;
                } elseif ($totalPaid > 0) {
                    $paymentStatus = 'partial';
                }
                
                $session->payment->update([
                    'total_price' => $totalCost,
                    'payment_status' => $paymentStatus,
                    'remaining_amount' => $remainingAmount
                ]);
                
                \Log::info('Updated payment in SessionPriceController AJAX', [
                    'session_id' => $session->id,
                    'payment_id' => $session->payment->id,
                    'new_cost' => $newCost,
                    'drinks_cost' => $drinksCost,
                    'overtime_cost' => $overtimeCost,
                    'total_cost' => $totalCost,
                    'remaining_amount' => $remainingAmount
                ]);
            }
            
            // حساب إجمالي التكلفة
            $totalCost = $this->calculateTotalSessionCost($session);
            
            return response()->json([
                'success' => true,
                'internet_cost' => number_format($newCost, 2),
                'total_cost' => number_format($totalCost, 2),
                'duration' => $this->formatDuration($session),
                'message' => 'تم تحديث تكلفة الإنترنت بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating internet cost', [
                'session_id' => $session->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث التكلفة: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث تكلفة الإنترنت للجلسة (Form Submit)
     */
    public function updateInternetCostForm(Request $request, Session $session)
    {
        try {
            // التحقق من صحة البيانات
            $request->validate([
                'custom_internet_cost' => 'nullable|numeric|min:0'
            ], [
                'custom_internet_cost.numeric' => 'تكلفة الإنترنت يجب أن تكون رقماً',
                'custom_internet_cost.min' => 'تكلفة الإنترنت يجب أن تكون أكبر من أو تساوي صفر'
            ]);

            // تسجيل معلومات الجلسة للتشخيص
            \Log::info('Updating internet cost for session (Form)', [
                'session_id' => $session->id,
                'custom_cost' => $request->custom_internet_cost,
                'session_category' => $session->session_category
            ]);

            // تحديث تكلفة الإنترنت المخصصة
            $customCost = $request->custom_internet_cost !== null && $request->custom_internet_cost !== '' 
                ? floatval($request->custom_internet_cost) 
                : null;

            $session->update([
                'custom_internet_cost' => $customCost
            ]);

            // إعادة تحميل الجلسة
            $session->refresh();

            // تحديث المدفوعة إذا كانت موجودة
            if ($session->payment) {
                $session->load('overtimes');
                $drinksCost = $session->drinks->sum('price');
                $overtimeCost = $session->calculateOvertimeCost();
                $totalCost = $customCost + $drinksCost + $overtimeCost;
                $totalPaid = $session->payment->amount_bank + $session->payment->amount_cash;
                $remainingAmount = max(0, $totalCost - $totalPaid);
                
                // تحديث حالة الدفع بناءً على المبالغ المدفوعة
                $paymentStatus = 'pending';
                if ($totalPaid >= $totalCost) {
                    $paymentStatus = 'paid';
                    $remainingAmount = 0;
                } elseif ($totalPaid > 0) {
                    $paymentStatus = 'partial';
                }
                
                $session->payment->update([
                    'total_price' => $totalCost,
                    'payment_status' => $paymentStatus,
                    'remaining_amount' => $remainingAmount
                ]);
                
                \Log::info('Updated payment in SessionPriceController', [
                    'session_id' => $session->id,
                    'payment_id' => $session->payment->id,
                    'custom_cost' => $customCost,
                    'drinks_cost' => $drinksCost,
                    'overtime_cost' => $overtimeCost,
                    'total_cost' => $totalCost,
                    'remaining_amount' => $remainingAmount
                ]);
            }

            // حساب التكلفة الجديدة للعرض
            $newCost = $session->calculateInternetCost();
            $totalCost = $this->calculateTotalSessionCost($session);

            \Log::info('Internet cost updated successfully', [
                'session_id' => $session->id,
                'new_cost' => $newCost,
                'total_cost' => $totalCost
            ]);

            // إعادة توجيه مع رسالة نجاح
            $message = 'تم تحديث تكلفة الإنترنت بنجاح';
            
            if ($session->isSubscription()) {
                if ($customCost === null) {
                    $message .= ' - الإنترنت مجاني للاشتراك';
                } else {
                    $message .= ' - تكلفة ثابتة: $' . number_format($newCost, 2) . ' طوال فترة الاشتراك';
                }
            } else {
                $message .= ' - التكلفة: $' . number_format($newCost, 2);
            }
            
            return redirect()->route('sessions.show', $session)
                ->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // معالجة أخطاء التحقق من صحة البيانات
            \Log::warning('Validation error updating internet cost', [
                'session_id' => $session->id,
                'errors' => $e->errors()
            ]);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            // معالجة الأخطاء العامة
            \Log::error('Error updating internet cost (Form)', [
                'session_id' => $session->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث التكلفة: ' . $e->getMessage());
        }
    }

    /**
     * الحصول على معلومات الأسعار المحدثة للجلسة
     */
    public function getSessionPricing(Session $session): JsonResponse
    {
        try {
            $session->load('overtimes');
            $internetCost = $session->calculateInternetCost();
            $drinksCost = $session->drinks->sum('price');
            $overtimeCost = $session->calculateOvertimeCost();
            $totalCost = $internetCost + $drinksCost + $overtimeCost;
            
            // معلومات الدفع
            $payment = $session->payment;
            $paidAmount = $payment ? ($payment->amount_cash + $payment->amount_bank) : 0;
            $remainingAmount = $totalCost - $paidAmount;
            
            // معلومات الوقت
            $duration = $this->formatDuration($session);
            $isActive = $session->session_status === 'active';
            
            // معلومات الأسعار الحالية
            $publicPrices = PublicPrice::first();
            
            return response()->json([
                'success' => true,
                'session_id' => $session->id,
                'is_active' => $isActive,
                'pricing' => [
                    'internet_cost' => number_format($internetCost, 2),
                    'drinks_cost' => number_format($drinksCost, 2),
                    'overtime_cost' => number_format($overtimeCost, 2),
                    'total_cost' => number_format($totalCost, 2),
                    'paid_amount' => number_format($paidAmount, 2),
                    'remaining_amount' => number_format($remainingAmount, 2)
                ],
                'duration' => $duration,
                'current_rates' => [
                    'hourly_rate' => number_format($publicPrices->hourly_rate ?? 5.00, 2),
                    'overtime_morning' => number_format($publicPrices->price_overtime_morning ?? 5.00, 2),
                    'overtime_night' => number_format($publicPrices->price_overtime_night ?? 7.00, 2)
                ],
                'session_info' => [
                    'category' => $session->session_category,
                    'start_time' => $session->start_at->format('Y-m-d H:i:s'),
                    'end_time' => $session->end_at ? $session->end_at->format('Y-m-d H:i:s') : null,
                    'status' => $session->session_status,
                    'is_subscription' => $session->isSubscription(),
                    'expected_end_date' => $session->expected_end_date ? $session->expected_end_date->format('Y-m-d H:i:s') : null,
                    'remaining_days' => $session->getRemainingDays()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب معلومات الأسعار: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث جميع الجلسات النشطة
     */
    public function updateAllActiveSessions(): JsonResponse
    {
        try {
            $activeSessions = Session::where('session_status', 'active')->get();
            $updatedCount = 0;
            $totalRevenue = 0;
            
            foreach ($activeSessions as $session) {
                $oldCost = $session->custom_internet_cost ?? 0;
                $newCost = $session->calculateInternetCost();
                
                if ($newCost != $oldCost) {
                    $session->update(['custom_internet_cost' => $newCost]);
                    $session->refresh();
                    
                    // تحديث المدفوعة إذا كانت موجودة
                    if ($session->payment) {
                        $session->load('overtimes');
                        $drinksCost = $session->drinks->sum('price');
                        $overtimeCost = $session->calculateOvertimeCost();
                        $totalCost = $newCost + $drinksCost + $overtimeCost;
                        $totalPaid = $session->payment->amount_bank + $session->payment->amount_cash;
                        $remainingAmount = max(0, $totalCost - $totalPaid);
                        
                        // تحديث حالة الدفع بناءً على المبالغ المدفوعة
                        $paymentStatus = 'pending';
                        if ($totalPaid >= $totalCost) {
                            $paymentStatus = 'paid';
                            $remainingAmount = 0;
                        } elseif ($totalPaid > 0) {
                            $paymentStatus = 'partial';
                        }
                        
                        $session->payment->update([
                            'total_price' => $totalCost,
                            'payment_status' => $paymentStatus,
                            'remaining_amount' => $remainingAmount
                        ]);
                    }
                    
                    $updatedCount++;
                } else {
                    // للجلسات التي لم يتم تحديثها، استخدم القيم الحالية
                    $currentCost = $session->custom_internet_cost ?? $session->calculateInternetCost();
                    if ($session->payment) {
                        $totalRevenue += $session->payment->total_price;
                    } else {
                        $totalRevenue += $currentCost + $session->drinks->sum('price');
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'updated_sessions' => $updatedCount,
                'total_active_sessions' => $activeSessions->count(),
                'estimated_revenue' => number_format($totalRevenue, 2),
                'message' => "تم تحديث {$updatedCount} جلسة نشطة"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الجلسات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على إحصائيات الأسعار في الوقت الفعلي
     */
    public function getRealTimePricingStats(): JsonResponse
    {
        try {
            $activeSessions = Session::where('session_status', 'active')->get();
            $publicPrices = PublicPrice::first();
            
            $stats = [
                'active_sessions' => $activeSessions->count(),
                'total_internet_revenue' => 0,
                'total_drinks_revenue' => 0,
                'total_revenue' => 0,
                'average_session_duration' => 0,
                'current_rates' => [
                    'hourly' => $publicPrices->hourly_rate ?? 5.00,
                    'overtime_morning' => $publicPrices->price_overtime_morning ?? 5.00,
                    'overtime_night' => $publicPrices->price_overtime_night ?? 7.00
                ]
            ];
            
            $totalDuration = 0;
            
            foreach ($activeSessions as $session) {
                $internetCost = $session->calculateInternetCost();
                $drinksCost = $session->drinks->sum('price');
                
                $stats['total_internet_revenue'] += $internetCost;
                $stats['total_drinks_revenue'] += $drinksCost;
                
                // استخدام المدفوعة المحدثة إذا كانت موجودة
                if ($session->payment) {
                    $stats['total_revenue'] += $session->payment->total_price;
                } else {
                    $session->load('overtimes');
                    $overtimeCost = $session->calculateOvertimeCost();
                    $stats['total_revenue'] += $internetCost + $drinksCost + $overtimeCost;
                }
                
                $duration = $session->start_at->diffInMinutes(now());
                $totalDuration += $duration;
            }
            
            if ($activeSessions->count() > 0) {
                $stats['average_session_duration'] = round($totalDuration / $activeSessions->count(), 2);
            }
            
            // تنسيق الأرقام
            $stats['total_internet_revenue'] = number_format($stats['total_internet_revenue'], 2);
            $stats['total_drinks_revenue'] = number_format($stats['total_drinks_revenue'], 2);
            $stats['total_revenue'] = number_format($stats['total_revenue'], 2);
            
            return response()->json([
                'success' => true,
                'stats' => $stats,
                'last_updated' => now()->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب الإحصائيات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حساب إجمالي تكلفة الجلسة
     */
    private function calculateTotalSessionCost(Session $session): float
    {
        $session->load('overtimes');
        $internetCost = $session->calculateInternetCost();
        $drinksCost = $session->drinks->sum('price');
        $overtimeCost = $session->calculateOvertimeCost();
        return $internetCost + $drinksCost + $overtimeCost;
    }

    /**
     * تنسيق مدة الجلسة
     */
    private function formatDuration(Session $session): string
    {
        $startTime = $session->start_at;
        $endTime = $session->end_at ?? now();
        
        $durationInMinutes = $startTime->diffInMinutes($endTime);
        
        // التأكد من أن المدة لا تقل عن دقيقة واحدة
        if ($durationInMinutes < 1) {
            $durationInMinutes = 1;
        }
        
        $hours = intval($durationInMinutes / 60);
        $minutes = $durationInMinutes % 60;
        
        return "{$hours}س {$minutes}د";
    }
} 