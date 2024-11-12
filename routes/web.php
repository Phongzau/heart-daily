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
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewletterPopupController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PaypalSettingController;
use App\Http\Controllers\Admin\VnpaySettingController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\OrderUserController;
use App\Http\Controllers\Client\WishlistController;
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
//profile
Route::middleware('auth')->group(function () {
    Route::get('user/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
    Route::put('/reset-password', [UserController::class, 'resetPassword'])->name('reset.password.submit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/user/update-address', [UserController::class, 'createOrUpdateAddress'])->name('user.updateAddress');
    Route::get('/provinces', [UserController::class, 'getProvinces']);
    Route::get('/provinces/{province_id}/districts', [UserController::class, 'getDistrictsByProvince']);
    Route::get('/districts/{district_id}/communes', [UserController::class, 'getCommunesByDistrict']);
});
//blog
Route::get('blog-details/{slug}', [App\Http\Controllers\Client\BlogController::class, 'blogDetails'])->name('blog-details');
Route::get('/blogs/{category?}', [App\Http\Controllers\Client\BlogController::class, 'blogs'])->name('blogs');
Route::post('/comments', [App\Http\Controllers\Client\BlogController::class, 'comments'])->name('comments');
Route::get('/comments', [App\Http\Controllers\Client\BlogController::class, 'getAllComments'])->name('get-comments');

///review
Route::post('/reviews', [App\Http\Controllers\Client\ProductController::class, 'reviews'])->name('reviews');
Route::get('/reviews', [App\Http\Controllers\Client\ProductController::class, 'getAllReviews'])->name('get-reviews');

//about
Route::get('/abouts', [App\Http\Controllers\Client\AboutController::class, 'index'])->name('about');

//product

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('getProducts');
    Route::get('/ajax', [ProductController::class, 'ajaxIndex'])->name('ajaxGetProducts');
    Route::get('/{slug}', [ProductController::class, 'productDetail'])->name('detail');
});

