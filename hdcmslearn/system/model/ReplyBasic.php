<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace system\model;

/**
 * 文本回复
 * Class ReplyNews
 * @package system\model
 * @author 向军
 */
class ReplyBasic extends Common {
	protected $table = 'reply_basic';
	protected $denyInsertFields = [ 'id' ];
	protected $validate = [
		[ 'rid', 'required', '回复规则编号不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ],
		[ 'content', 'required', '回复内容不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ],
	];
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH ],
	];

}