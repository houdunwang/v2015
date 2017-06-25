<?php
/**
 * 文件缓存
 *
 * @param        $name
 * @param string $value
 * @param string $path
 *
 * @return bool
 */
if ( ! function_exists('f')) {
    function f($name, $value = '[get]', $expire = 3600, $path = '')
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = \houdunwang\cache\Cache::driver('file');
        }
        $path     = $path ?: \houdunwang\config\Config::get('cache.file.dir');
        $instance = $instance->dir($path);
        if (is_null($name)) {
            //删除所有缓存
            return $instance->flush();
        }
        switch ($value) {
            case '[get]':
                //获取
                return $instance->get($name);
            case '[del]':
                //删除
                return $instance->del($name);
            default:
                return $instance->set($name, $value, $expire);
        }
    }
}

/**
 * 数据库缓存
 *
 * @param      $key
 * @param null $value
 *
 * @return mixed
 */
if ( ! function_exists('d')) {
    /**
     * 数据表缓存操作函数
     *
     * @param string $name   缓存标识
     * @param string $value  缓存数据
     * @param int    $expire 过期时间
     * @param array  $field  附加字段
     *
     * @return mixed
     */
    function d($name, $value = '[get]', $expire = 0, $field = [])
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = \houdunwang\cache\Cache::driver('mysql');
        }
        if (is_null($name)) {
            //删除所有缓存
            return $instance->flush();
        }
        switch ($value) {
            case '[get]':
                //获取
                return $instance->get($name);
            case '[del]':
                //删除
                return $instance->del($name);
            default:
                return $instance->set($name, $value, $expire, $field);
        }
    }
}