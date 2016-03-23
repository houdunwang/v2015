<?php
	include "./functions.php";
	$sql="SELECT * FROM article LIMIT 1";
	$hd=query($sql);
	$hd=current($hd);
	$hd=$hd['aid'];
	$aid=isset($_GET['aid'])?(int)$_GET['aid']:$hd;

	// 上一篇文章
	function upaid($aid){
		// 获取数据库中比当前请求的文章主键id小的所有文章中最大的一条数据
		$sql="SELECT * FROM article WHERE aid<{$aid} ORDER BY aid desc LIMIT 1";
		$date=query($sql);		
		$date=current($date);
		return $date;
	}

	$up=upaid($aid);

	// 下一篇文章
	function nextaid($aid){
		// 获取数据库中比当前请求的文章主键id大的所有文章获取主键最大的一条数据返出
		$sql="SELECT * FROM article WHERE aid>{$aid} ORDER BY aid ASC LIMIT  1";
		$date=query($sql);
		$date=current($date);
		return $date;
	}
	$next=nextaid($aid);
	// 获取文章数据
	$sql="SELECT * FROM article WHERE aid={$aid}";
	$houdun=query($sql);
	$houdun=current($houdun);
	include "./tpl/content.html";

?>