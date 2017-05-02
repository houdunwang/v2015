<?php 
	//实际创建xml文件的过程
	//1、新建文件
	//2、头部声明
	//3、创建根节点
	//4、创建子元素
	//5、创建文本或者属性
	//6、文档保存

	//使用dom对象创建xml文档
	// DomDocument类
	//1创建dom对象，相当于新建文件,并且声明头部
	//传递两个参数 1.版本  2.编码
	$dom=new DomDocument('1.0','utf-8');

	//2.创建根节点
	$message=$dom->createElement('message');
	// 将创建的节点追加到dom对象中
	$dom->appendChild($message);

	//3.创建子元素
	$line=$dom->createElement('line');
	// 追加到message节点下面
	$message->appendChild($line);

	//4.保存文档
	//将dom对象信息转为字符串
	$str=$dom->saveXML();
	echo $str;
?>