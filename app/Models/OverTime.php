<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OverTime extends Model
{
    protected $fillable = [
        'user_id',
        'start_at',
        'end_at',
        'price',
        'time_type',
        'status_paid'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'price' => 'decimal:2',
        'status_paid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
