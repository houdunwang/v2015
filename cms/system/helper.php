<?php
/**
 * 生成模块访问URL
 *
 * @param        $path
 * @param string $name 模块标识
 *
 * @return string
 */
function url($path, $name = '')
{
    $name = empty($name) ? Request::get('m') : $name;

    return $url = __ROOT__."?m={$name}&action=controller/".str_replace('.', '/', $path);
}