<?php 
	//获取当前删除的留言id
	$id=$_GET['id'];
	//加载xml文档
	$xml=simplexml_load_file('db.xml');
	//使用unset删除$xml下line索引为$id的那一条数据
	unset($xml->line[(int)$id]);
	//将xml转为字符串
	$str=$xml->saveXML();
	//将$str写到db.xml中
	file_put_contents('db.xml',$str);
	//跳转到首页
	echo '<script>location.href="index.php"</script>';
?>