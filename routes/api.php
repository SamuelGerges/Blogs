<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\Postcontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
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

Route::middleware('auth:api')->controller(UserController::class)
    ->prefix('user')
    ->group(function () {
        Route::get('/get_users_posts',  'index');
    });

Route::middleware('auth:api')->controller(Postcontroller::class)
    ->prefix('post')
    ->group(function () {
        Route::post('add_post', 'add')->name('add');
        Route::patch('update/{id}',  'update')->name('update');
        Route::get('user-posts',  'userPosts')->name('user-posts');
    });


Route::middleware('auth:api')->controller(AdminController::class)
    ->prefix('admin')
    ->group(function (){
        Route::get('posts','getPostIsPending')->name('posts');
        Route::patch('rejected/{id}','rejected')->name('rejected');
        Route::delete('delete-post/{id}','deletePost')->name('delete-post');
        Route::delete('destroy/{id}','destroy')->name('destroy');
        Route::get('get-users','users')->name('get-users');
        Route::post('add-admins','addAdmin')->name('add-admins');
    });






