<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegistrationController;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [CourseController::class, 'index'])->name('courses.index');
Route::get('/news', [PostController::class, 'index'])->name('news.index');
Route::get('/news/{post:slug}', [PostController::class, 'publicShow'])->name('news.show');
Route::get('/courses/{course}/register', [RegistrationController::class, 'create'])->name('registrations.create');
Route::post('/courses/{course}/register', [RegistrationController::class, 'store'])->middleware('throttle:10,1')->name('registrations.store');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::prefix('admin')->name('admin.')->middleware(['auth', EnsureAdmin::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [CourseController::class, 'adminIndex'])->name('courses.index');
    Route::get('/courses/{course}/delete', [CourseController::class, 'confirmDelete'])->name('courses.delete');
    Route::resource('courses', CourseController::class)->except(['index']);
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/posts', [PostController::class, 'adminIndex'])->name('posts.index');
    Route::get('/posts/{post}/delete', [PostController::class, 'confirmDelete'])->name('posts.delete');
    Route::resource('posts', PostController::class)->except(['index']);
});
