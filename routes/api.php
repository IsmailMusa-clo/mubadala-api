<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ExchangeController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum', 'verified')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('profile', [ProfileController::class, 'index']);
    Route::post('profile/update', [ProfileController::class, 'update']);
    Route::post('change-password', [AuthController::class, 'changePassword']);

    Route::post('products/add-images', [ProductController::class, 'addImage']);
    Route::get('my-products', [ProductController::class, 'myProducts']);
    Route::get('my-offers', [OfferController::class, 'myOffers']);
    Route::put('offers/{offer}/accept', [OfferController::class, 'acceptOffer']);
    Route::put('products/{product}/exchanged-product', [ProductController::class, 'exchangedProduct']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('offers', OfferController::class);

    Route::post('chat', [ChatController::class, 'getOrCreateChat']);
    Route::post('chat/send-message', [ChatController::class, 'sendMessage']);
    Route::get('chat/inbox', [ChatController::class, 'inbox']);
    Route::delete('chat/{message}/delete-message', [ChatController::class, 'deleteMessage']);

    Route::post('exchange/{product}/contact', [ExchangeController::class, 'addContact']);
});

Route::prefix('email')->group(function () {

    Route::post('verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware(['auth:sanctum', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');
});


Route::prefix('auth')->middleware('guest')->group(function () {
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);
});
