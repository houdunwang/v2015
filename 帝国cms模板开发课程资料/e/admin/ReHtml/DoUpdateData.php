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
CheckLevel($logininid,$loginin,$classid,"changedata");
//栏目
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//刷新表
$retable="";
$selecttable="";
$cleartable='';
$i=0;
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable where intb=0 order by tid");
while($tr=$empire->fetch($tsql))
{
	$i++;
	if($i%4==0)
	{
		$br="<br>";
	}
	else
	{
		$br="";
	}
	$retable.="<input type=checkbox name=tbname[] value='$tr[tbname]' checked>$tr[tname]&nbsp;&nbsp;".$br;
	$selecttable.="<option value='".$tr[tbname]."'>".$tr[tname]."</option>";
	$cleartable.="<option value='".$tr[tid]."'>".$tr[tname]."</option>";
}
//专题
$ztclass="";
$ztsql=$empire->query("select ztid,ztname from {$dbtbpre}enewszt order by ztid desc");
while($ztr=$empire->fetch($ztsql))
{
	$ztclass.="<option value='".$ztr['ztid']."'>".$ztr['ztname']."</option>";
}
//选择日期
$todaydate=date("Y-m-d");
$todaytime=time();
$changeday="<select name=selectday onchange=\"document.reform.startday.value=this.value;document.reform.endday.value='".$todaydate."'\">
<option value='".$todaydate."'>--选择--</option>
<option value='".$todaydate."'>今天</option>
<option value='".ToChangeTime($todaytime,7)."'>一周</option>
<option value='".ToChangeTime($todaytime,30)."'>一月</option>
<option value='".ToChangeTime($todaytime,90)."'>三月</option>
<option value='".ToChangeTime($todaytime,180)."'>半年</option>
<option value='".ToChangeTime($todaytime,365)."'>一年</option>
</select>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>数据整理</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script src="../ecmseditor/fieldfile/setday.js"></script>
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="34%" height="25">位置：<a href="DoUpdateData.php<?=$ecms_hashur['whehref']?>">数据整理</a></td>
    <td width="66%"><table width="460" border="0" align="right" cellpadding="0" cellspacing="0">
        <tr> 
          <td> <div align="center">[<a href="#IfTotalPlNum">批量更新信息评论数</a>]</div></td>
          <td> <div align="center">[<a href="#IfOtherInfo">批量更新相关链接</a>]</div></td>
          <td><div align="center">[<a href="#IfClearBreakInfo">清理多余信息</a>]</div></td>
        </tr>
      </table></td>
  </tr>
</table>
<form action="../ecmspl.php" method="get" name="form1" target="_blank" onsubmit="return confirm('确认要更新?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=IfTotalPlNum>
  <?=$ecms_hashur['form']?>
    <input name="from" type="hidden" id="from" value="ReHtml/DoUpdateData.php<?=$ecms_hashur['whehref']?>">
    <tr class="header"> 
      <td height="25"> <div align="center">批量更新信息评论数</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
            <tr> 
              <td height="25">数据表：</td>
              <td height="25"> <select name="tbname" id="tbname">
                  <option value=''>------ 选择数据表 ------</option>
                  <?=$selecttable?>
                </select>
                (*) </td>
            </tr>
            <tr> 
              <td height="25">栏目</td>
              <td height="25"><select name="classid">
                  <option value="0">所有栏目</option>
                  <?=$class?>
                </select>
                <font color="#666666">(如选择父栏目，将更新所有子栏目)</font></td>
            </tr>
            <tr> 
              <td width="23%" height="25"> <input name="retype" type="radio" value="0" checked>
                按时间更新：</td>
              <td width="77%" height="25">从 
                <input name="startday" type="text" size="12" onclick="setday(this)">
                到 
                <input name="endday" type="text" size="12" onclick="setday(this)">
                之间的信息 <font color="#666666">(不填将更新所有信息)</font></td>
            </tr>
            <tr> 
              <td height="25"> <input name="retype" type="radio" value="1">
                按ID更新：</td>
              <td height="25">从 
                <input name="startid" type="text" value="0" size="6">
                到 
                <input name="endid" type="text" value="0" size="6">
                之间的信息 <font color="#666666">(两个值为0将更新所有信息)</font></td>
            </tr>
            <tr>
              <td height="25">指定固定信息ID：</td>
              <td height="25"><input name="doids" type="text" id="doids" size="50">
                <font color="#666666">（多个ID可用半角逗号“,”隔开）</font></td>
            </tr>
            <tr> 
              <td height="25">&nbsp;</td>
              <td height="25"><input type="submit" name="Submit62" value="开始更新"> 
                <input type="reset" name="Submit72" value="重置"> <input name="enews" type="hidden" value="UpdateAllInfoPlnum">              </td>
            </tr>
            <tr> 
              <td height="25" colspan="2"><font color="#666666">说明：当信息表里的评论数与实际评论数不符时使用。</font></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
