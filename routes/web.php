<?php

// echo "xong roi nha a";die;

use Illuminate\Support\Facades\Route;



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/

// Route::get('/',function(){

//     return view('errors.show404');

// })->name('home');



Auth::routes(['register'=>false]);

// Login

Route::get('user/login','FrontendController@login')->name('login.form');

Route::post('user/login','FrontendController@loginSubmit')->name('login.submit');

Route::get('user/logout','FrontendController@logout')->name('user.logout');

// Register

Route::get('user/register','FrontendController@register')->name('register.form');

Route::post('user/register','FrontendController@registerSubmit')->name('register.submit');

// Reset password

Route::get('forgot-password', 'FrontendController@passwordRequest')->name('password.request');

Route::post('forgot-password', 'FrontendController@passwordEmail')->name('password.email');

Route::get('password-reset', 'FrontendController@passwordReset')->name('password.reset');

Route::post('password-reset', 'FrontendController@passwordUpdate')->name('password.update');

// Socialite

Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');

Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');



Route::get('/','FrontendController@home')->name('home');


// Frontend Routes

Route::get('/home', 'FrontendController@index');

Route::get('/about-us','FrontendController@aboutUs')->name('about-us');

Route::get('/contact','FrontendController@contact')->name('contact');

Route::post('/contact/message','MessageController@store')->name('contact.store');

Route::get('product-detail/{slug}','FrontendController@productDetail')->name('product-detail');

Route::get('/product/search','FrontendController@productSearch')->name('product.search');

Route::get('/product-cat/{slug}','FrontendController@productCat')->name('product-cat');

// Route::get('/product-sub-cat/{slug}/{sub_slug}','FrontendController@productSubCat')->name('product-sub-cat');

Route::get('/product-brand/{slug}','FrontendController@productBrand')->name('product-brand');

// Cart section

Route::get('/add-to-cart/{slug}','CartController@addToCart')->name('add-to-cart')->middleware('user');

Route::post('/add-to-cart','CartController@singleAddToCart')->name('single-add-to-cart')->middleware('user');

Route::get('cart-delete/{id}','CartController@cartDelete')->name('cart-delete');

Route::post('cart-update','CartController@cartUpdate')->name('cart.update');



Route::get('/cart',function(){

    return view('frontend.pages.cart');

})->name('cart');

Route::get('/cart/shop/{brand_id}',function($brand_id){

    return view('frontend.pages.cart-shop', compact('brand_id'));

})->name('cart.shop');

Route::get('/checkout/{brand_id}','CartController@checkoutBrand')->name('checkout.brand')->middleware('user');

Route::get('/checkout','CartController@checkout')->name('checkout')->middleware('user');

// Wishlist

Route::get('/wishlist',function(){

    return view('frontend.pages.wishlist');

})->name('wishlist');

Route::get('/wishlist/{slug}','WishlistController@wishlist')->name('add-to-wishlist')->middleware('user');

Route::get('wishlist-delete/{id}','WishlistController@wishlistDelete')->name('wishlist-delete');

Route::post('cart/order','OrderController@store')->name('cart.order');

Route::get('order/pdf/{orderNumber}','OrderController@pdf')->name('order.pdf');

Route::get('/income','OrderController@incomeChart')->name('product.order.income');

// Route::get('/user/chart','AdminController@userPieChart')->name('user.piechart');

Route::get('/products','FrontendController@productGrids')->name('product-grids');

Route::get('/product-lists','FrontendController@productLists')->name('product-lists'); // remove

Route::match(['get','post'],'/filter','FrontendController@productFilter')->name('shop.filter');

// Order Track

Route::get('/product/track','OrderController@orderTrack')->name('order.track');

Route::post('product/track/order','OrderController@productTrackOrder')->name('product.track.order')->middleware('user');

// Blog

Route::get('/blog','FrontendController@blog')->name('blog');

Route::get('/blog-detail/{slug}','FrontendController@blogDetail')->name('blog.detail');

Route::get('/blog/search','FrontendController@blogSearch')->name('blog.search');

Route::post('/blog/filter','FrontendController@blogFilter')->name('blog.filter');

Route::get('blog-cat/{slug}','FrontendController@blogByCategory')->name('blog.category');

Route::get('blog-tag/{slug}','FrontendController@blogByTag')->name('blog.tag');

// Page

Route::get('/page/{slug}','FrontendController@page')->name('page');

// NewsLetter

Route::post('/subscribe','FrontendController@subscribe')->name('subscribe');

// Product Review

Route::resource('/review','ProductReviewController');

Route::post('product/{slug}/review','ProductReviewController@store')->name('review.store');

// Post Comment

Route::post('post/{slug}/comment','PostCommentController@store')->name('post-comment.store');

Route::resource('/comment','PostCommentController');

// Coupon

Route::post('/coupon-store','CouponController@couponStore')->name('coupon-store');

// Payment

Route::get('payment', 'PayPalController@payment')->name('payment');

Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');

Route::get('payment/success', 'PayPalController@success')->name('payment.success');



