<?php
if ( ! function_exists('c')) {
    /**
     * 操作配置项
     * @param string $name
     * @param string $value
     *
     * @return mixed
     */
    function c($name = '', $value = '')
    {
        if ($name === '') {
            return \houdunwang\config\Config::all();
        }
        if ($value === '') {
            return \houdunwang\config\Config::get($name);
        }

        return \houdunwang\config\Config::set($name, $value);
    }
}

if ( ! function_exists('env')) {
    /**
     * 根据.env配置文件获取匹配项
     *
     * @param $name  配置名称
     * @param $value 为空时的返回值
     *
     * @return mixed
     */
    function env($name, $value = null)
    {
        return \houdunwang\config\Config::getEnv($name) ?: $value;
    }
}