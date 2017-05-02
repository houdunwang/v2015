<?php 
	//根据文件获取xml操作对象
	$xml=simplexml_load_file('xml.xml');
	// var_dump($xml);
	// simplexml对象提供了方便的方法
	// 第一个参数是标签的名字，第二个是标签的值
	// 如果没有第二个值，那就相当于只创建一个标签
	$line=$xml->addChild('line');
	// 在line标签下添加子元素
	$line->addChild('author','百度');
	$line->addChild('face','3.jpg');
	$line->addChild('content','百度一下，那就知道');

	//给节点添加属性
	$line->addAttribute('name','three');
	// var_dump($xml);
	
	// 将$xml对象信息转换为字符串
	// asXML()
	// $str=$xml->saveXML();
	$str=$xml->asXML();
	// var_dump($str);
	file_put_contents('xml.xml',$str);
?>