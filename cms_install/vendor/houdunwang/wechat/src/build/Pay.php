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
use houdunwang\tool\Tool;
use houdunwang\wechat\build\pay\QrPay;

/**
 * 微信支付
 * Class Pay
 *
 * @package houdunwang\wechat\build
 */
class Pay extends Base
{
    use QrPay;
    /**
     * 统一下单返回结果
     *
     * @var array
     */
    protected $order = [];

    /**
     * 公众号支付
     *
     * @param $order
     *
     * @return mixed
     */
    public function jsapi($order)
    {
        //支付完成时
        if (isset($_GET['done'])) {
            //支付成功后根据配置文件设置的链接地址跳转到成功页面
            return [
                'errcode'      => 'SUCCESS',
                'out_trade_no' => $_GET['out_trade_no'],
            ];
        } else {
            $order['trade_type'] = 'JSAPI';
            $scope               = $this->instance('oauth')->snsapiBase();
            $order['openid']     = $scope['openid'];
            $res                 = $this->unifiedorder($order);
            if ($res['errcode'] == 'FAIL') {
                return $res;
            }
            $data['appId']     = $this->appid;
            $data['timeStamp'] = time();
            $data['nonceStr']  = Tool::randStr(16);
            $data['package']   = "prepay_id=".$res['prepay_id'];
            $data['signType']  = "MD5";
            $data['paySign']   = $this->makeSign($data);
            $js
                               = <<<str
<script>
    function onBridgeReady() {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest', {
                //公众号名称，由商户传入
                "appId": "{$data['appId']}",    
                //时间戳，自1970年以来的秒数
                "timeStamp": "{$data['timeStamp']}",
                //随机串
                "nonceStr": "{$data['nonceStr']}", 
                "package": "{$data['package']}",
                //微信签名方式
                "signType": "{$data['signType']}",
                //微信签名
                "paySign": "{$data['paySign']}" 
            },
            function (res) {
                if (res.err_msg == "get_brand_wcpay_request:ok") {
                    location.search += '&done=hdphp&out_trade_no={$order["out_trade_no"]}';
                } else {
                    alert('支付失败，请稍后再试');
                }
            }
        );
    }
    if (typeof WeixinJSBridge == "undefined") {
        if (document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        } else if (document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
    } else {
        onBridgeReady();
    }
</script>
str;
            die($js);
        }
    }

    /**
     * 统一下单
     *
     * @param array $data
     *
     * @return mixed
     */
    protected function unifiedorder(array $data)
    {
        $data['appid']     = $this->appid;
        $data['mch_id']    = Config::get('wechat.mch_id');
        $data['nonce_str'] = Tool::randStr(16);
        $data['sign']      = $this->makeSign($data);
        $xml               = $this->arrayToXml($data);
        $url               = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $res               = $this->xmlToArray(Curl::post($url, $xml));
        if ($res == false || $res['return_code'] != 'SUCCESS'
            || $res['result_code'] != 'SUCCESS'
        ) {
            $return = ['errcode' => 'FAIL'];
            if (isset($res['err_code_des'])) {
                $return['errmsg'] = $res['err_code_des'];
            }
            if (isset($res['return_msg'])) {
                $return['errmsg'] = $res['return_msg'];
            }

            return $return;
        }

        return $res;
    }

    /**
     * 支付成功后的异步通知
     *
     * @return mixed
     */
    public function getNotifyMessage()
    {
        return $this->xmlToArray($GLOBALS['HTTP_RAW_POST_DATA']);
    }

    public function orderQuery(array $data)
    {
        $data['appid']     = $this->appid;
        $data['mch_id']    = Config::get('wechat.mch_id');
        $data['nonce_str'] = Tool::randStr(16);
        $data['sign']      = $this->makeSign($data);
        $xml               = $this->arrayToXml($data);
        $url               = "https://api.mch.weixin.qq.com/pay/orderquery";
        $res               = Curl::post($url, $xml);

        return $this->xmlToArray($res);
    }
}