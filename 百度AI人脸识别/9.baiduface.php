<?php
//引入人脸识别类
require_once 'AipFace.php';

// 你的 APPID AK SK
const APP_ID = '11225840';
const API_KEY = 'O1UkIDI6Dy7FcPrRwQ2FabH1';
const SECRET_KEY = 'HHQwy0IGdTDRnoMTvQEKdk2oGNsrpnoN';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

////定义需要创建的用户组的名称
//$groupid = 'abc';
//
//$result = $client->groupAdd($groupid);
//
//echo '<pre>';
//print_r($result);

// 调用组列表查询
//$result = $client->getGroupList();

//删除指定用户组
$groupId1 = "group1";
$groupId2 = "houdun";

// 调用删除用户组
$client->groupDelete($groupId1);
$client->groupDelete($groupId2);

$result = $client->getGroupList();

echo '<pre>';
print_r($result);

?>