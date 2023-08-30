<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/users', 'UserController@index');
    Route::post('/users', 'UserController@store');
    Route::delete('/users/{user}', 'UserController@destroy');
    Route::put('/users/{user}', 'UserController@update');
});
