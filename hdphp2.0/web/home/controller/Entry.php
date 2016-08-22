<?php namespace web\home\controller;
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

class Entry {
	//首页
	public function index() {
		//显示模板
		View::make();
	}

	//?s=home/entry/show
	public function show(){
		echo 'show';
	}

	public function __empty(){
		echo '...';
	}
}