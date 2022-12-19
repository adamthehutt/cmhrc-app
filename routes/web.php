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
        Route::view('{profile}', 'track.index')->name("track.index")->can("view,profile");
        Route::view('{profile}/symptoms/{symptom}/trend', 'track.symptom')->name('track.symptom')->can('view,profile');
        Route::get('{profile}/symptoms-all/{month}', function (\App\Models\Profile $profile, string $month) {
                return view('track.chart')
                    ->with('chart', app(\App\Charts\SymptomsByDay::class)
                        ->setProfile($profile)
                        ->setMonth($month)
                        ->build()
                    )
                    ->with('profile', $profile)
                    ->with('month', $month);
            })
            ->name('track.chart')
            ->can('view,profile');
    });

    Route::prefix('trend/{profile}')->group(function () {
        Route::view('/', 'trend.index')->name('trend.index')->can('view,profile');
    });
});

require __DIR__.'/auth.php';
