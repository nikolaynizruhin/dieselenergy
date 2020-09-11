<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Category\ProductController;

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
Route::resource('contacts', ContactController::class)->only('store');
Route::resource('carts', CartController::class);
Route::resource('orders', OrderController::class)->only(['store', 'show']);
Route::resource('categories.products', ProductController::class)->shallow()->only(['index', 'show']);