// routes/api.php
// Route::get('/tags', [TagController::class, 'getTags']);
// routes/web.php






Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('cart', [CartController::class, 'cartDetails'])->name('cart-details');
Route::post('cart/update-quantity', [CartController::class, 'updateProductQty'])->name('cart.update-quantity');
Route::get('cart/product-total', [CartController::class, 'cartTotal'])->name('cart.product-total');
Route::get('apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('coupon-calculation', [CartController::class, 'couponCalculation'])->name('coupon-calculation');
Route::get('clear-cart', [CartController::class, 'clearCart'])->name('clear.cart');
Route::get('cart/remove-product/{cartKey}', [CartController::class, 'removeProduct'])->name('cart.remove-product');
Route::get('get-cart-count', [CartController::class, 'getCartCount'])->name('cart-count');
Route::get('cart-products', [CartController::class, 'getCartProducts'])->name('cart-products');
Route::post('cart/remove-sidebar-product', [CartController::class, 'removeSidebarProduct'])->name('cart.remove-sidebar-product');
//popup
Route::post('/newsletter-subscribe', [NewletterPopupController::class, 'subscribe'])->name('newsletter.subscribe');
Route::delete('/subscribers/{id}', [NewletterPopupController::class, 'destroySubscribe'])->name('subscribers.destroy');

//checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/order-complete', [CheckoutController::class, 'orderComplete'])->name('order.complete');
Route::get('/payment', [CheckoutController::class, 'createPayment'])->name('payment.create');
Route::get('/vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
Route::get('/momo', [CheckoutController::class, 'createMoMoPayment'])->name('momo.create');
Route::get('/momo-return', [CheckoutController::class, 'momoReturn'])->name('momo.return');
Route::get('paypal/payment', [CheckoutController::class, 'payWithPaypal'])->name('paypal.payment');
Route::get('paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('paypal.cancel');


//wishlist
Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::post('/update_wishlist', [ProductController::class, 'updateWishlist'])->name('updateWishlist');
    Route::get('/total_wishlist', [ProductController::class, 'totalWishlist'])->name('totalWishlist');
    Route::delete('/{id}', [WishlistController::class, 'remove'])->name('remove');
    Route::get('/', [WishlistController::class, 'index'])->name('index');
});

//Order User
Route::post('cancel-order', [OrderUserController::class, 'cancelOrder'])->name('cancel-order');
Route::post('confirm-order', [OrderUserController::class, 'confirmOrder'])->name('confirm-order');
Route::post('re-order', [OrderUserController::class, 'reOrder'])->name('re-order');
//chat

Route::get('/chat/{id?}', function ($id = null) {
    return view('client.page.chat', [
        'id' => $id
    ]);
})->middleware(['auth'])->name('chat');


Route::get('/contact', function () {
    return view('client.page.contact');
})->name('contact');



//admin
Route::prefix('admin')->name('admin.')->group(function () {

    //dashboard
    Route::middleware('permission:view-dashboard')->prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/order-statistics/{month}', [DashboardController::class, 'orderStatistics'])->name('order-statistics');
        Route::get('/yearly-statistics', [DashboardController::class, 'yearlyStatistics'])->name('yearly-statistics');
        Route::get('/top-products/{period}', [DashboardController::class, 'topProducts'])->name('top-products');
        // Route::get('/brand-statistics/{period}', [DashboardController::class, 'brandStatistics'])->name('brand-statistics');
    });
    // admin profile
    Route::get('/profile', [AdminProfileController::class, 'AdminProfile'])->name('profile');
    Route::post('/update', [AdminProfileController::class, 'AdminProfileUpdate'])->name('profile.update');
    Route::put('profile/update/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');

    //Brands
    Route::middleware('permission:view-brands')->prefix('brands')->name('brands.')->group(function () {
        Route::put('change-status', [BrandController::class, 'changeStatus'])->name('change-status');
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create')->middleware('permission:create-brands');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/edit/{brands}', [BrandController::class, 'edit'])->name('edit')->middleware('permission:edit-brands');
        Route::put('/update/{brands}', [BrandController::class, 'update'])->name('update');
        Route::delete('/destroy/{brands}', [BrandController::class, 'destroy'])->name('destroy')->middleware('permission:delete-brands');
    });

    //banner
    Route::middleware('permission:view-banners')->prefix('banners')->name('banners.')->group(function () {
        Route::put('change-status', [BannerController::class, 'changeStatus'])->name('change-status');
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/create', [BannerController::class, 'create'])->name('create')->middleware('permission:create-banners');
        Route::post('/store', [BannerController::class, 'store'])->name('store');
        Route::get('/edit/{banner}', [BannerController::class, 'edit'])->name('edit')->middleware('permission:edit-banners');
        Route::put('/update/{banner}', [BannerController::class, 'update'])->name('update');
        Route::delete('/destroy/{banner}', [BannerController::class, 'destroy'])->name('destroy')->middleware('permission:delete-banners');

        Route::post('/upload-image', [BannerController::class, 'uploadImage'])->name('upload.image');
    });

    //role
    Route::middleware(['role:admin|super_admin'])->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

    //category_attributes
    Route::middleware('permission:view-categories-attributes')->prefix('category_attributes')->name('category_attributes.')->group(function () {
        Route::put('change-status', [AdminCategoryAttributeController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/get-category-attributes', [AdminCategoryAttributeController::class, 'getCategoryAttributes'])->name('get-category-attributes');
        Route::get('/', [AdminCategoryAttributeController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoryAttributeController::class, 'create'])->name('create')->middleware('permission:create-categories-attributes');
        Route::post('/', [AdminCategoryAttributeController::class, 'store'])->name('store');
        Route::get('/{category_attribute}', [AdminCategoryAttributeController::class, 'show'])->name('show');
        Route::get('/{category_attribute}/edit', [AdminCategoryAttributeController::class, 'edit'])->name('edit')->middleware('permission:edit-categories-attributes');
        Route::put('/{category_attribute}', [AdminCategoryAttributeController::class, 'update'])->name('update');
        Route::delete('/{category_attribute}', [AdminCategoryAttributeController::class, 'destroy'])->name('destroy')->middleware('permission:delete-categories-attributes');
    });

    //attributes
    Route::middleware('permission:view-attributes')->prefix('attributes')->name('attributes.')->group(function () {
        Route::put('change-status', [AdminAttributeController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/get-attributes/{id}', [AdminAttributeController::class, 'getAttributes'])->name('get-attributes');
        Route::get('/', [AdminAttributeController::class, 'index'])->name('index');
        Route::get('/create', [AdminAttributeController::class, 'create'])->name('create')->middleware('permission:create-attributes');
        Route::post('/', [AdminAttributeController::class, 'store'])->name('store');
        Route::get('/{attribute}', [AdminAttributeController::class, 'show'])->name('show');
        Route::get('/{attribute}/edit', [AdminAttributeController::class, 'edit'])->name('edit')->middleware('permission:edit-attributes');
        Route::put('/{attribute}', [AdminAttributeController::class, 'update'])->name('update');
        Route::delete('/{attribute}', [AdminAttributeController::class, 'destroy'])->name('destroy')->middleware('permission:delete-attributes');
    });

    //category_product
    Route::middleware('permission:view-categories-products')->prefix('category_products')->name('category_products.')->group(function () {
        Route::put('change-status', [AdminCategoryProductController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('get-parent', [AdminCategoryProductController::class, 'getParentCategory'])
            ->name('get-parent');
        Route::get('/', [AdminCategoryProductController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoryProductController::class, 'create'])->name('create')->middleware('permission:create-categories-products');
        Route::post('/', [AdminCategoryProductController::class, 'store'])->name('store');
        Route::get('/{category_products}', [AdminCategoryProductController::class, 'show'])->name('show');
        Route::get('/{category_products}/edit', [AdminCategoryProductController::class, 'edit'])->name('edit')->middleware('permission:edit-categories-products');
        Route::put('/{category_products}', [AdminCategoryProductController::class, 'update'])->name('update');
        Route::delete('/{category_products}', [AdminCategoryProductController::class, 'destroy'])->name('destroy')->middleware('permission:delete-categories-products');
    });

    //menu
    Route::middleware('permission:view-menus')->prefix('menus')->name('menus.')->group(function () {
        Route::put('change-status', [MenuController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create')->middleware('permission:create-menus');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('/{menus}', [MenuController::class, 'show'])->name('show');
        Route::get('/{menus}/edit', [MenuController::class, 'edit'])->name('edit')->middleware('permission:edit-menus');
        Route::put('/{menus}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menus}', [MenuController::class, 'destroy'])->name('destroy')->middleware('permission:delete-menus');
    });

    //blogs categories
    Route::middleware('permission:view-blog-categories')->prefix('blog_categories')->name('blog_categories.')->group(function () {
        Route::put('change-status', [AdminBlogCategoryController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [AdminBlogCategoryController::class, 'index'])->name('index');
        Route::get('/create', [AdminBlogCategoryController::class, 'create'])->name('create')->middleware('permission:create-blog-categories');
        Route::post('/', [AdminBlogCategoryController::class, 'store'])->name('store');
        Route::get('/{blog_categories}', [AdminBlogCategoryController::class, 'show'])->name('show');
        Route::get('/{blog_categories}/edit', [AdminBlogCategoryController::class, 'edit'])->name('edit')->middleware('permission:edit-blog-categories');
        Route::put('/{blog_categories}', [AdminBlogCategoryController::class, 'update'])->name('update');
        Route::delete('/{blog_categories}', [AdminBlogCategoryController::class, 'destroy'])->name('destroy')->middleware('permission:delete-blog-categories');
    });

    //Abouts
    /** About page Routes */
    Route::middleware('permission:view-abouts')->prefix('abouts')->name('abouts.')->group(function () {
        Route::get('/', [AboutController::class, 'index'])->name('index');
        Route::put('/update', [AboutController::class, 'update'])->name('update');
    });

    //Menu Items
    Route::middleware('permission:view-menu-items')->prefix('menu_items')->name('menu_items.')->group(function () {
        Route::put('change-status', [MenuItemController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('get-parent', [MenuItemController::class, 'getParentMenuItems'])
            ->name('get-parent');
        Route::get('/', [MenuItemController::class, 'index'])->name('index');
        Route::get('/create', [MenuItemController::class, 'create'])->name('create')->middleware('permission:create-menu-items');
        Route::post('/', [MenuItemController::class, 'store'])->name('store');
        Route::get('/{menu_items}', [MenuItemController::class, 'show'])->name('show');
        Route::get('/{menu_items}/edit', [MenuItemController::class, 'edit'])->name('edit')->middleware('permission:edit-menu-items');
        Route::put('/{menu_items}', [MenuItemController::class, 'update'])->name('update');
        Route::delete('/{menu_items}', [MenuItemController::class, 'destroy'])->name('destroy')->middleware('permission:delete-menu-items');
    });

    // Settings
    /** Setting Routes */
    Route::middleware('permission:view-settings')->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('logo-setting-update', [SettingController::class, 'logoSettingUpdate'])->name('logo-setting-update');
        Route::put('general-setting-update', [SettingController::class, 'GeneralSettingUpdate'])->name('general-setting-update');
    });


    //blog
    Route::middleware('permission:view-blogs')->prefix('blogs')->name('blogs.')->group(function () {
        Route::put('change-status', [BlogController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/create', [BlogController::class, 'create'])->name('create')->middleware('permission:create-blogs');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('/{blogs}', [BlogController::class, 'show'])->name('show');
        Route::get('/{blogs}/edit', [BlogController::class, 'edit'])->name('edit')->middleware('permission:edit-blogs');
        Route::put('/{blogs}', [BlogController::class, 'update'])->name('update');
        Route::delete('/{blogs}', [BlogController::class, 'destroy'])->name('destroy')->middleware('permission:delete-blogs');
    });

    // user
    Route::middleware('permission:view-accounts')->prefix('accounts')->name('accounts.')->group(function () {
        Route::put('change-status', [ListAccountController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [ListAccountController::class, 'index'])->name('index');
        // Route::get('/create', [ListAccountController::class, 'create'])->name('create');
        // Route::post('/', [ListAccountController::class, 'store'])->name('store');
        Route::get('/{accounts}', [ListAccountController::class, 'show'])->name('show');
        Route::get('/{accounts}/edit', [ListAccountController::class, 'edit'])->name('edit')->middleware('permission:edit-accounts');
        Route::put('/{accounts}', [ListAccountController::class, 'update'])->name('update');
        Route::delete('/{accounts}', [ListAccountController::class, 'destroy'])->name('destroy')->middleware('permission:edit-accounts');
    });

    //Coupons
    Route::middleware('permission:view-coupons')->prefix('coupons')->name('coupons.')->group(function () {
        Route::put('change-status', [CouponController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create')->middleware('permission:create-coupons');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/{coupons}', [CouponController::class, 'show'])->name('show');
        Route::get('/{coupons}/edit', [CouponController::class, 'edit'])->name('edit')->middleware('permission:edit-coupons');
        Route::put('/{coupons}', [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupons}', [CouponController::class, 'destroy'])->name('destroy')->middleware('permission:delete-coupons');
    });

    //comment blogs
    Route::middleware('permission:view-blog-comments')->prefix('blog_comments')->name('blog_comments.')->group(function () {
        Route::get('/', [BlogCommentController::class, 'index'])->name('index');
        Route::delete('/{blog_comments}', [BlogCommentController::class, 'destroy'])->name('destroy')->middleware('permission:delete-blog-comments');
    });

    //product_review
    Route::middleware('permission:view-reviews')->prefix('product_reviews')->name('product_reviews.')->group(function () {
        Route::get('/', [ProductReviewController::class, 'index'])->name('index');
        // Route::post('/reviews', [ProductReviewController::class, 'store'])->name('review.store');
        Route::post('/reviews', [ProductController::class, 'reviews'])->name('review.store');
        Route::delete('/{product_review}', [ProductReviewController::class, 'destroy'])->name('destroy')->middleware('permission:delete-reviews');
        // Route::get('/reviews', [ProductController::class, 'getAllReviews'])->name('list');
    });


    //advertisement
    Route::middleware('permission:view-advertisements')->prefix('advertisement')->name('advertisement.')->group(function () {
        Route::put('change-status', [AdvertisementsController::class, 'changeStatus'])
            ->name('change-status');
        Route::get('/', [AdvertisementsController::class, 'index'])->name('index');
        Route::put('homepage-banner-section-one', [AdvertisementsController::class, 'homepageBannerSectionOne'])->name('homepage-banner-section-one');
        Route::put('homepage-banner-section-two', [AdvertisementsController::class, 'homepageBannerSectionTwo'])->name('homepage-banner-section-two');
        Route::put('homepage-banner-section-three', [AdvertisementsController::class, 'homepageBannerSectionThree'])->name('homepage-banner-section-three');
        Route::put('homepage-banner-section-four', [AdvertisementsController::class, 'homepageBannerSectionFour'])->name('homepage-banner-section-four');
        Route::put('productpage-banner', [AdvertisementsController::class, 'productPageBanner'])->name('productpage-banner');
        Route::put('cartpage-banner', [AdvertisementsController::class, 'cartPageBanner'])->name('cartpage-banner');
    });

    //Product
    Route::middleware('permission:view-products')->prefix('products')->name('products.')->group(function () {
        Route::put('change-status', [AdminProductController::class, 'changeStatus'])
            ->name('change-status');
        Route::delete('/product-attributes/{prdAttributeId}', [AdminProductController::class, 'destroyProductAttribute'])->name('destroy-product-attributes');
        Route::delete('/variants/{variantId}', [AdminProductController::class, 'destroyVariant'])->name('destroy-variant');
        Route::post('/upload', [AdminProductController::class, 'uploadImageGalleries'])->name('upload');
        Route::get('/', [AdminProductController::class, 'index'])->name('index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('create')->middleware('permission:create-products');
        Route::post('/', [AdminProductController::class, 'store'])->name('store');
        Route::get('/{products}', [AdminProductController::class, 'show'])->name('show');
        Route::get('/{products}/edit', [AdminProductController::class, 'edit'])->name('edit')->middleware('permission:edit-products');
        Route::put('/{products}', [AdminProductController::class, 'update'])->name('update');
        Route::delete('/{products}', [AdminProductController::class, 'destroy'])->name('destroy')->middleware('permission:delete-products');
    });

    //Socials
    Route::middleware('permission:view-socials')->prefix('socials')->name('socials.')->group(function () {
        Route::put('change-status', [SocialController::class, 'socialsChangeStatus'])
            ->name('change-status');
        Route::get('/', [SocialController::class, 'index'])->name('index');
        Route::get('/create', [SocialController::class, 'create'])->name('create')->middleware('permission:create-socials');
        Route::post('/', [SocialController::class, 'store'])->name('store');
        Route::get('/{socials}', [SocialController::class, 'show'])->name('show');
        Route::get('/{socials}/edit', [SocialController::class, 'edit'])->name('edit')->middleware('permission:edit-socials');
        Route::put('/{socials}', [SocialController::class, 'update'])->name('update');
        Route::delete('/{socials}', [SocialController::class, 'destroy'])->name('destroy')->middleware('permission:delete-socials');
    });

    //popup
    Route::middleware('permission:view-popups')->prefix('popups')->name('popups.')->group(function () {
        Route::put('change-status', [NewletterPopupController::class, 'changeStatus'])->name('change-status');
        Route::get('/', [NewletterPopupController::class, 'index'])->name('index');
        Route::get('/create', [NewletterPopupController::class, 'create'])->name('create')->middleware('permission:create-popups');
        Route::post('/store', [NewletterPopupController::class, 'store'])->name('store');
        Route::get('/edit/{popup}', [NewletterPopupController::class, 'edit'])->name('edit')->middleware('permission:edit-popups');
        Route::put('/update/{popup}', [NewletterPopupController::class, 'update'])->name('update');
        Route::delete('/destroy/{popup}', [NewletterPopupController::class, 'destroy'])->name('destroy')->middleware('permission:delete-popups');
        Route::post('/upload-image', [NewletterPopupController::class, 'uploadImage'])->name('upload.image');
    });

    //Tags
    Route::middleware('permission:view-tags')->prefix('tags')->name('tags.')->group(function () {
        Route::put('change-status', [TagController::class, 'tagsChangeStatus'])
            ->name('change-status');
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('/create', [TagController::class, 'create'])->name('create')->middleware('permission:create-tags');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::get('/{tags}', [TagController::class, 'show'])->name('show');
        Route::get('/{tags}/edit', [TagController::class, 'edit'])->name('edit')->middleware('permission:edit-tags');
        Route::put('/{tags}', [TagController::class, 'update'])->name('update');
        Route::delete('/{tags}', [TagController::class, 'destroy'])->name('destroy')->middleware('permission:delete-tags');
    });

    //payment srtting
    Route::middleware('permission:view-payment-settings')->prefix('payment-settings')->name('payment-settings.')->group(function () {
        Route::prefix('vnpay-setting')->name('vnpay-setting.')->group(function () {
            Route::get('/', [VnpaySettingController::class, 'index'])->name('index');
            Route::put('/{id}', [VnpaySettingController::class, 'update'])->name('update');
        });
        Route::prefix('paypal-setting')->name('paypal-setting.')->group(function () {
            Route::put('/{paypal_setting}', [PaypalSettingController::class, 'update'])->name('update');
            Route::post('/', [PaypalSettingController::class, 'store'])->name('store');
        });
    });

    /** Order Route **/
    Route::middleware('permission:view-orders')->prefix('orders')->name('orders.')->group(function () {
        Route::get('payment-status', [OrderController::class, 'changePaymentStatus'])->name('payment.status');
        Route::get('order-status', [OrderController::class, 'changeOrderStatus'])->name('order.status');
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{orders}', [OrderController::class, 'show'])->name('show')->middleware('permission:edit-orders');
        Route::delete('/{orders}', [OrderController::class, 'destroy'])->name('destroy')->middleware('permission:delete-orders');
    });
});


/** Client Routes */
