<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\session\build;

use houdunwang\config\Config;
use houdunwang\db\Db;

class MysqlHandler implements AbSession
{
    use Base;

    //数据库连接
    private $link;

    //数据表
    private $table;

    //初始
    public function connect()
    {
        $this->link  = Db::table(Config::get('session.mysql.table'));
        $this->table = $this->link->getTable();
    }

    //读取数据
    public function read()
    {
        $data = $this->link->where('session_id', $this->session_id)->pluck('data');

        return $data ? unserialize($data) : [];
    }

    //写入数据
    public function write()
    {
        $data = [
            'session_id' => $this->session_id,
            'data'       => serialize($this->items),
            'atime'      => time(),
        ];
        $this->link->where('session_id', $this->session_id)->replace($data);
    }

    /**
     * SESSION垃圾处理
     *
     * @return boolean
     */
    public function gc()
    {
        $sql = "DELETE FROM ".$this->table
               ." WHERE atime<".(time() - ($this->expire + 3600))
               ." AND session_id<>'".$this->session_id."'";

        return $this->link->execute($sql);
    }
}
