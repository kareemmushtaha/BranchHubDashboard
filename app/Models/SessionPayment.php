<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class SessionPayment extends Model
{
    use Auditable;
    protected $fillable = [
        'session_id',
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

    public function session()
    {
        return $this->belongsTo(Session::class)->withTrashed();
    }
}
