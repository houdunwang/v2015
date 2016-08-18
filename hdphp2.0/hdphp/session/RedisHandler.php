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

class RedisHandler implements AbSession {

    /**
     * Redis连接对象
     * @access private
     * @var Object
     */
    private $redis;

    function __construct() {

    }

    public function make() {
        $config = C( 'session.redis' );
        $this->redis = new Redis();
        $this->redis->connect( $config['host'], $config['port'] );
        if ( ! empty( $config['password'] ) ) {
            $this->redis->auth( $config['password'] );
        }
        $this->redis->select( (int) $config['database'] );
        session_set_save_handler( [ &$this, "open" ], [ &$this, "close" ], [ &$this, "read" ], [ &$this, "write" ], [ &$this, "destroy" ], [
                &$this,
                "gc"
            ] );
    }

    function open() {
        return TRUE;
    }

    /**
     * 获得缓存数据
     *
     * @param string $sid
     *
     * @return void
     */
    function read( $sid ) {
        $data = $this->redis->get( $sid );
        if ( $data ) {
            $values = explode( "|#|", $data );

            return $values[0] === $this->card ? $values[1] : '';
        }

        return $data;
    }

    /**
     * 写入SESSION
     *
     * @param string $sid
     * @param string $data
     *
     * @return void
     */
    function write( $sid, $data ) {
        return $this->redis->set( $sid, $this->card . '|#|' . $data );
    }

    /**
     * 删除SESSION
     *
     * @param string $sid SESSION_id
     *
     * @return boolean
     */
    function destroy( $sid ) {
        return $this->redis->delete( $sid );
    }

    /**
     * 垃圾回收
     * @return boolean
     */
    function gc() {
        return TRUE;
    }

}
