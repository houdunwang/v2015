<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\config\build;

/**
 * 配置项处理
 * Class Base
 *
 * @package houdunwang\config\build
 */
class Base
{
    //配置集合
    protected static $items = [];

    //.env配置集合
    protected static $env = [];

    //批量设置配置项
    public function batch(array $config)
    {
        foreach ($config as $k => $v) {
            $this->set($k, $v);
        }

        return true;
    }

    /**
     * 设置.env目录
     *
     * @param string $file
     */
    public function env($file = '.env')
    {
        if (is_file($file)) {
            $content = file_get_contents($file);
            preg_match_all('@(.+?)=(.+)@', $content, $env, PREG_SET_ORDER);
            if ($env) {
                foreach ($env as $e) {
                    self::$env[$e[1]] = $e[2];
                }
            }
        }
    }

    /**
     * @return array
     */
    public static function getEnv($name)
    {
        if (isset(self::$env[$name])) {
            return self::$env[$name];
        }
    }

    /**
     * 加载目录下的所有文件
     *
     * @param $dir 目录
     */
    public function loadFiles($dir)
    {
        foreach (glob($dir.'/*') as $f) {
            $info = pathinfo($f);
            $this->set($info['filename'], include $f);
        }
    }

    /**
     * 添加配置
     *
     * @param $key
     * @param $name
     *
     * @return bool
     */
    public function set($key, $name)
    {
        $tmp    = &self::$items;
        $config = explode('.', $key);
        foreach ((array)$config as $d) {
            if ( ! isset($tmp[$d])) {
                $tmp[$d] = [];
            }
            $tmp = &$tmp[$d];
        }

        $tmp = $name;

        return true;
    }

    /**
     * @param string $key     配置标识
     * @param mixed  $default 配置不存在时返回的默认值
     *
     * @return array|mixed|null
     */
    public function get($key, $default = null)
    {
        $tmp    = self::$items;
        $config = explode('.', $key);
        foreach ((array)$config as $d) {
            if (isset($tmp[$d])) {
                $tmp = $tmp[$d];
            } else {
                return $default;
            }
        }

        return $tmp;
    }

    /**
     * 排队字段获取数据
     *
     * @param string $key     获取键名
     * @param array  $extName 排除的字段
     *
     * @return array
     */
    public function getExtName($key, array $extName)
    {
        $config = $this->get($key);
        $data   = [];
        foreach ((array)$config as $k => $v) {
            if ( ! in_array($k, $extName)) {
                $data[$k] = $v;
            }
        }

        return $data;
    }

    /**
     * 检测配置是否存在
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        $tmp    = self::$items;
        $config = explode('.', $key);
        foreach ((array)$config as $d) {
            if (isset($tmp[$d])) {
                $tmp = $tmp[$d];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * 获取所有配置项
     *
     * @return array
     */
    public function all()
    {
        return self::$items;
    }

    /**
     * 设置items也就是一次更改全部配置
     *
     * @param $items
     *
     * @return mixed
     */
    public function setItems($items)
    {
        return self::$items = $items;
    }
}