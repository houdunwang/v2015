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

namespace Addons\Text;

use Addons\HdProcessor;
use Addons\Text\Model\TextModel;

/**
 * 微信消息处理器
 * Class Processor
 * @package Addons\Text
 */
class Processor extends HdProcessor {
	public function handler( $rid = '' ) {
		$model = new TextModel();
		$data  = $model->where( "rid=$rid" )->find();
		$this->message->text( $data['content'] );
	}
}