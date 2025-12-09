<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'debt'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'debt' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
