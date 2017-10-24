<?php

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

$webhook = "https://oapi.dingtalk.com/robot/send?access_token=36e5b057bac2c66b037e2485c0d51c7f91c4a2a2608825254ce7f7592fad69c2";
$message="后盾人 人人做后盾";
//"at": {
//    "atMobiles": [
//        "156xxxx8827",
//        "189xxxx8325"
//    ],
//        "isAtAll": false
//    }

$at = [
    'atMobiles' => [
        '15921776069',
    ],
    'isAtAll' => false
];

$data = array ('msgtype' => 'text','text' => array ('content' => $message),'at' => $at);
$data_string = json_encode($data);

$result = request_by_curl($webhook, $data_string);
echo $result;

?>