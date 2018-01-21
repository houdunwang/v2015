<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\article\controller;

use houdunwang\request\Request;
use module\article\model\WebModel;
use module\HdController;
use View;

/**
 * 文章模型管理
 * Class Model
 *
 * @package module\article\controller
 */
class Model extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth();
    }

    /**
     * 模块列表
     *
     * @return mixed
     */
    public function lists()
    {
        $data = WebModel::where('siteid', SITEID)->get();

        return view($this->template.'/content/model_lists', compact('data'));
    }

    /**
     * 修改模型
     *
     * @return mixed|string
     */
    public function post()
    {
        $model = Request::get('mid') ? WebModel::find(Request::get('mid')) : new WebModel();
        if (IS_POST) {
            $model->save(Request::post());
            //添加时创建表
            $model->createModelTable(Request::post('model_name'));

            return message('模型保存成功', url('model.lists'));
        }
        View::with('field', $model ?: []);

        return view($this->template.'/content/model_post');
    }

    /**
     * 删除模型
     *
     * @return mixed|string
     */
    public function del()
    {
        $mid = Request::get('mid');
        if (Db::table('web_category')->where('mid', $mid)->get()) {
            return message('请删除使用该模型的栏目后,再删除模型.', '', 'error');
        }
        $model = WebModel::find($mid);
        if ($model->delModel()) {
            return message('模型删除成功', url('model.lists'));
        } else {
            return message($model->getError(), url('model.lists'), 'error');
        }
    }
}