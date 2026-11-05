<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('courses.index', ['courses' => Course::orderBy('start_date')->get()]);
    }

    public function adminIndex()
    {
        return view('admin.courses.index', ['courses' => Course::withCount('registrations')->latest()->get()]);
    }

    public function create()
    {
        return view('admin.courses.form', ['course' => new Course]);
    }

    public function store(Request $request)
    {
        Course::create($this->validated($request));

        return redirect()->route('admin.courses.index')->with('success', 'Course added successfully.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.form', compact('course'));
    }

    public function show(Course $course)
    {
        $course->loadCount('registrations');

        return view('admin.courses.show', compact('course'));
    }

    public function confirmDelete(Course $course)
    {
        $course->loadCount('registrations');

        return view('admin.courses.delete', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $course->update($this->validated($request));

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course and its registrations deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],
            'duration' => ['required', 'string', 'max:80'],
            'fee' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
            'start_date' => ['required', 'date_format:Y-m-d'],
        ]);
    }
}