// Backend section start
    Route::get('ajax_load_price_size', 'FrontendController@ajax_load_price_size');
    Route::get('ajax_update_active_points', 'OrderController@ajax_update_active_points');
    Route::post('ajax_delete_muti_size', 'ProductController@delete_muti_size');

//Gallery
Route::get('add-gallery/{product_id}','GalleryController@add_gallery');
Route::post('select-gallery','GalleryController@select_gallery');
Route::post('insert-gallery/{pro_id}','GalleryController@insert_gallery');
Route::post('update-gallery-name','GalleryController@update_gallery_name');
Route::post('delete-gallery','GalleryController@delete_gallery');
Route::post('update-gallery','GalleryController@update_gallery');
Route::group(['prefix'=>'/admin','middleware'=>['auth','admin']],function(){

    Route::get('/','AdminController@index')->name('admin');

    Route::get('/file-manager',function(){

        return view('backend.layouts.file-manager');

    })->name('file-manager');

    // User

    Route::resource('users','UsersController');

    // Shop

    Route::get('/shop/{shop_id}','UsersController@shopInfo')->name('shop.info');

    Route::post('/shop/{shop_id}','UsersController@shopApproved')->name('shop.approved');

    // Banner

    Route::resource('banner','BannerController');

    // Brand

    Route::resource('brand','BrandController');

    // Profile

    Route::get('/profile','AdminController@profile')->name('admin-profile');

    Route::post('/profile/{id}','AdminController@profileUpdate')->name('profile-update');

    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');

    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');

    // Category

    Route::resource('/category','CategoryController');

    // Product

    Route::resource('/product','ProductController');

 

    // Ajax for sub category

    Route::post('/category/{id}/child','CategoryController@getChildByParent');

    // POST category

    Route::resource('/post-category','PostCategoryController');

    // Post tag

    Route::resource('/post-tag','PostTagController');

    // Post

    Route::resource('/post','PostController');

    // Message

    Route::resource('/message','MessageController');

    Route::get('/message/five','MessageController@messageFive')->name('messages.five');



    // Order

    Route::resource('/order','OrderController');

    Route::post('/order/bonus-approved','OrderController@bonusApproved')->name('bonus.approved');

    // Shipping

    Route::resource('/shipping','ShippingController');

    // Coupon

    Route::resource('/coupon','CouponController');

    // Settings

    Route::match(['get', 'post'], 'setting/layout','AdminController@settingLayout')->name('setting.layout');

    Route::match(['get', 'post'], 'setting/introduce','AdminController@settingIntroduce')->name('setting.introduce');

    Route::match(['get', 'post'], 'setting/social','AdminController@settingSocial')->name('setting.social');

    Route::match(['get', 'post'], 'setting/payment','AdminController@settingPayment')->name('setting.payment');

    Route::get('settings','AdminController@settings')->name('settings');

    Route::post('setting/update','AdminController@settingsUpdate')->name('settings.update');

    // Wallet manage

    // Route::resource('wallet','WalletController');

    // Page

    Route::resource('/page','PageController');

    // Notification

    Route::get('/notification/{id}','NotificationController@show')->name('admin.notification');

    Route::get('/notifications','NotificationController@index')->name('all.notification');

    Route::delete('/notification/{id}','NotificationController@delete')->name('notification.delete');

    // Wallet

    Route::get('wallet/{id}', 'WalletController@wallet')->name('wallet')->where('id', '[1-2]');

    Route::post('wallet/{id}/update', 'WalletController@walletUpdate')->name('wallet.update');

    Route::post('wallet/{id}/transfer', 'WalletController@walletTransfer')->name('wallet.transfer');

    Route::post('wallet/{id}/ᴡithdraᴡ', 'WalletController@walletWithdraᴡ')->name('wallet.withdraᴡ');

    Route::get('wallet/{id}/request', 'WalletController@walletRequest')->name('wallet.request');

    Route::post('wallet/{id}/request', 'WalletController@walletRequest')->name('wallet.request');

    // Account

    Route::get('affiliate', 'AffiliateController@index')->name('affiliate');

    Route::get('bank', 'BankController@edit')->name('bank.index');

    Route::post('bank/update', 'BankController@update')->name('bank.update');

    // Rollcall

    Route::get('rollcall', 'AdminController@rollCall')->name('rollcall.index');

    Route::get('rollcall/add', 'AdminController@addRollCall')->name('rollcall.add');

});





// User section start

