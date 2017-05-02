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

	//4.创建文件节点
	$node=$dom->createTextNode('后盾网，人人做后盾');
	// 将创建好的文本节点追加到line标签下
	$line->appendChild($node);

	// 创建标签属性（attribute）
	$attr=$dom->createAttribute('name');
	//给创建的属性添加值
	$attr->value="one";
	//将属性追加到标签下
	$line->appendChild($attr);

	//5.保存文档
	//将dom对象信息转为字符串
	$str=$dom->saveXML();
	// echo $str;
	// 将创建的xml信息写到文本中
	file_put_contents('xml.xml',$str);
?>