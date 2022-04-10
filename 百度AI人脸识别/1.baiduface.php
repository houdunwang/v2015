<?php
//引入人脸识别类
require_once 'AipFace.php';

// 你的 APPID AK SK
const APP_ID = '11225840';
const API_KEY = 'O1UkIDI6Dy7FcPrRwQ2FabH1';
const SECRET_KEY = 'HHQwy0IGdTDRnoMTvQEKdk2oGNsrpnoN';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

//定义需要检测的图片
$img = base64_encode(file_get_contents('pic/img.jpg'));

//调用人脸检测方法得到检测数据
$result = $client->detect($img, 'BASE64');

echo '<pre>';
print_r($result);
//Array
//(
//    [error_code] => 0 //错误码,如果为0的时候,是代表检测成功
//    [error_msg] => SUCCESS // 错误提示,如果是success,代表检测成功
//    [log_id] => 2317991686
//    [timestamp] => 1526025060
//    [cached] => 0
//    [result] => Array
//(
//    [face_num] => 1
//            [face_list] => Array
//(
//    [0] => Array
//    (
//        [face_token] => d4ba7ada2e9301d830b6f456f019eef0
//        [location] => Array
//(
//    [left] => 179.2576447
//                                    [top] => 102.8697205
//                                    [width] => 126
//                                    [height] => 107
//                                    [rotation] => 0
//                                )
//
//                            [face_probability] => 1
//                            [angle] => Array
//(
//    [yaw] => -0.7847980261
//                                    [pitch] => 2.985867023
//                                    [roll] => -0.7611394525
//                                )
//                        )
//                )
//        )
//)


?>


