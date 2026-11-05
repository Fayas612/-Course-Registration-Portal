@extends('layouts.app')
@section('title', 'Administrator sign in')
@section('content')
<div class="form-panel mx-auto"><p class="eyebrow">ADMINISTRATOR ACCESS</p><h1 class="h2 fw-bold mb-3">Welcome back</h1><p class="text-secondary">Sign in to manage courses and view registrations.</p>
<form method="post" action="{{ route('login.store') }}">@csrf
 <div class="mb-3"><label for="email" class="form-label">Email address</label><input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"></div>
 <div class="mb-4"><label for="password" class="form-label">Password</label><input class="form-control" type="password" id="password" name="password" required autocomplete="current-password"></div>
 <button class="btn btn-dark w-100">Sign in</button>
</form></div>
@endsection
