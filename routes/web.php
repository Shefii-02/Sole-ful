<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BasketController;
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
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route::get('customerOrderNotification', function () { 
//     $order = Order::orderBy('id','desc')->first();
//     return view('email.customerOrderNotification',compact('order'));
// });
// Route::get('adminOrderNotification', function () { 
//     $order = Order::orderBy('id','desc')->first();
//    return view('email.adminOrderNotification',compact('order'));
// });



Route::get('home', 'App\Http\Controllers\FrontendController@home')->name('home');

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
    Route::get('cart-list', 'BasketController@getCartList')->name('cart-list');
    Route::get('cart', 'BasketController@cart')->name('cart-list');
    Route::post('cart/product-add', 'BasketController@cartProductAdd')->name('product-add');
    Route::get('checkout', 'BasketController@checkout')->name('checkout');
    Route::get('gift-code-apply', 'OrderController@giftCodeApply')->name('gift-code-apply');

    Route::get('checkout/calculation', 'OrderController@checkoutCalculation')->name('checkout.calculation');
    
    Route::post('sign-in', 'BasketController@postSignin')->name('signIn');

    Route::get('contact-us', function () { return view('frontend.contact-us');})->name('contact-us');

    
    Route::get('/order-status', [OrderController::class, 'index']);
    
    Route::post('/add-to-cart', [BasketController::class, 'store']);
    Route::get('product/{uid}/{slug}', 'FrontendController@product')->name('product');
    Route::post('place-order', 'OrderController@placeOrder')->name('place-order');
    
    
    Route::get('blogs', 'FrontendController@blogs')->name('blogs');
    Route::get('blogs/category/{slug}', 'FrontendController@blogCategory')->name('blog-category');
    Route::get('blogs/{slug}', 'FrontendController@blogSingle')->name('blog-single');
    Route::post('contact-us', 'FrontendController@contactSend')->name('contact-send');
    Route::get('about-us', 'FrontendController@about')->name('about');
    
    Route::get('/search', [FrontendController::class, 'search'])->name('search');

    Route::any('confirm', [OrderController::class, 'confirmPayment'])->name('confirm');
    

});

Route::post('account/address/create', [AccountController::class, 'addressCreate'])->name('account.address.add');

Route::group(['middleware' => ['auth:web','check.account.user'],'as' => 'account.','prefix' => 'account', 'namespace' => 'App\Http\Controllers\Account'], function (){

    Route::get('/', [AccountController::class, 'myaccount'])->name('home');
    Route::get('orders', [AccountController::class, 'ordersShow'])->name('orders.show');
    Route::post('orders/details/{id}', [AccountController::class, 'ordersDetails'])->name('orders.details');
    Route::post('orders/cancell/{id}', [AccountController::class, 'ordersCancell'])->name('orders.cancell');
    Route::post('orders/track/{id}', [AccountController::class, 'ordersTrack'])->name('orders.track');

    Route::get('address', [AccountController::class, 'addressShow'])->name('address.show');
  
    Route::post('address/update', [AccountController::class, 'addressUpdate'])->name('address.update');
    Route::delete('address/delete/{id}', [AccountController::class, 'addressDelete'])->name('address.delete');

    Route::get('profile', [AccountController::class, 'profileShow'])->name('profile.show');
    Route::post('profile', [AccountController::class, 'profileUpdate'])->name('profile.update');
    Route::post('reset-password', [AccountController::class, 'resetPassword'])->name('profile.reset-password');
    Route::get('support-center', [AccountController::class, 'supportCenter'])->name('support-center');

});

// Auth::routes();

Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 

Auth::routes(['logout' => false,]);

Route::group(['middleware' => ['auth:web','check.account.admin'],'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers'], function () {
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
    
    Route::get('orders', [OrderController::class,'index'])->name('orders.index');
    Route::post('orders/{invoice_id}/update', [OrderController::class,'update'])->name('orders.update');
    Route::get('orders/{invoice_id}/print', [OrderController::class,'printInvoice'])->name('orders.print');
    Route::get('orders/{invoice_id}', [OrderController::class,'show'])->name('orders.show');


    // Route::resource('orders', OrderController::class)->names('orders');
    
    Route::get('profile', [ProfileController::class,'index'])->name('profile');
    Route::post('profile/update', 'ProfileController@updateProfile')->name('profile.update');
    Route::post('profile/update-password', 'ProfileController@changePassword')->name('profile.changePassword');
    

    Route::get('/subscribers', [CustomerController::class, 'subscribers'])->name('subscribers.index');
    Route::resource('customers', CustomerController::class)->names('customers');
    Route::resource('coupons', CouponController::class)->names('coupons');
    Route::resource('advertisement', AdvertisementController::class)->names('advertisement');
    Route::resource('banners', BannerController::class)->names('banners');
    Route::resource('reviews', ReviewController::class)->names('reviews');
    Route::resource('sizes', SizeController::class)->names('sizes');
    Route::resource('colors', ColorController::class)->names('colors');
    Route::resource('activity', ActivityLogsController::class)->names('activity');

    Route::resource('blogs', BlogPostController::class)->names('blogs');
    Route::resource('blog-category', BlogCategoryController::class)->names('blogs-category');
});







