<?php
	//修改xml文档信息
	
	//加载要修改的xml文档信息
	$xml=simplexml_load_file('xml.xml');
	// var_dump($xml);
	/*//例如要修改第一个line下面的author值
	$xml->line[0]->author='houdunwang.com';
	var_dump($xml);*/

	//删除某个line或者某个标签
	unset($xml->line[1]);
	// var_dump($xml);

	//刚才的只是修改，删除的内存中的内容
	//如果想改变xml.xml文档的信息，那就重新保存
	// 获取$xml信息
	$str=$xml->saveXML();
	file_put_contents('xml.xml',$str);
?>