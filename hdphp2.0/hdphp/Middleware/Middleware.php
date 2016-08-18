<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\middleware;

class Middleware {
    protected $app;

    protected static $run = [ ];

    public function __construct( $app ) {
        $this->app = $app;
        self::$run = Config::get( 'middleware.global' );
    }

    /**
     * 添加控制器执行的中间件
     *
     * @param $name 中间件名称
     * @param $mod array 类型
     *  ['only'=>array('a','b')] 仅执行a,b控制器动作
     *  ['except']=>array('a','b')], 除了a,b控制器动作
     */
    public function set( $name, $mod = [ ] ) {
        if ( $mod ) {
            foreach ( $mod as $type => $data ) {
                switch ( $type ) {
                    case 'only':
                        if ( in_array( ACTION, $data ) ) {
                            self::$run[] = Config::get( 'middleware.middleware.' . $name );
                        }
                        break;
                    case 'except':
                        if ( ! in_array( ACTION, $data ) ) {
                            self::$run[] = Config::get( 'middleware.middleware.' . $name );
                        }
                        break;
                }
            }
        } else {
            self::$run[] = Config::get( 'middleware.middleware.' . $name );
        }
    }

    //执行控制器
    public function run() {
        foreach ( self::$run as $class ) {
            if ( class_exists( $class ) ) {
                $obj = $this->app->make( $class );
                if ( method_exists( $obj, 'run' ) ) {
                    $obj->run();
                }
            }
        }
    }
    //
    //    public function exe($name='', $mod = array())
    //    {
    //
    //        //执行指定中间件
    //        if($name)
    //        {
    //            $middleware = Config::get('middleware.middleware.' . $name);
    //            if($mod)
    //            {
    //                list($m,$action) = each($mod);
    //                switch($m)
    //                {
    //                    case 'only':
    //                        //仅指定方法
    //                        if (in_array(ACTION, $action)) {
    //                            self::$run[] = Config::get('middleware.middleware.' . $name);
    //                        }
    //                        break;
    //                    case 'except':
    //                        //除了指定方法
    //                        break;
    //                }
    //            }
    //        }
    //    }
}