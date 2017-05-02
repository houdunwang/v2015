<?php
//微信配置
return array(
    //微信首页验证时使用的token http://mp.weixin.qq.com/wiki/8/f9a0b8382e0b77d87b3bcc1ce6fbc104.html
    "token"      => "",
    //开发者手动填写或随机生成，将用作消息体加解密密钥。http://mp.weixin.qq.com/wiki/8/f9a0b8382e0b77d87b3bcc1ce6fbc104.html
    "encodingaeskey"=>"",
    //公众号身份标识
    "appid"      => "",
    //公众平台API(参考文档API 接口部分)的权限获取所需密钥Key
    "appsecret"  => "",
    //公众号支付请求中用于加密的密钥Key,微信发来的邮件中的微信支付商户号
    "mch_id"      => "",
    //商户支付密钥,此值需要手动在腾讯商户后台API密钥保持一致
    "key"        => "",
    //接收微信支付异步通知回调地址，不能携带参数,需要先声明路由
    "notify_url" => __ROOT__ . '/index.php/wxnotifyurl',
    //支付成功回调地址
    "back_url"   => 'http://www.houdunwang.com',
    //微信证书,红包等接口使用  https://pay.weixin.qq.com/index.php/core/account/api_cert#
    "apiclient_cert"=>"cert/apiclient_cert.pem",
    "apiclient_key"=>"cert/apiclient_key.pem",
    "rootca"=>"cert/rootca.pem",
);