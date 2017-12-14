<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
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
CheckLevel($logininid,$loginin,$classid,"dbdata");
$bakpath=$public_r['bakdbpath'];
$mydbname=RepPostVar($_GET['mydbname']);
if(empty($mydbname))
{
	printerror("NotChangeBakTable","history.go(-1)");
}
//选择数据库
$udb=$empire->usequery("use `".$mydbname."`");
//查询
$and="";
$keyboard=RepPostVar($_GET['keyboard']);
$sear=RepPostStr($_GET['sear'],1);
if(empty($sear))
{
	$keyboard=$dbtbpre;
}
if($keyboard)
{
	$and=" LIKE '%$keyboard%'";
}
$sql=$empire->query("SHOW TABLE STATUS".$and);
//存放目录
$mypath=$mydbname."_".date("YmdHis");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择数据表</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
		{
		continue;
	    }
	if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
function reverseCheckAll(form)
{
  for (var i=0;i<form.elements.length;i++)
  {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
	{
		continue;
	}
	if (e.name != 'chkall')
	{
	   if(e.checked==true)
	   {
       		e.checked = false;
	   }
	   else
	   {
	  		e.checked = true;
	   }
	}
  }
}
function SelectCheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
		{
		continue;
	    }
	if (e.name != 'chkall')
	  	e.checked = true;
    }
  }
