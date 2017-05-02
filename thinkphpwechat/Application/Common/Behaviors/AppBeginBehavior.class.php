<?php namespace Common\Behaviors;

use Common\Model\ConfigModel;
use wechat\WeChat;

require 'Application/Common/Common/helper.php';

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class AppBeginBehavior extends \Think\Behavior {
	//行为执行入口
	public function run( &$param ) {
		$this->loadConfig();
		$this->wechat();
	}

	//加载配置项
	protected function loadConfig() {
		$data           = ( new ConfigModel() )->find( 1 );
		$data['system'] = json_decode( $data['system'], true );
		$data['wechat'] = json_decode( $data['wechat'], true );
		v( 'config.system', $data['system'] );
		v( 'config.wechat', $data['wechat'] );
		$d = get_defined_constants( true );
		define( 'MODULE', ucfirst(I( 'get.mo', null ) ));
	}

	//设置微信配置项
	protected function wechat() {
		$config = [
			//微信首页验证时使用的token http://mp.weixin.qq.com/wiki/8/f9a0b8382e0b77d87b3bcc1ce6fbc104.html
			"token"     => v( 'config.wechat.token' ),
			//公众号身份标识
			"appid"     => v( 'config.wechat.appid' ),
			//公众平台API(参考文档API 接口部分)的权限获取所需密钥Key
			"appsecret" => v( 'config.wechat.appsecret' ),
		];
		new WeChat( $config );
	}
}