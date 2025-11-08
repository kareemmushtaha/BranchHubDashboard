<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class DrinkInvoice extends Model
{
    use Auditable;
    
    protected $fillable = [
        'user_id',
        'total_price',
        'amount_bank',
        'amount_cash',
        'payment_status',
        'remaining_amount',
        'note'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'amount_bank' => 'decimal:2',
        'amount_cash' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(DrinkInvoiceItem::class);
    }

    /**
     * تحديث المبلغ المتبقي
     */
    public function updateRemainingAmount()
    {
        $totalPaid = $this->amount_bank + $this->amount_cash;
        $this->remaining_amount = max(0, $this->total_price - $totalPaid);
        
        // تحديث حالة الدفع
        if ($this->remaining_amount == 0 && $this->total_price > 0) {
            $this->payment_status = 'paid';
        } elseif ($this->remaining_amount > 0 && $totalPaid > 0) {
            $this->payment_status = 'partial';
        } elseif ($totalPaid == 0 && $this->total_price > 0) {
            $this->payment_status = 'pending';
        }
        
        $this->save();
    }

    /**
     * تحديث إجمالي الفاتورة بناءً على العناصر
     */
    public function updateTotal()
    {
        $this->total_price = $this->items()->sum('price');
        $this->updateRemainingAmount();
    }
}
