<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace Addons\Base;


use Addons\Base\Model\BaseSystemModel;
use Addons\HdProcessor;

/**
 * 微信消息处理器
 * Class Processor
 * @package Addons\Base
 */
class Processor extends HdProcessor {
	public function handler() {
		$field = ( new BaseSystemModel() )->find( 1 );
		//关注时回复消息
		if ( $this->message->isSubscribeEvent() ) {
			//向用户回复消息
			$this->message->text( $field['welcome'] );
		}
		//默认消息回复
		if ( $this->message->isTextMsg() ) {
			$this->message->text( $field['default'] );
		}
	}
}