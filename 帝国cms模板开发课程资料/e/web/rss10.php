<?
if(!defined('InEmpireCMS'))
{
	exit();
}
header("Content-type: application/xml");
echo"<?xml version=\"1.0\" encoding=\"$pagecode\"?>\n";
?>
<rdf:RDF
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:syn="http://purl.org/rss/1.0/modules/syndication/"
  xmlns="http://purl.org/rss/1.0/">

	<channel rdf:about="<?=$public_r['newsurl']?>">
	<title><?=$pagetitle?></title>
	<link><?=$pageurl?></link>
	<description>Latest <?=$public_r['rssnum']?> infos of <?=$pagetitle?></description>
	<syn:updatePeriod>hourly</syn:updatePeriod>
	<syn:updateFrequency>1</syn:updateFrequency>
	<syn:updateBase>1970-01-01T00:00Z</syn:updateBase>
	<dc:creator>Empire CMS</dc:creator>
	<dc:date><?=gmdate('Y-m-d\TH:i:s',time())?>Z</dc:date>
	<items>
	<rdf:Seq>
	<rdf:li rdf:resource="<?=$public_r['newsurl']?>" />
	</rdf:Seq>
	</items>
	</channel>

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
	<item rdf:about="<?=$titleurl?>">
	<title><![CDATA[<?=RepSpeRssStr($r['title'])?>]]></title>
	<link><?=$titleurl?></link>
	<description><![CDATA[ <?=$smalltext?> ]]></description>
	<dc:subject><?=$cname?></dc:subject>
	<dc:creator><![CDATA[<?=RepSpeRssStr($r['writer'])?>]]></dc:creator>
	<dc:date><?=$newstime?>Z</dc:date>
	</item>
<?
}
?>
</rdf:RDF>