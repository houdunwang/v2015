<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\html\build;

use houdunwang\request\Request;

/**
 * 创建静态
 * Class Base
 *
 * @package houdunwang\html\build
 */
class Base
{
    /**
     * 生成静态
     *
     * @param array $action
     * @param array $args
     * @param       $file
     *
     * @return bool
     */
    public function make(array $action, array $args, $file)
    {
        foreach ($args as $k => $v) {
            Request::set('get.'.$k, $v);
        }
        ob_start();
        call_user_func_array([new $action[0], $action[1]], []);
        $data = ob_get_clean();
        //目录检测
        if ( ! is_dir(dirname($file))) {
            mkdir(dirname($file), 0755, true);
        }

        //创建静态文件
        return file_put_contents($file, $data) !== false;
    }
}