<?php namespace hdphp\tool;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use hdphp\kernel\ServiceFacade;

class ToolFacade extends ServiceFacade {
	public static function getFacadeAccessor() {
		return 'Tool';
	}
}