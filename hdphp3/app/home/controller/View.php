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

class View {
	public function __construct() {
	}

	//动作
	public function tag() {
		if ( IS_POST ) {
			Validate::make( [
				[ 'username', 'required', 'abc' ]
			] );
		}
		$data = Db::table( 'user' )->get();

		return view( '', 5 )->with( 'data', $data )->with( 'time', time() );
	}

	//用户定义标签
	public function user() {
		return view();
	}

	public function cache() {
		if ( ! \View::isCache( 'cache' ) ) {
			echo 'no cache';
			$data = Db::table( 'user' )->get();
		}

		return view( 'cache', 5 )->with( [ 'time' => NOW, 'data' => $data ] );
	}

	public function csrf(){
		print_const();
		return view();
	}
}
