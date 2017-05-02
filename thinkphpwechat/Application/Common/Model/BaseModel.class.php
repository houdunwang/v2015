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


use Think\Model;

class BaseModel extends Model {
	//数据的保存
	public function store( $data ) {
		if ( $this->create( $data ) ) {
			$action = isset( $data[ $this->pk ] ) ? "save" : "add";
			$res    = $this->$action( $data );

			return [ 'status' => 'success', 'data' => $res, 'message' => '操作成功' ];
		}

		return [ 'status' => 'failed', 'message' => $this->getError()?:'未知错误' ];
	}
}