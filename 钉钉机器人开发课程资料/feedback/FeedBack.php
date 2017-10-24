<?php
/**
 * Created by PhpStorm.
 * User: liyalong
 * Date: 2017/10/23
 * Time: 上午3:07
 */

class FeedBack{
    protected $webhook = "https://oapi.dingtalk.com/robot/send?access_token=36e5b057bac2c66b037e2485c0d51c7f91c4a2a2608825254ce7f7592fad69c2";

    /**
     * 发送curl请求方法
     * @param $remote_server
     * @param $post_string
     * @return mixed
     */
    public function request_by_curl($remote_server, $post_string) {
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

    /**
     * 返回text消息方法
     * @param $content
     * @param $atMobiles
     * @param $isAtAll
     * @return mixed
     */
    public function text($content,$atMobiles,$isAtAll){
//        {
//            "msgtype": "text",
//    "text": {
//            "content": "我就是我, 是不一样的烟火"
//    },
//    "at": {
//            "atMobiles": [
//                "156xxxx8827",
//                "189xxxx8325"
//            ],
//        "isAtAll": false
//    }
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ],
            'at' => [
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll
            ],
        ];
        $data_string = json_encode($data);
        //调用发送请求方法
        return $this->request_by_curl($this->webhook,$data_string);
//}
    }

    /**
     * 返回link消息方法
     * @param $text
     * @param $title
     * @param $picUlr
     * @param $messageUrl
     * @return mixed
     */
    public function link($text,$title,$picUlr,$messageUrl){
//        {
//            "msgtype": "link",
//    "link": {
//            "text": "这个即将发布的新版本，创始人陈航（花名“无招”）称它为“红树林”。
//而在此之前，每当面临重大升级，产品经理们都会取一个应景的代号，这一次，为什么是“红树林”？",
//        "title": "时代的火车向前开",
//        "picUrl": "",
//        "messageUrl": "https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI"
//    }
//}
        $data = [
            'msgtype' => 'link',
            'link' => [
                'text' => $text,
                'title' => $title,
                'picUrl' => $picUlr,
                'messageUrl' => $messageUrl
            ],
        ];
        $data_string = json_encode($data);
        //调用发送请求方法
        return $this->request_by_curl($this->webhook,$data_string);
    }

}