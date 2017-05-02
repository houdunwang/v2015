<?php namespace hdphp\weixin\build;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use hdphp\weixin\Weixin;

//二维码生成
class Qrcode extends Weixin {
	/**
	 * @param int $scene_id 自行设定的参数(第几个二维码）
	 * @param int $expire 正数为临时二维码 0 永久二维码
	 *
	 * @return bool
	 */
	public function createQrcode( $scene_id = 0, $expire = 0 ) {

		if ( $expire ) {
			//临时二维码
			$data = [ 'action_name' => 'QR_SCENE', 'expire_seconds' => 604800, 'action_info' => [ 'scene' => [ 'scene_id' => $scene_id ] ] ];
		} else {
			//永久二维码
			//永久二维码只能在1~100000
			if ( $scene_id < 1 || $scene_id > 100000 ) {
				$scene_id = 1;
			}
			$data = [ 'action_name' => 'QR_SCENE', 'action_info' => [ 'scene' => [ 'scene_id' => $scene_id ] ] ];
		}

		$url     = $this->apiUrl . '/cgi-bin/qrcode/create?access_token=' . $this->getAccessToken();
		$content = Curl::post( $url, json_encode( $data ) );
		$result  = $this->get( json_decode( $content, TRUE ) );

		return isset( $result['ticket'] ) ? $result['ticket'] : FALSE;
	}

	//通过ticket换取二维码
	public function getQrcode( $ticket ) {
		$ticket = urlencode( $ticket );

		return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
	}

}