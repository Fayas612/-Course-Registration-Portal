@extends('layouts.app')
@section('title', 'Registrations')
@section('content')
<p class="eyebrow">ADMIN DASHBOARD</p><h1 class="h2 fw-bold mb-4">Course registrations</h1>
<div class="table-responsive bg-white rounded border"><table class="table table-hover align-middle mb-0"><thead><tr><th scope="col">Name</th><th scope="col">Course</th><th scope="col">Email</th><th scope="col">Phone</th><th scope="col">Registered</th></tr></thead><tbody>
@forelse($registrations as $registration)<tr><td>{{ $registration->name }}</td><td>{{ $registration->course->title }}</td><td>{{ $registration->email }}</td><td>{{ $registration->phone }}</td><td>{{ $registration->created_at->format('d M Y') }}</td></tr>
@empty<tr><td colspan="5">No registrations yet.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $registrations->links('pagination::bootstrap-5') }}</div>
@endsection
