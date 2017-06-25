<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests\app\controller;


class Resource
{
    //GET /photo 索引
    public function index()
    {
        echo 'index';
    }

    //GET /photo/create 创建界面
    public function create()
    {
        echo 'create';
    }

    //POST /photo 保存新增数据
    public function store()
    {
        echo 'store';
    }

    //GET /photo/{photo} 显示文章
    public function show($id)
    {
        echo 'show';
    }

    //GET /photo/{photo}/edit 更新界面
    public function edit($id)
    {
        echo 'edit';
    }

    //PUT /photo/{photo} 更新数据
    public function update($id)
    {
        echo 'update';
    }

    //DELETE /photo/{photo} 删除
    public function destroy($id)
    {
        echo 'destroy';
    }
}