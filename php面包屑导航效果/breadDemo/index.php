<?php
	include "./functions.php";

	$sql="SELECT * FROM category LIMIT 1";
	$cdata=query($sql);
	$cdata=current($cdata);	
	$cid=$cdata['cid'];

	// 获得当前请求的分类的id
	$cid=isset($_GET['cid'])?(int)$_GET['cid']:$cid;

	// 获得所有分类数据信息
	$sql="SELECT * FROM category";
	$data=query($sql);

	// 获取所有面包屑数据
	$houdun=getFather($data,$cid);
	$houdun=array_reverse($houdun);

	include "./tpl/list.html";
?>