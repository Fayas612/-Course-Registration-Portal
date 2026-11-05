<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::get('/courses', function () {
    return response()->json(Course::orderBy('id')->get(['id', 'title', 'description', 'duration', 'fee', 'start_date']));
})->middleware('throttle:60,1');
