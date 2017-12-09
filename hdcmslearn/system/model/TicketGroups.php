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
 * 卡券使用会员组
 * Class TicketGroups
 * @package system\model
 * @author 向军
 */
class TicketGroups extends Common {
	protected $table = 'ticket_groups';
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH ],
		[ 'tid', 'required', '卡券编号tid不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ],
		[ 'group_id', 'required', '会员级编号不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ]
	];
}