<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\session;

//URL处理类
class Session {
    public function __construct() {
        $this->init();
        $driver       = '\hdphp\session\\' . ucfirst( Config::get( 'session.driver' ) ) . 'Handler';
        $this->driver = new $driver();
    }

    //session初始
    private function init() {
        //设置session_name
        session_name( Config::get( 'session.name' ) );

        //session_id的cookie域
        if ( $domain = Config::get( 'session.domain' ) ) {
            ini_set( 'session.cookie_domain', $domain );
        }

    }

    public function has( $name ) {
        return isset( $_SESSION[ $name ] );
    }

    public function set( $name, $value ) {
        $tmp =& $_SESSION;
        foreach ( explode( '.', $name ) as $d ) {
            if ( ! isset( $tmp[ $d ] ) ) {
                $tmp[ $d ] = [ ];
            }
            $tmp = &$tmp[ $d ];
        }

        return $tmp = $value;
    }

    public function get( $name = '' ) {
        $tmp = $_SESSION;
        foreach ( explode( '.', $name ) as $d ) {
            if ( isset( $tmp[ $d ] ) ) {
                $tmp = $tmp[ $d ];
            } else {
                return;
            }
        }

        return $tmp;
    }

    public function del( $name ) {
        if ( isset( $_SESSION[ $name ] ) ) {
            unset( $_SESSION[ $name ] );
        }

        return TRUE;
    }

    public function all() {
        return $_SESSION;
    }

    public function flush() {
        session_unset();
        session_destroy();
    }

    public function __call( $method, $params ) {
        return call_user_func_array( [ new $this->driver, $method ], $params );
    }
}