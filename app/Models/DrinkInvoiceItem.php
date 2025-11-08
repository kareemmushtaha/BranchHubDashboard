<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class DrinkInvoiceItem extends Model
{
    use Auditable;
    
    protected $fillable = [
        'drink_invoice_id',
        'drink_id',
        'quantity',
        'price',
        'status',
        'note'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(DrinkInvoice::class, 'drink_invoice_id');
    }

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }
}
