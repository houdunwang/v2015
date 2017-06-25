<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace addons\links\controller;

use addons\links\model\Link;
use Request;
use module\HdController;

class Admin extends HdController
{
    public function index()
    {
        $data = Link::get();

        return view($this->template.'/index.html', compact('data'));
    }

    /**
     * 保存/修改链接
     *
     * @return array|mixed
     */
    public function post()
    {
        $id    = Request::get('id');
        $model = $id ? Link::find($id) : new Link();
        if (IS_POST) {
            $model->save(Request::post());

            return $this->setRedirect(url('admin.index'))->success('保存成功');
        }

        return view($this->template.'/post.html', compact('model'));
    }

    /**
     * 删除链接
     * @return array
     */
    public function remove()
    {
        $id    = Request::get('id');
        $model = Link::find($id);
        $model->destory();

        return $this->success('删除成功');
    }
}