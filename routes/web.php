<?php

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
Route::get('/', 'ShopController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/orders', 'ShopController@orders')->name('orders');
Route::get('/shop/get-cart', 'ShopController@get_cart');

// Route::middleware(['auth'])->group(function () {
	Route::post('/shop/add-to-cart', 'ShopController@add_to_cart');
	Route::post('/shop/store-order', 'ShopController@store_order');
// });
