<?php
/**
 * 生成模块访问URL
 *
 * @param        $path
 * @param string $name 模块标识
 * @param array  $args GET参数
 *
 * @return string
 */
function url($path, $name = '', array $args = [])
{
    $name = empty($name) ? Request::get('m') : $name;

    return __ROOT__."?m={$name}&action=controller/".str_replace('.', '/', $path)
           .'&'.http_build_query($args);
}

/**
 * 将ISO格式时间格化输出
 *
 * @param string $format 转换的格式
 * @param string $date
 *
 * @return false|string
 */
function dateformat($format, $date)
{
    return date($format, strtotime($date));
}