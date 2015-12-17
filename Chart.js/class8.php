<?php 
	//设置程序运行为永久
	set_time_limit(0);
	//链接数据库
	// mysql mysqli pdo
	$pdo=new Pdo('mysql:host=127.0.0.1;dbname=chartjs','root','123456');
	//循环的往数据库插入100条随机产生的数据
	for($i=0;$i<100;$i++){
		//组合sql语句，中的时间跟数量的值为随机产生
		//11-1 11-7
		$sql="insert into sale_list set time='11-".mt_rand(1,7)."',nums=".mt_rand(10,20);
		//执行sql
		$pdo->query($sql);
	}
	echo 'ok';
?>