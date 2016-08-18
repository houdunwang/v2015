<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\lang;

use ArrayAccess;

class Lang {

	private $data;

	public function __construct() {
		$this->data = require APP_PATH . '/Common/Lang/' . Config::get( 'app.lang' ) . '.php';
	}

	//获取语言
	public function get( $lang ) {
		return $this->data[ $lang ];
	}

	//更改语言包
	public function lang( $lang ) {
		$this->data = require APP_PATH . '/Common/Lang/' . $lang . '.php';

		return $this;
	}
}