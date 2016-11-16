<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
Route::get( '/', function () {
	return view( 'home' )->with( 'name', '后盾人' );
} );

Route::get( '/show', function () {
	echo 'houdunren.com';
} );

Route::get( '/user/{id?}', function ( $id = 2 ) {
	$res = Db::table( 'user' )->find( $id );
	p( $res );
} );

Route::get( '/user/{id}/{name}', function (\app\Demo $d,$f = '后盾人', $name, $id ) {
	$d->show();
} );












