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

class Goods {
	/**
	 * @api {get} /goods/all 获取所有菜品列表
	 * @apiSampleRequest  /goods/all
	 * @apiName all
	 * @apiGroup goods
	 * @apiVersion 1.0.0
	 * @apiDescription 获取所有菜品列表
	 */
	public function all() {
		$data = Db::table( 'category' )->get();
		foreach ( $data as $k => $v ) {
			$data[ $k ]['_goods'] = Db::table( 'goods' )->where( 'cid', $v['cid'] )->get();
		}
		echo json_encode( $data, JSON_UNESCAPED_UNICODE );
		exit;
	}

	/**
	 * @api {get} /goods/get 获取菜品信息
	 * @apiSampleRequest  /goods/get
	 * @apiParam {Number} id 菜品编号
	 * @apiName get
	 * @apiGroup goods
	 * @apiVersion 1.0.0
	 * @apiDescription 获取菜品信息
	 */
	public function get() {
		$data = Db::table( 'goods' )->find( q( 'get.id' ) );
		echo json_encode( $data, JSON_UNESCAPED_UNICODE );
		exit;
	}
}
