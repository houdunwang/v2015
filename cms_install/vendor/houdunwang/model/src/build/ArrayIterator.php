<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\model\build;

/**
 * Trait ArrayIterator
 *
 * @package houdunwang\model\build
 */
trait ArrayIterator
{
    /**
     * @param $key
     * @param $value
     */
    public function offsetSet($key, $value)
    {
        $this->original[$key] = $value;
    }

    /**
     * @param $key
     *
     * @return null
     */
    public function offsetGet($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * @param $key
     */
    public function offsetUnset($key)
    {
        if (isset($this->original[$key])) {
            unset($this->original[$key]);
        }
    }

    /**
     *
     */
    function rewind()
    {
        reset($this->data);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->data);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * @return mixed
     */
    public function valid()
    {
        return current($this->data);
    }
}