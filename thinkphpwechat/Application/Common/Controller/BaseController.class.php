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

namespace Common\Controller;

use Think\Controller;

class BaseController extends Controller {
	public function __construct() {
		parent::__construct();
		if ( method_exists( $this, '__init' ) ) {
			$this->__init();
		}
	}

	//保存数据
	protected function store( Model $model, $data, \Closure $callback = null ) {
		$res = $model->store( I( 'post.' ) );
		if ( $res['status'] == 'success' && $callback instanceof \Closure ) {
			$callback( $res );
		} else {
			$this->message( $res );
		}
	}

	//响应信息
	protected function message( array $data ) {
		if ( $data['status'] == 'success' ) {
			$this->success( $data['message'] );
		} else {
			$this->error( $data['message'] );
		}
		exit;
	}
}