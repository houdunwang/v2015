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
 * 站点扩展套餐管理
 * Class SitePackage
 * @package system\model
 */
class SitePackage extends Common {
	protected $table = 'site_package';
	protected $validate = [
		[ 'siteid', 'required', '站点编号不能为空', self::EMPTY_VALIDATE, self::MODEL_BOTH ],
		[ 'package_id', 'required', '套餐编号不能为空', self::EMPTY_VALIDATE, self::MODEL_BOTH ],
	];
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH ],
	];
}