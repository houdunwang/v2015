<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\log;

class Log {
    const FATAL     = 'FATAL';          // 严重错误: 导致系统崩溃无法使用
    const ERROR     = 'ERROR';          // 一般错误: 一般性错误
    const WARNING   = 'WARNING';      // 警告性错误: 需要发出警告的错误
    const NOTICE    = 'NOTICE';        //通知: 程序可以运行但是还不够完美的错误
    const DEBUG     = 'DEBUG';          //调试: 调试信息
    const SQL       = 'SQL';              //SQL：SQL语句 注意只在调试模式开启时有效
    const EXCEPTION = 'EXCEPTION';  //异常错误
    public $dir;

    //日志信息
    public $log = [ ];

    public function __construct() {
        $this->dir = ROOT_PATH .  '/storage/log';
        is_dir( $this->dir ) or mkdir( $this->dir, 0755, TRUE );
    }

    /**
     * 记录日志内容
     *
     * @param $message 错误
     * @param string $level 级别
     */
    public function record( $message, $level = self::ERROR ) {
        $this->log[] = date( "[ c ]" ) . "{$level}: {$message}" . PHP_EOL;
    }

    /**
     * 存储日志内容
     * @access public
     * @return void
     */
    public function save() {
        if ( $this->log ) {
            $file = $this->dir . '/' . date( 'd' ) . '.log';
            error_log( implode( "", $this->log ), 3, $file, NULL );
        }
    }

    /**
     * 写入日志内容
     * @access public
     *
     * @param string $message 日志内容
     * @param string $level 错误等级
     * @param int $type 处理方式
     * @param string $destination 日志文件
     * @param string $extraHeaders
     *
     * @return void
     */
    public function write( $message, $level = self::ERROR ) {
        $file = $this->dir . '/'. date( 'Y_m_d' ) . '.log';
        error_log( date( "[ c ]" ) . "{$level}: {$message}" . PHP_EOL, 3, $file, NULL );
    }
}