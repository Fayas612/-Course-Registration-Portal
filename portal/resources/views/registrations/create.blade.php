@extends('layouts.app')
@section('title', 'Register for a course')
@section('content')
<div class="row g-5"><div class="col-md-5"><p class="eyebrow">TAKE THE NEXT STEP</p><h1 class="fw-bold">{{ $course->title }}</h1><p class="lead text-secondary">{{ $course->description }}</p><p>{{ $course->duration }} &middot; Starts {{ $course->start_date->format('d M Y') }}</p><strong class="h4">LKR {{ number_format((float) $course->fee, 2) }}</strong><p class="mt-4"><a href="{{ route('courses.index') }}">&larr; Back to courses</a></p></div>
<div class="col-md-7"><div class="form-panel"><h2 class="h4 fw-bold">Reserve your place</h2><p class="text-secondary">Enter your details to register for this course.</p>
<form method="post" action="{{ route('registrations.store', $course) }}">@csrf
 @foreach(['name' => 'Full name', 'email' => 'Email address', 'phone' => 'Phone number'] as $field => $label)
 <div class="mb-3"><label class="form-label" for="{{ $field }}">{{ $label }}</label><input class="form-control @error($field) is-invalid @enderror" type="{{ $field === 'email' ? 'email' : ($field === 'phone' ? 'tel' : 'text') }}" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}" maxlength="{{ $field === 'email' ? 254 : ($field === 'phone' ? 30 : 120) }}" autocomplete="{{ $field === 'phone' ? 'tel' : $field }}" required @if($field === 'phone') minlength="7" @endif>@error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
 @endforeach
 <p class="small text-secondary">Each email address may register once per course.</p><button class="btn btn-dark w-100">Complete registration</button>
</form></div></div></div>
@endsection
