<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\SocialMediaController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WishListController;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

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

Route::get('test2', function (){

    $url = 'https://lipak.com/product/%DA%AF%D9%88%D8%B4%DB%8C-%D9%85%D9%88%D8%A8%D8%A7%DB%8C%D9%84-%D8%A7%D9%BE%D9%84-%D9%85%D8%AF%D9%84-iphone-13-non-active-ch-a-%D8%B8%D8%B1%D9%81%DB%8C%D8%AA-128gb/?utm_source=ZoomitProduct&utm_medium=PriceList';
    $response = Http::get($url);
    $html = $response->body();

    $crawler = new Crawler($html);

    $metaTags = $crawler->filter("meta")->each(function ($node) {
        return [
            'name' => $node->attr('name'),
            'property' => $node->attr('property'),
            'content' => $node->attr('content'),
        ];
    });
    dd($metaTags);

});

Route::controller(AuthenticationController::class)->group(static function () {
    Route::get('test', 'test');
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
    Route::controller(UserController::class)->group(static function () {
        Route::put('profile', 'update');
        Route::post('profile', 'profile');
        Route::post('logout', 'logout');
        Route::post('resetPassword', 'resetPassword');
    });
    Route::apiResource('users', UserController::class);

    //Users route resources
    Route::controller(AddressController::class)->prefix('addresses')->group(static function () {
        Route::get('getProvinces', 'getProvinces');
        Route::get('getCities/{provinceId}', 'getCities');
    });
    Route::apiResource('social-media', SocialMediaController::class);

    Route::apiResource('addresses', AddressController::class);

    //Cards route resources
    Route::apiResource('cards', CardController::class);

    Route::apiResource('wish-lists', WishListController::class);
    Route::apiResource('items', ItemController::class);
});
