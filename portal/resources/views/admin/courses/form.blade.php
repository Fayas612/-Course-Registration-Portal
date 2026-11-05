@extends('layouts.app')
@section('title', $course->exists ? 'Edit course' : 'Add course')
@section('content')
<div class="form-panel mx-auto"><p class="eyebrow">COURSE MANAGEMENT</p><h1 class="h2 fw-bold mb-4">{{ $course->exists ? 'Edit course' : 'Add a new course' }}</h1>
<form method="post" action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}">@csrf @if($course->exists) @method('PUT') @endif
 <div class="mb-3"><label for="title" class="form-label">Course title</label><input class="form-control" id="title" name="title" maxlength="150" value="{{ old('title', $course->title) }}" required></div>
 <div class="mb-3"><label for="description" class="form-label">Description</label><textarea class="form-control" id="description" name="description" rows="4" maxlength="5000" required>{{ old('description', $course->description) }}</textarea></div>
 <div class="mb-3"><label for="duration" class="form-label">Duration (e.g. 12 weeks)</label><input class="form-control" id="duration" name="duration" maxlength="80" value="{{ old('duration', $course->duration) }}" required></div>
 <div class="row"><div class="col-sm-6 mb-4"><label for="fee" class="form-label">Fee (LKR)</label><input class="form-control" id="fee" name="fee" type="number" min="0" max="99999999.99" step="0.01" value="{{ old('fee', $course->fee ?? 0) }}" required></div>
 <div class="col-sm-6 mb-4"><label for="start_date" class="form-label">Start date</label><input class="form-control" id="start_date" name="start_date" type="date" value="{{ old('start_date', $course->start_date?->format('Y-m-d')) }}" required></div></div>
 <div class="d-flex gap-2"><button class="btn btn-dark">Save course</button><a class="btn btn-outline-secondary" href="{{ route('admin.courses.index') }}">Cancel</a></div>
</form></div>
@endsection
