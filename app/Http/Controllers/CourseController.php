<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Skill;
use App\Models\Leader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource (searchable).
     */
    public function index(Request $request)
    {
        $query = Course::withCount(['categories', 'skills', 'leaders']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('title', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            });
        }

        $courses = $query->latest()->paginate(15)->withQueryString();

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();
        $leaders = Leader::orderBy('name')->get();

        return view('courses.create', compact('categories', 'skills', 'leaders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateCourse($request);

        $course = new Course();
        $course->title = $validated['title'];
        $course->description = $validated['description'] ?? null;
        $course->short_description = $validated['short_description'] ?? null;
        $course->price = $validated['price'];
        $course->learner_count = (int) ($validated['learner_count'] ?? 0);
        $course->likes_count = (int) ($validated['likes_count'] ?? 0);
        $course->review_count = (int) ($validated['review_count'] ?? 0);
        $course->is_published = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            $course->cover_image = $request->file('cover_image')->store('courses/covers', 'public');
        }
        if ($request->hasFile('thumbnail_image')) {
            $course->thumbnail_image = $request->file('thumbnail_image')->store('courses/thumbnails', 'public');
        }

        $course->save();

        $course->categories()->sync($request->input('category_ids', []));
        $course->skills()->sync($request->input('skill_ids', []));
        $course->leaders()->sync($request->input('leader_ids', []));

        return redirect()->route('courses.index')->with('success', 'تم إضافة الدورة بنجاح');
    }

    /**
     * Display the specified resource (admin view).
     */
    public function show(Course $course)
    {
        $course->load(['categories', 'skills', 'leaders']);

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = Category::orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();
        $leaders = Leader::orderBy('name')->get();

        return view('courses.edit', compact('course', 'categories', 'skills', 'leaders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $this->validateCourse($request, $course);

        $course->title = $validated['title'];
        $course->description = $validated['description'] ?? null;
        $course->short_description = $validated['short_description'] ?? null;
        $course->price = $validated['price'];
        $course->learner_count = (int) ($validated['learner_count'] ?? 0);
        $course->likes_count = (int) ($validated['likes_count'] ?? 0);
        $course->review_count = (int) ($validated['review_count'] ?? 0);
        $course->is_published = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            if ($course->cover_image) {
                Storage::disk('public')->delete($course->cover_image);
            }
            $course->cover_image = $request->file('cover_image')->store('courses/covers', 'public');
        }
        if ($request->hasFile('thumbnail_image')) {
            if ($course->thumbnail_image) {
                Storage::disk('public')->delete($course->thumbnail_image);
            }
            $course->thumbnail_image = $request->file('thumbnail_image')->store('courses/thumbnails', 'public');
        }

        $course->save();

        $course->categories()->sync($request->input('category_ids', []));
        $course->skills()->sync($request->input('skill_ids', []));
        $course->leaders()->sync($request->input('leader_ids', []));

        return redirect()->route('courses.index')->with('success', 'تم تحديث الدورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->cover_image) {
            Storage::disk('public')->delete($course->cover_image);
        }
        if ($course->thumbnail_image) {
            Storage::disk('public')->delete($course->thumbnail_image);
        }

        $course->categories()->detach();
        $course->skills()->detach();
        $course->leaders()->detach();
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'تم حذف الدورة بنجاح');
    }

    /**
     * Toggle is_published.
     */
    public function togglePublished(Course $course)
    {
        $course->update(['is_published' => !$course->is_published]);

        return redirect()->back()->with('success', $course->is_published ? 'تم نشر الدورة' : 'تم إلغاء نشر الدورة');
    }

    /**
     * Validation rules for store/update.
     */
    protected function validateCourse(Request $request, ?Course $course = null): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'learner_count' => 'nullable|integer|min:0',
            'likes_count' => 'nullable|integer|min:0',
            'review_count' => 'nullable|integer|min:0',
            'cover_image' => 'nullable|image|max:2048',
            'thumbnail_image' => 'nullable|image|max:1024',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'skill_ids' => 'nullable|array',
            'skill_ids.*' => 'exists:skills,id',
            'leader_ids' => 'nullable|array',
            'leader_ids.*' => 'exists:leaders,id',
        ];

        if (!$course) {
            $rules['cover_image'] = 'nullable|image|max:2048';
            $rules['thumbnail_image'] = 'nullable|image|max:1024';
        }

        return $request->validate($rules);
    }
}
