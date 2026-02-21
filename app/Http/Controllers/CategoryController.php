<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('courses')->orderBy('name')->paginate(20);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'تم إضافة التصنيف بنجاح');
    }

    public function show(Category $category)
    {
        return redirect()->route('categories.edit', $category);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy(Category $category)
    {
        $category->courses()->detach();
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'تم حذف التصنيف بنجاح');
    }
}
