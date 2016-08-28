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
//网页授权获取用户基本信息
class oauth extends Weixin {
	//公共请求方法
	private function request( $type ) {
		if ( q( 'get.code' ) && q( 'get.state' ) == 'STATE' ) {
			$url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $this->appid . "&secret=" . $this->appsecret . "&code=" . q( 'get.code' ) . "&grant_type=authorization_code";
			$d    = Curl::get( $url );
			$data = $this->get( json_decode( $d, TRUE ) );

			return isset( $data['errcode'] ) ? FALSE : $data;
		} else {
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . c( 'weixin.appid' ) . "&redirect_uri=" . urlencode( __URL__ ) . "&response_type=code&scope=" . $type . "&state=STATE#wechat_redirect";
			header( 'location:' . $url );
			exit;
		}
	}

	//获取用户openid
	public function snsapiBase() {
		$data = $this->request( 'snsapi_base' );

		return $data ? $data['openid'] : FALSE;
	}

	//是用来获取用户的基本信息的
	public function snsapiUserinfo() {
		$data = $this->request( 'snsapi_userinfo' );
		if ( $data !== FALSE ) {
			$url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $data['access_token'] . "&openid=" . $data['openid'] . "&lang=zh_CN";
			$d   = Curl::get( $url );
			$res = $this->get( json_decode( $d, TRUE ) );

			return isset( $data['errcode'] ) ? FALSE : $res;
		}

		return FALSE;
	}
}
