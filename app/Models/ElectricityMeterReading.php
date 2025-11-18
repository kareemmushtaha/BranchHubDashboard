<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectricityMeterReading extends Model
{
    protected $fillable = [
        'morning_reading',
        'afternoon_reading',
        'evening_reading',
        'user_id'
    ];

    protected $casts = [
        'morning_reading' => 'decimal:2',
        'afternoon_reading' => 'decimal:2',
        'evening_reading' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that created the reading.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
