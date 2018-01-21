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
use module\article\model\WebContent;
use module\HdController;
use system\model\WeChat;
use Request;
use View;
use Db;

/**
 * 文章管理
 * Class Content
 *
 * @package module\article\controller
 */
class Content extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth();
        $mid = Request::get('mid');
        if (empty($mid)) {
            $mid = Db::table('web_model')->where('siteid', SITEID)->pluck('mid');
            if (empty($mid)) {
                die(message('请先添加模型后操作', url('model.lists'), 'info'));
            }
            die(go(request_url(), ['mid' => $mid]));
        }
    }

    /**
     * 文章列表
     *
     * @return mixed
     */
    public function lists()
    {
        if (IS_POST) {
            foreach ((array)$_POST['orderby'] as $aid => $order) {
                $model            = WebContent::find($aid);
                $model['orderby'] = $order;
                $model->save();
            }

            return message('排序更新成功');
        }
        $model = new WebContent();
        $table = $model->getTable();
        $db    = $model->field("*,{$table}.orderby")->orderBy('aid', 'DESC')
                       ->join('web_category', "{$table}.cid", '=', 'web_category.cid');
        if ($cid = Request::get('cid')) {
            $db->where('web_category.cid', $cid);
        }
        View::with('data', $db->paginate(10));
        View::with('category', WebCategory::getLevelCategory());
        View::with('WebContent', $model);

        return view($this->template.'/content/content_lists');
    }

    /**
     * 修改文章
     *
     * @return mixed|string
     */
    public function post()
    {
        $aid = Request::get('aid');
        if (IS_POST) {
            $data  = Request::post();
            $model = $aid ? WebContent::find($aid) : new WebContent();
            //编辑时暂存原关键词，用于添加规则失败时恢复使用
            $resKeyword = $model['keyword'];
            //保存文章数据
            $data['mid'] = Request::get('mid');
            $model->save($data);
            //存在关键词时添加微信想着数据
            if ($data['keyword']) {
                $result = WeChat::cover([
                    'keyword'     => $model['keyword'],
                    'title'       => $model['title'],
                    'description' => $model['description'],
                    'thumb'       => $model['thumb'],
                    'url'         => $model->url(),
                    'name'        => $model['aid'],
                ]);
                //微信封面回复添加失败时
                if ($result !== true) {
                    if ($aid) {
                        //编辑时添加关键词失败时恢复原关键词
                        $model['keyword'] = $resKeyword;
                        $model->save();
                    } else {
                        //如果是添加文章操作将已经添加的文章删除
                        $model->destory();
                    }

                    return message($result, '', 'error');
                }
            }

            return message('文章保存成功', url('content.lists'));
        }
        //编辑时获取原数据,微信关键词信息
        if ($aid) {
            $model = WebContent::find($aid);
        }
        //栏目列表
        $category = WebCategory::getLevelCategory();
        //扩展字段
        $extField = service('article.field.make', $model);
        View::with([
            'category' => $category,
            'field'    => $aid ? $model->toArray() : [],
            'extField' => $extField,
        ]);

        return view($this->template.'/content/content_post');
    }

    /**
     * 删除文章
     *
     * @return mixed|string
     */
    public function del()
    {
        if (WebContent::del(Request::get('aid'))) {
            return message('文章删除成功', url('content.lists'));
        } else {
            return message('文章删除失败，请稍候再试', url('content.lists'), 'error');
        }
    }
}