<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cloud\build;

use houdunwang\config\Config;
use houdunwang\curl\Curl;

class Base {
	protected $api;

	public function __construct() {
		$uid       = Config::get( 'cloud.uid' );
		$secret    = Config::get( 'cloud.secret' );
		$this->api = "http://www.hdcms.com?&secret={$secret}&uid={$uid}
		&m=store&action=controller";
	}

	/**
	 * 发送短信
	 *
	 * @param array $data
	 * [
	 *  'code'=>'模板CODE'，
	 *  'tel'=>'手机号'
	 * ]
	 *
	 * @return mixed
	 */
	public function sms( array $data ) {
		$res = Curl::post( $this->api . '/cloud/sms', $data );

		return json_decode( $res, true );
	}
}