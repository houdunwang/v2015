<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace web\home\controller;

/**
 * 店铺管理
 * Class Shop
 * @package web\home\controller
 */
class Shop {
	protected $db;

	public function __construct() {
		$this->db = new \system\model\Shop();
	}

	//动作
	public function post() {
		if ( IS_POST ) {
			$action      = $this->db->find( 1 ) ? 'save' : 'add';
			$_POST['id'] = 1;
			if ( $this->db->$action() ) {
				message( '保存成功', 'refresh', 'success' );
			}
			message( $this->db->getError(), 'back', 'error' );
		}
		View::with( 'field', $this->db->find( 1 ) );
		View::make();
	}
}
