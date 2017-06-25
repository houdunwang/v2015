<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\log\build;

use houdunwang\config\Config;
use houdunwang\dir\Dir;

class Base
{
    //日志保存目录
    protected $dir;
    //日志信息
    protected $log = [];

    public function __construct()
    {
        $this->dir(Config::get('log.dir'));
    }

    /**
     * 设置日志目录
     *
     * @param $dir
     *
     * @return $this
     */
    public function dir($dir)
    {
        Dir::create($dir);
        $this->dir = realpath($dir);

        return $this;
    }

    /**
     * 记录日志内容
     *
     * @param        $message 错误
     * @param string $level   级别
     *
     * @return bool
     */
    public function record($message, $level = self::ERROR)
    {
        $this->log[] = date("[ c ]")."{$level}: {$message}".PHP_EOL;

        return true;
    }

    /**
     * 存储日志内容
     *
     * @access public
     * @return void
     */
    protected function save()
    {
        if ($this->log) {
            $file = $this->dir.'/'.date('Y_m_d').'.log';

            return error_log(implode("", $this->log), 3, $file, null);
        }
    }

    /**
     * 写入日志内容
     *
     * @param string $message 日志内容
     * @param string $level   错误等级
     *
     * @return bool
     */
    public function write($message, $level = 'ERROR')
    {
        $file = $this->dir.'/'.date('Y_m_d').'.log';

        return error_log(
            date("[ c ]")."{$level}: {$message}".PHP_EOL,
            3,
            $file,
            null
        );
    }

    public function __destruct()
    {
        //记录日志
        $this->save();
    }
}