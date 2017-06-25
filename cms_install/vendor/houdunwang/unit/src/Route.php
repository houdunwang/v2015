<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\unit;

use Curl;

trait Route
{
    //请求主机
    protected $host;
    //响应验证码
    protected $code;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function request($action, $url, $data = [])
    {
        switch (strtolower($action)) {
            case 'get':
                Curl::get($this->host.$url);
                break;
            case 'post':
                $data['_method'] = strtoupper($action);
                Curl::post($this->host.$url, $data);
                break;
        }
        $this->setCode(Curl::getCode());

        return $this;
    }
}