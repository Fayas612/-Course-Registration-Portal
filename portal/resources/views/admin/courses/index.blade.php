@extends('layouts.app')
@section('title', 'Manage courses')
@section('content')
<div class="d-flex justify-content-between align-items-center gap-3 mb-4"><div><p class="eyebrow">ADMIN DASHBOARD</p><h1 class="h2 fw-bold">Manage courses</h1></div><a class="btn btn-dark" href="{{ route('admin.courses.create') }}">+ Add course</a></div>
<div class="table-responsive bg-white rounded border"><table class="table table-hover align-middle mb-0"><caption class="px-3">Course catalogue and registration totals</caption><thead><tr><th scope="col">Course</th><th scope="col">Starts</th><th scope="col">Fee (LKR)</th><th scope="col">Registrations</th><th scope="col">Actions</th></tr></thead><tbody>
@forelse($courses as $course)<tr><td class="fw-semibold">{{ $course->title }}</td><td>{{ $course->start_date->format('d M Y') }}</td><td>{{ number_format((float) $course->fee, 2) }}</td><td>{{ $course->registrations_count }}</td><td><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.courses.show', $course) }}">View</a><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.courses.edit', $course) }}">Edit</a><a class="btn btn-sm btn-outline-danger" href="{{ route('admin.courses.delete', $course) }}">Delete</a></div></td></tr>
@empty<tr><td colspan="5">No courses yet. Add your first course.</td></tr>@endforelse
</tbody></table></div>
@endsection
