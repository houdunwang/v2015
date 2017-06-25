<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\framework\middleware;

use houdunwang\middleware\build\Middleware;

/**
 * 模板文件
 * 如果是控制器请求且视图文件不存在时设置方法名为文件名
 * Class ViewParseFile
 *
 * @package houdunwang\framework\middleware
 */
class ViewParseFile implements Middleware
{
    public function run($next)
    {
        $file = \houdunwang\view\View::getFile();
        if (empty($file)) {
            $action = \houdunwang\route\Route::getAction();
            if ($action) {
                \houdunwang\view\View::setFile($action);
            }
        }
        $next();
    }
}