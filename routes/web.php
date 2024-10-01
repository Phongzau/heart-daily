<?php

use App\Http\Controllers\ColorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home.home');
});

Route::get('/wishlist', function () {
    return view('frontend.pages.wishlist');
})->name('wishlist');

Route::get('/contact', function () {
    return view('frontend.pages.contact');
})->name('contact');

Route::get('/blog', function () {
    return view('frontend.pages.blog');
})->name('blog');

Route::get('/blog-details', function () {
    return view('frontend.pages.blog-details');
})->name('blog-details');

Route::get('/about-us', function () {
    return view('frontend.pages.about');
})->name('about');

Route::get('/product', function () {
    return view('frontend.pages.product');
})->name('product');

Route::get('/product-details', function () {
    return view('frontend.pages.product-details');
})->name('product-details');

Route::get('/cart-details', function () {
    return view('frontend.pages.cart-details');
})->name('cart-details');

Route::get('/checkout', function () {
    return view('frontend.pages.checkout');
})->name('checkout');

Route::get('user/dashboard', function () {
    return view('frontend.dashboard.dashboard');
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('colors', [ColorController::class, 'index'])->name('colors.index');
Route::get('colors/create', [ColorController::class, 'create'])->name('colors.create'); 
Route::post('colors', [ColorController::class, 'store'])->name('colors.store'); 
Route::get('colors/{color}', [ColorController::class, 'show'])->name('colors.show');
Route::get('colors/{color}/edit', [ColorController::class, 'edit'])->name('colors.edit');
Route::put('colors/{color}', [ColorController::class, 'update'])->name('colors.update'); 
Route::delete('colors/{color}', [ColorController::class, 'destroy'])->name('colors.destroy');