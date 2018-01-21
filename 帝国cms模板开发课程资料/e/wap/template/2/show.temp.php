<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
DoWapHeader($pagetitle);
?>
<p><b>信息标题:</b> <?=DoWapClearHtml($r[title])?><br/>
<b>发布时间:</b> <?=date("Y-m-d H:i:s",$r[newstime])?><br/>
<b>所 在 地  &nbsp;:</b> <?=DoWapRepF($r[myarea],'myarea',$ret_r)?><br/>
<b>信息内容:</b></p>
<p><?=DoWapRepF($r[smalltext],'smalltext',$ret_r)?><br/></p>
<p><b>联系方式</b><br/>
发 布 者  &nbsp;: <?=DoWapClearHtml($r['username'])?><br/>
联系邮箱: <?=DoWapClearHtml($r['email'])?><br/>
联系方式: <?=DoWapRepF($r[mycontact],'mycontact',$ret_r)?><br/>
联系地址: <?=DoWapRepF($r[address],'address',$ret_r)?><br/>
</p>
<p><br/><a href="<?=$listurl?>">返回列表</a> <a href="index.php?style=<?=$wapstyle?>">网站首页</a></p>
<?php
DoWapFooter();
?>