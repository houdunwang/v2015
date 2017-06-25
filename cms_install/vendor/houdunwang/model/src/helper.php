<?php
if ( ! function_exists('model')) {
    /**
     * 生成模型实例对象
     *
     * @param $name
     *
     * @return mixed
     */
    function model($name)
    {
        $class = '\system\model\\'.ucfirst($name);

        return \houdunwang\container\Container::make($class);
    }
}