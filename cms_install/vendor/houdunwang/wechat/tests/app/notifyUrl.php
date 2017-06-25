<?php
//支付异步通知
include "../../vendor/autoload.php";


\houdunwang\config\Config::loadFiles('../config');
$data = \houdunwang\wechat\WeChat::instance('pay')->getNotifyMessage();
file_put_contents('abc.php', var_export($data, true));
/**
 * 商户处理后同步返回给微信参数
 * 告诉微信支付已经确认，不用再发送异步通知
 */

if ($data['result_code'] == 'SUCCESS' && $data['return_code'] == 'SUCCESS') {
    /**
     * 并校验返回的订单金额是否与商户侧的订单金额一致
     * 防止数据泄漏导致出现“假通知”，造成资金损失
     */

    //商城的业务处理比如用会积分更改等

    /**
     * 商户处理后同步返回给微信参数
     * 告诉微信支付已经确认，不用再发送异步通知
     */
    $data = [
        'return_code' => 'SUCCESS',
        'return_msg'  => 'OK',
    ];
    die(\houdunwang\xml\Xml::toSimpleXml($data));
}