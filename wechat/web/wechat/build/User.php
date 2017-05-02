<?php namespace wechat\build;

use wechat\Wx;

class User extends Wx {
	/**
	 * 获取粉丝的基本信息
	 *
	 * @param $openid 用户编号(微信服务器)关注时获取的
	 * @param string $lang 语言  默认是中文
	 *
	 * @return array|bool
	 */
	public function getUserInfo( $openid, $lang = 'zh_CN' ) {
		$url = $this->apiUrl . '/cgi-bin/user/info?access_token=' . $this->getAccessToken() . '&openid=' . $openid . '&lang=' . $lang;
		$res = $this->curl( $url );

		return $this->get( json_decode( $res, true ) );
	}

	/**
	 * 批量获取数组数据
	 * @param array $data openid列表
	 * @param string $lang 语言包
	 *
	 * @return array|bool
	 */
	public function getUserInfoList( array $data, $lang = 'zh_CN' ) {
		$url               = $this->apiUrl . '/cgi-bin/user/info/batchget?access_token=' . $this->getAccessToken();
		$post['user_list'] = [ ];
		foreach ( (array) $data as $openid ) {
			$post['user_list'][] = [ 'openid' => $openid, 'lang' => $lang ];
		}

		$res = $this->curl( $url, json_encode($post,JSON_UNESCAPED_UNICODE) );

		return $this->get( json_decode( $res, true ) );
	}
}