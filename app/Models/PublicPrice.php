<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicPrice extends Model
{
    protected $fillable = [
        'price_overtime_morning',
        'price_overtime_night',
        'hourly_rate'
    ];

    protected $casts = [
        'price_overtime_morning' => 'decimal:2',
        'price_overtime_night' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
    ];
}
