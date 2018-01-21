<?
if(!defined('InEmpireCMS'))
{
	exit();
}
header("Content-type: application/xml");
echo"<?xml version=\"1.0\" encoding=\"$pagecode\"?>\n";
?>
<rss version="2.0">
  <channel>
    <title><?=$pagetitle?></title>
    <link><?=$pageurl?></link>
    <description>Latest <?=$public_r['rssnum']?> infos of <?=$pagetitle?></description>
    <copyright>Copyright(C) Empire CMS</copyright>
    <generator>Empire CMS by Empire Studio.</generator>
    <lastBuildDate><?=gmdate('r',time())?></lastBuildDate>
    <ttl>60</ttl>
    <image>
      <url><?=$public_r['newsurl']?>e/data/images/rss.gif</url>
      <title><?=$public_r['sitename']?></title>
      <link><?=$public_r['newsurl']?></link>
    </image>
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
	$newstime=gmdate('r',$r['newstime']);
?>
    <item>
      <title><![CDATA[<?=RepSpeRssStr($r['title'])?>]]></title>
      <description><![CDATA[ <?=$smalltext?> ]]></description>
      <link><?=$titleurl?></link>
      <guid><?=$titleurl?></guid>
      <category><?=$cname?></category>
      <author><![CDATA[<?=RepSpeRssStr($r['writer'])?>]]></author>
      <pubDate><?=$newstime?></pubDate>
    </item>
<?
}
?>
  </channel>
</rss>