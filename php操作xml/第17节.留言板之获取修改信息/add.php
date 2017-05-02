<?php 
	header('content-type:text/html;charset=utf8');
	//接收post提交的数据
	$data=$_POST;

	// 给留言信息添加时间索引
	$data['time']=time();
	// var_dump($data);
	// 加载db.xml文档
	$xml=simplexml_load_file('db.xml');
	//在根元素下面创建一个标签，名字是line
	$line=$xml->addChild('line');

	// 在line下面添加元素及文本
	$line->addChild('author',$data['author']);
	$line->addChild('time',$data['time']);
	$line->addChild('face',$data['face']);
	$line->addChild('content',$data['content']);
	// var_dump($xml);
	// 以上操作只是内存改变，要想真正的改变，需要重新写入到db.xml中
	// 将$xml转为字符串
	$str=$xml->saveXML();
	//将$str写入到db.xml中去
	file_put_contents('db.xml',$str);
	//跳转到首页
	echo '<script>location.href="index.php"</script>';
?>