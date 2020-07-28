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

Route::view('/', 'home');
Route::view('/shop', 'shop');
Route::view('/product', 'product');
Route::view('/cart', 'cart');
Route::resource('carts', 'CartController');
Route::resource('categories.products', 'Category\ProductController')->shallow()->only(['index', 'show']);
