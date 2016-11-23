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

namespace Module\Controller;


use Common\Controller\AdminController;
use Common\Model\KeywordModel;

class KeywordController extends AdminController {
	protected $module;

	public function __init() {
		$class        = 'Addons\\' . MODULE . '\Keyword';
		$this->module = new $class;
	}

	//关键词列表
	public function lists() {
		$data = ( new KeywordModel() )->where( "module='" . MODULE . "'" )->select();
		$this->assign( 'data', $data );
		$this->display();
	}

	//关键词回复
	public function set() {
		//获取模块实例
		$rid = I( 'get.rid' );
		if ( IS_POST ) {
			$data           = I( 'post.' );
			$data['module'] = MODULE;
			if ( $rid ) {
				//修改时添加rid
				$data['rid'] = $rid;
			}
			$this->store( new KeywordModel(), $data, function ( $res ) {
				//关键词表的主键.如果有GET的rid为编辑,否则为添加
				$rid = I( 'get.rid' ) ?: $res['data'];
				$this->module->submit( $rid );
			} );
		}
		//读取编辑的数据
		if ( $rid ) {
			$keyword = ( new KeywordModel() )->find( $rid );
			$this->assign( 'keyword', $keyword );
		}
		//获取模块的内容
		$moduleContent = $this->module->form( $rid );
		$this->assign( 'moduleContent', $moduleContent );
		$this->display();
	}
}