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
class ArticleModel extends BaseModel {
	protected $pk        = 'id';
	protected $tableName = 'news_article';
	protected $_validate
	                     = [
			[ 'title', 'require', '标题不能为空', 1 ],
			[ 'content', 'require', '正文不能为空', 1 ],
			[ 'click', 'require', '查看次数不能为空', 1 ],
		];
}