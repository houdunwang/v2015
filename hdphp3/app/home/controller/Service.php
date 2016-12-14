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

use app\Demo;

class Service {
	public function __construct() {
		App::single( 'Demo', function () {
			return new Demo();
		} );
	}

	//动作
	public function index() {
//		App::make('HdForm')->show();
		HdForm::play();
	}

	public function provider() {
	    HdForm::play();
		HdForm::play();
		HdForm::play();
		HdForm::play();
//	    Demo::show();
//		App::make( 'Demo' )->show();
	}
}
