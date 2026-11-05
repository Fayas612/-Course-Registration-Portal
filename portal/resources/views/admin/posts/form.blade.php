@extends('layouts.app')
@section('title', $post->exists ? 'Edit news post' : 'Write a news post')
@section('content')
<div class="form-panel mx-auto"><p class="eyebrow">NEWS MANAGEMENT</p><h1 class="h2 fw-bold mb-4">{{ $post->exists ? 'Edit news post' : 'Write a news post' }}</h1>
<form method="post" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}">@csrf @if($post->exists) @method('PUT') @endif
<div class="mb-3"><label for="title" class="form-label">Title</label><input class="form-control" id="title" name="title" maxlength="180" value="{{ old('title', $post->title) }}" required></div>
<div class="mb-3"><label for="excerpt" class="form-label">Short summary</label><textarea class="form-control" id="excerpt" name="excerpt" rows="3" maxlength="300" required>{{ old('excerpt', $post->excerpt) }}</textarea></div>
<div class="mb-3"><label for="body" class="form-label">Post content</label><textarea class="form-control" id="body" name="body" rows="12" maxlength="30000" aria-describedby="body-help" required>{{ old('body', $post->body) }}</textarea><div class="form-text" id="body-help">Write plain text. Paragraph breaks are preserved.</div></div>
<div class="mb-4"><label for="is_published" class="form-label">Publication status</label><select class="form-select" name="is_published" id="is_published"><option value="0" @selected(!old('is_published', $post->is_published))>Draft - visible to administrators only</option><option value="1" @selected(old('is_published', $post->is_published))>Published - visible on the news page</option></select></div>
<div class="d-flex gap-2"><button class="btn btn-dark">Save post</button><a class="btn btn-outline-secondary" href="{{ route('admin.posts.index') }}">Cancel</a></div></form></div>
@endsection
