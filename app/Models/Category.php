<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Courses that belong to the category.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_category');
    }
}
