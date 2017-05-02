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
//会员组管理
class Group extends Weixin {
	//查询所有分组
	public function getAllGroups() {
		$url     = $this->apiUrl . "/cgi-bin/groups/get?access_token={$this->access_token}";
		$content = Curl::get( $url );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//创建分组
	public function create( $group ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/create?access_token={$this->access_token}";
		$content = Curl::post( $url, urldecode( json_encode( $this->urlencodeArray( $group ) ) ) );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//查询用户所在分组
	public function getUserGroup( $openid ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/getid?access_token={$this->access_token}";
		$user    = '{"openid": ' . $openid . '}';
		$content = Curl::post( $url, $user );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//修改分组名
	public function changeGroupName( $group ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/update?access_token={$this->access_token}";
		$content = Curl::post( $url, urldecode( json_encode( $this->urlencodeArray( $group ) ) ) );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//移动用户分组
	public function changUserGroup( $param ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/members/update?access_token={$this->access_token}";
		$content = Curl::post( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//批量移动用户分组
	public function moveUserToGroup( $param ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/members/batchupdate?access_token={$this->access_token}";
		$content = Curl::post( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}

	//删除分组
	public function delGroup( $param ) {
		$url     = $this->apiUrl . "/cgi-bin/groups/delete?access_token={$this->access_token}";
		$content = Curl::post( $url, urldecode( json_encode( $this->urlencodeArray( $param ) ) ) );
		$result  = json_decode( $content, TRUE );

		return $this->get( $result );
	}
}