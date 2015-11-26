<?php 
	header('content-type:text/html;charset=utf8');
	//获取当前修改的留言id
	$id=$_GET['id'];

	//如果有post提交，那就修改，否则就加载页面
	if(!empty($_POST)){
		// var_dump($_POST);
		// 加载db.xml文档
		$xml=simplexml_load_file('db.xml');
		// 获取当前修改的留言line
		$line=$xml->line[(int)$id];
		//修改当前line下面的标签值
		$line->author=$_POST['author'];
		$line->face=$_POST['face'];
		$line->time=time();
		$line->content=$_POST['content'];

		//将$xml转为字符串
		$str=$xml->saveXML();
		//将$str写入到db.xml中
		file_put_contents('db.xml',$str);
		//跳转到首页
		echo '<script>location.href="index.php"</script>';
	}else{
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
	}
?>