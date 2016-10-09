<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace system\service;

/**
 * 工具类服务
 * Class Util
 * @author 向军
 */
class Util {
	private $app;

	public function __construct( $app ) {
		$this->app = $app;
	}

	public function instance( $class ) {
		$class = 'system\service\build\\' . $class;

		return new $class;
	}
}