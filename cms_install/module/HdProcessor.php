<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module;

use WeChat;
use system\model\Keyword;

class HdProcessor
{
    /**
     * 根据关键词编号获取模块记录编号
     *
     * @param $kid
     *
     * @return mixed
     */
    final protected function getModuleId($kid)
    {
        return Keyword::where('id', $kid)->pluck('module_id');
    }

    public function __call($name, $arguments)
    {
        $instance = WeChat::instance('message');

        return call_user_func_array([$instance, $name], $arguments);
    }
}