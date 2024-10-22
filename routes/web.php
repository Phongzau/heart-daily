<?php

use App\Http\Controllers\GeneralSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCategoryProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AdminColorController;
use App\Http\Controllers\Admin\AdminAttributeController;
use App\Http\Controllers\Admin\AdminBlogCategoryController;
use App\Http\Controllers\Admin\AdminCategoryAttributeController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdvertisementsController;
use App\Http\Controllers\Admin\BlogCommentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ListAccountController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Middleware\CheckRole;
use App\Models\User;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/slider', [HomeController::class, 'index'])->name('slider');
//auth
Route::get('/login', [UserController::class, 'index'])->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('postLogin');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'postRegister'])->name('postRegister');
Route::get('/confirm-email', [UserController::class, 'confirmEmail'])->name('confirm.email');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [UserController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password', [UserController::class, 'sendResetLink'])->name('send.reset.link');
Route::get('/reset-password/{token}', [UserController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset.password.submit');
//chat

Route::get('/chat/{id?}', function ($id = null) {
    return view('client.page.chat', [
        'id' => $id
    ]);
})->middleware(['auth'])->name('chat');


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

// Route::get('/product-details', function () {
//     return view('client.page.product-details');
// })->name('product-details');

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
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:1'])->group(function () {
    //dashboard
    Route::get('/dashboard', function () {
        return view('admin.page.dashboard');
    })->name('dashboard');

    //Brands
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/edit/{brands}', [BrandController::class, 'edit'])->name('edit');
        Route::put('/update/{brands}', [BrandController::class, 'update'])->name('update');
        Route::delete('/destroy/{brands}', [BrandController::class, 'destroy'])->name('destroy');
        Route::put('change-status', [BrandController::class, 'changeStatus'])->name('change-status');
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
        Route::post('/upload-image', [BannerController::class, 'uploadImage'])->name('upload.image');
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
        Route::get('/get-category-attributes', [AdminCategoryAttributeController::class, 'getCategoryAttributes'])->name('get-category-attributes');
        Route::get('/', [AdminCategoryAttributeController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoryAttributeController::class, 'create'])->name('create');
        Route::post('/', [AdminCategoryAttributeController::class, 'store'])->name('store');
        Route::get('/{category_attribute}', [AdminCategoryAttributeController::class, 'show'])->name('show');
        Route::get('/{category_attribute}/edit', [AdminCategoryAttributeController::class, 'edit'])->name('edit');
        Route::put('/{category_attribute}', [AdminCategoryAttributeController::class, 'update'])->name('update');
        Route::delete('/{category_attribute}', [AdminCategoryAttributeController::class, 'destroy'])->name('destroy');
    });

    //attributes
    Route::prefix('attributes')->name('attributes.')->group(function () {
        Route::put('change-status', [AdminAttributeController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/get-attributes/{id}', [AdminAttributeController::class, 'getAttributes'])->name('get-attributes');
        Route::get('/', [AdminAttributeController::class, 'index'])->name('index');
        Route::get('/create', [AdminAttributeController::class, 'create'])->name('create');
        Route::post('/', [AdminAttributeController::class, 'store'])->name('store');
        Route::get('/{attribute}', [AdminAttributeController::class, 'show'])->name('show');
        Route::get('/{attribute}/edit', [AdminAttributeController::class, 'edit'])->name('edit');
        Route::put('/{attribute}', [AdminAttributeController::class, 'update'])->name('update');
        Route::delete('/{attribute}', [AdminAttributeController::class, 'destroy'])->name('destroy');
    });

    //category_product
    Route::prefix('category_products')->name('category_products.')->group(function () {
        Route::put('change-status', [AdminCategoryProductController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('get-parent', [AdminCategoryProductController::class, 'getParentCategory'])
            ->name('get-parent');
        Route::get('/', [AdminCategoryProductController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoryProductController::class, 'create'])->name('create');
        Route::post('/', [AdminCategoryProductController::class, 'store'])->name('store');
        Route::get('/{category_products}', [AdminCategoryProductController::class, 'show'])->name('show');
        Route::get('/{category_products}/edit', [AdminCategoryProductController::class, 'edit'])->name('edit');
        Route::put('/{category_products}', [AdminCategoryProductController::class, 'update'])->name('update');
        Route::delete('/{category_products}', [AdminCategoryProductController::class, 'destroy'])->name('destroy');
    });

    //menu
    Route::prefix('menus')->name('menus.')->group(function () {
        Route::put('change-status', [MenuController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('/{menus}', [MenuController::class, 'show'])->name('show');
        Route::get('/{menus}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{menus}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menus}', [MenuController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('blog_categories')->name('blog_categories.')->group(function () {
        Route::put('change-status', [AdminBlogCategoryController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [AdminBlogCategoryController::class, 'index'])->name('index');
        Route::get('/create', [AdminBlogCategoryController::class, 'create'])->name('create');
        Route::post('/', [AdminBlogCategoryController::class, 'store'])->name('store');
        Route::get('/{blog_categories}', [AdminBlogCategoryController::class, 'show'])->name('show');
        Route::get('/{blog_categories}/edit', [AdminBlogCategoryController::class, 'edit'])->name('edit');
        Route::put('/{blog_categories}', [AdminBlogCategoryController::class, 'update'])->name('update');
        Route::delete('/{blog_categories}', [AdminBlogCategoryController::class, 'destroy'])->name('destroy');
    });

    //Abouts
    /** About page Routes */
    Route::prefix('abouts')->name('abouts.')->group(function () {
        Route::get('/', [AboutController::class, 'index'])->name('index');
        Route::put('/update', [AboutController::class, 'update'])->name('update');
    });

    //Menu Items
    Route::prefix('menu_items')->name('menu_items.')->group(function () {
        Route::put('change-status', [MenuItemController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('get-parent', [MenuItemController::class, 'getParentMenuItems'])
            ->name('get-parent');
        Route::get('/', [MenuItemController::class, 'index'])->name('index');
        Route::get('/create', [MenuItemController::class, 'create'])->name('create');
        Route::post('/', [MenuItemController::class, 'store'])->name('store');
        Route::get('/{menu_items}', [MenuItemController::class, 'show'])->name('show');
        Route::get('/{menu_items}/edit', [MenuItemController::class, 'edit'])->name('edit');
        Route::put('/{menu_items}', [MenuItemController::class, 'update'])->name('update');
        Route::delete('/{menu_items}', [MenuItemController::class, 'destroy'])->name('destroy');
    });

    // Settings
    /** Setting Routes */
    Route::get('setting', [SettingController::class, 'index'])->name('settings.index');
    Route::put('logo-setting-update', [SettingController::class, 'logoSettingUpdate'])->name('logo-setting-update');
    Route::put('general-setting-update', [SettingController::class, 'GeneralSettingUpdate'])->name('general-setting-update');


    //blog
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::put('change-status', [BlogController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('/{blogs}', [BlogController::class, 'show'])->name('show');
        Route::get('/{blogs}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/{blogs}', [BlogController::class, 'update'])->name('update');
        Route::delete('/{blogs}', [BlogController::class, 'destroy'])->name('destroy');
    });

    // // user
    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::put('change-status', [ListAccountController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [ListAccountController::class, 'index'])->name('index');
        // Route::get('/create', [ListAccountController::class, 'create'])->name('create');
        // Route::post('/', [ListAccountController::class, 'store'])->name('store');
        Route::get('/{accounts}', [ListAccountController::class, 'show'])->name('show');
        Route::get('/{accounts}/edit', [ListAccountController::class, 'edit'])->name('edit');
        Route::put('/{accounts}', [ListAccountController::class, 'update'])->name('update');
        Route::delete('/{accounts}', [ListAccountController::class, 'destroy'])->name('destroy');
    });

    //Coupons
    Route::prefix('coupons')->name('coupons.')->group(function () {
        Route::put('change-status', [CouponController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/{coupons}', [CouponController::class, 'show'])->name('show');
        Route::get('/{coupons}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::put('/{coupons}', [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupons}', [CouponController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('blog_comments')->name('blog_comments.')->group(function () {
        Route::get('/', [BlogCommentController::class, 'index'])->name('index');
        Route::delete('/{blog_comments}', [BlogCommentController::class, 'destroy'])->name('destroy');
    });

    //advertisement
    Route::prefix('advertisement')->name('advertisement.')->group(function () {
        Route::get('/', [AdvertisementsController::class, 'index'])->name('index');
        Route::put('homepage-banner-section-one', [AdvertisementsController::class, 'homepageBannerSectionOne'])->name('homepage-banner-section-one');
        Route::put('homepage-banner-section-two', [AdvertisementsController::class, 'homepageBannerSectionTwo'])->name('homepage-banner-section-two');
        Route::put('homepage-banner-section-three', [AdvertisementsController::class, 'homepageBannerSectionThree'])->name('homepage-banner-section-three');
        Route::put('homepage-banner-section-four', [AdvertisementsController::class, 'homepageBannerSectionFour'])->name('homepage-banner-section-four');
        Route::put('productpage-banner', [AdvertisementsController::class, 'productPageBanner'])->name('productpage-banner');
        Route::put('cartpage-banner', [AdvertisementsController::class, 'cartPageBanner'])->name('cartpage-banner');
    });

    //Product
    Route::prefix('products')->name('products.')->group(function () {
        // Route::put('change-status', [CouponController::class, 'changeStatus'])
        //     ->name('change-status');
        Route::delete('/variants/{variantId}', [AdminProductController::class, 'destroyVariant'])->name('destroy-variant');
        Route::post('/upload', [AdminProductController::class, 'uploadImageGalleries'])->name('upload');
        Route::get('/', [AdminProductController::class, 'index'])->name('index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('create');
        Route::post('/', [AdminProductController::class, 'store'])->name('store');
        Route::get('/{products}', [AdminProductController::class, 'show'])->name('show');
        Route::get('/{products}/edit', [AdminProductController::class, 'edit'])->name('edit');
        Route::put('/{products}', [AdminProductController::class, 'update'])->name('update');
        Route::delete('/{products}', [AdminProductController::class, 'destroy'])->name('destroy');
    });

    //Coupons
    Route::prefix('socials')->name('socials.')->group(function () {
        Route::put('change-status', [SocialController::class, 'socialsChangeStatus'])
            ->name('change-status');
        Route::get('/', [SocialController::class, 'index'])->name('index');
        Route::get('/create', [SocialController::class, 'create'])->name('create');
        Route::post('/', [SocialController::class, 'store'])->name('store');
        Route::get('/{socials}', [SocialController::class, 'show'])->name('show');
        Route::get('/{socials}/edit', [SocialController::class, 'edit'])->name('edit');
        Route::put('/{socials}', [SocialController::class, 'update'])->name('update');
        Route::delete('/{socials}', [SocialController::class, 'destroy'])->name('destroy');
    });
});

/** Client Routes */

//blog
Route::get('blog-details/{slug}', [App\Http\Controllers\Client\BlogController::class, 'blogDetails'])->name('blog-details');
Route::get('/blogs/{category?}', [App\Http\Controllers\Client\BlogController::class, 'blogs'])->name('blogs');
Route::post('/comments', [App\Http\Controllers\Client\BlogController::class, 'comments'])->name('comments');
Route::get('/comments', [App\Http\Controllers\Client\BlogController::class, 'getAllComments'])->name('get-comments');

//about
Route::get('/abouts', [App\Http\Controllers\Client\AboutController::class, 'index'])->name('about');

    //logo
//    Route::get('/logo', [App\Http\Controllers\Client\SettingController::class, 'index'])->name('logo');

//product

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('getProducts');
    Route::get('/ajax', [ProductController::class, 'ajaxIndex'])->name('ajaxGetProducts');
});
