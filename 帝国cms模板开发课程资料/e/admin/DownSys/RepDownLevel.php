<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//验证权限
CheckLevel($logininid,$loginin,$classid,"repdownpath");
$url="<a href=RepDownLevel.php".$ecms_hashur['whehref'].">批量更改地址权限</a>";
//栏目
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//数据表
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable order by tid");
while($tr=$empire->fetch($tsql))
{
	$table.="<option value='".$tr[tbname]."'>".$tr[tname]."</option>";
}
$table="<select name='tbname'><option value='0'>--- 选择数据表 ---</option>".$table."</select>";
//----------会员组
$sql1=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	$ygroup.="<option value=".$l_r[groupid].">".$l_r[groupname]."</option>";
}
//----------地址前缀
$qz="";
$downsql=$empire->query("select urlname,urlid from {$dbtbpre}enewsdownurlqz order by urlid");
while($downr=$empire->fetch($downsql))
{
	$qz.="<option value='".$downr[urlid]."'>".$downr[urlname]."</option>";
}

db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>批量更改地址权限</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="../ecmscom.php" target="_blank" onsubmit="return confirm('确认要操作？');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> <div align="center">批量更改下载/在线地址权限 
          <input name="enews" type="hidden" id="enews" value="RepDownLevel">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="21%" height="25">操作数据表(*)：</td>
      <td width="79%" height="25"> 
        <?=$table?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">操作栏目：</td>
      <td height="25"><select name="classid" id="classid">
          <option value=0>所有栏目</option>
          <?=$class?>
        </select>
        <font color="#666666"> (如选择大栏目，将应用于所有子栏目)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">操作字段(*)：</td>
      <td height="25"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td width="32%"><input name="downpath" type="checkbox" id="downpath" value="1">
              下载地址(downpath)</td>
            <td width="68%"><input name="onlinepath" type="checkbox" id="onlinepath" value="1">
              在线地址(onlinepath)</td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">权限转换： 
        <input name="dogroup" type="checkbox" id="dogroup" value="1"></td>
      <td height="25"><div align="left"> 
          <table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
            <tr> 
              <td width="49%"><div align="center">原会员组</div></td>
              <td width="51%"><div align="center">新会员组</div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td><div align="center"> 
                  <select name="oldgroupid" id="oldgroupid">
                    <option value="no">不设置</option>
                    <option value="0">游客</option>
					<?=$ygroup?>
                  </select>
                </div></td>
              <td><div align="center"> 
                  <select name="newgroupid" id="newgroupid">
                    <option value="0">游客</option>
					<?=$ygroup?>
                  </select>
                </div></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">点数转换： 
        <input name="dofen" type="checkbox" id="dofen" value="1"></td>
      <td height="25"><table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="49%"><div align="center">原点数</div></td>
            <td width="51%"><div align="center">新点数</div></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><div align="center"> 
                <input name="oldfen" type="text" id="oldfen" value="no" size="6">
              </div></td>
            <td><div align="center"> 
                <input name="newfen" type="text" id="newfen" value="0" size="6">
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">前缀转换： 
        <input name="doqz" type="checkbox" id="doqz" value="1"></td>
      <td height="25"><table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="49%"><div align="center">原前缀</div></td>
            <td width="51%"><div align="center">新前缀</div></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><div align="center"> 
                <select name="oldqz" id="oldqz">
                  <option value="no">不设置</option>
				  <option value="0">空前缀</option>
                  <?=$qz?>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="newqz">
				<option value="0">空前缀</option>
                  <?=$qz?>
                </select>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">地址替换：
        <input name="dopath" type="checkbox" id="dopath" value="1"></td>
      <td height="25"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="49%"><div align="center">原下载地址字符</div></td>
            <td width="51%"><div align="center">新下载地址字符</div></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><div align="center"> 
                <input name="oldpath" type="text" id="oldpath">
              </div></td>
            <td><div align="center"> 
                <input name="newpath" type="text" id="newpath">
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">名称替换：
        <input name="doname" type="checkbox" id="doname" value="1"></td>
      <td height="25"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr> 
            <td width="49%"><div align="center">原下载名称字符</div></td>
            <td width="51%"><div align="center">新下载名称字符</div></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><div align="center"> 
                <input name="oldname" type="text" id="oldname">
              </div></td>
            <td><div align="center"> 
                <input name="newname" type="text" id="newname">
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">附加SQL条件：</td>
      <td height="25"><input name="query" type="text" id="query" size="75"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><font color="#666666">如：title='标题' and writer='作者'</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25">说明：如原点数为no，则所有信息的点数都为新点数，如果选项为不设置，则所有信息都为新的值。<br>
        注意：<font color="#FF0000">使用此功能，最好备份一下数据，以防万一</font></td>
    </tr>
  </table>
</form>
</body>
</html>
