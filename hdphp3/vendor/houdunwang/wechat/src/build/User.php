<?php namespace wechat\build;

use wechat\WeChat;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
//会员管理
class User extends WeChat {
	//设置备注名
	public function setRemark( $param ) {
		$url     = $this->apiUrl . '/cgi-bin/user/info/updateremark?access_token=' . $this->getAccessToken();
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );

		return $this->get( $content );
	}

	//获取用户基本信息
	public function getUserInfo( $openid ) {
		$url     = $this->apiUrl . "/cgi-bin/user/info?openid={$openid}&lang=zh_CN&access_token=" . $this->getAccessToken();
		$content = Curl::get( $url );

		return $this->get( $content );
	}

	//批量获取用户基本信息
	public function getUserInfoLists( $param ) {
		$url     = $this->apiUrl . '/cgi-bin/user/info/batchget?access_token=' . $this->getAccessToken();
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );

		return $this->get( $content );
	}

	//获取用户列表
	public function getUserLists( $next_openid = '' ) {
		$url     = $this->apiUrl . "/cgi-bin/user/get?access_token={$this->access_token}&next_openid={$next_openid}";
		$content = Curl::get( $url );

		return $this->get( $content );
	}
}