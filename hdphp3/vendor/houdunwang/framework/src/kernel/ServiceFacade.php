<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\kernel;

use RuntimeException;

abstract class ServiceFacade {
    protected static $app;

    public static $resolvedInstance = [ ];

    public static function getFacadeRoot() {
        return self::resolveFacadeInstance( static::getFacadeAccessor() );
    }

    protected static function getFacadeAccessor() {
        throw new RuntimeException( "Facade does not implement getFacadeAccessor method." );
    }

    protected static function resolveFacadeInstance( $name ) {
        if ( is_object( $name ) ) {
            return $name;
        }

//        if ( isset( static::$resolvedInstance[ $name ] ) ) {
//            return static::$resolvedInstance[ $name ];
//        }
        return static::$resolvedInstance[ $name ] = static::$app[ $name ];
    }

    public static function setFacadeApplication( $app ) {
        static::$app = $app;
    }

    public static function __callStatic( $method, $args ) {
        $instance = static::getFacadeRoot();
	    return call_user_func_array( [ $instance, $method ], $args );
//        switch ( count( $args ) ) {
//	    case 0:
//                return $instance->$method();
//
//            case 1:
//                return $instance->$method( $args[0] );
//
//            case 2:
//                return $instance->$method( $args[0], $args[1] );
//
//            case 3:
//                return $instance->$method( $args[0], $args[1], $args[2] );
//
//            case 4:
//                return $instance->$method( $args[0], $args[1], $args[2], $args[3] );
//
//            default:
//                return call_user_func_array( [ $instance, $method ], $args );
//        }
    }
}