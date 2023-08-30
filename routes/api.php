<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function() {

    Route::post('profile', 'API\UserController@profile');

    Route::post('rollcall', 'API\UserController@rollcall');
    Route::post('rollcall/add', 'API\UserController@addRollCall');
    Route::post('rollcall/count', 'API\UserController@totalRollCall');
    
    Route::post('wallet/policy/{id?}', 'API\WalletController@policy')->where('id', '[1-2]');
    Route::post('wallet/balance', 'API\WalletController@balance');

});



Route::get('/address/provinces', 'API\AddressController@getProvinces');
Route::get('/address/districts/{province_code}', 'API\AddressController@getDistricts');
Route::get('/address/wards/{district_code}', 'API\AddressController@getWards');
Route::post('/check-fee-ship', 'API\AddressController@checkFeeShip');


//api cho metadsv.com thực hiện chức năng subscribe
Route::post('subscribe-metadsv', 'API\UserController@subscribe_metadsv_com');
Route::get('get-all-product', 'API\ProductController@getAllProduct');
Route::get('get-product/{id}', 'API\ProductController@getProduct');
Route::get('get-all-category', 'API\CategoryController@getAllCategory');

