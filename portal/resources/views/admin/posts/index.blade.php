@extends('layouts.app')
@section('title', 'Manage news posts')
@section('content')
<div class="d-flex justify-content-between align-items-center gap-3 mb-4"><div><p class="eyebrow">ADMIN DASHBOARD</p><h1 class="h2 fw-bold">Manage news posts</h1></div><a class="btn btn-dark" href="{{ route('admin.posts.create') }}">+ Write a post</a></div>
<div class="table-responsive bg-white rounded border"><table class="table align-middle mb-0"><thead><tr><th scope="col">Title</th><th scope="col">Status</th><th scope="col">Author</th><th scope="col">Actions</th></tr></thead><tbody>
@forelse($posts as $post)<tr><td>{{ $post->title }}</td><td><span class="badge {{ $post->is_published ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td><td>{{ $post->author->name }}</td><td><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.posts.show', $post) }}">View</a><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.posts.edit', $post) }}">Edit</a><a class="btn btn-sm btn-outline-danger" href="{{ route('admin.posts.delete', $post) }}">Delete</a></div></td></tr>
@empty<tr><td colspan="4">No posts yet. Write your first announcement.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $posts->links('pagination::bootstrap-5') }}</div>
@endsection
