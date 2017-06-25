<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\route\build;

use houdunwang\cache\Cache;
use houdunwang\config\Config;
use houdunwang\request\Request;

/**
 * 路由处理类
 * Class Route
 *
 * @package hdphp\route
 */
class Base
{
    use Compile, Setting, Controller;
    //路由定义
    protected $route = [];
    //请求的URI
    protected $requestUri;
    //路由缓存
    protected $cache = [];
    //解析结果
    protected $content;
    //正则替换字符
    protected $patterns
        = [
            ':num' => '[0-9]+',
            ':all' => '.*',
        ];

    /**
     * 获取路由解析内容
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 设置路由解析结果
     *
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * 解析路由
     *
     * @return bool|void
     */
    public function bootstrap()
    {
        //请求URL
        $this->requestUri = $this->getRequestUri();
        //设置路由缓存
        if (Config::get('route.cache') && ($route = Cache::get('_ROUTES_'))) {
            $this->route = $route;
        } else {
            $this->route = $this->parseRoute();
        }
        //匹配路由
        foreach ($this->route as $key => $route) {
            $method = '_'.$route['method'];
            if ($this->$method($key) === true) {
                $this->setContent($this->exec());

                return $this;
            }
        }

        //路由匹配失败时解析控制器
        return $this->parseController();
    }

    /**
     * 路由匹配失败时
     * 执行默认控制器
     *
     * @return $this
     */
    protected function parseController()
    {
        //检查GET请求参数
        $http = Request::get(Config::get('http.url_var'));
        if ( ! empty($http)) {
            $info                   = explode('/', $http);
            $method                 = array_pop($info);
            $controller             = ucfirst(array_pop($info));
            $module                 = array_pop($info);
            $info[count($info) - 1] = ucfirst($info[count($info) - 1]);
            $action                 = Config::get('app.path').'\\'.$module.'\\controller\\'.$controller.'@'.$method;
        } else {
            //默认控制器
            $class  = Config::get('http.default_controller');
            $method = Config::get('http.default_action');
            $action = $class.'@'.$method;
        }
        $this->setContent($this->executeControllerAction($action));

        return $this;
    }

    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * 请求地址
     *
     * @return string
     */
    protected function getRequestUri()
    {
        $REQUEST_URI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $REQUEST_URI = str_replace($_SERVER['SCRIPT_NAME'], '', $REQUEST_URI);
        return trim($REQUEST_URI,'/');
    }

    /**
     * 使用正则表达式限制参数
     *
     * @param mixed  $rule
     * @param string $regexp
     *
     * @return $this
     */
    public function where($rule, $regexp = '')
    {
        $rule = is_array($rule) ? $rule : [$rule => $regexp];
        //当前路由在规则中的序号
        $routeKey = count($this->route) - 1;
        foreach ($rule as $k => $v) {
            $this->route[$routeKey]['where'][$k] = '#^'.$v.'$#';
        }

        return $this;
    }

    /**
     * 解析路由
     */
    protected function parseRoute()
    {
        /**
         * 为每一条路由规则生成正则表达式缓存
         * 同时解析路由中的{name}等变量
         *
         * @var [type]
         */
        foreach ($this->route as $key => $value) {
            //原始路由数据
            $regexp = $value['route'];
            //将:all等符号替换为标签路由字符
            if (strpos($regexp, ':') !== false) {
                //替换正则符号
                $regexp = str_replace(
                    array_keys($this->patterns),
                    array_values($this->patterns),
                    $regexp
                );
            }
            //将{name?}等替换为(.*?)形式
            preg_match_all('#\{(.*?)(\?)?\}#', $regexp, $args, PREG_SET_ORDER);
            foreach ($args as $i => $ato) {
                //存在$ato[2]表示存在{name?}中的问号，用来设置正则中的?
                $has = isset($ato[2]) ? $ato[2] : '';
                if ($has) {
                    //有{.*?}问号，表示变量是可选的，前面加? 组合成/? 形式
                    //要不没变量时会多一个/
                    $regexp = str_replace($ato[0], '?([a-z0-9]+?)'.$has, $regexp);
                } else {
                    $regexp = str_replace($ato[0], '([a-z0-9]+?)'.$has, $regexp);
                }
            }
            $this->route[$key]['regexp'] = '#^'.$regexp.'$#';
            $this->route[$key]['args']   = $args;
        }
        //缓存路由
        if (Config::get('route.cache')) {
            Cache::set('_ROUTES_', $this->route);
        }

        return $this->route;
    }
}