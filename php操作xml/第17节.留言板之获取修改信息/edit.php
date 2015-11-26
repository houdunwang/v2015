<?php 
	header('content-type:text/html;charset=utf8');
	//获取当前修改的留言id
	$id=$_GET['id'];

	//得到db.xml操作对象
	$xml=simplexml_load_file('db.xml');
	// var_dump($xml);
	// 根据id获取当前修改的留言信息
	$line=$xml->line[(int)$id];
	// 定义一个数组存放留言信息
	$arr=array(
			'author'=>(string)$line->author,
			'face'=>(string)$line->face,
			'time'=>(string)$line->time,
			'content'=>(string)$line->content,
		);
	// var_dump($arr);
	//加载修改页面
	include './template/edit.html';
?>