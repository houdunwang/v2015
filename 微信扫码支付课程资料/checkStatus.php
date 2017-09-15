<?php
/**
 * Created by PhpStorm.
 * User: liyalong
 * Date: 2017/9/14
 * Time: 下午11:40
 */

//此文件用来查询当前提交的订单状态
include 'connect.php';

$orderId = $_POST['orderId'];

$result = $pdo->query("select status from orders where orderId = {$orderId}");
$data = $result->fetch(PDO::FETCH_ASSOC);

if ($data['status'] == 1){
    //代表用户已经支付成功,通知前台用户已支付
    $res = [
        'isPay' => 1
    ];
}else{
    //代表用户尚未支付,通知前台用户尚未支付
    $res = [
        'isPay' => 0
    ];
}

echo  json_encode($res);