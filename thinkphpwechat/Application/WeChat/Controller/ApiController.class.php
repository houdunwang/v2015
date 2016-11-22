<?php namespace WeChat\Controller;
use wechat\WeChat;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class ApiController extends \Common\Controller\BaseController {
	public function __init() {
		( new WeChat() )->valid();
	}
	//与微信对接的接口
	public function handler() {
		//消息管理模块
		$instance = (new WeChat())->instance('message');
		//判断是否是文本消息
		if ($instance->isTextMsg())
		{
			//获取消息内容
			$message = $instance->getMessage();
			//向用户回复消息
			$instance->text('后盾人houdunren.com收到你的消息了...:' . $message->Content);
		}
	}
}