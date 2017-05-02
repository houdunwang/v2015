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


class KeywordModel extends BaseModel {
	protected $pk        = 'id';
	protected $tableName = 'keyword';
	protected $_validate
	                     = [
			[ 'keyword', 'require', '关键词不能为空', 1 ],
			[ 'keyword', '', '关键词已经存在！', 0, 'unique', 1 ],
			[ 'module', 'require', '模块标识不能为空', 1 ],
		];

}