<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEnrollmentRequest extends Model
{
    protected $fillable = [
        'course_id',
        'course_title',
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The course this enrollment request belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get status in Arabic.
     */
    public function getStatusArabicAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'في الانتظار',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            default    => $this->status,
        };
    }

    /**
     * Get status badge CSS class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'badge-pending',
            'approved' => 'badge-confirmed',
            'rejected' => 'badge-cancelled',
            default    => 'bg-secondary',
        };
    }
}
