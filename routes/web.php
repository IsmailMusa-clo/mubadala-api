<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ChatController;
use App\Http\Controllers\Dashboard\OfferController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\RolePermissionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Models\Offer;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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
})->middleware('auth:admin');

Route::get('/dashboard', function () {
    return view('layouts.parent');
})->middleware('auth:admin');

Route::middleware('guest:admin')->prefix('dashboard')->group(function () {
    Route::get('auth/login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('auth/login', [AuthController::class, 'login']);
});

Route::middleware('auth:admin')->prefix('dashboard/auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::get('profile/edit', [AuthController::class, 'profileEdit'])->name('auth.profile-edit');
    Route::put('profile/update', [AuthController::class, 'profileUpdate']);
    Route::put('profile/update-avatar', [AuthController::class, 'updateAvatar']);
    Route::put('password/update', [AuthController::class, 'updatePassword']);
});

Route::middleware('auth:admin')->prefix('dashboard')->group(function () {
    Route::put('users/{user}/update/user-image', [UserController::class, 'updateUserImage'])->name('user.update-image');
    Route::resource('users', UserController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::put('roles/{role}/permission', [RolePermissionController::class, 'update']);
    Route::get('products', [ProductController::class, 'index'])->name('dproducts.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('dproducts.show');
    Route::delete('products/{product}/delete', [ProductController::class, 'destroy']);
    Route::resource('categories', CategoryController::class);
    Route::get('offers', [OfferController::class, 'index'])->name('doffers.index');
    Route::get('offers/{offer}', [OfferController::class, 'show'])->name('doffers.show');
    Route::delete('offers/{offer}/delete', [OfferController::class, 'destroy']);
    Route::get('chats', [ChatController::class, 'index'])->name('chat.index');
    Route::delete('chats/{chat}', [ChatController::class, 'destroy']);
});
