<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\FilterController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\PartnershipController;
use App\Http\Controllers\Api\V1\PriceController;
use App\Http\Controllers\Api\V1\SocialMediaController;
use App\Http\Controllers\Api\V1\ThankYouNoteController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WishListController;

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

Route::get('test',[AddressController::class,'index']);

Route::get('payment/redirect',[AddressController::class,'verify']);

Route::controller(AuthenticationController::class)->group(static function () {
    Route::post('loginOtp', 'loginOtp')->middleware(['prevent.multiple.logins']);
    Route::post('loginPassword', 'loginPassword')->middleware(['prevent.multiple.logins']);
    Route::post('userInquiry', 'userInquiry');
});


Route::middleware(['throttle:otp'])->group(function () {
    Route::post('sendOtp', [AuthenticationController::class, 'sendOtp']);
});

Route::middleware(['auth:sanctum', 'role.check'])->group(static function () {
    // Users route resources
    Route::post('users/authentication', [AuthenticationController::class, 'authentication']);
    Route::controller(UserController::class)->prefix('users')->group(static function () {
        Route::put('profile', 'update');
        Route::post('profile', 'profile');
        Route::post('purchases', 'purchases');
        Route::post('logout', 'logout');
        Route::get('notifications', 'notifications');
        Route::get('unreadNotifications', 'unreadNotifications');
        Route::post('markAsReadNotification/{NotificationId}', 'markAsReadNotification');
        Route::post('markAsUnreadNotification/{NotificationId}', 'markAsUnreadNotification');
        Route::post('markAsReadAllNotifications', 'markAsReadAllNotifications');
        Route::post('markAsUnreadAllNotifications', 'markAsUnreadAllNotifications');
    });

    Route::post('users/interests', [UserController::class, 'syncInterests']);
    Route::apiResource('users', UserController::class);



    //Users route resources
    Route::controller(AddressController::class)->prefix('addresses')->group(static function () {
        Route::get('getProvinces', 'getProvinces');
        Route::get('getCities/{provinceId}', 'getCities');
    });
    Route::apiResource('social-media', SocialMediaController::class);

    Route::apiResource('addresses', AddressController::class);

    //Cards route resources
    Route::apiResource('cards', CardController::class)->except('update');

    Route::apiResource('wish-lists', WishListController::class);
    Route::post('wish-lists/share/{wish_list}', [WishListController::class, 'storeShare']);
    Route::delete('wish-lists/share/{wish_list}', [WishListController::class, 'destroyShare']);
    Route::post('items/purchase', [ItemController::class, 'purchaseItem']);
    Route::delete('items/purchase', [ItemController::class, 'cancelPurchaseItem']);
    Route::apiResource('items', ItemController::class);
    Route::post('items/purchase', [ItemController::class, 'purchaseItem']);
    Route::delete('items/purchase', [ItemController::class, 'cancelPurchaseItem']);
    Route::apiResource('filters', FilterController::class);
    Route::apiResource('thank-you-notes', ThankYouNoteController::class);
    Route::post('getPrice', [PriceController::class, 'getPrice']);
});

Route::middleware(['web', 'throttle:search'])->group(function () {
    Route::post('search', [UserController::class, 'search']);
    Route::get('wish-lists/wishes/{share}', [WishListController::class, 'showShare']);
});

Route::middleware(['web', 'throttle:partnership'])->group(function () {
    Route::post('partnership', [PartnershipController::class, 'store']);
});




