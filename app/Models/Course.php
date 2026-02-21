<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'price',
        'cover_image',
        'thumbnail_image',
        'learner_count',
        'likes_count',
        'review_count',
        'is_published',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'learner_count' => 'integer',
        'likes_count' => 'integer',
        'review_count' => 'integer',
        'is_published' => 'boolean',
    ];

    /**
     * Skills associated with the course.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'course_skill');
    }

    /**
     * Leaders (instructors) of the course.
     */
    public function leaders()
    {
        return $this->belongsToMany(Leader::class, 'course_leader');
    }

    /**
     * Categories the course belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'course_category');
    }

    /**
     * Enrollment requests for the course.
     */
    public function enrollmentRequests()
    {
        return $this->hasMany(CourseEnrollmentRequest::class);
    }

    /**
     * Get the route key for the model (SEO-friendly URLs).
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Boot: generate slug from title when creating or when title changes.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Course $course) {
            if (empty($course->slug)) {
                $course->slug = static::uniqueSlug(Str::slug($course->title));
            }
        });

        static::updating(function (Course $course) {
            if ($course->isDirty('title') && !$course->isDirty('slug')) {
                $course->slug = static::uniqueSlug(Str::slug($course->title), $course->id);
            }
        });
    }

    /**
     * Generate a unique slug.
     */
    public static function uniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug = $base;
        $count = 0;
        while (true) {
            $query = static::where('slug', $slug);
            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }
            if (!$query->exists()) {
                break;
            }
            $count++;
            $slug = $base . '-' . $count;
        }
        return $slug;
    }
}
