@extends('layouts.app')
@section('title', 'Delete course')
@section('content')
<div class="form-panel mx-auto"><p class="eyebrow">COURSE MANAGEMENT</p><h1 class="h2 fw-bold">Delete {{ $course->title }}?</h1><p>This permanently deletes the course and its {{ $course->registrations_count }} registration(s). This action cannot be undone.</p>
<form method="post" action="{{ route('admin.courses.destroy', $course) }}">@csrf @method('DELETE')<div class="d-flex gap-2"><button class="btn btn-danger">Delete course permanently</button><a class="btn btn-outline-secondary" href="{{ route('admin.courses.index') }}">Cancel</a></div></form></div>
@endsection
