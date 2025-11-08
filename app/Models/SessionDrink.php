<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class SessionDrink extends Model
{
    use Auditable;
    protected $fillable = [
        'session_id',
        'drink_id',
        'price',
        'quantity',
        'status',
        'note'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }

    /**
     * حساب إجمالي المشروبات
     */
    public static function getTotalDrinksRevenue()
    {
        return self::sum('price');
    }


}
