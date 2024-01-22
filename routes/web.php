<?php

use App\Models\Item;
use App\Models\WishList;
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
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/test', function () {
        $wishList = WishList::create(['user_id' => '09190755375', 'name' => 'test', 'description' => 'test']);
        $wishList->items()->create([
            'name'  => 'test item!',
            'price' => 12365484
        ]);
        dd('oik!');
    });

    Route::get('/test2', function () {
        $storage = \Cache::getStore(); // will return instance of FileStore
        $filesystem = $storage->getFilesystem(); // will return instance of Filesystem
        $dir = (\Cache::getDirectory());
        $keys = [];
        foreach ($filesystem->allFiles($dir) as $file1) {

            if (is_dir($file1->getPath())) {

                foreach ($filesystem->allFiles($file1->getPath()) as $file2) {
                    $keys = array_merge($keys, [$file2->getRealpath() => unserialize(substr(\File::get($file2->getRealpath()), 10))]);
                }
            }
            else {

            }
        }
        dd($keys);
        $wishList = Item::first();
        dd($wishList->wishList);
    });
});
