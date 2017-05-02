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

class MemcacheHandler implements AbSession {

    private $memcache;

    function __construct() {
    }

    public function make() {
        $options = Config( 'session.memcache' );
        $this->memcache = new Memcache();
        $this->memcache->connect( $options['host'], $options['port'] );
        session_set_save_handler( [ &$this, "open" ], [ &$this, "close" ], [ &$this, "read" ], [ &$this, "write" ], [ &$this, "destroy" ], [
                &$this,
                "gc"
            ] );
    }

    public function open() {
        return TRUE;
    }

    /**
     * 获得缓存数据
     *
     * @param string $sid
     *
     * @return boolean
     */
    public function read( $sid ) {
        return $this->memcache->get( $sid );
    }

    /**
     * 写入SESSION
     *
     * @param string $sid
     * @param string $data
     *
     * @return mixed
     */
    public function write( $sid, $data ) {
        return $this->memcache->set( $sid, $data );
    }

    /**
     * 删除SESSION
     *
     * @param string $sid SESSION_id
     *
     * @return boolean
     */
    public function destroy( $sid ) {
        return $this->memcache->delete( $sid );
    }

    /**
     * 垃圾回收
     * @return boolean
     */
    public function gc() {
        return TRUE;
    }

}
