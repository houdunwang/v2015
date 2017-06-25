<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests\app;

use houdunwang\view\build\TagBase;

class Common extends TagBase
{
    //标签声明
    public $tags
        = [
            //block说明 1：块标签  0：行标签
            'test' => ['block' => 1, 'level' => 4],
        ];

    public function _test($attr, $content, &$view)
    {
        return 'commonTag';
    }
}