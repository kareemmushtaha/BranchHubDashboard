<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'plan_type',
        'notes',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get plan type in Arabic
    public function getPlanTypeArabicAttribute()
    {
        return match($this->plan_type) {
            'daily' => 'حجز يومي',
            'weekly' => 'حجز أسبوعي',
            'monthly' => 'حجز شهري',
            default => $this->plan_type
        };
    }

    // Get status in Arabic
    public function getStatusArabicAttribute()
    {
        return match($this->status) {
            'pending' => 'في الانتظار',
            'confirmed' => 'مؤكد',
            'cancelled' => 'ملغي',
            default => $this->status
        };
    }

    // Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'confirmed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary'
        };
    }
}
