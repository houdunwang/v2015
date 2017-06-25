<?php namespace houdunwang\wechat;


use houdunwang\framework\build\Facade;

class WeChatFacade extends Facade {
	public static function getFacadeAccessor() {
		return 'WeChat';
	}
}