<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace web\api\controller;

class Shop {
	/**
	 * @api {get} /shop/get 店铺信息
	 * @apiSampleRequest  /shop/get
	 * @apiName get
	 * @apiGroup shop
	 * @apiVersion 1.0.0
	 * @apiDescription 获取商家信息
	 */
	public function get() {
		$data = Db::table( 'shop' )->find( 1 );

		die( json_encode( $data, JSON_UNESCAPED_UNICODE ) );
	}
}
