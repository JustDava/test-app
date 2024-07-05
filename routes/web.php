<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->namespace('\App\Http\Controllers')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    });

    Route::post('/login', 'AuthController@postSignin');

    Route::get('/reg', function () {
        return view('auth.reg');
    });

    Route::post('/reg', 'AuthController@postSignup');
});

Route::get('/', '\App\Http\Controllers\HomeController@index');
Route::get('/home', '\App\Http\Controllers\HomeController@index');

Route::get('/profile/{id}', '\App\Http\Controllers\HomeController@profile');
Route::get('/edit/{id}', '\App\Http\Controllers\HomeController@edit');
Route::post('/edit/{id}', '\App\Http\Controllers\HomeController@postEdit');
Route::get('/remove/{id}', '\App\Http\Controllers\HomeController@remove');

Route::get('/logout', '\App\Http\Controllers\AuthController@logout');
