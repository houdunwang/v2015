<?php namespace module\article\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use module\HdController;
use module\article\model\WebSlide;
use View;
use houdunwang\request\Request;

/**
 * 幻灯片管理
 * Class Slide
 *
 * @package module\article\controller
 */
class Slide extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth('article_site_slide');
    }

    //列表
    public function lists()
    {
        if (IS_POST) {
            //修改排序
            foreach ((array)Request::post('slide') as $id => $order) {
                $model                 = WebSlide::find($id);
                $model['displayorder'] = $order;
                $model->save();
            }

            return message('修改幻灯片成功', 'refresh');
        }
        $data = WebSlide::where('siteid', SITEID)->get();
        View::with('data', $data);

        return View::make($this->template.'/slide/slide_lists');
    }

    /**
     * 添加&修改
     *
     * @return mixed|string
     */
    public function post()
    {
        $id    = Request::get('id');
        $model = $id ? WebSlide::find($id) : new WebSlide();
        if (IS_POST) {
            $model->save(Request::post());

            return message('幻灯片保存成功', url('slide.lists'));
        }
        //官网列表
        View::with(['field' => $model]);

        return View::make($this->template.'/slide/slide_post');
    }

    /**
     * 删除幻灯图片
     *
     * @return mixed|string
     */
    public function remove()
    {
        $Model = WebSlide::where('siteid', SITEID)->find(Request::get('id'));
        if ($Model) {
            $Model->destory();

            return message('删除成功');
        }

        return message('删除失败可能因为幻灯图片不存在', '', 'error');
    }
}