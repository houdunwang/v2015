<?php

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\unit;

use houdunwang\framework\App;

trait Application
{
    protected static $isBoot;

    /**
     * 创建应用
     */
    public function create()
    {
        if (is_null(self::$isBoot)) {
            define('RUN_MODE', 'TEST');
            App::bootstrap();
            self::$isBoot = true;
        }
    }
}