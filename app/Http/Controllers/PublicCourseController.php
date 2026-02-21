<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{
    /**
     * Course list: cards with thumbnail, title, short description, price, learners. Filter by category.
     */
    public function index(Request $request)
    {
        $query = Course::where('is_published', true)->with('categories');

        if ($request->filled('category')) {
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $request->category));
        }

        $courses = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::has('courses')->orderBy('name')->get();

        return view('public.courses.index', compact('courses', 'categories'));
    }

    /**
     * Course detail: hero with cover, full description, skills badges, leaders (photo/CV), stats.
     */
    public function show(Course $course)
    {
        if (!$course->is_published) {
            abort(404);
        }

        $course->load(['categories', 'skills', 'leaders']);

        return view('public.courses.show', compact('course'));
    }
}
