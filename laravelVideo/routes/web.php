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

Route::get('/', 'Admin\EntryController@login');
Route::any('/component/uploader','Component\UploadController@uploader');
Route::any('/component/filesLists','Component\UploadController@filesLists');
//OSS上传
Route::any('/component/oss','Component\OssController@sign');
include __DIR__.'/admin/web.php';