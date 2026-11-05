<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Course Registration Portal') | CoursePath</title>
    <link href="{{ asset('assets/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/portal.css') }}" rel="stylesheet">
</head>
<body>
<a class="visually-hidden-focusable" href="#main">Skip to content</a>
<nav class="navbar navbar-expand-xl bg-white border-bottom" aria-label="Main navigation">
 <div class="container py-2">
  <a class="navbar-brand fw-bold" href="{{ route('courses.index') }}"><span class="brand-mark">C</span> CoursePath</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="navigation"><div class="navbar-nav ms-auto align-items-xl-center gap-xl-3">
    <a class="nav-link" href="{{ route('courses.index') }}">Explore courses</a>
    <a class="nav-link" href="{{ route('news.index') }}">News</a>
    <a class="nav-link" href="{{ url('/api/courses') }}">Course API</a>
    @auth
      @if(auth()->user()->is_admin)
       <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
       <a class="nav-link" href="{{ route('admin.courses.index') }}">Manage courses</a>
       <a class="nav-link" href="{{ route('admin.registrations.index') }}">Registrations</a>
       <a class="nav-link" href="{{ route('admin.posts.index') }}">Manage posts</a>
      @endif
      <form action="{{ route('logout') }}" method="post">@csrf<button class="btn btn-outline-dark btn-sm">Sign out</button></form>
    @else
      <a class="btn btn-outline-dark btn-sm" href="{{ route('login') }}">Admin sign in</a>
    @endauth
  </div></div>
 </div>
</nav>
<main id="main" class="container py-5">
 @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
 @if($errors->any())
 <div class="alert alert-danger" role="alert"><strong>Please correct the following:</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
 @endif
 @yield('content')
</main>
<footer class="container py-4 border-top d-flex flex-wrap justify-content-between gap-2 text-secondary small"><span>CoursePath / Learn. Build. Grow.</span><span>Course Registration Portal &middot; {{ date('Y') }}</span></footer>
<script src="{{ asset('assets/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/portal.js') }}" defer></script>
</body>
</html>
