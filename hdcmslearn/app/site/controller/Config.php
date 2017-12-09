<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\site\controller;

use system\model\Modules;

/**
 * 模块配置管理
 * Class Config
 *
 * @package app\site\controller
 */
class Config extends Admin
{
    /**
     * 模块配置
     *
     * @return mixed|string
     */
    public function post()
    {
        auth('system_setting');
        //后台分配菜单
        $class = '\addons\\'.v('module.name').'\system\Config';
        if ( ! class_exists($class) || ! method_exists($class, 'settingsDisplay')) {
            return message('访问的模块不存在', 'back', 'error');
        }
        View::with('module_action_name', '参数设置');
        $obj     = new $class();
        $setting = Modules::getModuleConfig(v('module.name'));

        return $obj->settingsDisplay($setting);
    }
}