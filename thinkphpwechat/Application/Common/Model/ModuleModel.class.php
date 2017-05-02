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

namespace Common\Model;


class ModuleModel extends BaseModel {
	protected $pk        = 'id';
	protected $tableName = 'module';
	protected $_validate
	                     = [
			[ 'title', 'require', '模块标题不能为空' ],
			[ 'name', 'require', '模块标识不能为空' ],
			[ 'actions', 'require', '模块动作不能为空' ],
		];
}