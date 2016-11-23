<?php namespace Addons\News\Model;

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
class CategoryModel extends BaseModel {
	protected $pk        = 'id';
	protected $tableName = 'news_category';
	protected $_validate
	                     = [
			[ 'catname', 'require', '栏目名称不能为空', 1 ],
		];
}