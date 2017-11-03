<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/create', 'PurchaseController@create');

Route::post('/store', 'PurchaseController@store');

Route::get('/browse', 'PurchaseController@browse');