<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "auth" middleware groups. Now create something great!
|
*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->withoutMiddleware('auth')->name('login');
Route::post('login', 'Auth\LoginController@login')->withoutMiddleware('auth');
Route::post('logout', 'Auth\LoginController@logout')->withoutMiddleware('auth')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->withoutMiddleware('auth')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->withoutMiddleware('auth')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->withoutMiddleware('auth')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->withoutMiddleware('auth')->name('password.update');

Route::get('/', 'DashboardController')->name('dashboard');

Route::resource('products', 'ProductController');
Route::resource('customers', 'CustomerController')->except('show');
Route::resource('orders', 'OrderController');
Route::resource('carts', 'CartController')->except(['index', 'show']);
Route::resource('medias', 'MediaController')->only(['create', 'store', 'destroy']);
Route::resource('images', 'ImageController')->except(['show', 'edit', 'update']);
Route::resource('brands', 'BrandController')->except('show');
Route::resource('categories', 'CategoryController');
Route::resource('attributes', 'AttributeController')->except('show');
Route::resource('specifications', 'SpecificationController')->only(['create', 'store', 'destroy']);

// User Routes...
Route::resource('users', 'UserController')->except('show');
Route::put('users/{user}/password', 'UserPasswordController@update')->name('users.password.update');
