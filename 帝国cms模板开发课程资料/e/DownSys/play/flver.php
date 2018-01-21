<?php
if(!defined('InEmpireCMS'))
{
        exit();
}
//扣点
ViewOnlineKFen($showdown_r,$u,$u['userid'],$classid,$id,$pathid,$r);

$width=480;
$height=360;
$openwidth=$width+30;
$openheight=$height+60;
?>
<HTML>
<HEAD>
<TITLE><?=$r[title]?> --- 媒体播放器</TITLE>
<META HTTP-EQUIV="Expires" CONTENT="0">
<link rel="stylesheet" href="js/player.css">
<script language="javascript">
window.resizeTo(<?=$openwidth?>,<?=$openheight?>);
window.moveTo(100,100);
window.focus()
</script>
<SCRIPT language=javascript>
function click() {
if (event.button==2) {
alert('对不起，请勿点击右键')
}
}
document.onmousedown=click
</SCRIPT>
<BODY id=thisbody  bgcolor="#000000" topMargin=0 leftMargin=0 rightMargin=0 bottomMargin=0 style="scroll:no; overflow: hidden;" ondragstart="self.event.returnValue=false" onselectstart="self.event.returnValue=false">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"> 
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="<?=$width?>" height="<?=$height?>">
<param name="movie" value="images/flvplayer.swf?vcastr_file=<?=$trueurl?>&vcastr_title=<?=$r[title]?>&BarColor=0xFF6600&BarPosition=1&IsAutoPlay=1">
<param name="quality" value="high">
<param name="allowFullScreen" value="true" />
<embed src="images/flvplayer.swf?vcastr_file=<?=$trueurl?>&vcastr_title=<?=$r[title]?>&BarColor=0xFF6600&BarPosition=1&IsAutoPlay=1" allowFullScreen="true"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$width?>" height="<?=$height?>"></embed>
</object>
      </td>
  </tr>
</table>
</body>
</html>