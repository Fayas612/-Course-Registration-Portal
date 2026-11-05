@extends('layouts.app')
@section('title', 'Admin dashboard')
@section('content')
<p class="eyebrow">ADMIN DASHBOARD</p>
<h1 class="h2 fw-bold">Welcome, {{ auth()->user()->name }}</h1>
<p class="text-secondary mb-4">Manage your course catalogue, registrations and news in one place.</p>
<div class="row g-3 mb-5">
 @foreach([['Courses', $courseCount, route('admin.courses.index')], ['Registrations', $registrationCount, route('admin.registrations.index')], ['News posts', $postCount, route('admin.posts.index')], ['Published posts', $publishedCount, route('news.index')]] as [$label, $count, $url])
 <div class="col-6 col-lg-3"><a class="card h-100 text-decoration-none" href="{{ $url }}"><div class="card-body p-4"><p class="text-secondary mb-2">{{ $label }}</p><strong class="display-6">{{ $count }}</strong></div></a></div>
 @endforeach
</div>
<div class="d-flex gap-2 flex-wrap mb-4"><a class="btn btn-dark" href="{{ route('admin.courses.create') }}">+ Add course</a><a class="btn btn-outline-dark" href="{{ route('admin.posts.create') }}">+ Write a post</a></div>
<h2 class="h4 fw-bold mb-3">Recent registrations</h2>
<div class="table-responsive bg-white rounded border"><table class="table align-middle mb-0"><thead><tr><th>Name</th><th>Course</th><th>Registered</th></tr></thead><tbody>
@forelse($recentRegistrations as $registration)<tr><td>{{ $registration->name }}</td><td>{{ $registration->course->title }}</td><td>{{ $registration->created_at->format('d M Y') }}</td></tr>
@empty<tr><td colspan="3">No registrations yet.</td></tr>@endforelse
</tbody></table></div>
@endsection
