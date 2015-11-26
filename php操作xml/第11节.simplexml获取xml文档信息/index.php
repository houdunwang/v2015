<?php 
	//获取xml文档的信息
	//1.加载xml文档
	$xml=simplexml_load_file('xml.xml');
	// var_dump($xml);
	// 获取$xml对象line属性中第一条信息、
	// var_dump($xml->line[0]);
	
	/*// 获取line第一条中author属性的值
	echo $xml->line[0]->author;
	echo $xml->line[1]->face;*/

	/*// 如果想获取所有的值，那就得循环
	// 把信息压倒数组中去
	$arr=array();
	foreach($xml->line as $k=>$v){
		// 获取$v中的信息，压倒$arr中
		$arr[]=array(
				'author'=>(string)$v->author,
				'face'=>(string)$v->face,
				'content'=>(string)$v->content
			);
	}
	var_dump($arr);*/

	//获取标签属性的方法
	$attr=$xml->line[0]->attributes();
	foreach($attr as $k=>$v){
		echo $k.'=>'.$v.'<br>';
	}
?>