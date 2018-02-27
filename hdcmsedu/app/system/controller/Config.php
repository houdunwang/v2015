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

use houdunwang\dir\Dir;
use system\model\Config as ConfigModel;
use houdunwang\request\Request;
use houdunwang\db\Db;

/**
 * 系统配置管理
 * Class Config
 *
 * @package system\controller
 */
class Config extends Admin
{
    public function __construct()
    {
        $this->superUserAuth();
    }

    /**
     * 注册配置管理
     *
     * @return mixed|string
     */
    public function register()
    {
        if (IS_POST) {
            $model             = ConfigModel::find(1);
            $model['register'] = Request::post('register');
            $model->save();

            return message('注册设置保存成功');
        }
        $group = Db::table('user_group')->get();

        return view()->with(compact('group'));
    }

    /**
     * 站点开/关设置
     *
     * @return mixed
     */
    public function site()
    {
        if (IS_POST) {
            $post          = Request::post('site');
            $model         = ConfigModel::find(1);
            $model['site'] = $post;
            $model->save();

            return message('站点设置更新成功');
        }

        return view();
    }
}