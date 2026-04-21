<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Home routes (đặt các route liên quan đến trang chủ ở đây)
Route::get('/san-pham/{id}', [HomeController::class, 'show'])->name('sanpham.show');



// Order routes (đặt các route liên quan đến đặt hàng, giỏ hàng ở đây)





// Admin routes (đặt các route liên quan đến trang quản trị ở đây)
Route::delete('/laptop_delete/{id}', [App\Http\Controllers\AdminLaptopController::class, 'laptop_delete'])->name("laptop_delete");
Route::get('/laptop_manager', [App\Http\Controllers\AdminLaptopController::class, 'laptop_manager'])->name("laptop_manager");
//
require __DIR__.'/auth.php';
