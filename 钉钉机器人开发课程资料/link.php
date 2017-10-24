<?php
/**
 * Created by PhpStorm.
 * User: liyalong
 * Date: 2017/10/23
 * Time: 上午2:14
 */
function request_by_curl($remote_server, $post_string) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
//{
//    "msgtype": "link",
//    "link": {
//    "text": "这个即将发布的新版本，创始人陈航（花名“无招”）称它为“红树林”。
//而在此之前，每当面临重大升级，产品经理们都会取一个应景的代号，这一次，为什么是“红树林”？",
//        "title": "时代的火车向前开",
//        "picUrl": "",
//        "messageUrl": "https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI"
//    }
//}
$webhook = 'https://oapi.dingtalk.com/robot/send?access_token=36e5b057bac2c66b037e2485c0d51c7f91c4a2a2608825254ce7f7592fad69c2';
$link = [
    'text' => '这个即将发布的新版本，创始人陈航（花名“无招”）称它为“红树林',
    'title' => '时代的火车向前开',
    'messageUrl' => 'https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI'
];

$data = [
    'msgtype' => 'link',
    'link' => $link,
];
$data_string = json_encode($data);
$result = request_by_curl($webhook,$data_string);
echo $result;