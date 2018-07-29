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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/verify/{code}','Auth\RegisterController@verifyUser');
Route::middleware(['auth:web'])->group(function(){
    Route::get('/download_video','VideoController@download')->name('video.download');
    Route::post('/store_video','VideoController@store')->name('video.store');
});

