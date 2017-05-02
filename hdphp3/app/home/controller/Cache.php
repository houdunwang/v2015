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
use hdphp\cache\File;

class Cache {
	//动作
	public function index() {
		File
		c( 'cache.file.dir', 'cache' );
		$data = Db::table( 'HdForm' )->get();
		f( 'HdForm', $data, 50 );
		p( f( 'HdForm' ) );
		f( null );
	}

	public function db() {
		$r = d( 'b', 'houdunren.com', 20 );
		dd($r);
		$res = d( 'b', 'houdunren.com999', 20 );
		dd($res);
	}
}
