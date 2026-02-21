<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $fillable = [
        'name',
        'email',
        'cv',
        'phone',
        'photo',
        'job_title',
        'job_description',
        'linkedin',
    ];

    /**
     * Courses that the leader instructs.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_leader');
    }
}
