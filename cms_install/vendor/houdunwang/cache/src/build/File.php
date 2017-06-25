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

use Exception;
use houdunwang\config\Config;
use houdunwang\dir\Dir;

/**
 * 文件缓存处理
 * Class File
 *
 * @package houdunwang\cache\build
 */
class File implements InterfaceCache
{
    use Base;
    //缓存目录
    private $dir;

    //连接
    public function connect()
    {
        $this->dir(Config::get('cache.file.dir'));
    }

    //设置缓存目录
    public function dir($dir)
    {
        $this->dir = $dir;
        if (!Dir::create($this->dir)) {
            throw new Exception("缓存目录创建失败或目录不可写");
        }

        return $this;
    }

    //缓存文件
    private function getFile($name)
    {
        return $this->dir.'/'.md5($name).".php";
    }

    //设置
    public function set($name, $data, $expire = 3600)
    {
        $file = $this->getFile($name);
        //缓存时间
        $expire = sprintf("%010d", $expire);
        $data   = $expire.serialize($data);

        return file_put_contents($file, $data);
    }

    //获取
    public function get($name)
    {
        $file = $this->getFile($name);
        //缓存文件不存在
        if ( ! is_file($file) || ! is_readable($file)) {
            return null;
        }
        $content = file_get_contents($file);
        $expire  = intval(substr($content, 0, 10));
        //修改时间
        $mtime = filemtime($file);

        //缓存失效处理
        if ($expire > 0 && $mtime + $expire < time()) {
            @unlink($file);

            return false;
        }

        return unserialize(substr($content, 10));
    }

    //删除
    public function del($name)
    {
        $file = $this->getFile($name);

        return Dir::delFile($file);
    }

    //刷新缓存池
    public function flush()
    {
        return Dir::del($this->dir);
    }
}