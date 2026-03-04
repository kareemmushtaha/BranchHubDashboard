<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use Illuminate\Http\Request;

class PublicLeaderController extends Controller
{
    public function index(Request $request)
    {
        $query = Leader::withCount(['courses' => fn ($q) => $q->where('is_published', true)]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%");
            });
        }

        $leaders = $query->latest()->paginate(6)->withQueryString();

        return view('public.leaders.index', compact('leaders'));
    }

    public function show(Leader $leader)
    {
        $leader->load('courses');
        $leader->loadCount('courses');

        return view('public.leaders.show', compact('leader'));
    }
}
