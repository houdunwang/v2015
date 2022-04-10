<?php
//引入人脸识别类
require_once 'AipFace.php';

// 你的 APPID AK SK
const APP_ID = '11225840';
const API_KEY = 'O1UkIDI6Dy7FcPrRwQ2FabH1';
const SECRET_KEY = 'HHQwy0IGdTDRnoMTvQEKdk2oGNsrpnoN';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

//调用对应方法来实现活体检测功能
$array = [
    [
        'image' => base64_encode(file_get_contents('pic/img.jpg')),
        'image_type' => 'BASE64',
        'face_field' => 'age,beauty,expression,faceshape,gender,glasses,landmark,race,quality,facetype,parsing'
    ],
    [
        'image' => base64_encode(file_get_contents('pic/image.jpg')),
        'image_type' => 'BASE64',
        'face_field' => 'age,beauty,expression,faceshape,gender,glasses,landmark,race,quality,facetype,parsing'
    ],
];
$result = $client->faceverify($array);

echo '<pre>';
print_r($result);

?>