<?php
/**
 * Created by PhpStorm.
 * User: liyalong
 * Date: 2017/9/14
 * Time: 下午12:28
 */
include 'connect.php';
//获取微信的回调数据 格式是XML
$data = file_get_contents('php://input');
//将$data转换成对象
$data = simplexml_load_string($data,'SimpleXMLElement',LIBXML_NOCDATA);

file_put_contents('data.php',var_export($data,true));

//如果return_code = SUCCESS,代表用户支付成功
if ($data->return_code == 'SUCCESS'){
    $orderId = $data->attach;
    $res = $pdo->exec("update orders set status = 1 where orderId = {$orderId}");
    if($res){
        file_put_contents('return.php',$res);
    }
    //以下还可以处理其他业务,比如,将用户购买的对应商品库存减去购买数量等

}