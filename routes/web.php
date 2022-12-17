<?php

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

Route::redirect('/', "/profiles");

Route::middleware('auth')->group(function() {
    Route::prefix("profiles")->group(function () {
        Route::view('/', 'profiles.index')->name("profiles.index");
    });

    Route::prefix("track")->group(function () {
        Route::view('{profile?}', 'track.index')->name("track.index");
    });
});




require __DIR__.'/auth.php';
