<?php
/**
 * Created by PhpStorm.
 * User: liyalong
 * Date: 2017/9/25
 * Time: 下午11:25
 */
session_start();
var_dump($_SESSION['code']);
var_dump($_POST['code']);
if($_SESSION['code'] != $_POST['code']){
    echo '验证码输入错误';die;
}
$username = $_POST['username'];
$password = $_POST['password'];

//接下来就是将数据存入数据库
$dsn = "mysql:host=localhost;dbname=alidayu";
$pdo = new PDO($dsn,'root','root');
$sql = "insert into user (username,password) values ('$username','$password')";

$result = $pdo->exec($sql);

if ($result){
    echo '注册成功';
}
