<?php

use Illuminate\Support\Facades\Route;

Route::middleware('admin')
    ->prefix('admin')
    ->group(function () {
        Route::view('/', 'admin.index');
    });
