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

/**
 * 定时任务
 * Class Crontab
 *
 * @package app\site\controller
 */
class Crontab extends Admin
{
    public function lists()
    {
        auth('system_crontab');
        View::with('module_action_name', '定时任务设置');

        return view();
    }
}