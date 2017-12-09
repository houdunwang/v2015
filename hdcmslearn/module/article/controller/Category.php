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

use module\article\model\WebCategory;
use module\article\model\WebModel;
use module\HdController;
use Arr;
/**
 * 栏目管理
 * Class Category
 *
 * @package module\article\controller
 */
class Category extends HdController
{
    public function __construct()
    {
        auth();
        parent::__construct();
    }

    /**
     * 栏目列表
     *
     * @param \module\article\model\WebCategory $webCategory
     *
     * @return mixed
     */
    public function lists(WebCategory $webCategory)
    {
        $data = $webCategory->getLevelCategory();
        foreach ($data as $k => $v) {
            $data[$k]['url'] = WebCategory::url($v);
        }

        return view($this->template.'/content/category_lists', compact('data'));
    }

    /**
     * 修改栏目
     *
     * @return mixed|string
     */
    public function post()
    {
        $cid = Request::get('cid');
        if (IS_POST) {
            $model = $cid ? WebCategory::find($cid) : new WebCategory();
            $data  = json_decode(Request::post('data'), true);
            $model->save($data);

            return message('栏目保存成功', url('category.lists'));
        }
        $category = WebCategory::getLevelCategory($cid);
        $model    = WebModel::getLists();
        if (empty($model)) {
            return message('请先添加模块后再进行操作', url('model.lists'), 'info');
        }
        $field = [];
        if ($cid) {
            $field = WebCategory::find($cid)->toArray();
        }

        return view($this->template.'/content/category_post.php', compact('category', 'model', 'field'));
    }

    /**
     * 删除栏目
     *
     * @return mixed|string
     */
    public function del()
    {
        $cid = Request::get('cid');
        //删除子栏目
        $child = Arr::channelList(Db::table('web_category')->get(), $cid);
        if ($child) {
            return message('请先删除子栏目', '', 'error');
        }
        $model = WebCategory::find($cid);
        if ($model->delCategory()) {
            return message('栏目删除成功', url('category.lists'));
        } else {
            return message($model->getError(), url('category.lists'), 'error');
        }
    }
}