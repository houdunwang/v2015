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
Route::get('/login','Entry\\LoginController@loginform');
Route::post('/login','Entry\\LoginController@login');
Route::get('/StartCaptchaServlet','Entry\\LoginController@StartCaptchaServlet');
