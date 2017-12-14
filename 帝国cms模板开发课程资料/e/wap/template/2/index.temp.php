<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
$add='';
$bclassid=(int)$_GET['bclassid'];
if($pr['wapshowmid'])
{
	$add=" and modid in (".$pr['wapshowmid'].")";
}
DoWapHeader($pagetitle);
?>
<?php
if($bclassid)
{
	$returnurl="index.php?style=$wapstyle&amp;bclassid=".($class_r[$bclassid]['bclassid']?$class_r[$bclassid]['bclassid']:0);
?>
<p><b>子栏目列表：</b><?=$class_r[$bclassid]['classname']?></p>
<?php
}
else
{
	$returnurl="index.php?style=$wapstyle";
?>
<p><b>网站栏目:</b><?=$pagetitle?></p>
<?php
}
?>
<p>
<?php
$sql=$empire->query("select classid,classname,islast from {$dbtbpre}enewsclass where bclassid='$bclassid' and showclass=0 and wburl=''".$add." order by myorder,classid");
while($r=$empire->fetch($sql))
{
	$classurl="list.php?classid=".$r[classid]."&amp;style=".$wapstyle."&amp;bclassid=".$bclassid;
	$indexurl="index.php?style=".$wapstyle."&amp;bclassid=".$r[classid];
	if($r['islast'])
	{
		$showsonclass="";
	}
	else
	{
		$showsonclass=" <small>(<a href=\"$indexurl\">下级栏目</a>)</small>";
	}
?>
<a href="<?=$classurl?>"><?=DoWapClearHtml($r[classname])?></a><?=$showsonclass?><br />
<?php
}
?>
</p>
<p><a href="<?=$returnurl?>">返回</a> <a href="index.php?style=<?=$wapstyle?>">网站首页</a></p>
<?php
DoWapFooter();
?>