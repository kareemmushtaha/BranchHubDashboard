<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'item_name',
        'amount',
        'payment_type',
        'payment_date',
        'details',
        'user_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
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
