<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\base\controller;

use module\base\model\BaseContent;
use Request;
use module\HdController;

class Wx extends HdController
{
    public function lists()
    {
        $data = BaseContent::paginate(10);

        return $this->template('wx/lists', compact('data'));
    }

    /**
     * 保存微信回复数据
     *
     * @return array|mixed
     */
    public function post()
    {
        $id    = Request::get('id');
        $model = $id ? BaseContent::find($id) : new BaseContent();
        if (IS_POST) {
            $post = Request::post();
            $model->save($post);
            $post['module_id'] = $model['id'];
            $this->saveKeyword($post);

            return $this->setRedirect(url('wx.lists'))->success('保存成功');
        }
        $this->assignKeyword($id);

        return $this->template('wx/post', compact('model'));
    }

    /**
     * 删除基本回复内容
     *
     * @return array
     */
    public function remove()
    {
        $id = Request::get('id');
        $this->removeKeyword($id);
        $model = BaseContent::find($id);
        $model->destory();

        return $this->setRedirect(url('wx.lists'))->success('删除成功');
    }
}