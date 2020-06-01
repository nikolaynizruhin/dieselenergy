<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('dashboard', 'DashboardController')->name('dashboard');

Route::resource('products', 'ProductController');
Route::resource('customers', 'CustomerController');
Route::resource('orders', 'OrderController');
Route::resource('carts', 'CartController');
Route::resource('medias', 'MediaController');
Route::resource('brands', 'BrandController');
Route::resource('categories', 'CategoryController');
Route::resource('attributes', 'AttributeController');
Route::resource('specifications', 'SpecificationController');

Route::resource('users', 'UserController');
Route::put('users/{user}/password', 'UserPasswordController@update')->name('users.password.update');
