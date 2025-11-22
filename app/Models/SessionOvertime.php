<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SessionOvertime extends Model
{
    protected $table = 'session_overtimes';
    
    protected $fillable = [
        'session_id',
        'start_at',
        'end_at',
        'total_hour',
        'hourly_rate',
        'cost',
        'notes'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'total_hour' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'cost' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        // حساب total_hour و cost تلقائياً عند الحفظ
        static::saving(function ($overtime) {
            if ($overtime->start_at && $overtime->end_at) {
                $start = Carbon::parse($overtime->start_at);
                $end = Carbon::parse($overtime->end_at);
                $diffInMinutes = $start->diffInMinutes($end);
                $overtime->total_hour = round($diffInMinutes / 60, 2);
            }

            // حساب cost بناءً على hourly_rate و total_hour
            if ($overtime->total_hour > 0) {
                $rate = $overtime->hourly_rate;
                
                // إذا لم يكن هناك hourly_rate محدد، استخدم السعر التلقائي
                if ($rate === null) {
                    // تحميل session إذا لم يكن محملاً
                    if (!$overtime->relationLoaded('session') && $overtime->session_id) {
                        $overtime->load('session');
                    }
                    
                    if ($overtime->session) {
                        // إذا كان هناك سعر مخصص للجلسة، استخدمه
                        if ($overtime->session->custom_overtime_rate !== null) {
                            $rate = $overtime->session->custom_overtime_rate;
                        } else {
                            // استخدام السعر الافتراضي من PublicPrice
                            $publicPrices = \App\Models\PublicPrice::first();
                            $rate = $publicPrices->overtime_rate ?? 5.00;
                        }
                    } else {
                        // استخدام السعر الافتراضي من PublicPrice
                        $publicPrices = \App\Models\PublicPrice::first();
                        $rate = $publicPrices->overtime_rate ?? 5.00;
                    }
                }
                
                $overtime->cost = round($overtime->total_hour * $rate, 2);
            } else {
                $overtime->cost = 0;
            }
        });
    }

    /**
     * الحصول على السعر التلقائي للجلسة
     */
    public function getDefaultHourlyRate()
    {
        // إذا كان هناك سعر مخصص للجلسة، استخدمه
        if ($this->session && $this->session->custom_overtime_rate !== null) {
            return $this->session->custom_overtime_rate;
        }

        // استخدام السعر الافتراضي من PublicPrice
        $publicPrices = \App\Models\PublicPrice::first();
        return $publicPrices->overtime_rate ?? 5.00;
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
