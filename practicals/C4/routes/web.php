<?php
// Add to routes/web.php in an existing Laravel application.
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
Route::get('/products', [ProductController::class, 'index']);
