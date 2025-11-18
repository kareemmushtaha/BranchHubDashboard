<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSalary extends Model
{
    protected $fillable = [
        'employee_name',
        'salary_date',
        'cash_amount',
        'bank_amount',
        'transfer_type',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'cash_amount' => 'decimal:2',
        'bank_amount' => 'decimal:2',
        'salary_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that created the salary record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transfer type in Arabic.
     */
    public function getTransferTypeArabicAttribute(): string
    {
        return $this->transfer_type === 'full' ? 'راتب كامل' : 'راتب جزئي';
    }

    /**
     * Get the total amount (cash + bank).
     */
    public function getTotalAmountAttribute(): float
    {
        return (float) $this->cash_amount + (float) $this->bank_amount;
    }
}
