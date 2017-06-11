<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\home\controller;

use houdunwang\db\Db;
use Request;
use system\model\Module;

class Entry
{
    public function index()
    {
        $content = $this->runModule();
        if ($content !== false) {
            return $content;
        }

        return View::with('framework', 'HDPHP')->make();
    }

    /**
     * 执行控制器
     *
     * @return mixed
     */
    protected function runModule()
    {
        $module = Request::get('m');
        $model  = Module::where('name', $module)->first();
        $action = Request::get('action');
        if ($model and $module and $action) {
            $info    = explode('/', $action);
            $info[1] = ucfirst($info[1]);
            $class   = ($model['is_system'] == 1 ? 'module' : 'addons').'\\'.$module.'\\'.$info[0].'\\'.$info[1];

            return call_user_func_array([new $class, $info[2]], []);
        }

        return false;
    }
}