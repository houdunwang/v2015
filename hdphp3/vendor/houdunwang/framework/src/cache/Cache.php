<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\cache;

/**
 * 缓存处理基类
 * Class Cache
 *
 * @package Hdphp\Cache
 * @author  向军 <2300071698@qq.com>
 */
class Cache {

    //应用
    public $app;

    //连接
    protected $connect;

    public function __construct( $app ) {
        $this->app     = $app;
        $driver        = '\hdphp\cache\\' .ucfirst(Config::get( 'cache.type' ));
        $this->connect = new $driver;
    }

    //更改缓存驱动
    public function driver( $driver ) {
        $driver        = '\hdphp\cache\\' . $driver;
        $this->connect = new $driver;

        return $this;
    }

    public function __call( $method, $params ) {
        if ( method_exists( $this->connect, $method ) ) {
            return call_user_func_array( [ $this->connect, $method ], $params );
        } else {
            return $this;
        }
    }

}