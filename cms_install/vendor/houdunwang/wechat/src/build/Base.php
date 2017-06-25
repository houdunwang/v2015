<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build;

use houdunwang\config\Config;
use houdunwang\curl\Curl;
use houdunwang\dir\Dir;
use houdunwang\request\Request;
use houdunwang\wechat\build\traits\Sign;

/**
 * 基础类
 * Class Base
 *
 * @package houdunwang\wechat\build
 */
class Base extends Error
{
    use Xml, Sign;
    protected $appid;
    protected $appsecret;

    //验证令牌
    protected $accessToken;

    //微信服务器发来的数据
    protected $message;

    //API 根地址
    protected $apiUrl = 'https://api.weixin.qq.com';

    //缓存目录
    protected $cacheDir;

    public function __construct()
    {
        $this->appid     = Config::get('wechat.appid');
        $this->appsecret = Config::get('wechat.appsecret');
        $this->cacheDir  = Config::get('wechat.cache_path');
        $this->setAccessToken();
        $this->setMessage();
    }

    /**
     * 获取微信消息内容
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * 获取微信发送来的消息
     */
    public function setMessage()
    {
        if (isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
            $content = $GLOBALS['HTTP_RAW_POST_DATA'];
        } else {
            $content = file_get_contents('php://input');
        }

        $xml_parser = xml_parser_create();
        if ( ! xml_parse($xml_parser, $content, true)) {
            xml_parser_free($xml_parser);

            return false;
        } else {
            $this->message = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
    }

    public function __get($name)
    {
        return isset($this->message->$name) ? $this->message->$name : null;
    }

    /**
     * 获取消息类型
     *
     * @return mixed
     */
    public function getMessageType()
    {
        if (isset($this->message->MsgType)) {
            return $this->message->MsgType;
        }
    }

    /**
     * 微信接口整合验证进行绑定
     *
     * @return bool
     */
    public function valid()
    {
        if ( ! isset($_GET["echostr"]) || ! isset($_GET["signature"])
             || ! isset($_GET["timestamp"])
             || ! isset($_GET["nonce"])
        ) {
            return false;
        }
        $echoStr   = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $token     = Config::get('wechat.token');
        $tmpArr    = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            echo $echoStr;
            exit;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * 设置accessToken
     *
     * @param bool $force
     *
     * @throws \Exception
     */
    public function setAccessToken($force = false)
    {
        static $accessToken;
        //缓存文件
        $file = $this->cacheDir.'/'.md5($this->appid.$this->appsecret).'.php';
        if ( ! $accessToken) {
            if ($force === false && is_file($file) && filemtime($file) + 7000 > time()) {
                //缓存有效
                $data = include $file;
            } else {
                $url  = $this->apiUrl
                        .'/cgi-bin/token?grant_type=client_credential&appid='
                        .$this->appid.'&secret='.$this->appsecret;
                $data = json_decode(Curl::get($url), true);
                //获取失败
                if (isset($data['errmsg'])) {
                    throw new \Exception($data['errmsg']);
                }
                //缓存access_token
                Dir::create($this->cacheDir);
                file_put_contents($file,
                    '<?php return '.var_export($data, true).';?>');
            }
            $accessToken = $data['access_token'];
        }
        $this->accessToken = $accessToken;
    }

    /**
     * 获取实例
     *
     * @param string $api
     *
     * @return mixed
     */
    public function instance($api)
    {
        $class = '\houdunwang\wechat\build\\'.ucfirst($api);

        return new $class();
    }

    /**
     * 格式化上传素材的数据
     *
     * @param $file
     *
     * @return array
     */
    protected function getPostMedia($file)
    {
        if (class_exists('\CURLFile')) {
            //关键是判断curlfile,官网推荐php5.5或更高的版本使用curlfile来实例文件
            $data = [
                'media' => new \CURLFile (realpath($file)),
            ];
        } else {
            $data = [
                'media' => '@'.realpath($file),
            ];
        }

        return $data;
    }
}