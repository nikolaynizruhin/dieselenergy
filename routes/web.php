<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Category\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
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
Route::view('/privacy', 'privacy')->name('privacy');
Route::resource('contacts', ContactController::class)->only('store');
Route::resource('carts', CartController::class);
Route::resource('posts', PostController::class)->only(['index', 'show'])->scoped(['post' => 'slug']);
Route::resource('orders', OrderController::class)->only(['store', 'show']);
Route::get('shop/{category:slug}', [ProductController::class, 'index'])->name('categories.products.index');
Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
