<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\home\controller;
class Cache {
	//动作
	public function index() {
		c( 'cache.file.dir', 'cache' );
		$data = Db::table( 'user' )->get();
		f( 'user', $data, 50 );
		p( f( 'user' ) );
		f( null );
	}

	public function db() {
		$r = d( 'b', 'houdunren.com', 20 );
		dd($r);
		$res = d( 'b', 'houdunren.com999', 20 );
		dd($res);
	}
}
