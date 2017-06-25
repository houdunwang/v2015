<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\dir\build;

/**
 * 目录操作
 * Class Base
 *
 * @package houdunwang\dir\build
 */
class Base
{
    //遍历目录
    public function tree($dir)
    {
        $list = [];
        if (empty($dir)) {
            return $list;
        }
        foreach (glob($dir.'/*') as $id => $v) {
            $info                     = pathinfo($v);
            $list [$id] ['path']      = $v;
            $list [$id] ['type']      = filetype($v);
            $list [$id] ['dirname']   = $info['dirname'];
            $list [$id] ['basename']  = $info['basename'];
            $list [$id] ['filename']  = $info['filename'];
            $list [$id] ['extension'] = isset($info['extension'])
                ? $info['extension'] : '';
            $list [$id] ['filemtime'] = filemtime($v);
            $list [$id] ['fileatime'] = fileatime($v);
            $list [$id] ['size']      = is_file($v) ? filesize($v)
                : $this->size($v);
            $list [$id] ['iswrite']   = is_writeable($v);
            $list [$id] ['isread']    = is_readable($v);
        }

        return $list;
    }

    //获取目录在小
    public function size($dir)
    {
        $s = 0;
        foreach (glob($dir.'/*') as $v) {
            $s += is_file($v) ? filesize($v) : self::size($v);
        }

        return $s;
    }

    //删除文件
    public function delFile($file)
    {
        if (is_file($file)) {
            return unlink($file);
        }

        return true;
    }

    //删除目录
    public function del($dir)
    {
        if ( ! is_dir($dir)) {
            return true;
        }
        foreach (glob($dir."/*") as $v) {
            is_dir($v) ? $this->del($v) : unlink($v);
        }

        return rmdir($dir);
    }

    //创建目录
    public function create($dir, $auth = 0755)
    {
        if ( ! empty($dir)) {
            return is_dir($dir) or mkdir($dir, $auth, true);
        }
    }

    //复制目录
    public function copy($old, $new)
    {
        is_dir($new) or mkdir($new, 0755, true);

        foreach (glob($old.'/*') as $v) {
            $to = $new.'/'.basename($v);
            is_file($v) ? copy($v, $to) : $this->copy($v, $to);
        }

        return true;
    }

    //复制文件
    public function copyFile($file, $to)
    {
        if ( ! is_file($file)) {
            return false;
        }
        //创建目录
        $this->create(dirname($to));

        return copy($file, $to);
    }

    //移动目录
    public function move($old, $new)
    {
        if ($this->copy($old, $new)) {
            return $this->del($old);
        }
    }

    /**
     * 移动文件
     *
     * @param string $file 文件
     * @param string $dir  目录
     *
     * @return bool
     */
    public function moveFile($file, $dir)
    {
        is_dir($dir) or mkdir($dir, 0755, true);
        if (is_file($file) && is_dir($dir)) {
            copy($file, $dir.'/'.basename($file));

            return unlink($file);
        }
    }
}