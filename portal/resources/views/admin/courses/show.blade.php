@extends('layouts.app')
@section('title', $course->title)
@section('content')
<div class="form-panel mx-auto"><p class="eyebrow">COURSE DETAILS</p><h1 class="h2 fw-bold">{{ $course->title }}</h1><p class="article-body text-secondary">{{ $course->description }}</p>
<dl class="row"><dt class="col-sm-5">Duration</dt><dd class="col-sm-7">{{ $course->duration }}</dd><dt class="col-sm-5">Start date</dt><dd class="col-sm-7">{{ $course->start_date->format('d M Y') }}</dd><dt class="col-sm-5">Fee</dt><dd class="col-sm-7">LKR {{ number_format((float) $course->fee, 2) }}</dd><dt class="col-sm-5">Registrations</dt><dd class="col-sm-7">{{ $course->registrations_count }}</dd></dl>
<div class="d-flex gap-2 flex-wrap"><a class="btn btn-dark" href="{{ route('admin.courses.edit', $course) }}">Edit course</a><a class="btn btn-outline-danger" href="{{ route('admin.courses.delete', $course) }}">Delete course</a><a class="btn btn-outline-secondary" href="{{ route('admin.courses.index') }}">Back</a></div></div>
@endsection
