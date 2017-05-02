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

namespace Addons\Text;

use Addons\Module;
use Addons\Text\Model\TextModel;

/**
 * 关键词处理类
 * Class Keyword
 * @package Addons\Text
 */
class Keyword extends Module {
	//关键词界面
	public function form( $rid = 0 ) {
		if ( $rid ) {
			$data = ( new TextModel() )->where( "rid=$rid" )->select();
			$this->assign( 'field', current( $data ) );
		}

		return $this->fetch( $this->template . '/form.html' );
	}

	//保存数据
	public function submit( $rid ) {
		$model           = new TextModel();
		$data['rid']     = $rid;
		$data['content'] = I( 'post.content' );
		if ( $id = $model->getFieldByRid( $rid, 'id' ) ) {
			$data['id'] = $id;
		}
		$this->store( $model, $data, function () {
			$this->success( '保存成功', u( 'module/keyword/lists', [ 'mo' => 'Text' ] ) );
			exit;
		} );
	}
}