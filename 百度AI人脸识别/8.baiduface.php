<?php
//引入人脸识别类
require_once 'AipFace.php';

// 你的 APPID AK SK
const APP_ID = '11225840';
const API_KEY = 'O1UkIDI6Dy7FcPrRwQ2FabH1';
const SECRET_KEY = 'HHQwy0IGdTDRnoMTvQEKdk2oGNsrpnoN';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);
//需要获取人脸图像的用户id
$userId = "a1";
//用户所在的组编号
$groupId = "hd";

// 调用获取用户人脸列表
$result = $client->faceGetlist($userId, $groupId);

//删除人脸图像
//$userId = 'a1';
//$groupId = 'hd';
//$faceToken = 'd4ba7ada2e9301d830b6f456f019eef0';
//
//// 调用人脸删除
//$result = $client->faceDelete($userId, $groupId, $faceToken);

echo '<pre>';
print_r($result);

?>