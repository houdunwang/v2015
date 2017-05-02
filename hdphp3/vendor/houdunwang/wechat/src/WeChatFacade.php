<?php namespace wechat;

use hdphp\kernel\ServiceFacade;

class WeChatFacade extends ServiceFacade {
	public static function getFacadeAccessor() {
		return 'WeChat';
	}
}