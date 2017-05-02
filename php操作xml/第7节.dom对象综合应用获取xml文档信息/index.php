<?php

	//创建dom对象
	$dom=new DomDocument();
	//加载文档
	$dom->load('xml.xml');

	//定义一个数组，用来接收xml文件的值
	$arr=array();
	//根据标签名字获取标签list
	$lines=$dom->getElementsByTagName('line');

	//循环$lines得到下面的内容
	foreach($lines as $k=>$v){
		// 获取当前line下的author标签及值
		$author=$v->getElementsByTagName('author')->item(0);
		$authorValue=$author->nodeValue;
		// echo $authorValue.'<br>';
		//获取当前line下面的face标签及值
		$face=$v->getElementsByTagName('face')->item(0);
		$faceValue=$author->nodeValue;
		//获取当前line下面的content标签及值
		$content=$v->getElementsByTagName('content')->item(0);
		$contentValue=$author->nodeValue;

		//将上面获的的信息压倒$arr数组中去
		$arr[]=array(
				'author'=>$authorValue,
				'face'=>$faceValue,
				'content'=>$contentValue
			);
	}

	//打印$arr
	var_dump($arr);