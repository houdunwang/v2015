<?php
Route::group(['prefix' => 'admin'], function()
{
	Route::controller('HdForm','home/router');
//	Route::get('add', function()
//	{
//		echo 'add';
//	});
//
//	Route::get('save', function()
//	{
//		echo 'save';
//	});
});