<?php

use App\Http\Controllers\Admin\AdminColorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
//auth
Route::get('/login', [UserController::class, 'index'])->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('postLogin');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'postRegister'])->name('postRegister');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


Route::get('/wishlist', function () {
    return view('client.page.wishlist');
})->name('wishlist');

Route::get('/contact', function () {
    return view('client.page.contact');
})->name('contact');

Route::get('/blog', function () {
    return view('client.page.blog');
})->name('blog');

Route::get('/blog-details', function () {
    return view('client.page.blog-details');
})->name('blog-details');

Route::get('/about-us', function () {
    return view('client.page.about');
})->name('about');

Route::get('/product', function () {
    return view('client.page.product');
})->name('product');

Route::get('/product-details', function () {
    return view('client.page.product-details');
})->name('product-details');

Route::get('/cart-details', function () {
    return view('client.page.cart-details');
})->name('cart-details');

Route::get('/checkout', function () {
    return view('client.page.checkout');
})->name('checkout');

Route::get('user/dashboard', function () {
    return view('client.page.dashboard.dashboard');
});


//admin
Route::prefix('admin')->name('admin.')->group(function () {
    //dashboard
    Route::get('/dashboard', function () {
        return view('admin.page.dashboard');
    })->name('dashboard');
    //color
    Route::prefix('colors')->name('colors.')->group(function () {
        Route::get('/', [AdminColorController::class, 'index'])->name('index');
        Route::get('/create', [AdminColorController::class, 'create'])->name('create');
        Route::post('/store', [AdminColorController::class, 'store'])->name('store');
        Route::get('/edit/{color}', [AdminColorController::class, 'edit'])->name('edit');
        Route::put('/update/{color}', [AdminColorController::class, 'update'])->name('update');
        Route::delete('/destroy/{color}', [AdminColorController::class, 'destroy'])->name('destroy');
    });

    Route::resource('role', RoleController::class);
});
