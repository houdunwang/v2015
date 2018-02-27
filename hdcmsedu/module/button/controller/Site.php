<?php namespace module\button\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use module\HdController;
use system\model\Button;
use View;
use houdunwang\request\Request;
/**
 * 微信菜单
 * Class Site
 *
 * @package module\button\controller
 */
class Site extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth();
    }

    /**
     * 菜单列表
     *
     * @return mixed
     */
    public function lists()
    {
        $data = Button::where('siteid', siteid())->get();
        View::with('data', $data);

        return view($this->template.'/lists.php');
    }

    /**
     * 删除菜单
     *
     * @return mixed|string
     */
    public function remove()
    {
        $model = Button::find(Request::get('id'));
        if ($model->destory()) {
            return message('删除菜单成功');
        }

        return message('删除菜单失败', 'back', 'error');
    }

    /**
     * 添加/编辑菜单
     *
     * @return mixed
     */
    public function post()
    {
        $id = q('get.id');
        if (IS_POST) {
            $model           = $id ? Button::find($id) : new Button();
            $model['title']  = Request::post('title');
            $model['data']   = Request::post('data');
            $model['status'] = 0;
            $model['id']     = Request::get('id');
            $model->save();

            return message('菜单保存成功', url('site.lists'));
        }
        if ($id) {
            $field         = Button::find($id)->toArray();
            $field['data'] = json_decode($field['data'], true);
        } else {
            $field['title'] = '';
            $field['data']  = [
                'status' => 1,
                'button' => [
                    [
                        'type'       => 'view',
                        'name'       => '菜单名称',
                        'url'        => '',
                        'active'     => true,
                        'sub_button' => [],
                    ],
                ],
            ];
        }
        $field['data'] = json_encode($field['data']);

        return view($this->template.'/post.php')->with('field', $field);
    }

    /**
     * 推送到微信端
     *
     * @return mixed|string
     */
    public function pushWechat()
    {
        $id   = Request::post('id');
        $data = Button::where('id', $id)->pluck('data');
        $data = json_decode($data, true);
        $data = $this->addHttp($data);
        $res  = \WeChat::instance('button')->create($data);
        if ($res['errcode'] == 0) {
            Button::whereNotIn('id', [$id])->update(['status' => 0]);
            Button::where('id', $id)->update(['status' => 1]);

            return message('推送微信菜单成功', url('site.lists'), 'success');
        }

        return message($res['errmsg'], 'back', 'error', 5);
    }

    /**
     * url地址前添加http
     *
     * @param $data
     *
     * @return mixed
     */
    protected function addHttp($data)
    {
        foreach ($data['button'] as $k => $v) {
            //添加url前缀
            if (isset($v['url']) && ! preg_match('/^http/', $v['url'])) {
                $data['button'][$k]['url'] = __ROOT__.$v['url'];
            }
            //子菜单处理
            if (isset($v['sub_button'])) {
                foreach ($v['sub_button'] as $n => $m) {
                    if (isset($m['url']) && ! preg_match('/^http/', $m['url'])) {
                        $data['button'][$k]['sub_button'][$n]['url'] = __ROOT__.$m['url'];
                    }
                }
            }
        }

        return $data;
    }
}