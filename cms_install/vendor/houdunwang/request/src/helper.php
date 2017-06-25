<?php
if ( ! function_exists('request_url')) {
    /**
     * 请求的URL地址
     *
     * @return string
     */
    function request_url()
    {
        return trim('http://'.$_SERVER['HTTP_HOST'].'/'.trim($_SERVER['REQUEST_URI'], '/\\'), '/');
    }
}

if ( ! function_exists('history_url')) {
    /**
     * 来源链接
     *
     * @return string
     */
    function history_url()
    {
        return isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
    }
}
if ( ! function_exists('root_url')) {
    /**
     * 网站根地址URI
     *
     * @return string
     */
    function root_url()
    {
        return trim('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }
}

if ( ! function_exists('web_url')) {
    /**
     * 网站主页
     * 根据配置项 http.rewrite判断
     * 没有开启伪静态时添加index.php入口文件
     *
     * @return string
     */
    function web_url()
    {
        return Config::get('http.rewrite') ? root_url() : root_url().'/index.php';
    }
}

if ( ! function_exists('q')) {
    /**
     * 取得或设置全局数据包括:
     * $_COOKIE,$_SESSION,$_GET,$_POST,$_REQUEST,$_SERVER,$_GLOBALS
     *
     * @param string $var     变量名
     * @param mixed  $default 默认值
     * @param string $methods 函数库
     *
     * @return mixed
     */
    function q($var, $default = null, $methods = '')
    {
        return \houdunwang\request\Request::query($var, $default, $methods);
    }
}

if ( ! function_exists('old')) {
    /**
     * 获取表单旧数据
     *
     * @param        $name    表单
     * @param string $default 默认值
     *
     * @return string
     */
    function old($name, $default = '')
    {
        $data = \houdunwang\session\Session::flash('oldFormData');

        return isset($data[$name]) ? $data[$name] : $default;
    }
}
if ( ! function_exists('clientIp')) {
    /**
     * 客户端IP地址
     *
     * @return mixed
     */
    function clientIp()
    {
        return \houdunwang\request\Request::ip();
    }
}