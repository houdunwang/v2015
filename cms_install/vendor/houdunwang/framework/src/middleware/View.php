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
use Config;

class View implements Middleware
{
    public function run($next)
    {
        Config::set('view.compile_open', Config::get('app.debug'));
        //分配SESSION闪存中的错误信息
        \houdunwang\view\View::with('errors', \houdunwang\session\Session::flash('errors'));

        if ($post = \houdunwang\request\Request::post()) {
            \houdunwang\session\Session::flash('oldFormData', $post);
        }
        $next();
    }
}