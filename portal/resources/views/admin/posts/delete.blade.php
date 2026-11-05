@extends('layouts.app')
@section('title', 'Delete news post')
@section('content')
<div class="form-panel mx-auto"><p class="eyebrow">NEWS MANAGEMENT</p><h1 class="h2 fw-bold">Delete this post?</h1><p class="lead">{{ $post->title }}</p><p>This permanently deletes the post. This action cannot be undone.</p><form method="post" action="{{ route('admin.posts.destroy', $post) }}">@csrf @method('DELETE')<div class="d-flex gap-2"><button class="btn btn-danger">Delete post permanently</button><a class="btn btn-outline-secondary" href="{{ route('admin.posts.index') }}">Cancel</a></div></form></div>
@endsection
