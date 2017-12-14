<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
DoWapHeader($pagetitle);
?>
<p><b>标题:</b><?=DoWapClearHtml($r[title])?><br/>
<b>作者:</b><?=DoWapRepF($r[writer],'writer',$ret_r)?><br/>
<b>日期:</b><?=date("Y-m-d H:i:s",$r[newstime])?><br/>
<b>内容:</b></p>
<p><?=DoWapRepNewstext($r[newstext])?></p>
<p><br/><a href="<?=$listurl?>">返回列表</a> <a href="index.php?style=<?=$wapstyle?>">网站首页</a></p>
<?php
DoWapFooter();
?>