<?php

use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SizeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('home', 'App\Http\Controllers\FrontendController@home')->name('home');

    Route::get('T&C', function () { return view('frontend.documents.T-C');})->name('t-c');
    Route::get('refund_policy', function () {
        return view('frontend.documents.refund_policy');
    })->name('refund_policy');
    Route::get('privacy_policy', function () {
        return view('frontend.documents.privacy_policy');
    })->name('privacy_policy');
    Route::get('return_policy', function () {
        return view('frontend.documents.return_policy');
    })->name('return_policy');
    Route::get('shipping_policy', function () {
        return view('frontend.documents.shipping_policy');
    })->name('shipping_policy');


   
    

Route::group(['as' => 'public.', 'namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', 'FrontendController@index')->name('index');
    Route::get('shop', 'FrontendController@shop')->name('shop');
    Route::get('/shop/filter', [ProductController::class, 'filterProducts'])->name('shop.filter');
    Route::get('/shop/{page}', [ProductController::class, 'categoryProducts'])->name('shop.page');
    Route::get('wishlist', 'FrontendController@getWishlist')->name('wishlist');
    Route::get('quick-view', 'FrontendController@QuickView')->name('quick-view');
    Route::get('/get-variation-details', [FrontendController::class, 'getVariationDetails']);
    Route::get('/add-to-cart', [FrontendController::class, 'addToCart']);
    

    Route::get('product/{uid}/{slug}', 'FrontendController@product')->name('product');
    
    Route::get('services', 'FrontendController@services')->name('services');
    Route::get('services/{slug}', 'FrontendController@serviceSingle')->name('services-single');
    Route::get('doctors', 'FrontendController@doctors')->name('doctors');
    Route::get('doctors/{slug}', 'FrontendController@doctorSingle')->name('doctors-single');
    Route::get('packages', 'FrontendController@packages')->name('packages');
    Route::get('packages/{slug}', 'FrontendController@packageSingle')->name('packages-single');
    Route::get('blogs', 'FrontendController@blogs')->name('blogs');
    Route::get('blogs/category/{slug}', 'FrontendController@blogCategory')->name('blog-category');
    Route::get('blogs/{slug}', 'FrontendController@blogSingle')->name('blog-single');
    Route::get('contact-us', 'FrontendController@contact')->name('contact');
    Route::post('contact-us', 'FrontendController@contactSend')->name('contact-send');
    Route::get('about-us', 'FrontendController@about')->name('about');
    Route::post('appointment', 'FrontendController@appointment')->name('appointment');
});


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth:web'],'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers'], function () {
    // Route::get('dashboard', function () {
    //     // $averageSessionDuration = Analytics::averageSessionDuration(Period::days(7));

    //     // dd($averageSessionDuration);
    //     return view('admin.dashboard.index');
    // })->name('dashboard');
    
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/products/best-selling', [ProductController::class, 'bestSelling'])->name('best-selling.index');
    Route::post('/products/best-selling', [ProductController::class, 'bestSellingUpdate'])->name('best-selling.update');
    Route::get('/products/featured-products', [ProductController::class, 'featuredProducts'])->name('featured-products.index');
    Route::post('/products/featured-products', [ProductController::class, 'featuredProductsUpdate'])->name('featured-products.update');
    Route::get('/products/stock', [ProductController::class, 'stock'])->name('stock.index');
    Route::post('/products/stock/{id}', [ProductController::class, 'stockUpdate'])->name('stock.update');
    Route::any('/products/art_code-check', [ProductController::class, 'artCodeCheck'])->name('products.art_code-check');
    Route::any('/products/product_no-check', [ProductController::class, 'productNoCheck'])->name('products.product_no-check');
    Route::any('/products/sku-check', [ProductController::class, 'skuCheck'])->name('products.sku-check');
    Route::any('/products/generate-autosku', [ProductController::class, 'generateAutosku'])->name('products.generate-autosku');
    
    

    Route::resource('products', ProductController::class)->names('products');
    Route::resource('orders', OrderController::class)->names('orders');

    Route::get('/subscribers', [CustomerController::class, 'subscribers'])->name('subscribers.index');
    Route::resource('customers', CustomerController::class)->names('customers');
    Route::resource('coupons', CouponController::class)->names('coupons');
    Route::resource('advertisement', AdvertisementController::class)->names('advertisement');
    Route::resource('banners', BannerController::class)->names('banners');
    Route::resource('reviews', ReviewController::class)->names('reviews');
    Route::resource('sizes', SizeController::class)->names('sizes');
    Route::resource('colors', ColorController::class)->names('colors');
    Route::resource('activity', ActivityLogsController::class)->names('activity');
    Route::resource('profile', ProfileController::class)->names('profile');
    Route::resource('blogs', BlogPostController::class)->names('blogs');
    Route::resource('blog-category', BlogCategoryController::class)->names('blogs-category');
});







