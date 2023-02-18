<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Category\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'home')->name('home');
Route::view('/privacy', 'privacy')->name('privacy');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::resource('contacts', ContactController::class)->only('store');
Route::resource('carts', CartController::class);
Route::resource('orders', OrderController::class)->only(['store', 'show']);
Route::get('shop/{category:slug}', [ProductController::class, 'index'])->name('categories.products.index');
Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('blog', [PostController::class, 'index'])->name('posts.index');
Route::get('blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');
