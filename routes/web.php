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

Route::view('/', 'home')->name('home');
Route::resource('contacts', 'ContactController')->only('store');
Route::resource('carts', 'CartController');
Route::resource('orders', 'OrderController')->only(['store', 'show']);
Route::resource('categories.products', 'Category\ProductController')->shallow()->only(['index', 'show']);
