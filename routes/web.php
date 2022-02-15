<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminController::class, 'admin'])->name('admin');
    Route::get('/users', [AdminController::class, 'users'])->name('adminUsers');
    Route::get('/products', [AdminController::class, 'products'])->name('adminProducts');
    Route::get('/categories', [AdminController::class, 'categories'])->name('adminCategories');
    Route::get('/enterAsUser/{id}', [AdminController::class, 'enterAsUser'])->name('enterAsUser');
    Route::post('/createCategory', [AdminController::class, 'createCategory'])->name('createCategory');
    Route::post('/deleteCategory/{id}', [AdminController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/updateCategory', [AdminController::class, 'updateCategory'])->name('updateCategory');
    Route::post('/exportCategories', [AdminController::class, 'exportCategories'])->name('exportCategories');
    Route::post('/deleteExportFile', [AdminController::class, 'deleteExportFile'])->name('deleteExportFile');
    Route::post('/importCategories', [AdminController::class, 'importCategories'])->name('importCategories');
    Route::post('/createProduct', [AdminController::class, 'createProduct'])->name('createProduct');
    Route::post('/exportProducts', [AdminController::class, 'exportProducts'])->name('exportProducts');
    Route::post('/importProducts', [AdminController::class, 'importProducts'])->name('importProducts');
    Route::post('/deleteProduct/{id}', [AdminController::class, 'deleteProduct'])->name('deleteProduct');
    Route::post('/updateProduct', [AdminController::class, 'updateProduct'])->name('updateProduct');
    Route::prefix('roles')->group(function () {
        Route::post('/add', [AdminController::class, 'addRole'])->name('addRole');
        Route::post('/delete', [AdminController::class, 'deleteRole'])->name('deleteRole');
        Route::post('/applyRole/{id}', [AdminController::class, 'applyRole'])->name('applyRole');
    });
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('cart');
    Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
    Route::post('/removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/createOrder', [CartController::class, 'createOrder'])->name('createOrder');
});

Route::get('category/{category}', [HomeController::class, 'category'])->name('category');

Route::get('profile/orders', [ProfileController::class, 'orders'])->name('orders');
Route::get('profile/{user}', [ProfileController::class, 'profile'])->middleware(['auth', 'check_user'])->name('profile');
Route::post('profile/save', [ProfileController::class, 'save'])->name('saveProfile');

Auth::routes();


