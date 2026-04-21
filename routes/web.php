<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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



// Order routes (đặt các route liên quan đến đặt hàng, giỏ hàng ở đây)





// Admin routes (đặt các route liên quan đến trang quản trị ở đây)





//
require __DIR__.'/auth.php';
