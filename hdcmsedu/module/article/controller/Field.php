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
use module\HdController;
use module\article\model\Field as FieldModel;
use Schema;
use View;
/**
 * 模型字段管理
 * Class Field
 *
 * @package module\article\controller
 */
class Field extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth();
    }

    /**
     * 字段列表
     *
     * @return mixed
     */
    public function lists()
    {
        $data = FieldModel::where('siteid', SITEID)->where('mid', Request::get('mid'))->get();

        return view($this->template.'/content/field_lists', compact('data'));
    }

    /**
     * 修改字段
     *
     * @return mixed|string
     */
    public function post()
    {
        $id    = Request::get('id');
        $model = $id ? FieldModel::find($id) : new FieldModel();
        $mid   = Request::get('mid');
        if (IS_POST) {
            $data = json_decode(Request::post('options'), true);
            //新增时添加表字段
            $model->createField($mid, $data);
            $data['mid']     = $mid;
            $data['options'] = Request::post('options');
            $model->save($data);

            return message('字段保存成功', url('field.lists', ['mid' => $mid]));
        }
        View::with('field', $model ?: []);
        $options = FieldModel::where('id', $id)->pluck('options') ?: "{title: '',name: '',orderby: 0,required: 0,type: 'string',field: 'varchar',form: 'input',length: 100}";

        return view($this->template.'/content/field_post', compact('options'));
    }

    /**
     * 删除模型
     *
     * @return mixed|string
     */
    public function del()
    {
        $model = FieldModel::find(Request::get('id'));
        if ($model->delField()) {
            return message('字段删除成功');
        }

        return message($model->getError(), '', 'error');
    }
}