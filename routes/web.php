<?php

use App\Http\Controllers\Admin\AdminAttributeController;
use App\Http\Controllers\Admin\AdminCategoryAttributeController;
use App\Http\Controllers\Admin\AdminColorController;
use App\Http\Controllers\Admin\BannerController;
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
    //banner
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/create', [BannerController::class, 'create'])->name('create');
        Route::post('/store', [BannerController::class, 'store'])->name('store');
        Route::get('/edit/{banner}', [BannerController::class, 'edit'])->name('edit');
        Route::put('/update/{banner}', [BannerController::class, 'update'])->name('update');
        Route::delete('/destroy/{banner}', [BannerController::class, 'destroy'])->name('destroy');
        Route::put('change-status', [BannerController::class, 'changeStatus'])->name('change-status');
    });
    //role
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });
    //category_attributes
    Route::prefix('category_attributes')->name('category_attributes.')->group(function () {
        Route::put('change-status', [AdminCategoryAttributeController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [AdminCategoryAttributeController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoryAttributeController::class, 'create'])->name('create');
        Route::post('/', [AdminCategoryAttributeController::class, 'store'])->name('store');
        Route::get('/{category_attribute}', [AdminCategoryAttributeController::class, 'show'])->name('show');
        Route::get('/{category_attribute}/edit', [AdminCategoryAttributeController::class, 'edit'])->name('edit');
        Route::put('/{category_attribute}', [AdminCategoryAttributeController::class, 'update'])->name('update');
        Route::delete('/{category_attribute}', [AdminCategoryAttributeController::class, 'destroy'])->name('destroy');
    });
    //category_attributes
    Route::prefix('attributes')->name('attributes.')->group(function () {
        Route::put('change-status', [AdminAttributeController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [AdminAttributeController::class, 'index'])->name('index');
        Route::get('/create', [AdminAttributeController::class, 'create'])->name('create');
        Route::post('/', [AdminAttributeController::class, 'store'])->name('store');
        Route::get('/{attribute}', [AdminAttributeController::class, 'show'])->name('show');
        Route::get('/{attribute}/edit', [AdminAttributeController::class, 'edit'])->name('edit');
        Route::put('/{attribute}', [AdminAttributeController::class, 'update'])->name('update');
        Route::delete('/{attribute}', [AdminAttributeController::class, 'destroy'])->name('destroy');
    });
});
