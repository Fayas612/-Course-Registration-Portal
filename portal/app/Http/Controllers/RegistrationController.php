<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function create(Course $course)
    {
        return view('registrations.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:254', Rule::unique('registrations')->where('course_id', $course->id)],
            'phone' => ['required', 'string', 'min:7', 'max:30', 'regex:/^[0-9+() .-]+$/'],
        ], ['email.unique' => 'This email is already registered for this course.']);
        try {
            $course->registrations()->create($data);
        } catch (UniqueConstraintViolationException $e) {
            // The database constraint also protects simultaneous duplicate requests.
            throw ValidationException::withMessages(['email' => 'This email is already registered for this course.']);
        }

        return redirect()->route('courses.index')->with('success', 'Registration successful. Thank you for joining '.$course->title.'!');
    }

    public function index()
    {
        return view('admin.registrations', ['registrations' => Registration::with('course')->latest()->paginate(20)]);
    }
}
