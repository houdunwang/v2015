<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\database;

use houdunwang\framework\build\Facade;

class SchemaFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'Schema';
	}
}