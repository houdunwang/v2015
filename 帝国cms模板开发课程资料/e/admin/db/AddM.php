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
CheckLevel($logininid,$loginin,$classid,"m");
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(!$tid||!$tbname)
{
	printerror("ErrorUrl","history.go(-1)");
}
$enews=RepPostStr($_GET['enews'],1);
$docopy=(int)$_GET['docopy'];
$mtype=" checked";
$r['mustqenterf']=",title,";
$r[myorder]=0;
$record="<!--record-->";
$field="<!--field--->";
$postword='增加';
$url="数据表:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListM.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">系统模型管理</a>&nbsp;>&nbsp;增加系统模型";
if($enews=="AddM"&&$docopy)
{
	$postword='复制';
	$mid=(int)$_GET['mid'];
	$mtype="";
	$r=$empire->fetch1("select * from {$dbtbpre}enewsmod where mid='$mid' and tid='$tid'");
	$url="数据表:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListM.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">系统模型管理</a>&nbsp;>&nbsp;复制系统模型: ".$r['mname'];
}
//修改系统模型
if($enews=="EditM")
{
	$postword='修改';
	$mid=(int)$_GET['mid'];
	$mtype="";
	$url="数据表:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListM.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">系统模型管理</a>&nbsp;>&nbsp;修改系统模型";
	$r=$empire->fetch1("select * from {$dbtbpre}enewsmod where mid='$mid' and tid='$tid'");
}
//取得字段
$no=0;
$fsql=$empire->query("select f,fname,iscj,dotemp,tbdataf from {$dbtbpre}enewsf where isshow=1 and tid='$tid' order by myorder,fid");
while($fr=$empire->fetch($fsql))
{
	$no++;
	$bgcolor="ffffff";
	if($no%2==0)
	{
		$bgcolor="#F8F8F8";
	}
	$like=$field.$fr[f].$record;
	$slike=",".$fr[f].",";
	//录入项
	if(strstr($r[enter],$like))
	{
		$enterchecked=" checked";
		//取得字段标识
		$dor=explode($like,$r[enter]);
		if(strstr($dor[0],$record))
		{
			$dor1=explode($record,$dor[0]);
			$last=count($dor1)-1;
			$fr[fname]=$dor1[$last];
		}
		else
		{
			$fr[fname]=$dor[0];
		}
	}
	else
	{
		$enterchecked="";
	}
	//标题
	if($enews=="AddM"&&($fr[f]=="title"||$fr[f]=="special.field"))
	{
		$enterchecked=" checked";
	}
	$entercheckbox="<input name=center[] type=checkbox class='docheckbox' value='".$fr[f]."'".$enterchecked.">";
	//投稿项
	if(strstr($r[qenter],$like))
	{
		$qenterchecked=" checked";
	}
	else
	{
		$qenterchecked="";
	}
	$qentercheckbox="<input name=cqenter[] type=checkbox class='docheckbox' value='".$fr[f]."'".$qenterchecked.">";
	$listtempfcheckbox="";
	$pagetempfcheckbox="";
	if($fr['dotemp'])
	{
		//列表模板项
		if(empty($fr['tbdataf']))//主表
		{
			if(strstr($r[listtempvar],$like))
			{
				$listtempfchecked=" checked";
			}
			else
			{
				$listtempfchecked="";
			}
			$listtempfcheckbox="<input name=ltempf[] type=checkbox class='docheckbox' value='".$fr[f]."'".$listtempfchecked.">";
		}
		//内容模板项
		if(strstr($r[tempvar],$like))
		{
			$pagetempfchecked=" checked";
		}
		else
		{
			$pagetempfchecked="";
		}
		$pagetempfcheckbox="<input name=ptempf[] type=checkbox class='docheckbox' value='".$fr[f]."'".$pagetempfchecked.">";
	}
	//采集项
	$cjcheckbox="";
	if($fr[iscj])
	{
		if(strstr($r[cj],$like))
		{$cjchecked=" checked";}
		else
		{$cjchecked="";}
		//标题
		if($enews=="AddM"&&$fr[f]=="title")
		{
			$cjchecked=" checked";
		}
		$cjcheckbox="<input name=cchange[] type=checkbox class='docheckbox' value='".$fr[f]."'".$cjchecked.">";
	}
	//搜索项
	$searchcheckbox="";
	if($fr[f]!="special.field"&&empty($fr['tbdataf'])&&empty($fr['tbdataf']))
	{
		if(strstr($r[searchvar],$slike))
		{$searchchecked=" checked";}
		else
		{$searchchecked="";}
		$searchcheckbox="<input name=schange[] type=checkbox class='docheckbox' value='".$fr[f]."'".$searchchecked.">";
	}
	//必填项
	$mustfcheckbox="";
	if($fr[f]!="special.field")
	{
		$mustfchecked="";
		if(strstr($r[mustqenterf],$slike))
		{$mustfchecked=" checked";}
		if($enews=="AddM"&&$fr[f]=="title")
		{
			$mustfchecked=" checked";
		}
		$mustfcheckbox="<input name=menter[] type=checkbox class='docheckbox' value='".$fr[f]."'".$mustfchecked.">";
	}
	//结合项
	$listandfcheckbox="";
	if($fr[f]!="special.field"&&empty($fr['tbdataf']))
	{
		$listandfchecked="";
		if(strstr($r[listandf],$slike))
		{$listandfchecked=" checked";}
		$listandfcheckbox="<input name=listand[] type=checkbox class='docheckbox' value='".$fr[f]."'".$listandfchecked.">";
	}
	//排序项
	$orderfcheckbox="";
	if($fr[f]!="special.field"&&empty($fr['tbdataf']))
	{
		$orderfchecked="";
		if(strstr($r[orderf],$slike))
		{$orderfchecked=" checked";}
		$orderfcheckbox="<input name=listorder[] type=checkbox class='docheckbox' value='".$fr[f]."'".$orderfchecked.">";
	}
	//可增加
	$canaddfcheckbox="";
	if($fr[f]!="special.field")
	{
		$canaddfchecked="";
		if(strstr($r[canaddf],$slike))
		{$canaddfchecked=" checked";}
		if($enews=="AddM"&&!$docopy)
		{
			$canaddfchecked=" checked";
		}
		$canaddfcheckbox="<input name=canadd[] type=checkbox class='docheckbox' value='".$fr[f]."'".$canaddfchecked.">";
	}
	//可修改
	$caneditfcheckbox="";
	if($fr[f]!="special.field")
	{
		$caneditfchecked="";
		if(strstr($r[caneditf],$slike))
		{$caneditfchecked=" checked";}
		if($enews=="AddM"&&!$docopy)
		{
			$caneditfchecked=" checked";
		}
		$caneditfcheckbox="<input name=canedit[] type=checkbox class='docheckbox' value='".$fr[f]."'".$caneditfchecked.">";
	}
	$data.="<tr bgcolor='".$bgcolor."'> 
            <td height=32> <div align=center> 
                <input name=cname[".$fr[f]."] type=text value='".$fr[fname]."'>
              </div></td>
            <td> <div align=center> 
                <input name=cfield type=text value='".$fr[f]."' readonly>
              </div></td>
			<td><div align=center> 
                ".$entercheckbox."
              </div></td>
			<td><div align=center> 
                ".$qentercheckbox."
              </div></td>
			<td><div align=center> 
                ".$mustfcheckbox."
              </div></td>
			<td><div align=center> 
                ".$canaddfcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$caneditfcheckbox."
              </div></td>
            <td> <div align=center> 
                ".$cjcheckbox."
              </div></td>
            <td><div align=center> 
                ".$listtempfcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$pagetempfcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$searchcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$orderfcheckbox."
              </div></td>
			  <td><div align=center> 
                ".$listandfcheckbox."
              </div></td>
          </tr>";
}
//预设投票
$infovotesql=$empire->query("select voteid,ysvotename from {$dbtbpre}enewsvotemod order by voteid");
while($infovoter=$empire->fetch($infovotesql))
{
	$select="";
	if($r[definfovoteid]==$infovoter[voteid])
	{
		$select=" selected";
	}
	$definfovote.="<option value='".$infovoter[voteid]."'".$select.">".$infovoter[ysvotename]."</option>";
}
//打印模板
$printtemp_options='';
$ptsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsprinttemp")." order by tempid");
while($ptr=$empire->fetch($ptsql))
{
	$select="";
	if($ptr[tempid]==$r[printtempid])
	{
		$select=" selected";
	}
	$printtemp_options.="<option value=".$ptr[tempid].$select.">".$ptr[tempname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加系统模型</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function DoCheckAll(form,chf)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
	if(e.name==chf)
		{
		e.checked=true;
	    }
	}
  }
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsmod.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr> 
      <td height="25" colspan="2" class="header">增加系统模型 
        <input name="add[mid]" type="hidden" id="add[mid]" value="<?=$mid?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="add[tbname]" type="hidden" id="add[tbname]" value="<?=$tbname?>"> 
        <input name="add[tid]" type="hidden" id="add[tid]" value="<?=$tid?>"> 
		<?=$ecms_hashur['form']?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25">模型名称</td>
      <td width="77%" height="25"><input name="add[mname]" type="text" id="add[mname]" value="<?=$r[mname]?>" size="43"> 
        <font color="#666666">(比如：&quot;新闻系统模型&quot;)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">模型别名</td>
      <td height="25"><input name="add[qmname]" type="text" id="add[qmname]" value="<?=$r[qmname]?>" size="43"> 
        <font color="#666666">(比如：&quot;新闻&quot;，用于前台显示)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">是否启用</td>
      <td height="25"><input type="radio" name="add[usemod]" value="0"<?=$r[usemod]==0?' checked':''?>>
        开启 
        <input type="radio" name="add[usemod]" value="1"<?=$r[usemod]==1?' checked':''?>>
        不使用</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">显示到前台导航</td>
      <td height="25"><input type="radio" name="add[showmod]" value="0"<?=$r[showmod]==0?' checked':''?>>
        显示 
        <input type="radio" name="add[showmod]" value="1"<?=$r[showmod]==1?' checked':''?>>
        不显示</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">显示顺序</td>
      <td height="25"><input name="add[myorder]" type="text" id="add[myorder]" value="<?=$r[myorder]?>" size="43"> 
        <font color="#666666">(值越小显示越前面)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2" valign="top">选择本模型的字段项</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2" valign="top"> <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DBEAF5">
          <tr> 
            <td width="15%" height="25"> <div align="center">字段标识</div></td>
            <td width="17%" height="25"> <div align="center">字段名</div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'center[]');">录入项</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'cqenter[]');">投稿项</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'menter[]');">必填项</a></div></td>
            <td width="6%"><div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'canadd[]');">可增加</a></div></td>
            <td width="6%"><div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'canedit[]');">可修改</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'cchange[]');">采集项</a></div></td>
            <td width="7%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'ltempf[]');">列表模板</a></div></td>
            <td width="7%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'ptempf[]');">内容模板</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'schange[]');">搜索项</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'listorder[]');">排序项</a></div></td>
            <td width="6%"> <div align="center"><a href="#empirecms" title="全选" onclick="DoCheckAll(document.form1,'listand[]');">结合项</a></div></td>
          </tr>
          <?=$data?>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2" valign="top"><p>栏目列表页结合项设置： 
          <input type="radio" name="add[setandf]" value="0"<?=$r[setandf]==0?' checked':''?>>
          完全匹配 
          <input type="radio" name="add[setandf]" value="1"<?=$r[setandf]==1?' checked':''?>>
          模糊匹配</p></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">录入表单模板<br>
        (<font color="#FF0000"> 
        <input name="add[mtype]" type="checkbox" id="add[mtype]" value="1"<?=$mtype?>>
        自动生成表单模板</font>)</td>
      <td height="25"><textarea name="add[mtemp]" cols="75" rows="20" id="add[mtemp]" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[mtemp]))?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">前台投稿表单模板<br>
        (<font color="#FF0000"> 
        <input name="add[qmtype]" type="checkbox" id="add[qmtype]" value="1"<?=$mtype?>>
        自动生成表单模板</font>) </td>
      <td height="25"><textarea name="add[qmtemp]" cols="75" rows="20" id="textarea2" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[qmtemp]))?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="2" valign="top">信息列表名称</td>
      <td height="25"><input name="add[listfile]" type="text" id="add[listfile]" value="<?=$r[listfile]?>" size="43"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><font color="#666666">(不设置为使用默认列表，增加列表可在e/data/html/list里增加文件，<a href="../../data/html/list/ReadMe.txt" target="_blank">点击这里</a>查看说明)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">信息预设投票</td>
      <td height="25"><select name="add[definfovoteid]" id="add[definfovoteid]">
          <option value="0">不设置</option>
          <?=$definfovote?>
        </select> <input type="button" name="Submit622" value="管理预设投票" onclick="window.open('../other/ListVoteMod.php<?=$ecms_hashur['whehref']?>');"> 
        <font color="#666666">(增加信息时默认的投票项)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">打印模板</td>
      <td height="25"><select name="add[printtempid]" id="add[printtempid]">
	  		<option value="0">使用默认</option>
          <?=$printtemp_options?>
        </select> 
        <input type="button" name="Submit6222" value="管理打印模板" onclick="window.open('../template/ListPrinttemp.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">注释</td>
      <td height="25"><textarea name="add[mzs]" cols="75" rows="10" id="textarea" style="WIDTH: 100%"><?=stripSlashes($r[mzs])?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
