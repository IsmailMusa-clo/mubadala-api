<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\OfferController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Models\Offer;
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

Route::get('/', function () {
    return view('layouts.parent');
});

Route::get('/dashboard', function () {
    return view('layouts.parent');
});

Route::middleware('guest')->prefix('dashboard')->group(function () {
    Route::put('users/{user}/update/user-image', [UserController::class, 'updateUserImage'])->name('user.update-image');
    Route::resource('users', UserController::class);
    Route::get('products', [ProductController::class, 'index'])->name('dproducts.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('dproducts.show');
    Route::delete('products/{product}/delete', [ProductController::class, 'destroy']);
    Route::resource('categories', CategoryController::class);
    Route::get('offers', [OfferController::class, 'index'])->name('doffers.index');
    Route::get('offers/{offer}', [OfferController::class, 'show'])->name('doffers.show');
    Route::delete('offers/{offer}/delete', [OfferController::class, 'destroy']);
});
