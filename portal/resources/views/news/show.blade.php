@extends('layouts.app')
@section('title', $post->title)
@section('content')
<article class="article-panel mx-auto"><a href="{{ route('news.index') }}">&larr; All announcements</a><p class="eyebrow mt-4">COURSEPATH NEWS</p><h1 class="fw-bold mb-3">{{ $post->title }}</h1><p class="small text-secondary">{{ $post->published_at->format('d M Y') }} &middot; {{ $post->author->name }}</p><p class="lead">{{ $post->excerpt }}</p><div class="article-body mt-4">{{ $post->body }}</div></article>
@endsection
