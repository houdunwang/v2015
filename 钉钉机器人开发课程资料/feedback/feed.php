<?php
/**
 * Created by PhpStorm.
 * User: liyalong
 * Date: 2017/10/23
 * Time: 上午2:47
 */
include './FeedBack.php';

//在这里,省略将数据存入数据库的操作

$type = $_POST['type'];
$feedback = new FeedBack();
if($type == 1){
    //代表是好评,调用text消息类型返回
    $content = '用户提交的反馈信息为:' . $_POST['content'];
    $mobiles = [
        '15921776069'
    ];
    $feedback->text($content,$mobiles,false);
}else{
    //代表是差评,调用link消息类型返回
    $text = '用户提交的反馈信息为:' . $_POST['content'];
    $title = $_POST['title'];
    $picUlr = '';
    $messageUrl = 'http://www.houdunren.com';
    $feedback->link($text,$title,$picUlr,$messageUrl);
}
