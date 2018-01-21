<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<script language="javascript" src="js/var.js"></script>
<script language="javascript" src="js/player.js"></script>
<script language="javascript" src="js/timer.js"></script>

<HTML>
<HEAD>
<TITLE><?=$r[title]?> --- 媒体播放器</TITLE>
<META HTTP-EQUIV="Expires" CONTENT="0">
<link rel="stylesheet" href="js/player.css">
<script language="javascript">
window.resizeTo( 375 , 421 );
window.moveTo( 100 , 100 );
window.focus()
</script>
<SCRIPT language=javascript>
function click() {
if (event.button==2) {
alert('对不起，您想做什么？')
}
}
document.onmousedown=click
</SCRIPT>

<script language="javascript" src="js/rmplayer.js"></script>
<BODY id=thisbody  bgcolor="#000000" topMargin=0 leftMargin=0 rightMargin=0 bottomMargin=0  style="scroll:no; overflow: hidden;" ondragstart="self.event.returnValue=false"  onselectstart="self.event.returnValue=false"  onmousedown="WindowMove_Start()"  onmouseup="WindowMove_End()" oncontextmenu="self.event.returnValue=false" onmousemove="WindowMove()">
<object id="min" type="application/x-oleobject"  classid="clsid:adb880a6-d8ff-11cf-9377-00aa003b7a11" style="{visibility:hidden}"><param name="Command"  value="Minimize"></object>
<!--播放器主界面-->
<DIV id="myplayPanel">
  <TABLE border=0 cellPadding=0 cellSpacing=0 width="362">
    <TR><TD width="11"><img border="0" src="images/top_l.gif" width="11" height="37"></td><td background="images/top_bg.gif" width="340">　</TD><td background="images/top_bg.gif" NOWRAP valign="center">
      </TD><td width="11"><img border="0" src="images/top_r.gif" width="11" height="37"></td>
    </TR>
    <TR>
      <td background="images/center_bgl.gif" width="11">　</td>
      <TD bgcolor="#000000" colspan="2" width="340" height="250">
        <DIV id="bufimg" style="HEIGHT: 100%; POSITION: absolute; TOP: 37px; VISIBILITY: visible; WIDTH: 100%; Z-INDEX: 4;left:11px"><img border="0" src="images/bufimg.gif" width="340" height="250"></DIV>
        <DIV id="MP" style="Z-INDEX: -1">
        <OBJECT classid="CLSID:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA" height=250 id=Player width=340>
            <param name="_ExtentX" value="8255">
            <param name="_ExtentY" value="6376">
            <param name="AUTOSTART" value="1">
            <param name="SHUFFLE" value="0">
            <param name="PREFETCH" value="0">
            <param name="NOLABELS" value="0">
            <param name="CONTROLS" value="ImageWindow">
            <param name="CONSOLE" value="one">
            <param name="LOOP" value="0">
            <param name="NUMLOOP" value="0">
            <param name="CENTER" value="0">
            <param name="MAINTAINASPECT" value="0">
            <param name="BACKGROUNDCOLOR" value="#000000">
          </OBJECT>
        </DIV>
      </TD>
      <td background="images/center_bgr.gif" width="11">　</td>
    </TR>
    </table>
<!--Control Pancel Start-->
<DIV id="mycontrolPanel">
<!--------位置控制------------->
<DIV id="myadvControl"><div id="info"></div></DIV>
<DIV id="myPosBar" onmousedown="SetPos_Start()" onmousemove="SetPos()" onmouseup="SetPos_End()"><IMG alt="播放位置" border=0  src="images/control_bar.gif" width="29" style="cursor:hand" height="12">
</DIV>
<table border="0" width="362" cellspacing="0" cellpadding="0" height="17">
    <tr>
      <td background="images/control1.gif">
      　
      </td>
    </tr>
</table>
<!--------时间显示------------->
<table border="0" width="362" cellspacing="0" cellpadding="0" height="50" background="images/control20.gif">
    <tr>
      <td width="100%" height="24">
       </td>
    </tr>
    <tr>
      <td width="100%" height="26">
         <img src="images/clock_l.gif" width="245" height="13"><img src="js/cb.gif" name="a" width="11" height="13"><img src="js/cb.gif" name="b" width="11" height="13"><img src="js/colon.gif" name="c" width="11" height="13"><img src="js/cb.gif" name="d" width="11" height="13"><img src="js/cb.gif" name="e" width="11" height="13"><img src="js/colon.gif" name="f" width="11" height="13"><img src="js/cb.gif" name="g" width="11" height="13"><img src="js/cb.gif" name="h" width="11" height="13">
       </td>
    </tr>
</table>
<!--------声音控制------------->
  <DIV id="myVolBar" onmousedown="SetVol_Start()" onmousemove="SetVol()" onmouseup="SetVol_End()"><IMG alt="音量调节" border=0 src="images/bar.gif" width="11" height="8" style="cursor:hand"></DIV>
  <table border="0" width="362" cellspacing="0" cellpadding="0">
    <tr>
      <td><img border="0" src="images/control3_01.gif" width="42" height="35"></td>
      <td><img border="0" src="images/control3_02.gif" width="23" height="35" title="播放" onclick="Play()" name="playpause" style="cursor:hand"></td>
      <td><img border="0" src="images/control3_03.gif" width="23" height="35" title="暂停" onclick="Pause()" name="playpause" style="cursor:hand"></td>
      <td><img border="0" src="images/control3_04.gif" width="24" height="35" name="stop" title="停止" onclick="Stop()" style="cursor:hand"></td>
      <td><img border="0" src="images/control3_05.gif" width="5" height="35"></td>
      <td><img border="0" src="images/control3_06.gif" width="23" height="35" alt="开始位置" title="开始位置" onclick="SetPosition(0)" style="cursor:hand"></td>
      <td><img border="0" src="images/control3_07.gif" width="24" height="35" alt="结束位置" title="结束位置" onclick="SetPosition(-1)" style="cursor:hand"></td>
      <td><img border="0" src="images/control3_08.gif" width="5" height="35"></td>
      <td><img border="0" src="images/control3_09.gif" width="24" height="35" name="fullscreen" alt="全屏幕" title="全屏幕" onClick="FullScreen()" style="cursor:hand"></td>
      <td><img border="0" src="images/control3_10.gif" width="169" height="35"></td>
    </tr>
  </table>
<!--Control Panel End-->
<!--------高级控制------------->
<DIV id="myadvPanel">
</DIV>
<!--panel table end-->
<!--事件处理-->
<SCRIPT  language="vbscript">
        sub Player_OnBuffering(Flags,PercentComplete)
                strMsg=" 正在缓冲……" & PercentComplete & "%"
                info.innerHTML=strMsg
                call ShowBuffering(PercentComplete <100)
        end sub
</script>

<SCRIPT  language="vbscript">
        sub Player_OnContacting(HostName)
                info.innerHTML= "正在连接 "& HostName
        end sub
</script>

<SCRIPT  language="vbscript">
        sub Player_OnErrorMessage(Sevrity,RMACode,UserCode,MsgText,MoreURL)
                info.innerHTML= "发生错误: "& MsgText
                msgbox MsgText
        end sub
</script>

<SCRIPT FOR="window" EVENT="onresize()" language="javascript">
        document.all.Player.width=document.body.clientWidth-20;
        document.all.Player.height=document.all.Player.width*0.75;
</SCRIPT>

<script language="javascript">document.all.Player.SetSource('<?=$url?>');</script>
<script language="javascript">
        StreamMedia();
        StreamMonitor();
</script>

</body>
</html>