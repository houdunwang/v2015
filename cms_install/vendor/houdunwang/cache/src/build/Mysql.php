<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cache\build;

use houdunwang\config\Config;
use houdunwang\db\Db;

/**
 * Mysql
 * Class Mysql
 *
 * @package houdunwang\cache\build
 */
class Mysql implements InterfaceCache
{
    use Base;
    //缓存目录
    protected $link;

    //连接
    public function connect()
    {
        $this->link = Db::table(Config::get('cache.mysql.table'));
    }

    //设置
    public function set($name, $content, $expire = 0, $fields = [])
    {
        $data = array_merge(
            $fields,
            [
                'name'      => $name,
                'data'      => serialize($content),
                'create_at' => time(),
                'expire'    => $expire,
            ]
        );

        return $this->link->replace($data) ? true : false;
    }

    //获取
    public function get($name)
    {
        $data = $this->link->where('name', $name)->first();
        if (empty($data)) {
            return null;
        } else if ($data['expire'] > 0
            && $data['create_at'] + $data['expire'] < time()
        ) {
            //缓存过期
            $this->link->where('name', $name)->delete();
        } else {
            return unserialize($data['data']);
        }
    }

    //删除
    public function del($name)
    {
        return $this->link->where('name', $name)->delete();
    }

    //删除所有
    public function flush()
    {
        return $this->link->execute(
            "TRUNCATE ".Config::get('cache.mysql.table')
        );
    }
}