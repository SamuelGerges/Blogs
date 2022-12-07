<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\Postcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::middleware('guest:api')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
    });

Route::middleware('auth:api')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('user-profile', 'profile')->name('profile');
        Route::post('logout', 'logout')->name('logout');

    });


Route::middleware('auth:api')
    ->controller(Postcontroller::class)
    ->prefix('posts')
    ->group(function () {
        Route::post('add_post', 'add')->name('add');
        Route::patch('update/{id}', 'update')->name('update');
//        Route::delete('delete', 'profile')->name('profile');
//        Route::post('logout', 'logout')->name('logout');

    });

