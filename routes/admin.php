<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SpecificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserPasswordController;
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
Route::get('login', [LoginController::class, 'showLoginForm'])->withoutMiddleware('auth')->name('login');
Route::post('login', [LoginController::class, 'login'])->withoutMiddleware('auth');
Route::post('logout', [LoginController::class, 'logout'])->withoutMiddleware('auth')->name('logout');

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->withoutMiddleware('auth')->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->withoutMiddleware('auth')->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->withoutMiddleware('auth')->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->withoutMiddleware('auth')->name('password.update');

Route::get('/', DashboardController::class)->name('dashboard');

Route::resources([
    'products' => ProductController::class,
    'customers' => CustomerController::class,
    'orders' => OrderController::class,
    'contacts' => ContactController::class,
    'categories' => CategoryController::class,
    'currencies' => CurrencyController::class,
    'posts' => PostController::class,
]);

Route::resource('carts', CartController::class)->except(['index', 'show']);
Route::resource('medias', MediaController::class)->except(['index', 'show']);
Route::resource('images', ImageController::class)->except(['show', 'edit', 'update']);
Route::resource('brands', BrandController::class)->except('show');
Route::resource('attributes', AttributeController::class)->except('show');
Route::resource('specifications', SpecificationController::class)->except('index');

// User Routes...
Route::resource('users', UserController::class)->except('show');
Route::put('users/{user}/password', [UserPasswordController::class, 'update'])->name('users.password.update');