function check()
{
	var ok;
	ok=confirm("确认要执行此操作?");
	return ok;
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="searchtb" method="GET" action="ChangeTable.php">
<?=$ecms_hashur['eform']?>
<input name="sear" type="hidden" id="sear" value="1">
<input name="mydbname" type="hidden" value="<?=$mydbname?>">
  <tr> 
    <td width="58%">位置：备份数据 -&gt; <a href="ChangeDb.php<?=$ecms_hashur['whehref']?>">选择数据库</a> -&gt; <a href="ChangeTable.php?mydbname=<?=$mydbname?><?=$ecms_hashur['ehref']?>">选择备份表</a>&nbsp;(<?=$mydbname?>)</td>
      <td width="42%"><div align="center">查询: 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <input type="submit" name="Submit3" value="显示数据表">
        </div></td>
  </tr>
  <tr> 
    <td height="25" colspan="2"><div align="center">
          备份步骤：选择数据库 -&gt; <font color="#FF0000">选择要备份的表</font> -&gt; 开始备份 -&gt; 
          完成</div></td>
  </tr>
</form>
</table>
<form action="phome.php" method="post" name="ebakchangetb" target="_blank" onsubmit="return check();">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25">备份参数设置： 
        <input name="phome" type="hidden" id="phome2" value="DoEbak"> 
        <input name="mydbname" type="hidden" id="mydbname" value="<?=$mydbname?>">
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="23%"><input type="radio" name="baktype" value="0"<?=$dbaktype==0?' checked':''?>> 
              <strong>按文件大小备份</strong> </td>
            <td width="77%" height="23"> 每组备份大小： 
              <input name="filesize" type="text" id="filesize" value="300" size="6">
              KB <font color="#666666">(1 MB = 1024 KB)</font></td>
          </tr>
          <tr> 
            <td><input type="radio" name="baktype" value="1"<?=$dbaktype==1?' checked':''?>> 
              <strong>按记录数备份</strong></td>
            <td height="23">每组备份 
              <input name="bakline" type="text" id="bakline" value="500" size="6">
              条记录， 
              <input name="autoauf" type="checkbox" id="autoauf" value="1" checked>
              自动识别自增字段<font color="#666666">(此方式效率更高)</font></td>
          </tr>
          <tr> 
            <td>备份数据库结构</td>
            <td height="23"><input name="bakstru" type="checkbox" id="bakstru" value="1" checked> 
              <font color="#666666">(没特殊情况，请选择)</font></td>
          </tr>
          <tr> 
            <td valign="top">数据编码</td>
            <td height="23"> <select name="dbchar" id="dbchar">
                <option value="auto"<?=$ddbchar=='auto'?' selected':''?>>自动识别编码</option>
                <option value=""<?=$ecms_config['db']['setchar']==''?' selected':''?>>不设置</option>
                <option value="gbk"<?=$ecms_config['db']['setchar']=='gbk'?' selected':''?>>gbk</option>
                <option value="utf8"<?=$ecms_config['db']['setchar']=='utf8'?' selected':''?>>utf8</option>
                <option value="gb2312"<?=$ecms_config['db']['setchar']=='gb2312'?' selected':''?>>gb2312</option>
                <option value="big5"<?=$ecms_config['db']['setchar']=='big5'?' selected':''?>>big5</option>
                <option value="latin1"<?=$ecms_config['db']['setchar']=='latin1'?' selected':''?>>latin1</option>
              </select> <font color="#666666">(从mysql4.0导入mysql4.1以上版本需要选择固定编码，不能选自动)</font></td>
          </tr>
          <tr>
            <td valign="top">数据存放格式</td>
            <td height="23"><input name="bakdatatype" type="radio" value="0" checked>
              正常 
              <input type="radio" name="bakdatatype" value="1">
              十六进制方式<font color="#666666">(十六进制备份文件会占用更多的空间)</font></td>
          </tr>
          <tr> 
            <td>存放目录</td>
            <td height="23">admin/ebak/ 
              <?=$bakpath?>
              / 
              <input name="mypath" type="text" id="mypath" value="<?=$mypath?>"> 
              <input type="button" name="Submit2" value="选择目录" onclick="javascript:window.open('ChangePath.php?change=1&toform=ebakchangetb<?=$ecms_hashur['ehref']?>','','width=600,height=500,scrollbars=yes');"> 
              <font color="#666666">(目录不存在，系统会自动建立)</font></td>
          </tr>
          <tr> 
            <td valign="top">备份选项</td>
            <td height="23">导入方式: 
              <select name="insertf" id="insertf">
                <option value="replace">REPLACE</option>
                <option value="insert">INSERT</option>
              </select>
              , 
              <input name="beover" type="checkbox" id="beover" value="1"<?=$dbeover==1?' checked':''?>>
              完整插入, 
              <input name="bakstrufour" type="checkbox" id="bakstrufour" value="1"> 
              <a title="需要转换数据表编码时选择">转成MYSQL4.0格式</a>, 每组备份间隔： 
              <input name="waitbaktime" type="text" id="waitbaktime" value="0" size="2">
              秒</td>
          </tr>
          <tr> 
            <td valign="top">备份说明<br> <font color="#666666">(系统会生成一个readme.txt)</font></td>
            <td height="23"><textarea name="readme" cols="80" rows="8" id="readme"></textarea></td>
          </tr>
          <tr> 
            <td valign="top">去除自增值的字段列表：<br> <font color="#666666">(格式：<strong>表名.字段名</strong><br>
              多个请用&quot;,&quot;格开)</font></td>
            <td height="23"><textarea name="autofield" cols="80" rows="5" id="autofield"></textarea></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="header"> 
      <td height="25">选择要备份的表：( <a href="#ebak" onclick="SelectCheckAll(document.ebakchangetb)"><u>全选</u></a> 
        | <a href="#ebak" onclick="reverseCheckAll(document.ebakchangetb);"><u>反选</u></a> 
        )</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr bgcolor="#DBEAF5"> 
            <td width="5%" height="23"> <div align="center">选择</div></td>
            <td width="27%" height="23" bgcolor="#DBEAF5"> <div align="center">表名(点击查看字段)</div></td>
            <td width="13%" height="23" bgcolor="#DBEAF5"> <div align="center">类型</div></td>
            <td width="15%" bgcolor="#DBEAF5"><div align="center">编码</div></td>
            <td width="15%" height="23"> <div align="center">记录数</div></td>
            <td width="14%" height="23"> <div align="center">大小</div></td>
            <td width="11%" height="23"> <div align="center">碎片</div></td>
          </tr>
          <?
		  $totaldatasize=0;//总数据大小
		  $tablenum=0;//总表数
		  $datasize=0;//数据大小
		  $rownum=0;//总记录数
		  while($r=$empire->fetch($sql))
		  {
		  $rownum+=$r[Rows];
		  $tablenum++;
		  $datasize=$r[Data_length]+$r[Index_length];
		  $totaldatasize+=$r[Data_length]+$r[Index_length]+$r[Data_free];
		  $collation=$r[Collation]?$r[Collation]:'---';
		  ?>
          <tr id=tb<?=$r[Name]?>> 
            <td height="23"> <div align="center"> 
                <input name="tablename[]" type="checkbox" id="tablename[]" value="<?=$r[Name]?>" onclick="if(this.checked){tb<?=$r[Name]?>.style.backgroundColor='#F1F7FC';}else{tb<?=$r[Name]?>.style.backgroundColor='#ffffff';}" checked>
              </div></td>
            <td height="23"> <a href="#ebak" onclick="window.open('ListField.php?mydbname=<?=$mydbname?>&mytbname=<?=$r[Name]?><?=$ecms_hashur['ehref']?>','','width=660,height=500,scrollbars=yes');" title="点击查看表字段列表"> 
              <?=$r[Name]?>
              </a></td>
            <td height="23"> <div align="center">
                <?=$r[Type]?$r[Type]:$r[Engine]?>
              </div></td>
            <td><div align="center">
				<?=$collation?>
			</div></td>
            <td height="23"> <div align="right">
                <?=$r[Rows]?>
              </div></td>
            <td height="23"> <div align="right">
                <?=Ebak_ChangeSize($datasize)?>
              </div></td>
            <td height="23"> <div align="right">
                <?=Ebak_ChangeSize($r[Data_free])?>
              </div></td>
          </tr>
          <?
		  }
		  db_close();
		  $empire=null;
		  ?>
          <tr bgcolor="#DBEAF5"> 
            <td height="23"> <div align="center">
                <input type=checkbox name=chkall value=on onclick=CheckAll(this.form) checked>
              </div></td>
            <td height="23"> <div align="center"> 
                <?=$tablenum?>
              </div></td>
            <td height="23"> <div align="center">---</div></td>
            <td><div align="center">---</div></td>
            <td height="23"> <div align="center">
                <?=$rownum?>
              </div></td>
            <td height="23" colspan="2"> <div align="center">
                <?=Ebak_ChangeSize($totaldatasize)?>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr class="header"> 
      <td height="25">
<div align="center">
          <input type="submit" name="Submit" value="开始备份" onclick="document.ebakchangetb.phome.value='DoEbak';">
          &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit2" value="修复数据表" onclick="document.ebakchangetb.phome.value='DoRep';">
          &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="优化数据表" onclick="document.ebakchangetb.phome.value='DoOpi';">
        &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="删除数据表" onclick="document.ebakchangetb.phome.value='DoDrop';">
		&nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="清空数据表" onclick="document.ebakchangetb.phome.value='EmptyTable';">
		</div></td>
    </tr>
  </table>
</form>
</body>
</html>
