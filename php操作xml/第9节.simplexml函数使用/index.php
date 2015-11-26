<?php
	// simplexml函数
	// 根据dom对象获取simplexml
	// simplexml_import_dom(DOMElemet)
	// 根据一个xml的字符获取simplexml
	// simplexml_load_string(string)
	// 根据文件获取simplexml
	// simplexml_load_file($file)

/*	// 定义一个字符串，内容是xml信息
	// 如果xml有头部声明，那就让头部在字符串的第一位开始写
	$str=<<<str
<?xml version="1.0" encoding="utf-8"?>
	<message>
		<line>
			<author>后盾网</author>
			<content>后盾网，人人做后盾</content>
		</line>
	</message>
str;
	$xml=simplexml_load_string($str);
	var_dump($xml);*/

	//根据文件获取xml操作对象
	$xml=simplexml_load_file('xml.xml');
	// var_dump($xml);
	$arr=json_decode(json_encode($xml),true);
	var_dump($arr);