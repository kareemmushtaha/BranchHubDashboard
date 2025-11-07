<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'amount',
        'payment_type',
        'details',
        'user_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the expense.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment type in Arabic.
     */
    public function getPaymentTypeArabicAttribute(): string
    {
        return $this->payment_type === 'bank' ? 'بنكي' : 'نقدي';
    }
}
