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
 * 会员字段信息表
 * 用于标识用户个人信息字段的中文标识与排序/显示
 * Class MemberFields
 * @package system\model
 */
class MemberFields extends Common {
	protected $table = 'member_fields';
	protected $validate = [
		[ 'title', 'required', '字段名称不能为空', self::MUST_VALIDATE, self::MODEL_BOTH ],
		[ 'status', 'num:0,1', '状态选择错误', self::MUST_VALIDATE, self::MODEL_BOTH ],
		[ 'id', 'checkId', '当前站点不存在该字段', self::NOT_EMPTY_VALIDATE, self::MODEL_BOTH ],
	];
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH ],
		[ 'status', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'orderby', 'intval', 'function', self::MUST_AUTO, self::MODEL_BOTH ],
	];

	protected function checkId( $field, $value ) {
		return Db::table( 'member_fields' )->where( 'siteid', SITEID )->where( 'id', $value )->get() ? true : false;
	}
}