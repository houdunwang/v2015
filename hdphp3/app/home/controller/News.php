<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\home\controller;

class News {

	//GET /photo 索引
	public function index( \system\model\News $m ) {
		$d = $m->get();

		return \View::make()->with( 'data', $d );
	}

	//GET /photo/create 创建界面
	public function create() {
		return view();
	}

	//POST /photo 保存新增数据
	public function store( \system\model\News $m ) {
		$m->save( Request::post() );
		message( '保存成功', __ROOT__ . '/index.php/news' );
	}

	//GET /photo/{photo} 显示文章
	public function show( $id, \system\model\News $m ) {
		$d = $m->find( $id );

		return \View::make()->with( 'field', $d );
	}

	//GET /photo/{photo}/edit 更新界面
	public function edit( $id, \system\model\News $m ) {
		$d = $m->find( $id );

		return \View::make()->with( 'field', $d );
	}

	//PUT /photo/{photo} 更新数据
	public function update( $id, \system\model\News $m ) {
		$news        = $m->find( $id );
		$news->title = Request::post( 'title' );
		$news->save();
		message( '保存成功', __ROOT__ . '/index.php/news' );
	}

	//DELETE /photo/{photo} 删除
	public function destroy( $id ,\system\model\News $m) {
		$news = $m->find($id);
		$news->destory();
	}
}