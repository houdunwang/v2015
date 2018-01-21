<?php namespace app\system\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

/**
 * 应用商店管理
 * Class Store
 *
 * @package app\system\controller
 */
class Store extends Admin
{
    public function __construct()
    {
        \User::superUserAuth();
    }

    //模块菜单
    public function module()
    {
        message('嗨. 不要着急, 正在开发中...', 'back', 'info');
    }
}