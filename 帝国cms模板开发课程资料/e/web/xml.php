<?
if(!defined('InEmpireCMS'))
{
	exit();
}
header("Content-type: application/xml");
echo"<?xml version=\"1.0\" encoding=\"$pagecode\"?>\n";
?>
<source>

	<url><?=$pageurl?></url>

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
	$thetime=$r['newstime'];
	$mydate=gmdate('Y-m-d',$thetime);
	$mytime=gmdate('H:i',$thetime);
?>
	<info id="<?=$r['id']?>">
		<title><![CDATA[<?=RepSpeRssStr($r['title'])?>]]></title>
	    <url><?=$titleurl?></url>
		<author><![CDATA[ <?=RepSpeRssStr($r['writer'])?> ]]></author>
		<classname><?=$cname?></classname>
		<date><?=$mydate?></date>
		<time><?=$mytime?></time>
	</info>
<?
}
?>
</source>