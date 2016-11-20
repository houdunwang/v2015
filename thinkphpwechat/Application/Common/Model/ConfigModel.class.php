<?php namespace Common\Model;
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class ConfigModel extends BaseModel {
	protected $pk        = 'id';
	protected $tableName = 'config';
	protected $_validate
	                     = [
			[ 'system', 'require', '系统配置不能为空' ],
			[ 'wechat', 'require', '公众号配置不能为空' ]
		];

	//保存数据
	public function store( $data ) {
		$data['id'] = 1;
		if ( $this->create( $data ) ) {
			$action = isset( $data[ $this->pk ] ) ? "save" : "add";
			$res    = $this->$action( $data );

			return [ 'status' => 'success', 'data' => $res, 'message' => '操作成功' ];
		}

		return [ 'status' => 'failed', 'message' => $this->getError() ];
	}
}