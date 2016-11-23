<?php namespace Addons\Button;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework, HDCMS]
 * |      Site: www.hdphp.com www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    Video : www.houdunren.com
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use Addons\Button\Model\ButtonModel;
use Addons\Module;
use wechat\WeChat;

/**
 * 后台访问处理类
 * Class Site
 * @package Addons\Button
 */
class Site extends Module {
	//菜单列表
	public function lists() {
		$model = new ButtonModel();
		$data  = $model->select();
		$this->assign( 'data', $data );
		$this->make();
	}

	//保存菜单
	public function set() {
		$model = new ButtonModel();
		$id    = I( 'get.id' );
		if ( IS_POST ) {
			$data           = I( 'post.' );
			$data['status'] = 0;
			if ( $id ) {
				$data['id'] = $id;
			}
			$this->store( $model, $data, function () {
				$this->success( '保存成功', site_url( 'button.lists' ) );
				exit;
			} );
		}
		$field = $id ? $model->find( $id ) : [ 'title' => '', 'data' => '{"button":[]}' ];
		$this->assign( 'field', $field );
		$this->make();
	}

	//推送菜单
	public function push() {
		$id    = I( 'get.id' );
		$model = new ButtonModel();
		$data  = $model->find( $id );
		if ( ( new WeChat() )->instance( 'button' )->create( $data['data'] ) ) {
			$model->where( "id<>$id" )->save( [ 'status' => 0 ] );
			$model->save( [ 'id' => $id, 'status' => 1 ] );
			$this->success( '推送成功', site_url( 'button.lists' ) );
			exit;
		}
	}
}