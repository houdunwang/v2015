<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\component\controller;

use houdunwang\route\Controller;
use Request;

/**
 * 组件公共类
 * Class Common
 *
 * @package app\component\controller
 */
class Common extends Controller {
	/**
	 * 根据前台权限标识
	 * 验证权限并模拟实现登录
	 */
	protected function auth() {
		switch ( Request::post( 'user_type' ) ) {
			case 'user':
				auth();
				break;
			case 'member':
				memberIsLogin();
				break;
			default:
				die( message( '缺少参数user_type', '', 'error' ) );
		}
	}
}