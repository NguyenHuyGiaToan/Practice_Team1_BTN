<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Home routes (đặt các route liên quan đến trang chủ ở đây)




// Order routes (đặt các route liên quan đến đặt hàng, giỏ hàng ở đây)





// Admin routes (đặt các route liên quan đến trang quản trị ở đây)





//
require __DIR__.'/auth.php';
