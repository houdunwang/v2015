<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\middleware;

use hdphp\kernel\ServiceFacade;

class MiddlewareFacade extends ServiceFacade {
	public static function getFacadeAccessor() {
		return 'Middleware';
	}
}