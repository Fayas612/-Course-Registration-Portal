@extends('layouts.app')
@section('title', $post->title)
@section('content')
<article class="article-panel mx-auto"><p class="eyebrow">ADMIN POST PREVIEW</p><span class="badge {{ $post->is_published ? 'text-bg-success' : 'text-bg-secondary' }} mb-3">{{ $post->is_published ? 'Published' : 'Draft' }}</span><h1 class="fw-bold">{{ $post->title }}</h1><p class="lead mt-3">{{ $post->excerpt }}</p><div class="article-body my-4">{{ $post->body }}</div><div class="d-flex gap-2 flex-wrap"><a class="btn btn-dark" href="{{ route('admin.posts.edit', $post) }}">Edit post</a>@if($post->is_published)<a class="btn btn-outline-dark" href="{{ route('news.show', $post->slug) }}">Open public page</a>@endif<a class="btn btn-outline-danger" href="{{ route('admin.posts.delete', $post) }}">Delete</a><a class="btn btn-outline-secondary" href="{{ route('admin.posts.index') }}">Back to posts</a></div></article>
@endsection