<form action="../ecmscom.php" method="get" name="form1" target="_blank" onsubmit="return confirm('确认要更新?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=IfOtherInfo>
  <?=$ecms_hashur['form']?>
    <input name="from" type="hidden" id="from" value="ReHtml/DoUpdateData.php<?=$ecms_hashur['whehref']?>">
    <tr class="header"> 
      <td height="25"> <div align="center">批量更新相关链接</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
            <tr> 
              <td height="25">数据表：</td>
              <td height="25"> <select name="tbname" id="tbname">
                  <option value=''>------ 选择数据表 ------</option>
                  <?=$selecttable?>
                </select>
                (*) </td>
            </tr>
            <tr> 
              <td height="25">栏目</td>
              <td height="25"><select name="classid">
                  <option value="0">所有栏目</option>
                  <?=$class?>
                </select>
                <font color="#666666">(如选择父栏目，将更新所有子栏目)</font></td>
            </tr>
            <tr> 
              <td width="23%" height="25"> <input name="retype" type="radio" value="0" checked>
                按时间更新：</td>
              <td width="77%" height="25">从 
                <input name="startday" type="text" size="12" onclick="setday(this)">
                到 
                <input name="endday" type="text" size="12" onclick="setday(this)">
                之间的信息 <font color="#666666">(不填将更新所有信息)</font></td>
            </tr>
            <tr> 
              <td height="25"> <input name="retype" type="radio" value="1">
                按ID更新：</td>
              <td height="25">从 
                <input name="startid" type="text" value="0" size="6">
                到 
                <input name="endid" type="text" value="0" size="6">
                之间的信息 <font color="#666666">(两个值为0将更新所有信息)</font></td>
            </tr>
            <tr> 
              <td height="25">&nbsp;</td>
              <td height="25"><input type="submit" name="Submit62" value="开始更新"> 
                <input type="reset" name="Submit72" value="重置"> <input name="enews" type="hidden" value="ChangeInfoOtherLink"> 
              </td>
            </tr>
            <tr> 
              <td height="25" colspan="2"><font color="#666666">友情提醒：此功能比较耗资源，非必要时请勿用。</font></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
<form action="../ecmscom.php" method="POST" name="form1" onsubmit="return confirm('确认要清理?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="IfClearBreakInfo">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> <div align="center">清理多余信息</div></td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">选择要清理的数据表</td>
      <td width="80%" bgcolor="#FFFFFF"><select name="tid" id="tid">
          <option value=''>------ 选择数据表 ------</option>
          <?=$cleartable?>
        </select>
        *</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><input type="submit" name="Submit6" value="马上清理"> 
        <input name="enews" type="hidden" id="enews2" value="ClearBreakInfo"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25"><font color="#666666">说明: 当生成信息内容页时提示如下错误时使用本功能来清理多余信息：<br>
      生成内容页提示“Table '*.phome_ecms_' doesn't exist......update ***_ecms_ set havehtml=1   where id='' limit 1”时使用。</font></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
</p>
</body>
</html>
<?
db_close();
$empire=null;
?>
