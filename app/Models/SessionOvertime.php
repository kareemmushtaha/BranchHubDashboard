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
        'total_hour'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'total_hour' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        // حساب total_hour تلقائياً عند الحفظ
        static::saving(function ($overtime) {
            if ($overtime->start_at && $overtime->end_at) {
                $start = Carbon::parse($overtime->start_at);
                $end = Carbon::parse($overtime->end_at);
                $diffInMinutes = $start->diffInMinutes($end);
                $overtime->total_hour = round($diffInMinutes / 60, 2);
            }
        });
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
