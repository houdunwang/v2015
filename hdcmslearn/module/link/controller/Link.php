<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\link\controller;

use module\HdController;

/**
 * 系统连接管理
 * Class Link
 *
 * @package module\link\controller
 */
class Link extends HdController
{
    //加载系统链接
    public function system()
    {
        auth();
        return view($this->template.'/system.html');
    }
}