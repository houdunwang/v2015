<?php
/**
 * Created by PhpStorm.
 * User: liyalong
 * Date: 2017/9/7
 * Time: 下午9:55
 */
//在这里处理连接数据库

$dsn = "mysql:host=pay.hdphp.com;dbname=pay_hdphp_com";
$username = 'pay_hdphp_com';
$password = 'NAw8KnCZyy';

try{
    $pdo = new PDO($dsn,$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->query('set names utf8');
}catch (PDOException $e){
    die($e->getMessage());
}




