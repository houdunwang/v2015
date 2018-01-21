<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\system\controller;

use houdunwang\request\Request;
use system\model\Menu as MenuModel;
use houdunwang\arr\Arr;

/**
 * 菜单管理
 * Class Menu
 *
 * @package app\system\controller
 */
class Menu extends Admin
{
    public function __construct()
    {
        $this->superUserAuth();
    }

    /**
     * 编辑菜单
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function edit()
    {
        if (IS_POST) {
            $data = json_decode(Request::post('menu'), true);
            foreach ($data as $m) {
                $model               = empty($m['id']) ? new MenuModel() : MenuModel::find($m['id']);
                $model['pid']        = intval($m['pid']);
                $model['title']      = $m['title'];
                $model['permission'] = $m['permission'];
                $model['url']        = $m['url'];
                $model['append_url'] = $m['append_url'];
                $model['icon']       = $m['icon'];
                $model['orderby']    = intval($m['orderby']);
                $model['is_display'] = $m['is_display'];
                $model['mark']       = $m['mark'];
                $model['is_system']  = $m['is_system'];
                $model->save();
            }

            return message('菜单列表更新成功');
        }
        $data  = MenuModel::get()->toArray();
        $menus = Arr::tree($data, 'title', 'id', 'pid');

        return view()->with('menus', json_encode($menus, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 更改显示状态
     */
    public function changeDisplayState()
    {
        $model               = MenuModel::find(q('post.id'));
        $model['id']         = Request::post('id');
        $model['is_display'] = Request::post('is_display');
        $model->save();

        return message('菜单显示状态更改成功');
    }

    /**
     * 删除菜单
     *
     * @param \system\model\Menu $menu
     *
     * @return mixed|string
     */
    public function delMenu(MenuModel $menu)
    {
        $id = Request::post('id');
        if ($menu->delMenu($id)) {
            return message('菜单删除成功');
        }

        return message($menu->getError(), '', 'error');
    }
}