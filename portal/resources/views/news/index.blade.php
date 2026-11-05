@extends('layouts.app')
@section('title', 'News and announcements')
@section('content')
<p class="eyebrow">FROM THE COURSEPATH COMMUNITY</p><h1 class="display-6 fw-bold">News and announcements</h1><p class="lead text-secondary mb-5">Course updates, learning tips and stories from our community.</p>
<div class="row g-4">
@forelse($posts as $post)<div class="col-md-6 col-lg-4"><article class="card h-100"><div class="card-body p-4 d-flex flex-column"><p class="small text-secondary">{{ $post->published_at->format('d M Y') }}</p><h2 class="h4 fw-bold">{{ $post->title }}</h2><p class="text-secondary flex-grow-1">{{ $post->excerpt }}</p><a class="btn btn-outline-dark align-self-start" href="{{ route('news.show', $post->slug) }}">Read announcement <span class="visually-hidden">{{ $post->title }}</span>&rarr;</a></div></article></div>
@empty<div class="col-12"><p class="alert alert-light border">No announcements yet. Check back soon.</p></div>@endforelse
</div><div class="mt-4">{{ $posts->links('pagination::bootstrap-5') }}</div>
@endsection
