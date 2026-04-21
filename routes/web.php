<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SanPhamController;
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
// Thêm vào giỏ hàng
Route::post('/cart/add', [HomeController::class, 'addToCart'])->name('cart.add');
Route::get('/laptop/theloai/{id}', function($id) {return redirect()->route('home', ['id_danh_muc' => $id]);});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gio-hang', [HomeController::class, 'cart'])->name('cart.index');
Route::post('/add-to-cart', [HomeController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [HomeController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/checkout', [HomeController::class, 'checkout'])->name('cart.checkout');

Route::post('/timkiem', [SanPhamController::class, 'search'])->name('search');

// Admin routes (đặt các route liên quan đến trang quản trị ở đây)
Route::delete('/laptop_delete/{id}', [App\Http\Controllers\AdminLaptopController::class, 'laptop_delete'])->name("laptop_delete");
Route::get('/laptop_manager', [App\Http\Controllers\AdminLaptopController::class, 'laptop_manager'])->name("laptop_manager");
//
require __DIR__.'/auth.php';
