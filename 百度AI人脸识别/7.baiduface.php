<?php
//引入人脸识别类
require_once 'AipFace.php';

// 你的 APPID AK SK
const APP_ID = '11225840';
const API_KEY = 'O1UkIDI6Dy7FcPrRwQ2FabH1';
const SECRET_KEY = 'HHQwy0IGdTDRnoMTvQEKdk2oGNsrpnoN';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

//定义注册的人脸图片
$image = base64_encode(file_get_contents('pic/image.jpg'));
//定义图片类型
$imageType = 'BASE64';
//定义用户组,如果该用户组存在,就直接将这个图片在用户组内添加一个用户,作为该用户的人脸识别图片,如果没有该用户组,会自动创建一个用户组
$groupId = 'hd';
//定义用户编号
$userId = 'a1';

// 调用人脸注册
$result = $client->addUser($image, $imageType, $groupId, $userId);

echo '<pre>';
print_r($result);

?>