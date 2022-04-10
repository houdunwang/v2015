<?php
//引入人脸识别类
require_once 'AipFace.php';

// 你的 APPID AK SK
const APP_ID = '11225840';
const API_KEY = 'O1UkIDI6Dy7FcPrRwQ2FabH1';
const SECRET_KEY = 'HHQwy0IGdTDRnoMTvQEKdk2oGNsrpnoN';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

////定义被复制的用户id
//$userid = 'a1';
////选填的设置从哪个组复制到哪个组
//$options = [
//    'src_group_id' => 'hd',
//    'dst_group_id' => 'abc',
//];
//
//$result = $client->userCopy($userid,$options);

$groupId = "hd";

// 调用获取用户列表
$result = $client->getGroupUsers($groupId);

echo '<pre>';
print_r($result);

?>