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
//会员组管理
class Group extends WeChat {
	//查询所有分组
	public function getAllGroups() {
		$url     = $this->apiUrl . "/cgi-bin/groups/get?access_token={$this->access_token}";
		$content = $this->curl( $url );

		return $this->get( $content );
	}

	//创建分组
	public function create( $group ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/create?access_token={$this->access_token}";
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $group ) ) ) );

		return $this->get( $content );
	}

	//查询用户所在分组
	public function getUserGroup( $openid ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/getid?access_token={$this->access_token}";
		$user    = '{"openid": ' . $openid . '}';
		$content = $this->curl( $url, $user );

		return $this->get( $content );
	}

	//修改分组名
	public function changeGroupName( $group ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/update?access_token={$this->access_token}";
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $group ) ) ) );

		return $this->get( $content );
	}

	//移动用户分组
	public function changUserGroup( $param ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/members/update?access_token={$this->access_token}";
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );

		return $this->get( $content );
	}

	//批量移动用户分组
	public function moveUserToGroup( $param ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/members/batchupdate?access_token={$this->access_token}";
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );

		return $this->get( $content );
	}

	//删除分组
	public function delGroup( $param ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/delete?access_token={$this->access_token}";
		$content = $this->curl( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );

		return $this->get( $content );
	}
}