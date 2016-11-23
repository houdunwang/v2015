<?php namespace Addons\Text\Model;

use Common\Model\BaseModel;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class TextModel extends BaseModel {
	protected $id        = 'id';
	protected $tableName = 'text_contents';
	protected $_validate
	                     = [
			[ 'content', 'require', '回复内容为空', 1 ],
		];
}