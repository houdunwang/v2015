<?php
	//获取xml文档信息
	
	//1.加载xml文档
	$xml=simplexml_load_file('xml.xml');
	//获取跟标签名字
	// echo $xml->getname();
	// 获取line标签子元素信息
	$arr=$xml->line[0]->children();
	/*var_dump($arr);
	echo $arr->author;*/

	// 循环获取所有的line下面的信息
	foreach($xml->line as $v){
		// 获取当前下面的子元素
		$arr=$v->children();
		foreach($arr as $k=>$vv){
			echo $k.'=>'.$vv.'<br>';
		}
		echo '<hr>';
	}
?>