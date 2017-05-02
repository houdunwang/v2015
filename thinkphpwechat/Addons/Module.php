<?php namespace Addons;

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
class Module extends BaseController {
	protected $template;

	public function __construct() {
		parent::__construct();
		$this->template = 'Addons/' . MODULE . '/View';
	}

	//显示模板
	public function make( $name = '' ) {
		$name = $name ?: I( 'get.ac' );
		$tpl  = 'Addons/' . MODULE . '/View/' . $name . '.html';
		$this->display( $tpl );
	}
}