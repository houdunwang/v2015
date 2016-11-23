<?php namespace Addons\Base\Model;

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
//hdcms
class BaseSystemModel extends BaseModel {
	protected $pk        = 'id';
	protected $tableName = 'base_system';

	public function store( $data ) {
		$data['id'] = 1;

		return parent::store( $data );
	}
}