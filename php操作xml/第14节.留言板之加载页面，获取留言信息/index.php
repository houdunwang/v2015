<?php
    header('content-type:text/html;charset=utf8');
    //判断db.xml是否存在
    if(!is_file('db.xml')){
        //定义一个xml格式的字符串，
        $str=<<<str
<?xml version='1.0' encoding="utf-8"?>
<message>
</message>
str;
        //将$str写入到db.xml文件中
        file_put_contents('db.xml',$str);
    }else{
        // 如果存在db.xml文件，那就获取留言信息
        //加载xml文件
        $xml=simplexml_load_file('db.xml');
        var_dump($xml);
        // 循环获取$xml根标签下的数据
        //定义一个数组，存放留言信息
        $arr=array();
        foreach($xml->line as $v){
            //得到每一条留言信息，压倒$arr中
            $arr[]=array(
                    'author'=>(string)$v->author,
                    'face'=>(string)$v->face,
                    'time'=>(string)$v->time,
                    'content'=>(string)$v->content
                );
        }
        var_dump($arr);
    }
    //引入首页静态页面
    include './template/index.html';
?>