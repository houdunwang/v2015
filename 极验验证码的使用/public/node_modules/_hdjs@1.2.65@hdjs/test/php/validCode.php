<?php
//短信&邮箱验证码
//发送验证码可以使用  composer require houdunwang/aliyunsms 发送短信 或 composer require houdunwang/mail 发送邮件
$json = json_encode(['valid' => 1, 'message' => '发送成功']);
die($json);