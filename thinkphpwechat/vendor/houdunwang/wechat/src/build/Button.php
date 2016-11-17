<?php namespace wechat\build;

//自定义菜单
use wechat\WeChat;

class Button extends WeChat {
	//创建菜单
	public function create( $button ) {
		$url     = $this->apiUrl . '/cgi-bin/menu/create?access_token=' . $this->getAccessToken();
		$content = $this->curl( $url, $button );

		return $this->get( $content );
	}

	//创建个性化菜单
	public function createAddconditional( $button ) {
		$url     = $this->apiUrl . '/cgi-bin/menu/addconditional?access_token=' . $this->getAccessToken();
		$content = $this->curl( $url, $button );

		return $this->get( $content );
	}

	//查询微信服务器上菜单
	public function query() {
		$url     = $this->apiUrl . '/cgi-bin/menu/get?access_token=' . $this->getAccessToken();
		$content = $this->curl( $url );

		return $this->get( $content );
	}

	//删除菜单
	public function flush() {
		$url     = $this->apiUrl . '/cgi-bin/menu/delete?access_token=' . $this->getAccessToken();
		$content = $this->curl( $url );

		return $this->get( $content );
	}
}