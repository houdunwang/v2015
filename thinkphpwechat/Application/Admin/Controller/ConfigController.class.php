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

namespace Admin\Controller;


use Common\Controller\AdminController;
use Common\Model\ConfigModel;

class ConfigController extends AdminController {
	public function set() {
		if ( IS_POST ) {
			$model = new ConfigModel();
			$res   = $model->store( I( 'post.' ) );
			if ( $res['status'] == 'success' ) {
				$this->success( $res['message'] );
			} else {
				$this->error( $res['message'] );
			}
			exit;
		}
		$field = ( new ConfigModel() )->find( 1 );
		$this->assign( 'field', $field );
		$this->display();
	}
}