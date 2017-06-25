<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests\app\controller;


class Entry
{
    public function show()
    {
        return 'entry_show';
    }

    public function home()
    {
        return 'home';
    }

    public function getAll()
    {
        return 'all';
    }

    public function getIndex()
    {
        return 'get_index';
    }

    public function postSend()
    {
        return 'post_send';
    }
}