<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
//Route::get( '/', function () {
//	return view( 'home' )->with( 'name', '后盾人' );
//} );
//
//Route::get( '/show', function () {
//	echo 'houdunren.com';
//} );
//
//Route::get( '/form/{id?}', function ( $id = 2 ) {
//	$res = Db::table( 'form' )->find( $id );
//	p( $res );
//} );
//
//Route::get( '/form/{id}/{name}', function (\app\Demo $d,$f = '后盾人', $name, $id ) {
//	$d->show();
//} );


//Route::get('xj/{id}_{cid}.html','home/router/show');

//Route::controller('form','home/router');

//Route::get( 'news/{id}_{cid}.html', function ( $cid,$id ) {
//	echo $cid.'='.$id.'houdunren.com';
//} )->where( 'id', '[0-9]+' )->where('cid','[1-5]');
//Route::get( 'news/{id}_{cid}.html', function ( $cid,$id ) {
//	echo $cid.'='.$id.'houdunren.com';
//} )->where(['id'=>'[0-9]+','cid'=>'9']);

//Route::get( 'ren/{id}', function (  ) {
//	return Route::input('id');
////	echo 'ok'.$id;
//} );

//Route::get('xj/{id}_{cid}.html','home/router/show');

//admin/

//require 'system/routes/admin.php';

Route::resource('photo', 'home/photo');
Route::resource('news', 'home/news');

