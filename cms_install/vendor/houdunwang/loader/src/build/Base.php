<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\loader\build;

use houdunwang\config\Config;

class Base
{
    // 类库映射
    protected $alias = [];

    //初始
    public function bootstrap()
    {
        //导入类库别名
        $this->addMap(Config::get('loader.alias'));
        //自动加载文件
        $this->autoloadFile();
    }

    // 注册自动加载机制
    public function register($autoload = '')
    {
        spl_autoload_register(
            $autoload
                ? $autoload
                : [
                'hdphp\kernel\Loader',
                'autoload',
            ]
        );
    }

    //自动加载文件
    public function autoloadFile()
    {
        foreach (Config::get('loader.auto_load_file') as $f) {
            if (is_file($f)) {
                include $f;
            }
        }
    }

    //类库映射
    public function addMap($alias, $namespace = '')
    {
        if (is_array($alias)) {
            foreach ($alias as $key => $value) {
                $this->alias[$key] = $value;
            }
        } else {
            $this->alias[$alias] = $namespace;
        }
    }

    //类自动加载
    public function autoload($class)
    {
        $file = str_replace('\\', '/', $class).'.php';
        if (isset($this->alias[$class])) {
            //检测类库映射
            require_once str_replace('\\', '/', $this->alias[$class]);
        } else if (is_file(ROOT_PATH.'/'.$file)) {
            require_once ROOT_PATH.'/'.$file;
        } else {
            //自动加载命名空间
            foreach (Config::get('loader.autoload_namespace') as $key => $value)
            {
                if (strpos($class, $key) !== false) {
                    $file = str_replace($key, $value, $class).'.php';
                    require_once(str_replace('\\', '/', $file));
                }
            }
        }
    }
}