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

use system\model\News;

class Router {
	//动作
	public function show( News $m ) {
//		dd( $m->find( 1 )->title );
//		dd( $cid );
//		dd( $id );
//		echo 'houdunren.com';
		p(Route::input());
	}

	public function getAdd() {
		echo 'houdunren.com';
	}

	public function getLists(){
		echo 'houdunwang.com';
	}

	public function getFind(){
		$id = Request::get('id');
		echo 'find...'.$id;
	}
}
