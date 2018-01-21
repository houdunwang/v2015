<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/q_functions.php");
require("../data/dbcache/class.php");
require LoadLang("pub/fun.php");
require("../member/class/user.php");
$link=db_connect();
$empire=new mysqlquery();
$userid=0;
$username='';
$spacestyle='';
$search='';
require('CheckUser.php');//验证用户
//用户
$search.="&userid=$userid";
$start=0;
$page=intval($_GET['page']);
$page=RepPIntvar($page);
$line=12;//每行显示
$page_line=10;
$offset=$page*$line;
$totalquery="select count(*) as total from {$dbtbpre}enewsmembergbook where userid='$userid'";
$num=$empire->gettotal($totalquery);
$query="select gid,isprivate,uid,uname,ip,addtime,gbtext,retext from {$dbtbpre}enewsmembergbook where userid='$userid'";
$query.=" order by gid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page1($num,$line,$page_line,$start,$page,$search);
require('template/'.$spacestyle.'/gbook.temp.php');
db_close();
$empire=null;
?>