<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = Leader::withCount('courses')->orderBy('name')->paginate(20);
        return view('leaders.index', compact('leaders'));
    }

    public function create()
    {
        return view('leaders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'cv' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:1024',
            'job_title' => 'nullable|string|max:255',
            'job_description' => 'nullable|string',
            'linkedin' => 'nullable|url|max:255',
        ]);
        $data = $request->only(['name', 'email', 'cv', 'phone', 'job_title', 'job_description', 'linkedin']);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('leaders', 'public');
        }
        Leader::create($data);
        return redirect()->route('leaders.index')->with('success', 'تم إضافة القائد بنجاح');
    }

    public function show(Leader $leader)
    {
        $leader->loadCount('courses');
        $leader->load('courses');
        return view('leaders.show', compact('leader'));
    }

    public function edit(Leader $leader)
    {
        return view('leaders.edit', compact('leader'));
    }

    public function update(Request $request, Leader $leader)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'cv' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:1024',
            'job_title' => 'nullable|string|max:255',
            'job_description' => 'nullable|string',
            'linkedin' => 'nullable|url|max:255',
        ]);
        $data = $request->only(['name', 'email', 'cv', 'phone', 'job_title', 'job_description', 'linkedin']);
        if ($request->hasFile('photo')) {
            if ($leader->photo) {
                Storage::disk('public')->delete($leader->photo);
            }
            $data['photo'] = $request->file('photo')->store('leaders', 'public');
        }
        $leader->update($data);
        return redirect()->route('leaders.index')->with('success', 'تم تحديث القائد بنجاح');
    }

    public function destroy(Leader $leader)
    {
        if ($leader->photo) {
            Storage::disk('public')->delete($leader->photo);
        }
        $leader->courses()->detach();
        $leader->delete();
        return redirect()->route('leaders.index')->with('success', 'تم حذف القائد بنجاح');
    }
}
