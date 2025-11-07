<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'payment_method',
        'amount',
        'balance_before',
        'balance_after',
        'notes',
        'reference',
        'admin_name'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get transaction type in Arabic.
     */
    public function getTypeInArabicAttribute(): string
    {
        return match($this->type) {
            'charge' => 'شحن',
            'deduct' => 'خصم',
            'refund' => 'استرداد',
            default => $this->type
        };
    }

    /**
     * Get payment method in Arabic.
     */
    public function getPaymentMethodInArabicAttribute(): string
    {
        return match($this->payment_method) {
            'cash' => 'كاش',
            'bank_transfer' => 'حوالة بنكية',
            default => $this->payment_method
        };
    }
}
