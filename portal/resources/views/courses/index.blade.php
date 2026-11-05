@extends('layouts.app')
@section('title', 'Explore courses')
@section('content')
<section class="hero mb-5 p-4 p-md-5">
 <div class="row align-items-center g-4"><div class="col-md-8">
  <p class="eyebrow mb-3">YOUR NEXT CHAPTER STARTS HERE</p>
  <h1 class="display-5 fw-bold mb-3">Build skills.<br><span class="text-accent">Create your future.</span></h1>
  <p class="lead mb-4">Practical courses for curious minds. Find your path and take the next step in your learning journey.</p>
  <a class="btn btn-dark btn-lg" href="#catalog">Explore courses &darr;</a>
 </div><div class="col-md-4"><div class="hero-note"><span class="display-4 fw-bold">{{ $courses->count() }}</span><p class="mb-0">courses to explore</p><hr><span>Hands-on learning.<br>Real-world skills.</span></div></div></div>
</section>
<section id="catalog" aria-labelledby="catalog-title">
 <div class="row align-items-end g-3 mb-4"><div class="col-md-7"><p class="eyebrow text-secondary mb-2">THE COURSE COLLECTION</p><h2 id="catalog-title" class="fw-bold">Find what inspires you</h2></div>
 <div class="col-md-5"><label class="form-label" for="course-search">Search courses</label><input id="course-search" type="search" class="form-control" placeholder="Try Laravel, PHP or front-end..."></div></div>
 <p id="search-status" class="small text-secondary" aria-live="polite">{{ $courses->count() }} courses available</p>
 <div class="row g-4">
 @foreach($courses as $course)
 <div class="col-md-4 course-card" data-search="{{ strtolower($course->title.' '.$course->description) }}">
  <article class="card h-100 shadow-sm"><div class="card-body p-4 d-flex flex-column">
   <div class="d-flex justify-content-between align-items-center mb-4"><span class="badge rounded-pill text-bg-light border">{{ $course->duration }}</span><span class="course-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></div>
   <h3 class="h4 fw-bold">{{ $course->title }}</h3><p class="text-secondary flex-grow-1">{{ $course->description }}</p>
   <p class="small text-secondary">Starts {{ $course->start_date->format('d M Y') }}</p>
   <div class="pt-3 border-top d-flex align-items-center justify-content-between gap-2"><strong>LKR {{ number_format((float) $course->fee, 2) }}</strong><a class="btn btn-dark" href="{{ route('registrations.create', $course) }}">Register <span class="visually-hidden">for {{ $course->title }}</span>&rarr;</a></div>
  </div></article>
 </div>
 @endforeach
 </div>
 <p id="no-results" class="alert alert-light border" @if($courses->isNotEmpty()) hidden @endif>No courses found. Try another search or visit again soon.</p>
</section>
@endsection
