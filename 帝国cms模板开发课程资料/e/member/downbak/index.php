<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../class/user.php");
require("../../data/dbcache/class.php");
require "../".LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
eCheckCloseMods('member');//关闭模块
//是否登陆
$user=islogin();
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=10;//每页显示链接数
$offset=$page*$line;//总偏移量
$totalquery="select count(*) as total from {$dbtbpre}enewsdownrecord where userid='$user[userid]'";
$num=$empire->gettotal($totalquery);//取得总条数
$query="select * from {$dbtbpre}enewsdownrecord where userid='$user[userid]'";
$query=$query." order by truetime desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page1($num,$line,$page_line,$start,$page,$search);
//导入模板
require(ECMS_PATH.'e/template/member/downbak.php');
db_close();
$empire=null;
?>