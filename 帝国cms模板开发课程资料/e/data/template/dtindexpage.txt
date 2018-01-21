<?php
require('e/class/connect.php');
require('e/class/db_sql.php');
require('e/class/functions.php');
require('e/class/t_functions.php');
require('e/data/dbcache/class.php');
require ECMS_PATH.'e/data/'.LoadLang('pub/fun.php');
$link=db_connect();
$empire=new mysqlquery();
$pr=$empire->fetch1("select sitekey,siteintro from {$dbtbpre}enewspublic limit 1");
//页面
$pagetitle=ehtmlspecialchars($public_r['sitename']);
$pagekey=ehtmlspecialchars($pr['sitekey']);
$pagedes=ehtmlspecialchars($pr['siteintro']);
$url="<a href=\"".ReturnSiteIndexUrl()."\">".$fun_r['index']."</a>";//栏目导航
$indextemp=GetIndextemp();//取得模板
$string=DtNewsBq('indexpage',$indextemp,0);
$string=str_replace('[!--newsnav--]',$url,$string);//位置导航
$string=ReplaceSvars($string,$url,0,$pagetitle,$pagekey,$pagedes,$addr,0);
$string=str_replace('[!--page.stats--]','',$string);
echo stripSlashes($string);
db_close();
$empire=null;
?>