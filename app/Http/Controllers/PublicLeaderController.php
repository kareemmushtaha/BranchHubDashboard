<?php

namespace App\Http\Controllers;

use App\Models\Leader;

class PublicLeaderController extends Controller
{
    public function show(Leader $leader)
    {
        $leader->load('courses');
        $leader->loadCount('courses');

        return view('public.leaders.show', compact('leader'));
    }
}
