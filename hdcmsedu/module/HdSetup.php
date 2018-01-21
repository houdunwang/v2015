<?php namespace module;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use system\model\User;

/**
 * 模块安装管理基类
 * Class HdSetup
 *
 * @package module
 */
abstract class HdSetup
{
    public function __construct()
    {
        if (User::superUserAuth() == false) {
            die(message('没有操作权限'));
        }
    }
}