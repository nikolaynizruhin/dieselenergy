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
Route::resource('customers', 'CustomerController');
Route::resource('orders', 'OrderController');
Route::resource('carts', 'CartController');
Route::resource('medias', 'MediaController');
Route::resource('images', 'ImageController');
Route::resource('brands', 'BrandController');
Route::resource('categories', 'CategoryController');
Route::resource('attributes', 'AttributeController');
Route::resource('specifications', 'SpecificationController');

Route::resource('users', 'UserController');
Route::put('users/{user}/password', 'UserPasswordController@update')->name('users.password.update');
