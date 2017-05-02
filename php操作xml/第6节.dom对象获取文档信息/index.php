<?php
	// dom获取xml文档的属性值及文本值
	//创建dom对象
	$dom=new DomDocument();

	//加载xml文件
	//加载文件，如果文件不存在会报错，
	//如果xml文档有问题，也会保存
	$res=$dom->load('xml.xml');
	// var_dump($res);
	//以标签名获取节点list
	$lines=$dom->getElementsByTagName('line');
	// var_dump($lines);
	//获取第一个line里面的内容
	//nodeValue获取标签的文本内容
	// echo $lines->item(0)->nodeValue;
	
	// 获取标签属性值
	echo $lines->item(1)->getAttribute('name');
