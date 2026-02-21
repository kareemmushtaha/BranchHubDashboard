<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Courses that have this skill.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_skill');
    }
}
