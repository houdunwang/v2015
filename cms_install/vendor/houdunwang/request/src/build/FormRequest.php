<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\request\build;

/**
 * 表单请求基础类
 * Class Request
 *
 * @package houdunwang\request\build
 */
abstract class FormRequest implements \ArrayAccess
{
    /**
     * 验证失败时的跳转页面
     *
     * @var string
     */
    protected $home = '/';

    /**
     * @return mixed
     */
    abstract public function authorize();

    /**
     * @return mixed
     */
    abstract public function rules();

    /**
     * @var array
     */
    protected $data = [];

    /**
     * FormRequest constructor.
     */
    public function __construct()
    {
        if ($this->authorize() !== true) {
            go(__WEB__.$this->home);
        }
        $this->data = \Request::post();
        $this->validate();
    }

    /**
     * 开始验证
     */
    final private function validate()
    {
        if ( ! empty($this->data)) {
            Validate::make($this->rules(), $this->data);
        }
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
    }

    /**
     * @param mixed $key
     *
     * @return mixed|null
     */
    public function offsetGet($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this[$name]) ? $this[$name] : null;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->all();
    }
}