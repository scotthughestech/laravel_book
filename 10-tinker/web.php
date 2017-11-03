<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    // Create new Purchase model
    $purchase = new \App\Purchase;
    // Assign values
    $purchase->date = \Carbon\Carbon::now();
    $purchase->price = 23.50;
    $purchase->description = 'Gasoline';
    // Save to database
    $purchase->save();
    // Feedback
    return 'Purchase created';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
