<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace web\home\controller;

class T2 {
	//动作
	public function index() {
//		View::with( 'a', 'houdunwang.com' );
//		View::with( 'b', '后盾人' );
		View::with(['a'=>'houdunwang.com','b'=>'后盾人'])->with('url','yahoo.com.cn')->make();
	}
}
