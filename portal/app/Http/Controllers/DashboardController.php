<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Post;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'courseCount' => Course::count(),
            'registrationCount' => Registration::count(),
            'postCount' => Post::count(),
            'publishedCount' => Post::published()->count(),
            'recentRegistrations' => Registration::with('course')->latest()->limit(5)->get(),
        ]);
    }
}
