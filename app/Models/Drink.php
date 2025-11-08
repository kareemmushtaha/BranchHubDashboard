<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    protected $fillable = [
        'name',
        'price',
        'size',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function sessionDrinks()
    {
        return $this->hasMany(SessionDrink::class);
    }
}
