<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
//公告
$spacegg='';
if($addur['spacegg'])
{
	$spacegg='<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#96C8F1">
  <tr>
    <td background="template/default/images/bg_title_sider.gif"><b>公告</b></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            '.$addur['spacegg'].'
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<br>';
}
//导航菜单
$dhmenu='';
$modsql=$empire->query("select mid,qmname from {$dbtbpre}enewsmod where usemod=0 and showmod=0 and qenter<>'' order by myorder,mid");
while($modr=$empire->fetch($modsql))
{
	$dhmenu.="<td width=70 height=24 onmouseover='ChangeMenuBg(this,mod".$modr[mid].")' onmouseout='ChangeMenuBg2(this,mod".$modr[mid].")' align='center' onclick=\"self.location.href='list.php?userid=$userid&mid=$modr[mid]';\"><font color='#FFFFFF' id='mod".$modr[mid]."'><strong>".$modr[qmname]."</strong></font></td>";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$spacename?> - Powered by EmpireCMS</title>
<meta content="<?=$spacename?>" name="keywords" />
<meta content="<?=$spacename?>" name="description" />
<link href="template/default/images/style.css" rel="stylesheet" type="text/css" />
<script>
function ChangeMenuBg(doobj,dofont){
	doobj.style.cursor="hand";
	doobj.style.background='url(template/default/images/nav_a_bg3.gif)';
	dofont.style.color='#000000';
}
function ChangeMenuBg2(doobj,dofont){
	doobj.style.background='';
	dofont.style.color='#ffffff';
}
</script>
</head>
<body topmargin="0">
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="F7F7F7">
  <tr>
    <td height="20">&nbsp;<font color="#666666"> 
      <?=$spacename?>
      </font></td>
    <td align="right"><a href="<?=$public_r[newsurl]?>">网站首页</a> | <a onClick="window.external.addFavorite('<?=$spaceurl?>','<?=$spacename?>')" href="#ecms">加入收藏</a> 
      | <a onClick="this.style.behavior='url(#default#homepage)';this.setHomePage('<?=$spaceurl?>')" href="#ecms">设为首页</a></td>
 </tr>
</table>
<table width="778" height="108" border="0" align="center" cellpadding="0" cellspacing="8" background="template/default/images/head_bg.gif">
  <tr> 
    <td valign="middle"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="15%"></td>
          <td><font style="font-family:宋体;font-size:20px;color:FFFFFF;font-weight:normal;font-style:normal;"><strong><?=$spacename?></strong></font><br><span style='line-height=15pt'><a href="<?=$spaceurl?>"><font color="ffffff"><?=$spaceurl?></font></a></span></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="32" background="template/default/images/nav_bg2.gif">
<table border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="70" height="24" onMouseOver="ChangeMenuBg(this,mhome)" onMouseOut="ChangeMenuBg2(this,mhome)" align="center" onClick="self.location.href='index.php?userid=<?=$userid?>';"><font color="#FFFFFF" id="mhome"><strong>空间首页</strong></font></td>
			<?=$dhmenu?>
          <td width="70" height="24" onMouseOver="ChangeMenuBg(this,muserinfo)" onMouseOut="ChangeMenuBg2(this,muserinfo)" align="center" onClick="self.location.href='UserInfo.php?userid=<?=$userid?>';"><font color="#FFFFFF" id="muserinfo"><strong>个人资料</strong></font></td>
		  <td width="70" height="24" onMouseOver="ChangeMenuBg(this,mgbook)" onMouseOut="ChangeMenuBg2(this,mgbook)" align="center" onClick="self.location.href='gbook.php?userid=<?=$userid?>';"><font color="#FFFFFF" id="mgbook"><strong>留言板</strong></font></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="23" bgcolor="B3DBF5">&nbsp;&nbsp;您现在的位置：
      <?=$url?>
    </td>
  </tr>
</table>
<table width="778" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
  <td colspan="2"><table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="220" valign="top"> <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#96C8F1">
              <tr> 
                <td background="template/default/images/bg_title_sider.gif">&nbsp;</td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="6" cellpadding="0">
                    <tr> 
                      <td height="25"><div align="center"><img src="<?=$userpic?>" width="158" height="158" style="border:1px solid #cccccc;" /></div></td>
                    </tr>
                    <tr> 
                      <td height="25"><div align="center"><a href="UserInfo.php?userid=<?=$userid?>">
                          <?=$username?>
                          </a></div></td>
                    </tr>
                  </table> </td>
              </tr>
            </table>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#96C8F1">
              <tr> 
                <td background="template/default/images/bg_title_sider.gif"><strong>用户菜单</strong></td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="6" cellpadding="3">
                    <tr> 
                      <td height="25"><a href="../member/friend/add/?fname=<?=$username?>" target="_blank">加为好友</a></td>
                      <td><a href="../member/msg/AddMsg/?username=<?=$username?>" target="_blank">发短消息</a></td>
                    </tr>
                    <tr> 
                      <td height="25"><a href="UserInfo.php?userid=<?=$userid?>">用户资料</a></td>
                      <td><a href="../member/cp">管理面板</a></td>
                    </tr>
                  </table> </td>
              </tr>
            </table>
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#96C8F1">
			<tr>
				<td background="template/default/images/bg_title_sider.gif">访问统计：<?=$addur[viewstats]?></td>
			</tr>
			</table>
          </td>
          <td valign="top"><table width="98%" height="360" border="0" align="right" cellpadding="0" cellspacing="0" bgcolor="#F4F9FD">
              <tr>
                <td valign="top">