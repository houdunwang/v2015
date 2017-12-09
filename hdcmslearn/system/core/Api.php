<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * |     Weibo: http://weibo.com/houdunwangxj
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system\core;

use houdunwang\model\Model;

/**
 * 为模块提供的通用接口
 * 操作系统表
 * Class Api
 *
 * @package system\core
 */
class Api extends Model
{
    use Member;

    protected function make($table)
    {
        return (new self())->setTable($table)->init();
    }

    public function test()
    {
        $obj = $this->make('s_a')->insert(['uid' => 12]);
//        Db::table('s_a')->insert(['uid' => 12]);
    }

    public function __call($method, $params)
    {
    }

    public static function __callStatic($method, $params)
    {
    }
}