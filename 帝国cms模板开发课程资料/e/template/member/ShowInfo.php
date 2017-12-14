<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
//oicq
if($addr['oicq'])
{
	$addr['oicq']="<a href='http://wpa.qq.com/msgrd?V=1&amp;Uin=".$addr['oicq']."&amp;Site=".$public_r['sitename']."&amp;Menu=yes' target='_blank'><img src='http://wpa.qq.com/pa?p=1:".$addr['oicq'].":4'  border='0' alt='QQ' />".$addr['oicq']."</a>";
}
//表单
$record="<!--record-->";
$field="<!--field--->";
$er=explode($record,$formr['viewenter']);
$count=count($er);
$memberinfo='';
for($i=0;$i<$count-1;$i++)
{
	$er1=explode($field,$er[$i]);
	if(strstr($formr['filef'],",".$er1[1].","))//附件
	{
		if($addr[$er1[1]])
		{
			$val="<a href='".$addr[$er1[1]]."' target='_blank'>".$addr[$er1[1]]."</a>";
		}
		else
		{
			$val="";
		}
	}
	elseif(strstr($formr['imgf'],",".$er1[1].","))//图片
	{
		if($addr[$er1[1]])
		{
			$val="<img src='".$addr[$er1[1]]."' border=0>";
		}
		else
		{
			$val="";
		}
	}
	elseif(strstr($formr['tobrf'],",".$er1[1].","))//多行文本框
	{
		$val=nl2br($addr[$er1[1]]);
	}
	else
	{
		$val=$addr[$er1[1]];
	}
	$memberinfo.="<tr bgcolor='#FFFFFF'><td height=25>".$er1[0].":</td><td>".$val."</td></tr>";
}

$public_diyr['pagetitle']='查看 '.$username.' 的会员资料';
$url="<a href='../../../'>首页</a>&nbsp;>&nbsp;<a href='../cp/'>会员中心</a>&nbsp;>&nbsp;查看会员资料";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<table width='100%' border='0' align='center' cellpadding='3' cellspacing='1' class="tableborder">
  <tr class="header"> 
    <td height="25" colspan="2">查看 <?=$username?> 的会员资料</td>
  </tr>
  <tr>
    <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
        <tr>
          <td> [ <a href="../msg/AddMsg/?username=<?=$username?>" target="_blank">发短消息</a> 
            ] [ <a href="../friend/add/?fname=<?=$username?>" target="_blank">加为好友</a> 
            ] [ <a href="../../space/?userid=<?=$r[userid]?>" target="_blank">会员空间</a> ] </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td width='17%' height="25" bgcolor="#FFFFFF"> <div align='left'>用户名 </div></td>
    <td width='83%' height="25" bgcolor="#FFFFFF"> 
      <?=$username?>
    </td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FFFFFF">会员等级</td>
    <td height="25" bgcolor="#FFFFFF">
      <?=$level_r[$r[groupid]]['groupname']?>
    </td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FFFFFF">注册时间</td>
    <td height="25" bgcolor="#FFFFFF"> 
      <?=$registertime?>
    </td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FFFFFF"> <div align='left'>邮箱</div></td>
    <td height="25" bgcolor="#FFFFFF"> <a href="mailto:<?=$email?>"> 
      <?=$email?>
      </a></td>
  </tr>
  <?=$memberinfo?>
  <tr> 
    <td>&nbsp;</td>
    <td height="25"> <input type='button' name='Submit2' value='返回' onclick='history.go(-1)'></td>
  </tr>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>