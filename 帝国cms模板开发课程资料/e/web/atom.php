<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
header("Content-type: application/xml");
//取得网址
$idurl=substr($public_r['newsurl'],7,-1);
$year=date("Y");
echo"<?xml version=\"1.0\" encoding=\"$pagecode\"?>\n";
?>
<feed version="0.3" xmlns="http://purl.org/atom/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xml:lang="en">
	<title><?=$pagetitle?></title>
	<link rel="alternate" type="text/html" href="<?=$pageurl?>" />
	<modified><?=gmdate('Y-m-d\TH:i:s',time())?>Z</modified>
	<tagline>Latest <?=$public_r['rssnum']?> infos of <?=$pagetitle?></tagline>
	<id>tag:<?=$idurl?>,<?=$year?>://1</id>
	<generator url="http://www.movabletype.org/" version="3.2">Movable Type</generator>
	<copyright>Copyright(C) Empire CMS</copyright>
<?
$field="";
while($r=$empire->fetch($sql))
{
	if(empty($field))
	{
		$field=ReturnTheIntroField($r);
	}
	//简介
	$smalltext=RepSpeRssStr(sub(strip_tags($r[$field]),0,$sublen,false));
	//标题链接
	$titleurl=RepSpeRssStr(sys_ReturnBqTitleLink($r));
	if(!stristr($titleurl,'://'))
	{
		$titleurl=$sitedomain.$titleurl;
	}
	$cname=RepSpeRssStr($class_r[$r[classid]]['classname']);
	$newstime=gmdate('Y-m-d\TH:i:s',$r['newstime']);
?>
	<entry>
	<title><![CDATA[<?=RepSpeRssStr($r['title'])?>]]></title>
	<link rel="alternate" type="text/html" href="<?=$titleurl?>" />
	<modified><?=$newstime?>Z</modified>
	<id>tag:<?=$idurl?>,<?=$year?>://1</id>
	<created><?=$newstime?>Z</created>
	<author><![CDATA[<?=RepSpeRssStr($r['writer'])?>]]></author>
	<dc:subject><?=$cname?></dc:subject>
	<content type="text/html" mode="escaped" xml:lang="en" xml:base="<?=$pageurl?>"><![CDATA[ <?=$smalltext?> ]]></content>
	</entry>
<?
}
?>
</feed>