Route::group(['prefix'=>'/user','middleware'=>['user']],function(){

    Route::get('/','User\HomeController@index')->name('user');

    // Profile

    Route::get('/profile','User\HomeController@profile')->name('user.profile');

    Route::post('/profile/{id}','User\HomeController@profileUpdate')->name('user.profile.update');

    Route::get('change-password', 'User\HomeController@changePassword')->name('user.password');

    Route::post('change-password', 'User\HomeController@changPasswordStore')->name('user.password.update');

    //  Order

    Route::get('/order',"User\OrderController@orderIndex")->name('user.order.index');

    Route::get('/order/show/{orderNumber}',"User\OrderController@orderShow")->name('user.order.show');

    Route::delete('/order/delete/{orderNumber}','User\OrderController@userOrderDelete')->name('user.order.delete');

    Route::post('/order/cancel/{orderNumber}','User\OrderController@userOrderCancel')->name('user.order.cancel');

    // Product Review

    Route::get('/user-review','User\ProductReviewController@productReviewIndex')->name('user.productreview.index');

    Route::delete('/user-review/delete/{id}','User\ProductReviewController@productReviewDelete')->name('user.productreview.delete');

    Route::get('/user-review/edit/{id}','User\ProductReviewController@productReviewEdit')->name('user.productreview.edit');

    Route::patch('/user-review/update/{id}','User\ProductReviewController@productReviewUpdate')->name('user.productreview.update');

    // Post comment

    Route::get('user-post/comment','User\PostCommentController@userComment')->name('user.post-comment.index');

    Route::delete('user-post/comment/delete/{id}','User\PostCommentController@userCommentDelete')->name('user.post-comment.delete');

    Route::get('user-post/comment/edit/{id}','User\PostCommentController@userCommentEdit')->name('user.post-comment.edit');

    Route::patch('user-post/comment/udpate/{id}','User\PostCommentController@userCommentUpdate')->name('user.post-comment.update');

    // Wallet

    Route::get('wallet/{id}', 'User\WalletController@wallet')->name('user.wallet')->where('id', '[1-2]');

    Route::post('wallet/{id}/update', 'User\WalletController@walletUpdate')->name('user.wallet.update');

    Route::post('wallet/{id}/transfer', 'User\WalletController@walletTransfer')->name('user.wallet.transfer');

    Route::post('wallet/{id}/ᴡithdraᴡ', 'User\WalletController@walletWithdraᴡ')->name('user.wallet.ᴡithdraᴡ');

    Route::get('wallet/{id}/request', 'User\WalletController@walletRequest')->name('user.wallet.request');

    Route::post('wallet/{id}/request', 'User\WalletController@walletRequest')->name('user.wallet.request');

    // Account

    Route::get('affiliate', 'User\AffiliateController@index')->name('user.affiliate');

    Route::get('bank', 'User\BankController@edit')->name('user.bank.index');

    Route::post('bank/update', 'User\BankController@update')->name('user.bank.update');

    // Seller

    Route::get('shop', 'User\ShopController@shop')->name('user.shop');

    Route::post('shop/register', 'User\ShopController@register')->name('user.shop.register');

    // Rollcall

    Route::get('rollcall', 'User\HomeController@rollCall')->name('user.rollcall.index');

    Route::get('rollcall/add', 'User\HomeController@addRollCall')->name('user.rollcall.add');

});



Route::group(['middleware'=>['user']],function(){

    // User profile - Web layout

    Route::match(['get', 'post'], 'profile','FrontendController@profile')->name('web.user.profile');
    Route::match(['get', 'post'], 'points','FrontendController@points')->name('web.user.points');
    Route::match(['get', 'post'], 'password','FrontendController@password')->name('web.user.password');

    Route::match(['get', 'post'], 'order','FrontendController@order')->name('web.user.order');

    Route::get('token', 'FrontendController@token')->name('web.user.token');

});



// Shop section start

Route::group(['prefix'=>'/shop','middleware'=>['user']],function(){

    // Product

    Route::get('product', 'User\ShopProductController@index')->name('shop.product.index');

    Route::get('product/import', 'User\ShopProductController@import')->name('shop.product.import');

    Route::get('product/detail/{id?}', 'User\ShopProductController@detail')->name('shop.product.detail');

    Route::post('product/importSubmit', 'User\ShopProductController@importSubmit')->name('shop.product.importSubmit');

    Route::post('product/importUpdate', 'User\ShopProductController@importUpdate')->name('shop.product.importUpdate');

    Route::post('product/delete', 'User\ShopProductController@importDelete')->name('shop.product.importDelete');

    // Order

    Route::get('order', 'User\ShopOrderController@index')->name('shop.order.index');

    Route::get('order/show/{orderNumber}', 'User\ShopOrderController@index')->name('shop.order.show');

    // Setting

    Route::match(['get', 'post'], 'setting/layout','User\ShopSettingController@settingLayout')->name('shop.setting.layout');

    Route::match(['get', 'post'], 'setting/introduce','User\ShopSettingController@settingIntroduce')->name('shop.setting.introduce');

    Route::match(['get', 'post'], 'setting/social','User\ShopSettingController@settingSocial')->name('shop.setting.social');

    Route::match(['get', 'post'], 'setting/payment','User\ShopSettingController@settingPayment')->name('shop.setting.payment');

    // Route::get('settings','User\ShopSettingController@settings')->name('shop.settings');

    // Route::post('setting/update','User\ShopSettingController@settingsUpdate')->name('shop.settings.update');

    // Banner

    Route::resource('banner','User\ShopBannerController', ['as' => 'shop']);

    // Page

    Route::resource('page','User\ShopPageController', ['as' => 'shop']);

});



Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {

    \UniSharp\LaravelFilemanager\Lfm::routes();

});



Route::get('php-artisan/{command}', 'ArtisanController@command');

