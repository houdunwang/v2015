<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.hdphp.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\database\build;

use Closure;
use houdunwang\config\Config;
use houdunwang\database\Schema;

/**
 * 数据库操作
 * Class Base
 *
 * @package houdunwang\database\build
 */
class Base
{
    //操作表
    protected $table;
    //执行动作
    protected $exe;
    //连接
    protected $driver;

    public function __construct()
    {
        $class = '\houdunwang\database\build\\'.ucfirst(Config::get('database.driver'));

        $this->driver = new $class();
    }

    /**
     * 创建表
     *
     * @param string  $table   表名
     * @param Closure $callback
     * @param string  $comment 表注释
     *
     * @return bool
     */
    public function create($table, Closure $callback, $comment = '')
    {
        if (Schema::tableExists($table)) {
            return true;
        }
        $Blueprint = new Blueprint($table, $comment);
        $callback($Blueprint);

        return $Blueprint->create();
    }

    public function table($table, Closure $callback)
    {
        $Blueprint = new Blueprint($table);
        $callback($Blueprint);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->driver, $name], $arguments);
    }
}