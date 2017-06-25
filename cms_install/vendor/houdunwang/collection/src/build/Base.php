<?php namespace houdunwang\collection\build;

use houdunwang\page\Page;

/**
 * 模型多数据集合
 * Class Collection
 *
 * @package hdphp\hd
 */
class Base implements \Iterator, \ArrayAccess
{
    //数据集合
    protected $items = [];

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->items);
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return current($this->items);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->items);
    }

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $key <p>
     *                   The offset to retrieve.
     *                   </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($key)
    {
        return isset($this->items[$key]) ? $this->items[$key] : null;
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $key <p>
     *                   The offset to unset.
     *                   </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($key)
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
    }

    /**
     * 转换为数组
     *
     * @return array
     */
    public function toArray()
    {
        $res = [];
        foreach ($this->items as $k => $v) {
            if (is_object($v) && method_exists($v, 'toArray')) {
                $res[] = $v->toArray();
            } else {
                $res[] = $v;
            }
        }

        return $res;
    }

    /**
     * 设置items值
     *
     * @param $data
     *
     * @return $this
     */
    public function make($data)
    {
        $this->items = $data;

        return $this;
    }

    /**
     * 前台显示页码样式
     *
     * @return mixed
     */
    public function links()
    {
        return Page::show();
    }
}