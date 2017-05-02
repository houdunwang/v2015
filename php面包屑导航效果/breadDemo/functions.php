<?php
	header('Content-type:text/html;charset=utf8');
	function p($hd){
		echo '<pre>';
		print_r($hd);
		echo '</pre>';
	}

	// 连接数据库
	function query($sql){
		$dsn='mysql:host=localhost;dbname=blog_edu';
		$username='root';
		$password='';
		try{
			$pdo=new Pdo($dsn,$username,$password);
			$pdo->query('SET NAMES UTF8');
			$result=$pdo->query($sql);
			$row=$result->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		}catch(PDOExtention $e){
			die($e->getMessage());
		}
	}

	// 获取父级的面包屑方法

	function getFather($data,$cid){

		$temp=array();
		foreach($data as $k=>$v){
			if($v['cid']==$cid){
				$temp[]=$v;
				// 合并数组函数,传入需要合并的数组
				$temp=array_merge($temp,getFather($data,$v['pid']));
			}
		}
		return $temp;

	}
?>