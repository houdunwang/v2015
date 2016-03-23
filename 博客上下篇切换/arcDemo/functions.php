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
			$pdo->query("SET NAMES UTF8");
			$result=$pdo->query($sql);
			$row=$result->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		}catch(PDOExtention $e){
			die($e->getMessage());
		}
	}

?>