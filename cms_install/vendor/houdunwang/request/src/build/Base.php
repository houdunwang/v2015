<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\request\build;

use houdunwang\arr\Arr;
use houdunwang\cookie\Cookie;
use houdunwang\session\Session;
use houdunwang\tool\Tool;

/**
 * 请求管理
 * Class Base
 *
 * @package houdunwang\request\build
 */
class Base
{
    protected $items = [];

    /**
     * 启动组件
     */
    public function bootstrap()
    {
        $_SERVER['SCRIPT_NAME'] = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
        //命令行时定义默认值
        if ( ! isset($_SERVER['REQUEST_METHOD'])) {
            $_SERVER['REQUEST_METHOD'] = '';
        }
        if ( ! isset($_SERVER['HTTP_HOST'])) {
            $_SERVER['HTTP_HOST'] = '';
        }
        if ( ! isset($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = '';
        }
        if ( ! defined('NOW')) {
            define('NOW', $_SERVER['REQUEST_TIME']);
        }
        if ( ! defined('MICROTIME')) {
            define('MICROTIME', $_SERVER['REQUEST_TIME_FLOAT']);
        }
        if ( ! defined('__URL__')) {
            define('__URL__', trim('http://'.$_SERVER['HTTP_HOST'].'/'.trim($_SERVER['REQUEST_URI'], '/\\'), '/'));
        }
        if ( ! defined('__HISTORY__')) {
            define("__HISTORY__", isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '');
        }
        $this->defineRequestConst();
    }

    /**
     * 定义请求常量
     */
    protected function defineRequestConst()
    {
        $this->items['POST']    = $_POST;
        $this->items['GET']     = $_GET;
        $this->items['REQUEST'] = $_REQUEST;
        $this->items['SERVER']  = $_SERVER;
        $this->items['GLOBALS'] = $GLOBALS;
        $this->items['SESSION'] = Session::all();
        $this->items['COOKIE']  = Cookie::all();

        if (empty($_POST)) {
            $input = file_get_contents('php://input');
            if ($data = json_decode($input, true)) {
                $this->items['POST'] = $data;
            }
        }
        if ( ! defined('IS_GET')) {
            define('IS_GET', $this->isMethod('get'));
        }
        if ( ! defined('IS_POST')) {
            define('IS_POST', $this->isMethod('post'));
        }
        if ( ! defined('IS_DELETE')) {
            define('IS_DELETE', $this->isMethod('delete'));
        }
        if ( ! defined('IS_PUT')) {
            define('IS_PUT', $this->isMethod('put'));
        }
        if ( ! defined('IS_AJAX')) {
            define('IS_AJAX', $this->isAjax());
        }
        if ( ! defined('IS_WECHAT')) {
            define('IS_WECHAT', $this->isWeChat());
        }
        if ( ! defined('IS_MOBILE')) {
            define('IS_MOBILE', $this->isMobile());
        }
    }

    /**
     * 判断请求类型
     *
     * @param $action
     *
     * @return bool
     */
    public function isMethod($action)
    {
        switch (strtoupper($action)) {
            case 'GET':
                return $_SERVER['REQUEST_METHOD'] == 'GET';
            case 'POST':
                return $_SERVER['REQUEST_METHOD'] == 'POST' || ! empty($this->items['POST']);
            case 'DELETE':
                return $_SERVER['REQUEST_METHOD'] == 'DELETE'
                    ?: (isset($_POST['_method']) && $_POST['_method'] == 'DELETE');
            case 'PUT':
                return $_SERVER['REQUEST_METHOD'] == 'PUT' ?: (isset($_POST['_method']) && $_POST['_method'] == 'PUT');
        }
    }

    /**
     * 获取请求的类型
     * GET/POST/DELETE/PUT
     *
     * @return mixed
     */
    public function getRequestType()
    {
        $type = ['PUT', 'DELETE', 'POST', 'GET'];
        foreach ($type as $t) {
            if ($this->isMethod($t)) {
                return $t;
            }
        }
    }

    /**
     * 是否为异步提交
     *
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
               && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])
                  == 'xmlhttprequest';
    }

    /**
     * 获取数据
     *
     * @param       $name
     * @param       $value
     * @param array $method
     *
     * @return null
     */
    public function query($name, $value = null, $method = [])
    {
        $exp = explode('.', $name);
        if (count($exp) == 1) {
            array_unshift($exp, 'request');
        }
        $action = array_shift($exp);

        return $this->__call($action, [implode('.', $exp), $value, $method]);
    }

    /**
     * 设置值
     *
     * @param $name 类型如get.name,post.id
     * @param $value
     *
     * @return bool
     */
    public function set($name, $value)
    {
        $info   = explode('.', $name);
        $action = strtoupper(array_shift($info));
        if (isset($this->items[$action])) {
            $this->items[$action] = Arr::set(
                $this->items[$action],
                implode('.', $info),
                $value
            );

            return true;
        }
    }

    /**
     * 获取数据
     * 示例: Request::get('name')
     *
     * @param $action    类型如get,post
     * @param $arguments 参数结构如下
     *                   [
     *                   'name'=>'变量名',//config.a 可选
     *                   'value'=>'默认值',//可选
     *                   'method'=>'回调函数',//数组类型 可选
     *                   ]
     *
     * @return mixed
     */
    public function __call($action, $arguments)
    {
        $action = strtoupper($action);
        if (empty($arguments)) {
            return $this->items[$action];
        }

        $data = Arr::get($this->items[$action], $arguments[0]);

        if ( ! is_null($data) && ! empty($arguments[2])) {
            return Tool::batchFunctions($arguments[2], $data);
        }

        return ! is_null($data) ? $data
            : (isset($arguments[1]) ? $arguments[1] : null);
    }

    //客户端IP
    public function ip($type = 0)
    {
        $type = intval($type);
        //保存客户端IP地址
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } else if (isset($_SERVER["REMOTE_ADDR"])) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                return '';
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } else if (getenv("REMOTE_ADDR")) {
                $ip = getenv("REMOTE_ADDR");
            } else {
                return '';
            }
        }
        $long     = ip2long($ip);
        $clientIp = $long ? [$ip, $long] : ["0.0.0.0", 0];

        return $clientIp[$type];
    }

    //判断请求来源是否为本网站域名
    public function isDomain()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = parse_url($_SERVER['HTTP_REFERER']);

            return $referer['host'] == $_SERVER['HTTP_HOST'];
        }

        return false;
    }

    //https请求
    public function isHttps()
    {
        if (isset($_SERVER['HTTPS'])
            && ('1' == $_SERVER['HTTPS']
                || 'on' == strtolower($_SERVER['HTTPS']))
        ) {
            return true;
        } elseif (isset($_SERVER['SERVER_PORT'])
                  && ('443' == $_SERVER['SERVER_PORT'])
        ) {
            return true;
        }

        return false;
    }

    //微信客户端检测
    public function isWeChat()
    {
        return isset($_SERVER['HTTP_USER_AGENT'])
               && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false;
    }

    //手机客户端判断
    public function isMobile()
    {
        //微信客户端检测
        if ($this->isWeChat()) {
            return true;
        }
        if ( ! empty($_GET['_mobile'])) {
            return true;
        }
        if ( ! isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP'])
            ? $_SERVER['ALL_HTTP'] : '';
        $mobile_browser      = '0';
        if (preg_match(
            '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i',
            strtolower($_SERVER['HTTP_USER_AGENT'])
        )) {
            $mobile_browser++;
        }
        if ((isset($_SERVER['HTTP_ACCEPT']))
            and (strpos(
                     strtolower($_SERVER['HTTP_ACCEPT']),
                     'application/vnd.wap.xhtml+xml'
                 ) !== false)
        ) {
            $mobile_browser++;
        }
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            $mobile_browser++;
        }
        if (isset($_SERVER['HTTP_PROFILE'])) {
            $mobile_browser++;
        }
        $mobile_ua     = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = [
            'w3c ',
            'acs-',
            'alav',
            'alca',
            'amoi',
            'audi',
            'avan',
            'benq',
            'bird',
            'blac',
            'blaz',
            'brew',
            'cell',
            'cldc',
            'cmd-',
            'dang',
            'doco',
            'eric',
            'hipt',
            'inno',
            'ipaq',
            'java',
            'jigs',
            'kddi',
            'keji',
            'leno',
            'lg-c',
            'lg-d',
            'lg-g',
            'lge-',
            'maui',
            'maxo',
            'midp',
            'mits',
            'mmef',
            'mobi',
            'mot-',
            'moto',
            'mwbp',
            'nec-',
            'newt',
            'noki',
            'oper',
            'palm',
            'pana',
            'pant',
            'phil',
            'play',
            'port',
            'prox',
            'qwap',
            'sage',
            'sams',
            'sany',
            'sch-',
            'sec-',
            'send',
            'seri',
            'sgh-',
            'shar',
            'sie-',
            'siem',
            'smal',
            'smar',
            'sony',
            'sph-',
            'symb',
            't-mo',
            'teli',
            'tim-',
            'tosh',
            'tsm-',
            'upg1',
            'upsi',
            'vk-v',
            'voda',
            'wap-',
            'wapa',
            'wapi',
            'wapp',
            'wapr',
            'webc',
            'winw',
            'winw',
            'xda',
            'xda-',
        ];
        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) {
            $mobile_browser++;
        }
        // Pre-final check to reset everything if the user is on Windows
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows')
            !== false
        ) {
            $mobile_browser = 0;
        }
        // But WP7 is also Windows, with a slightly different characteristic
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone')
            !== false
        ) {
            $mobile_browser++;
        }
        if ($mobile_browser > 0) {
            return true;
        } else {
            return false;
        }
    }
}