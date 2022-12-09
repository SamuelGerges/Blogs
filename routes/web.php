<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;


Route::get('/', function () {
    return view('welcome');
});


// TODO :: Explain method Database Eloquent Relation
Route::controller(TestController::class)->prefix('test')
    ->group(function () {
        Route::get('first', 'first');
        Route::get('value', 'value');
        Route::get('find', 'find');
        Route::get('find_or_fail', 'findORFail');
    });
