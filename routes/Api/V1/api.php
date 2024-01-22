<?php

use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\WishListController;
use App\Http\Controllers\SSOController;
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

Route::controller(SSOController::class)->group(static function () {
    Route::post('loginOtp', 'loginOtp');
    Route::post('loginPassword', 'loginPassword');
    Route::post('resetPassword', 'resetPassword');
    Route::post('profile', 'profile');
    Route::post('logout', 'logout');
    Route::post('sendOtp', [SSOController::class, 'sendOtp'])->middleware(['throttle:otp']);
});

Route::middleware(['web', 'cache_auth', 'role.check'])->group(static function () {
    //Cards route resources
    Route::apiResource('wish-lists', WishListController::class);
    Route::apiResource('items', ItemController::class);
});

