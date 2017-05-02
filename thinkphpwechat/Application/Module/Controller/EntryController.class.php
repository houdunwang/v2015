<?php namespace Module\Controller;

use Common\Controller\BaseController;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class EntryController extends BaseController {
	/**
	 * 访问模块控制器方法的代理
	 * @return mixed
	 */
	public function handler() {
		$module = ucfirst( $_GET['mo'] );
		switch ( $_GET['t'] ) {
			case 'site':
				//分配后台菜单
				$this->assignModuelMenu();
				//后台
				$class = 'Addons\\' . $module . '\Site';
				break;
			case 'web':
				//前台
				$class = 'Addons\\' . $module . '\Web';
				brek;
		}

		return call_user_func_array( [ new $class, $_GET['ac'] ], [ ] );
	}
}