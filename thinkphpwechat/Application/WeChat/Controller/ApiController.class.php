<?php namespace WeChat\Controller;

use Common\Model\KeywordModel;
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
		$instance = ( new WeChat() )->instance( 'message' );
		//判断是否是文本消息
		if ( $instance->isTextMsg() ) {
			//获取消息内容
			$message = $instance->getMessage();
			//向用户回复消息
			if ( $data = ( new KeywordModel() )->where( "keyword='{$message->Content}'" )->find() ) {
				$this->module( $data['module'], $data['rid'] );
			}
		}
		//点击菜单事件
		if ($instance->isClickEvent())
		{
			//获取消息内容
			$message = $instance->getMessage();
			//向用户回复消息
			if ( $data = ( new KeywordModel() )->where( "keyword='{$message->EventKey}'" )->find() ) {
				$this->module( $data['module'], $data['rid'] );
			}
		}
		//当没有回复时交给默认消息处理
		$this->module( 'base' );
	}

	/**
	 * 调用模块的微信处理器
	 * @param $name
	 * @param int $rid
	 */
	protected function module( $name, $rid = 0 ) {
		$class = 'Addons\\' . ucfirst( $name ) . '\Processor';
		call_user_func_array( [ new $class, 'handler' ], [ 'rid' => $rid ] );
	}
}












