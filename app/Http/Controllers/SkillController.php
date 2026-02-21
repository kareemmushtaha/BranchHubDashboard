<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::withCount('courses')->orderBy('name')->paginate(20);
        return view('skills.index', compact('skills'));
    }

    public function create()
    {
        return view('skills.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Skill::create(['name' => $request->name]);
        return redirect()->route('skills.index')->with('success', 'تم إضافة المهارة بنجاح');
    }

    public function show(Skill $skill)
    {
        return redirect()->route('skills.edit', $skill);
    }

    public function edit(Skill $skill)
    {
        return view('skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $skill->update(['name' => $request->name]);
        return redirect()->route('skills.index')->with('success', 'تم تحديث المهارة بنجاح');
    }

    public function destroy(Skill $skill)
    {
        $skill->courses()->detach();
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'تم حذف المهارة بنجاح');
    }
}
