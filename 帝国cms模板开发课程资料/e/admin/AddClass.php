<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
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
CheckLevel($logininid,$loginin,$classid,"class");
$enews=ehtmlspecialchars($_GET['enews']);
if($_GET['from'])
{
	$listclasslink="ListPageClass.php";
}
else
{
	$listclasslink="ListClass.php";
}
$url="<a href=".$listclasslink.$ecms_hashur['whehref'].">栏目管理</a>&nbsp;>&nbsp;增加栏目";
$zt="";
$b_ok=1;
$hiddenclass="<script>document.getElementById('smallclass').style.display='none';document.getElementById('smallclasssetinfo').style.display='none';document.getElementById('smallclasssettemp').style.display='none';document.getElementById('smallcgtoinfo').style.display='none';document.getElementById('smallclassbdinfo').style.display='none';</script>";
//初使化数据
$r[myorder]=0;
$r[listorder]="id DESC";
$r[reorder]="newstime DESC";
$islast="";
$filename0=" checked";
$filename1="";
$filename2="";
$openpl0=" checked";
$openpl1="";
$openadd0="";
$openadd1=" checked";
$r[classtype]=".html";
$r[filetype]=".html";
$r[newspath]="Y-m-d";
$r[link_num]="10";
$r[lencord]=25;
$read="";
$r[newline]=10;
$r[hotline]=10;
$r[goodline]=10;
$r[hotplline]=10;
$r[firstline]=10;
$r[maxnum]=0;
$r[addinfofen]=0;
$r[doctime]=0;
$r[down_num]=2;
$r[online_num]=2;
$checked=" checked";
$r['addreinfo']=1;
$defaultbclassid=" selected";
$islist="";
$islast="<input name=islast type=checkbox id=islast onclick='small_class(this.checked)' value='1'>是";
//复制栏目
$docopy=ehtmlspecialchars($_GET['docopy']);
if($docopy&&$enews=="AddClass")
{
	$copyclass=1;
}
$ecmsfirstpost=1;
$classid=(int)$_GET['classid'];
if($enews=='EditClass')
{
	$filepass=$classid;
}
else
{
	$filepass=ReturnTranFilepass();
}
//修改栏目
if($enews=="EditClass"||$copyclass)
{
	$ecmsfirstpost=0;
	if($copyclass)
	{
		$thisdo="复制";
	}
	else
	{
		$thisdo="修改";
	}
	$read="";
	$r=$empire->fetch1("select * from {$dbtbpre}enewsclass where classid='$classid'");
	$addr=$empire->fetch1("select * from {$dbtbpre}enewsclassadd where classid='$classid'");
	if(!empty($r[bclassid]))
	{$defaultbclassid="";}
	$url="<a href=".$listclasslink.$ecms_hashur['whehref'].">管理栏目</a>&nbsp;>&nbsp;".$thisdo."栏目：".$r[classname];
	if($r[islist])
	{$islist=" checked";}
	//修改大栏目
	if(!$r[islast])
	{
		//主栏目
		if(empty($r[bclassid]))
		{
			$b_ok=1;
		}
		//中级栏目
		else
		{
			$b_ok=1;
		}
	}
	//终级栏目
	else
	{
		$hiddenclass="<script>document.getElementById('bigclasssettemp').style.display='none';document.getElementById('bigclasssetclasstext').style.display='none';</script>";
		$b_ok=0;
	}
	//终级类别
	if($r[islast])
	{
		$islast="<b>是</b>";
		$islastcheck=" checked";
	}
	else
	{
		$islast="<b>否</b>";
		$islastcheck="";
	}
	$islast.="<input type=hidden name=islast value='".$r[islast]."'>";
	if($r[filename]==1)
	{
		$filename0="";
		$filename1=" checked";
		$filename2="";
	}
	elseif($r[filename]==2)
	{
		$filename0="";
		$filename1="";
		$filename2=" checked";
	}
	else
	{}
	if($r[openpl])
	{
		$openpl0="";
		$openpl1=" checked";
	}
	if($r[checkpl])
	{
		$checkpl=" checked";
	}
	if($r[openadd])
	{
		$openadd0="";
		$openadd1=" checked";
	}
	else
	{
		$openadd0=" checked";
		$openadd1="";
	}
	//栏目目录
	$mycr=GetPathname($r[classpath]);
	$pripath=$mycr[1];
	$classpath=$mycr[0];
	$read="";
	//复制栏目
	if($copyclass)
	{
		$r[classname].="(1)";
		$classpath.="1";
		$read="";
		$islast="<input name=islast type=checkbox id=islast onclick='small_class(this.checked)' value='1'".$islastcheck.">是";
    }
	if($r[checked])
	{$checked=" checked";}
	else
	{$checked="";}
}
//系统模型
$m_sql=$empire->query("select mid,mname,usemod from {$dbtbpre}enewsmod order by myorder,mid");
while($m_r=$empire->fetch($m_sql))
{
	if(empty($m_r[usemod]))
	{
		if($m_r[mid]==$r[modid])
		{$m_d=" selected";}
		else
		{$m_d="";}
		$mod_options.="<option value=".$m_r[mid].$m_d.">".$m_r[mname]."</option>";
	}
	//列表模板
	$listtemp_options.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$dtlisttemp_options.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$lt_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewslisttemp")." where modid='$m_r[mid]'");
	while($lt_r=$empire->fetch($lt_sql))
	{
		//静态
		if($lt_r[tempid]==$r[listtempid])
		{$lt_d=" selected";}
		else
		{$lt_d="";}
		$listtemp_options.="<option value=".$lt_r[tempid].$lt_d."> |-".$lt_r[tempname]."</option>";
		//动态
		if($lt_r[tempid]==$r[dtlisttempid])
		{$lt_dt=" selected";}
		else
		{$lt_dt="";}
		$dtlisttemp_options.="<option value=".$lt_r[tempid].$lt_dt."> |-".$lt_r[tempname]."</option>";
	}
	//搜索模板
	$searchtemp.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$st_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewssearchtemp")." where modid='$m_r[mid]'");
	while($st_r=$empire->fetch($st_sql))
	{
		if($st_r[tempid]==$r[searchtempid])
		{$st_d=" selected";}
		else
		{$st_d="";}
		$searchtemp.="<option value=".$st_r[tempid].$st_d."> |-".$st_r[tempname]."</option>";
	}
	//内容模板
	$newstemp_options.="<option value=0 style='background:#99C4E3'>".$m_r[mname]."</option>";
	$nt_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewsnewstemp")." where modid='$m_r[mid]'");
	while($nt_r=$empire->fetch($nt_sql))
	{
		if($nt_r[tempid]==$r[newstempid])
		{$nt_d=" selected";}
		else
		{$nt_d="";}
		$newstemp_options.="<option value=".$nt_r[tempid].$nt_d."> |-".$nt_r[tempname]."</option>";
	}
}
//栏目
$fcfile="../data/fc/ListEnews.php";
$fcjsfile="../data/fc/cmsclass.js";
if(file_exists($fcjsfile)&&file_exists($fcfile))
{
	$options=GetFcfiletext($fcjsfile);
	$options=str_replace("<option value='$r[bclassid]'","<option value='$r[bclassid]' selected",$options);
}
else
{
	$options=ShowClass_AddClass("",$r[bclassid],0,"|-",0,0);
}
//会员组
$qgroup='';
$qgbr='';
$qgi=0;
$cgroup='';
$sql1=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	if($r[groupid]==$l_r[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$l_r[groupid].$select.">".$l_r[groupname]."</option>";
	//投稿
	$qgi++;
	if($qgi%6==0)
	{
		$qgbr='<br>';
	}
	else
	{
		$qgbr='';
	}
	$qgchecked='';
	if(strstr($r[qaddgroupid],','.$l_r[groupid].','))
	{
		$qgchecked=' checked';
	}
	$qgroup.="<input type=checkbox name=qaddgroupidck[] value='".$l_r[groupid]."'".$qgchecked.">".$l_r[groupname]."&nbsp;".$qgbr;
	//栏目页权限
	$cgchecked='';
	if(strstr($r[cgroupid],','.$l_r[groupid].','))
	{
		$cgchecked=' checked';
	}
	$cgroup.="<input type=checkbox name=cgroupidck[] value='".$l_r[groupid]."'".$cgchecked.">".$l_r[groupname]."&nbsp;".$qgbr;
}
//js模板
$jstempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsjstemp")." order by tempid");
while($jstempr=$empire->fetch($jstempsql))
{
	$select="";
	if($r[jstempid]==$jstempr[tempid])
	{
		$select=" selected";
	}
	$jstemp.="<option value='".$jstempr[tempid]."'".$select.">".$jstempr[tempname]."</option>";
}
//封面模板
$classtempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsclasstemp")." order by tempid");
while($classtempr=$empire->fetch($classtempsql))
{
	$select="";
	if($r[classtempid]==$classtempr[tempid])
	{
		$select=" selected";
	}
	$classtemp.="<option value='".$classtempr[tempid]."'".$select.">".$classtempr[tempname]."</option>";
}
//评论模板
$pltempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewspltemp")." order by tempid");
while($pltempr=$empire->fetch($pltempsql))
{
	$select="";
	if($r[pltempid]==$pltempr[tempid])
	{
		$select=" selected";
	}
	$pltemp.="<option value='".$pltempr[tempid]."'".$select.">".$pltempr[tempname]."</option>";
}
//WAP模板
$wapstyles='';
$wapstyle_sql=$empire->query("select styleid,stylename from {$dbtbpre}enewswapstyle order by styleid");
while($wapstyle_r=$empire->fetch($wapstyle_sql))
{
	$select="";
	if($r[wapstyleid]==$wapstyle_r[styleid])
	{
		$select=" selected";
	}
	$wapstyles.="<option value='".$wapstyle_r[styleid]."'".$select.">".$wapstyle_r[stylename]."</option>";
}
//预设投票
$infovotesql=$empire->query("select voteid,ysvotename from {$dbtbpre}enewsvotemod order by voteid desc");
while($infovoter=$empire->fetch($infovotesql))
{
	$select="";
	if($r[definfovoteid]==$infovoter[voteid])
	{
		$select=" selected";
	}
	$definfovote.="<option value='".$infovoter[voteid]."'".$select.">".$infovoter[ysvotename]."</option>";
}
//优化方案
$yh_options='';
$yhsql=$empire->query("select id,yhname from {$dbtbpre}enewsyh order by id");
while($yhr=$empire->fetch($yhsql))
{
	$select='';
	if($r[yhid]==$yhr[id])
	{
		$select=' selected';
	}
	$yh_options.="<option value='".$yhr[id]."'".$select.">".$yhr[yhname]."</option>";
}
//工作流
$workflows='';
$wfsql=$empire->query("select wfid,wfname from {$dbtbpre}enewsworkflow order by myorder,wfid");
while($wfr=$empire->fetch($wfsql))
{
	$select='';
	if($r[wfid]==$wfr[wfid])
	{
		$select=' selected';
	}
	$workflows.="<option value='".$wfr[wfid]."'".$select.">".$wfr[wfname]."</option>";
}
//当前使用的模板组
$thegid=GetDoTempGid();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="stylesheet" href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" type="text/css">
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="adminstyle/<?=$loginadminstyleid?>/tab.winclassic.css" disabled="disabled" /> 
<title>管理栏目</title>
<!-- the id is not needed. It is used here to be able to change css file at runtime -->
<style type="text/css"> 
   .dynamic-tab-pane-control .tab-page { 
          width:                100%;
 } 
  .dynamic-tab-pane-control .tab-page .dynamic-tab-pane-control .tab-page { 
         height:                150px; 
 } 
  form { 
         margin:        0; 
         padding:        0; 
 } 
  /* over ride styles from webfxlayout */ 
  .dynamic-tab-pane-control h2 { 
         font-size:12px;
		 font-weight:normal;
		 text-align:        center; 
         width:                auto;
		 height:            20; 
 } 
   .dynamic-tab-pane-control h2 a { 
         display:        inline; 
         width:                auto; 
 } 
  .dynamic-tab-pane-control a:hover { 
         background: transparent; 
 } 
  </style>
 <script type="text/javascript" src="../data/images/tabpane.js"></script> <script type="text/javascript"> 
  function setLinkSrc( sStyle ) { 
         document.getElementById( "luna-tab-style-sheet" ).disabled = sStyle != "luna"; 
  
         //document.documentElement.style.background = "";
         //document.body.style.background = sStyle == "webfx" ? "white" : "ThreeDFace"; 
 } 
function chgBg(obj,color){
 if (document.all || document.getElementById)
   obj.style.backgroundColor=color;
 else if (document.layers)
   obj.bgColor=color;
}
  setLinkSrc( "luna" ); 
  </script>
  
<script>
function small_class(mycheck)
{
if(mycheck)
{
document.getElementById('smallclass').style.display="";
document.getElementById('smallclasssetinfo').style.display="";
document.getElementById('smallclasssettemp').style.display="";
document.getElementById('bigclasssettemp').style.display="none";
document.getElementById('bigclasssetclasstext').style.display="none";
document.getElementById('smallcgtoinfo').style.display="";
document.getElementById('smallclassbdinfo').style.display="";
}
else
{
document.getElementById('smallclass').style.display="none";
document.getElementById('smallclasssetinfo').style.display="none";
document.getElementById('smallclasssettemp').style.display="none";
document.getElementById('bigclasssettemp').style.display="";
document.getElementById('bigclasssetclasstext').style.display="";
document.getElementById('smallcgtoinfo').style.display="none";
document.getElementById('smallclassbdinfo').style.display="none";
}
}

function mybclass()
{
bclass=new Array();
bclass[0]=new Array();
bclass[0][0]='';
<?
//-----------类别js数组
$psql=$empire->query("select classid,classpath from {$dbtbpre}enewsclass order by classid");
$i=0;
while($pr=$empire->fetch($psql))
{
?>
bclass[<?=$pr[classid]?>]=new Array();
bclass[<?=$pr[classid]?>][0]="<?=$pr[classpath]?>/";
<?
}
?>
}
mybclass();

function changeitem(myfrm)
{var SelectedBigId;
SelectedBigId=myfrm.bclassid.options[myfrm.bclassid.selectedIndex].value;
myfrm.pripath.value=bclass[SelectedBigId][0];
	if(myfrm.enews.value=='EditClass')
	{
		if(!myfrm.ecmsclasstype.value==1)
		{
			myfrm.classpath.focus();
		}
	}
	else
	{
		if(!myfrm.ecmsclasstype[1].checked)
		{
			myfrm.classpath.focus();
		}
	}
}

//检查
function CheckForm(obj)
{
if(obj.classname.value=="")
{
alert("请输入栏目名称");
return false;
}
if(obj.enews.value=='EditClass')
{
	if(obj.ecmsclasstype.value==1)
	{
		return true;
	}
}
else
{
	if(obj.ecmsclasstype[1].checked)
	{
		return true;
	}
}
if(obj.classpath.value=="")
{
alert("请输入栏目目录");
return false;
}
//终极栏目
if(<?=$enews=='EditClass'?'obj.islast.value==1':'obj.islast.checked'?>)
{
	if(obj.modid.value==0||obj.modid.value=="")
	{
	alert("请选择所属系统模型");
	return false;
	}
	if(obj.listtempid.value==0)
	{
	alert("请到“模板选项”选择列表模板");
	return false;
	}
	if(obj.newstempid.value==0)
	{
	alert("请到“模板选项”选择内容模板");
	return false;
	}
	if(obj.filetype.value=="")
	{
	alert("请输入信息文件扩展名");
	return false;
	}
}
//大栏目
else
{
	if(obj.islist[1].checked&&obj.listtempid.value==0)//列表式
	{
		alert("请到“模板选项”选择列表模板");
		return false;
	}
	else if(obj.islist[0].checked&&obj.classtempid.value==0)
	{
		alert("到“模板选项”选择封面模板");
		return false;
	}
	else if(obj.islist[2].checked&&obj.classtext.value=='')
	{
		alert("请到“模板选项”设置页面内容");
		return false;
	}
}
return true;
}

//修改绑定信息
function EditBdInfo(obj){
	var infoid=obj.bdinfoid.value;
	var r;
	r=infoid.split(',');
	if(infoid==''||r.length==1)
	{
		alert('请输入绑定信息ID');
		return false;
	}
	window.open('AddNews.php?<?=$ecms_hashur['ehref']?>&enews=EditNews&classid='+r[0]+'&id='+r[1]);
}

//修改绑定信息
function EditSmallBdInfo(obj){
	var infoid=obj.smallbdinfoid.value;
	var r;
	r=infoid.split(',');
	if(infoid==''||r.length==1)
	{
		alert('请输入绑定信息ID');
		return false;
	}
	window.open('AddNews.php?<?=$ecms_hashur['ehref']?>&enews=EditNews&classid='+r[0]+'&id='+r[1]);
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr>
    <td>位置：<?=$url?> </td>
  </tr>
</table>
  <form name="form1" method="post" action="ecmsclass.php" onsubmit="return CheckForm(document.form1);">
  <?=$ecms_hashur['form']?>
  <div class="tab-pane" id="TabPane1"> <script type="text/javascript">
tb1 = new WebFXTabPane( document.getElementById( "TabPane1" ) );
</script>
<div class="tab-page" id="baseinfo"> 
                    
      <h2 class="tab">&nbsp;<font class=tabcolor>基本属性</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "baseinfo" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <input type=hidden name=enews value=<?=$enews?>>
        <tr class="header"> 
          <td height="30" colspan="2">增加栏目</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">栏目名称</td>
          <td> <input name="classname" type="text" id="classname" value="<?=$r[classname]?>" size="38"> 
            <?
	  if($enews=="AddClass")
	  {
	  ?>
            <input type="button" name="Submit5" value="生成拼音目录" onclick="window.open('GetPinyin.php?hz='+document.form1.classname.value+'&returnform=opener.document.form1.classpath.value<?=$ecms_hashur['href']?>','','width=160,height=100');"> 
            <?
	  }
	  ?>
            <input name="oldbclassid" type="hidden" id="oldbclassid" value="<?=$r[bclassid]?>"> 
            <input name="classid" type="hidden" id="classid" value="<?=$classid?>"> 
            <input name="oldclassname" type="hidden" id="oldclassname" value="<?=$r[classname]?>"> 
            <input name="oldislast" type="hidden" id="oldislast" value="<?=$r[islast]?>"> 
            <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">栏目别名</td>
          <td><input name="bname" type="text" id="bname" value="<?=$r[bname]?>" size="38"> 
            <font color="#666666">(为空则与栏目名相同)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25" valign="top">所属父栏目</td>
          <td><select name="bclassid" size="12" id="bclassid" onchange='javascript:changeitem(document.form1);' style="width:320">
              <option value="0"<?=$defaultbclassid?>>根栏目</option>
              <?=$options?>
            </select> </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">栏目类型</td>
          <td> 
            <?php
		  $wbclassstyle=' style="display:none"';
		  $nbclassstyle='';
		  if($enews=='EditClass')
		  {
		  	if(empty($r[wburl]))
			{
				$wbclassstyle=' style="display:none"';
				$nbclassstyle='';
				echo"<b>内部栏目</b><input type=hidden name=ecmsclasstype value=0>";
			}
			else
			{
				$wbclassstyle='';
				$nbclassstyle=' style="display:none"';
				echo"<b>外部栏目</b><input type=hidden name=ecmsclasstype value=1>";
			}
		  }
		  else
		  {
		  	if(empty($r[wburl]))
			{
				$wbclassstyle=' style="display:none"';
				$nbclassstyle='';
			}
			else
			{
				$wbclassstyle='';
				$nbclassstyle=' style="display:none"';
			}
		  ?>
            <input name="ecmsclasstype" type="radio" value="0"<?=empty($r[wburl])?' checked':''?> onclick="wbclass.style.display='none';nbclass.style.display='';">
            内部栏目 
            <input type="radio" name="ecmsclasstype" value="1"<?=empty($r[wburl])?'':' checked'?> onclick="wbclass.style.display='';nbclass.style.display='none';">
            外部栏目<font color="#666666">(选择后不能修改)</font> 
            <?php
			}
			?>          </td>
        </tr>
        <tbody id="wbclass"<?=$wbclassstyle?>>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">&nbsp;</td>
            <td>外部栏目链接地址： 
              <input name="wburl" type="text" id="wburl" value="<?=$r[wburl]?>" size="38">
              <input name="oldwburl" type="hidden" id="oldwburl" value="<?=$r[wburl]?>"></td>
          </tr>
        </tbody>
        <tbody id="nbclass"<?=$nbclassstyle?>>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">是否终级栏目</td>
            <td> 
              <?=$islast?>
              <font color="#FF0000">(终级栏目下才能增加信息)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25" valign="top">栏目存放文件夹 
              <input name="oldclasspath" type="hidden" id="oldclasspath" value="<?=$r[classpath]?>"> 
              <br> <input name="oldcpath" type="hidden" id="oldcpath" value="<?=$classpath?>"></td>
            <td><table border="0" cellspacing="1" cellpadding="3">
                <tr bgcolor="DBEAF5"> 
                  <td>&nbsp;</td>
                  <td bgcolor="DBEAF5">上层栏目目录</td>
                  <td>本栏目目录</td>
                  <td bgcolor="DBEAF5">&nbsp;</td>
                </tr>
                <tr> 
                  <td><div align="right">根目录/</div></td>
                  <td><input name="pripath" type="text" id="pripath" value="<?=$pripath?>" size="30">                  </td>
                  <td><input name="classpath" type="text" id="classpath3" value="<?=$classpath?>" size="16"<?=$read?>></td>
                  <td> <div align="left"> 
                      <input type="button" name="Submit3" value="检测目录" onclick="javascript:window.open('ecmscom.php?<?=$ecms_hashur['href']?>&enews=CheckPath&pripath='+document.form1.pripath.value+'&classpath='+document.form1.classpath.value,'','width=100,height=100,top=250,left=450');">
                    </div></td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="23%" height="25">绑定的系统模型</td>
            <td width="77%"><select name="modid" id="modid">
                <?=$mod_options?>
              </select> <input type="button" name="Submit6" value="管理系统模型" onclick="window.open('db/ListTable.php<?=$ecms_hashur['whehref']?>');">
              * 
              <input name="oldmodid" type="hidden" id="oldmodid" value="<?=$r[modid]?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25">使用优化方案</td>
            <td><select name="yhid" id="yhid">
				<option name="0">不使用</option>
                <?=$yh_options?>
              </select> 
              <input type="button" name="Submit63" value="管理优化方案" onclick="window.open('db/ListYh.php<?=$ecms_hashur['whehref']?>');">            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">绑定域名</td>
            <td><input name="classurl" type="text" id="classurl" value="<?=$r[classurl]?>" size="38"> 
              <input name="UrlToSmall" type="checkbox" id="UrlToSmall" value="1">
              应用于子栏目<font color="#666666"> (没有绑定，请留空.后面无需加&quot;/&quot;)</font></td>
          </tr>
        </tbody>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">栏目缩略图</td>
          <td><input name="classimg" type="text" id="classimg" value="<?=$r[classimg]?>" size="38"> 
            <a onclick="window.open('ecmseditor/FileMain.php?modtype=1&type=1&classid=&doing=2&field=classimg&filepass=<?=$filepass?>&sinfo=1<?=$ecms_hashur['ehref']?>','','width=700,height=550,scrollbars=yes');" title="选择已上传的图片"><img src="../data/images/changeimg.gif" width="22" height="22" border="0" align="absbottom"></a></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25" valign="top">页面关键字</td>
          <td><input name="classpagekey" type="text" id="classpagekey" value="<?=$r[classpagekey]?>" size="38"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25" valign="top">栏目简介</td>
          <td><textarea name="intro" cols="70" rows="8" id="intro"><?=stripSlashes($r[intro])?></textarea></td>
        </tr>
		<?php
		if($enews=='EditClass')
		{
		?>
        <tr bgcolor="#FFFFFF">
          <td height="25">栏目增加时间</td>
          <td><?=$r['addtime']?date("Y-m-d",$r['addtime']):'---'?></td>
        </tr>
		<?php
		}
		?>
      </table>
  </div>
  <div class="tab-page" id="changevar"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">选项设置</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "changevar" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="30" colspan="2">栏目选项</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">是否显示到导航</td>
          <td><input type="radio" name="showclass" value="0"<?=$r[showclass]==0?' checked':''?>>
            显示 
            <input type="radio" name="showclass" value="1"<?=$r[showclass]==1?' checked':''?>>
            不显示<font color="#666666">（如：导航标签，地图标签）</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">显示排序</td>
          <td><input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>"> 
            <font color="#666666">(值越小越前面)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">栏目访问权限</td>
          <td>
            <?=$cgroup?>          </td>
        </tr>
        <tr bgcolor="#FFFFFF" id="smallcgtoinfo"> 
          <td height="25" valign="top">&nbsp;</td>
          <td><input name="cgtoinfo" type="checkbox" id="cgtoinfo" value="1"<?=$r[cgtoinfo]?' checked':''?>>
            访问权限应用于信息<font color="#666666">(选择后信息的查看权限可以不设置)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">开启前台投稿</td>
          <td><input type="radio" name="openadd" value="0"<?=$openadd0?>>
            开启 
            <input type="radio" name="openadd" value="1"<?=$openadd1?>>
            关闭 
            <input name="oldopenadd" type="hidden" id="oldopenadd" value="<?=$r[openadd]?>">          </td>
        </tr>
        <tbody id="smallclass">
          <tr> 
            <td>前台投稿设置</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>验证码</td>
            <td height="25"> 开启验证码: 
              <input name="qaddshowkey" type="checkbox" id="qaddshowkey2" value="1"<?=$r['qaddshowkey']==1?' checked':''?>>            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>投稿权限<font color="#666666">(不选为不限)</font></td>
            <td height="25"> 
              <?=$qgroup?>            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>投稿生成列表</td>
            <td height="25"><p> 
                <select name="qaddlist" id="qaddlist">
                  <option value="0"<?=$r['qaddlist']==0?' selected':''?>>不生成</option>
                  <option value="1"<?=$r['qaddlist']==1?' selected':''?>>生成当前栏目</option>
                  <option value="2"<?=$r['qaddlist']==2?' selected':''?>>生成首页</option>
                  <option value="3"<?=$r['qaddlist']==3?' selected':''?>>生成父栏目</option>
                  <option value="4"<?=$r['qaddlist']==4?' selected':''?>>生成当前栏目与父栏目</option>
                  <option value="5"<?=$r['qaddlist']==5?' selected':''?>>生成父栏目与首页</option>
                  <option value="6"<?=$r['qaddlist']==6?' selected':''?>>生成当前栏目、父栏目与首页</option>
                </select>
              </p></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>投稿审核</td>
            <td height="25"> <input type="radio" name="checkqadd" value="0"<?=$r['checkqadd']==0?' checked':''?>>
              需要审核 
              <input type="radio" name="checkqadd" value="1"<?=$r['checkqadd']==1?' checked':''?>>
              无需审核</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>发布信息增加</td>
            <td height="25"> <input name="addinfofen" type="text" id="addinfofen2" value="<?=$r[addinfofen]?>" size="6">
              点数 <font color="#666666">(不增加请设为0,扣点请设为负数，使用此项需将投稿权限设置为会员以上)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>管理投稿</td>
            <td height="25"><strong> 
              <select name="adminqinfo" id="adminqinfo">
                <option value="0"<?=$r['adminqinfo']==0?' selected':''?>>不能管理信息</option>
                <option value="1"<?=$r['adminqinfo']==1?' selected':''?>>可管理未审核信息</option>
                <option value="2"<?=$r['adminqinfo']==2?' selected':''?>>只可编辑未审核信息</option>
                <option value="3"<?=$r['adminqinfo']==3?' selected':''?>>只可删除未审核信息</option>
                <option value="4"<?=$r['adminqinfo']==4?' selected':''?>>可管理所有信息</option>
                <option value="5"<?=$r['adminqinfo']==5?' selected':''?>>只可编辑所有信息</option>
                <option value="6"<?=$r['adminqinfo']==6?' selected':''?>>只可删除所有信息</option>
              </select>
              <input name="qeditchecked" type="checkbox" id="qeditchecked" value="1"<?=$r['qeditchecked']==1?' checked':''?>>
              </strong>编辑信息需要审核</td>
          </tr>
          <tr> 
            <td valign="top">后台信息发布设置</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>增加/编辑信息</td>
            <td height="25"> <input name="addreinfo" type="checkbox" id="addreinfo" value="1"<?=$r['addreinfo']==1?' checked':''?>>
              生成内容页；生成列表： 
              <select name="haddlist" id="haddlist">
                <option value="0"<?=$r['haddlist']==0?' selected':''?>>不生成</option>
                <option value="1"<?=$r['haddlist']==1?' selected':''?>>生成当前栏目</option>
                <option value="2"<?=$r['haddlist']==2?' selected':''?>>生成首页</option>
                <option value="3"<?=$r['haddlist']==3?' selected':''?>>生成父栏目</option>
                <option value="4"<?=$r['haddlist']==4?' selected':''?>>生成当前栏目与父栏目</option>
                <option value="5"<?=$r['haddlist']==5?' selected':''?>>生成父栏目与首页</option>
                <option value="6"<?=$r['haddlist']==6?' selected':''?>>生成当前栏目、父栏目与首页</option>
              </select></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;</td>
            <td height="25"><input name="repreinfo" type="checkbox" id="repreinfo2" value="1"<?=$r[repreinfo]==1?' checked':''?>>
              生成上一篇信息</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;</td>
            <td height="25"><input name="sametitle" type="checkbox" id="sametitle" value="1"<?=$r['sametitle']==1?' checked':''?>>
              检测标题重复</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>审核设置</td>
            <td height="25"><input name="checked" type="checkbox" id="checked" value="1"<?=$checked?>>
              直接审核</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>使用工作流</td>
            <td height="25"><select name="wfid" id="wfid">
                <option value="0">不使用工作流</option>
                <?=$workflows?>
              </select></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">信息预设投票</td>
            <td><select name="definfovoteid" id="definfovoteid">
                <option value="0">不设置</option>
                <?=$definfovote?>
              </select> <input type="button" name="Submit622" value="管理预设投票" onclick="window.open('other/ListVoteMod.php<?=$ecms_hashur['whehref']?>');"> 
              <font color="#666666">(增加信息时默认的投票项)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">默认查看信息权限</td>
            <td><select name="groupid" id="groupid">
                <option value="0">游客</option>
                <?=$group?>
              </select> <font color="#666666">(增加信息时默认的会员组权限)</font></td>
          </tr>
          <tr> 
            <td valign="top">其他设置</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="23%" valign="top">评论功能</td>
            <td height="25"><input type="radio" name="openpl" value="0"<?=$openpl0?>>
              开启 
              <input type="radio" name="openpl" value="1"<?=$openpl1?>>
              关闭，评论需要审核: 
              <input name="checkpl" type="checkbox" id="checkpl2" value="1"<?=$checkpl?>>
              是</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">信息归档</td>
            <td>归档大于 
              <input name="doctime" type="text" id="doctime" value="<?=$r[doctime]?>" size="6">
              天的信息<font color="#666666">(0为不归档)</font></td>
          </tr>
          <tr> 
            <td>特殊模型设置</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="23%" height="25">下载/影视模型</td>
            <td height="25">每行显示 
              <input name="down_num" type="text" id="link_num3" value="<?=$r[down_num]?>" size="5">
              个下载地址， 
              <input name="online_num" type="text" id="down_num" value="<?=$r[online_num]?>" size="5">
              个在线观看地址</td>
          </tr>
        </tbody>
      </table>
  </div>
  <div class="tab-page" id="settemplate"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">模板选项</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "settemplate" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="30" colspan="2">模板设置</td>
        </tr>
		<tbody id="smallclassbdinfo">
		  <tr bgcolor="#FFFFFF">
            <td height="25">栏目绑定信息</td>
            <td height="25">绑定信息ID：
              <input name="smallbdinfoid" type="text" id="smallbdinfoid" value="<?=$r[bdinfoid]?>">
              <a href="#empirecms" onclick="EditSmallBdInfo(document.form1);">[修改信息]</a> <font color="#666666">(格式：栏目ID,信息ID)</font></td>
          </tr>
		</tbody>
        <tbody id="bigclasssettemp">
          <tr bgcolor="#FFFFFF"> 
            <td width="23%" height="25">页面显示模式</td>
            <td height="25"> <input type="radio" name="islist" value="0"<?=$r[islist]==0?' checked':''?>>
              封面式 
              <input type="radio" name="islist" value="1"<?=$r[islist]==1?' checked':''?>>
              列表式 
              <input type="radio" name="islist" value="2"<?=$r[islist]==2?' checked':''?>>
              页面内容式 
              <input type="radio" name="islist" value="3"<?=$r[islist]==3?' checked':''?> onclick="bdinfo.style.display='';">
              栏目绑定信息 
              <input name="oldislist" type="hidden" id="oldislist" value="<?=$r[islist]?>"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">&nbsp;</td>
            <td height="25"><font color="#666666">说明：封面式要选择封面模板、列表式要选择列表模板、内容式要录入页面内容</font></td>
          </tr>
		  <?php
		  $bdinfostyle=$r[islist]==3?'':' style="display:none"';
		  ?>
          <tr id="bdinfo" bgcolor="#FFFFFF"<?=$bdinfostyle?>>
            <td height="25">&nbsp;</td>
            <td height="25">绑定信息ID： 
              <input name="bdinfoid" type="text" id="bdinfoid" value="<?=$r[bdinfoid]?>">
              <a href="#empirecms" onclick="EditBdInfo(document.form1);">[修改信息]</a> 
              <font color="#666666">(格式：栏目ID,信息ID)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">封面模板</td>
            <td height="25"><select name="classtempid">
                <?=$classtemp?>
              </select> <input type="button" name="Submit6223" value="管理封面模板" onclick="window.open('template/ListClasstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </tbody>
        <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">所属列表模板</td>
          <td> 静态： 
            <select name="listtempid" id="listtempid">
              <?=$listtemp_options?>
            </select>
            ，动态： 
            <select name="dtlisttempid">
              <?=$dtlisttemp_options?>
            </select> <input type="button" name="Submit6222" value="管理列表模板" onclick="window.open('template/ListListtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');">
            *</td>
        </tr>
        <tbody id="smallclasssettemp">
          <tr bgcolor="#FFFFFF"> 
            <td height="25">所属内容模板</td>
            <td><select name="newstempid" id="newstempid">
                <?=$newstemp_options?>
              </select> <input type="button" name="Submit62222" value="管理内容模板" onclick="window.open('template/ListNewstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');">
              *( 
              <input name="tobetempinfo" type="checkbox" id="tobetempinfo" value="1">
              应用于已生成的信息 )</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">所属评论模板</td>
            <td><select name="pltempid" id="pltempid">
                <option value="0">使用默认模板 </option>
                <?=$pltemp?>
              </select> <input type="button" name="Submit62" value="管理评论模板" onclick="window.open('template/ListPltemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
          </tr>
        </tbody>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">搜索模板</td>
          <td><select name="searchtempid" id="searchtempid">
              <option value="0">使用默认模板 </option>
              <?=$searchtemp?>
            </select> <input type="button" name="Submit62" value="管理搜索模板" onclick="window.open('template/ListSearchtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">WAP模板</td>
          <td><select name="wapstyleid" id="wapstyleid">
              <option value="0">使用默认模板</option>
              <?=$wapstyles?>
            </select> <input type="button" name="Submit623" value="管理WAP模板" onclick="window.open('other/WapStyle.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');">
            ( 
            <input name="wapstylesclass" type="checkbox" id="wapstylesclass" value="1">
            应用于子栏目) </td>
        </tr>
        <tbody id="bigclasssetclasstext">
          <tr bgcolor="#FFFFFF"> 
            <td height="25">页面内容<font color="#666666">(支持标签同封面模板)</font></td>
            <td>请将内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.classtext.value);document.form1.classtext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('template/editor.php?getvar=opener.document.form1.classtext.value&returnvar=opener.document.form1.classtext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','editclasstext','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="100%" colspan="2"><textarea name="classtext" cols="80" rows="23" id="classtext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($addr[classtext]))?></textarea>                  </td>
                </tr>
              </table></td>
          </tr>
        </tbody>
      </table>
  </div>
  <div class="tab-page" id="sethtml"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">生成选项</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "sethtml" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="30" colspan="2">生成设置</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">栏目页模式</td>
          <td><input type="radio" name="listdt" value="0"<?=$r[listdt]==0?' checked':''?>>
            静态页面 
            <input type="radio" name="listdt" value="1"<?=$r[listdt]==1?' checked':''?>>
            动态页面 
            <input name="oldlistdt" type="hidden" id="oldlistdt" value="<?=$r[listdt]?>"></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">内容页模式</td>
          <td><input type="radio" name="showdt" value="0"<?=$r[showdt]==0?' checked':''?>>
            静态页面 
            <input type="radio" name="showdt" value="1"<?=$r[showdt]==1?' checked':''?>>
            动态生成<font color="#666666"> 
            <input type="radio" name="showdt" value="2"<?=$r[showdt]==2?' checked':''?>>
            </font>动态页面</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">管理信息排序方式</td>
          <td> <input name="listorder" type="text" id="listorder" value="<?=$r[listorder]?>" size="38"> 
            <select name="lorderselect" onchange="document.form1.listorder.value=this.value">
              <option value="id DESC"></option>
              <option value="newstime DESC">按发布时间降序排序</option>
              <option value="id DESC">按ID降序排序</option>
              <option value="onclick DESC">按点击率降序排序</option>
              <option value="totaldown DESC">按下载数降序排序</option>
              <option value="plnum DESC">按评论数降序排序</option>
            </select> </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">列表式页面排序方式</td>
          <td> <input name="reorder" type="text" id="reorder" value="<?=$r[reorder]?>" size="38"> 
            <select name="orderselect" onchange="document.form1.reorder.value=this.value">
              <option value="newstime DESC"></option>
              <option value="newstime DESC">按发布时间降序排序</option>
              <option value="id DESC">按ID降序排序</option>
              <option value="onclick DESC">按点击率降序排序</option>
              <option value="totaldown DESC">按下载数降序排序</option>
              <option value="plnum DESC">按评论数降序排序</option>
            </select> </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">是否生成</td>
          <td><input name="nreclass" type="checkbox" value="1"<?=$r[nreclass]==1?' checked':''?>>
            不生成栏目页， 
            <input name="nreinfo" type="checkbox" value="1"<?=$r[nreinfo]==1?' checked':''?>>
            不生成内容页， 
            <input name="nrejs" type="checkbox" value="1"<?=$r[nrejs]==1?' checked':''?>>
            不生成JS调用， 
            <input name="nottobq" type="checkbox" value="1"<?=$r[nottobq]==1?' checked':''?>>
            标签不调用</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">栏目文件扩展名</td>
          <td><input name="classtype" type="text" id="classtype" value="<?=$r[classtype]?>" size="38"> 
            <select name="select" onchange="document.form1.classtype.value=this.value">
              <option value=".html">扩展名</option>
              <option value=".html">.html</option>
              <option value=".htm">.htm</option>
              <option value=".php">.php</option>
              <option value=".shtml">.shtml</option>
            </select> <input name="oldclasstype" type="hidden" id="oldclasstype" value="<?=$r[classtype]?>"> 
            <font color="#666666">(如.html,.xml,.htm等)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">显示总记录数</td>
          <td> <input name="maxnum" type="text" id="maxnum" value="<?=$r[maxnum]?>" size="38">
            条<font color="#666666">(0为显示所有记录)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">生成静态页数</td>
          <td><input name="repagenum" type="text" id="repagenum" value="<?=$r[repagenum]?>" size="38">
            页<font color="#666666">(超过分页采用动态链接，0为不限)</font></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">生成信息每页显示</td>
          <td><input name="lencord" type="text" id="lencord" value="<?=$r[lencord]?>" size="38">
            条记录 
            <input name="oldlencord" type="hidden" id="oldlencord3" value="<?=$r[lencord]?>"></td>
        </tr>
        <tbody id="smallclasssetinfo">
          <tr bgcolor="#FFFFFF"> 
            <td height="25">相关链接显示</td>
            <td><input name="link_num" type="text" id="link_num" value="<?=$r[link_num]?>" size="38">
              条记录<font color="#666666">(0为不生成相关链接)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="26">内容页存放目录</td>
            <td><input type="radio" name="infopath" value="0"<?=$r[ipath]==''?' checked':''?>>
              栏目目录 
              <input type="radio" name="infopath" value="1"<?=$r[ipath]<>''?' checked':''?>>
              自定义： / 
              <input name="ipath" type="text" id="ipath" value="<?=$r[ipath]?>"> 
              <font color="#666666">(从根目录开始)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="26">内容页目录存放形式</td>
            <td><input name="newspath" type="text" id="newspath" value="<?=$r[newspath]?>" size="38"> 
              <select name="select2" onchange="document.form1.newspath.value=this.value">
                <option value="Y-m-d">选择</option>
                <option value="Y-m-d">2005-01-27</option>
                <option value="Y/m-d">2005/01-27</option>
                <option value="Y/m/d">2005/01/27</option>
                <option value="Ymd">20050127</option>
                <option value="">不设置目录</option>
              </select> <font color="#666666">(如Y-m-d，Y/m-d等形式)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">内容页文件命名形式</td>
            <td>[前缀] 
              <input name="filename_qz" type="text" id="filename_qz" value="<?=$r[filename_qz]?>" size="15">
              命名: 
              <input type="radio" name="filename" value="0"<?=$r[filename]==0?' checked':''?>>
              <a title="信息ID：1.html">信息ID</a> 
              <input type="radio" name="filename" value="1"<?=$r[filename]==1?' checked':''?>>
              <a title="unix时间戳+信息ID：12102462981.html">time()</a> 
              <input type="radio" name="filename" value="4"<?=$r[filename]==4?' checked':''?>>
              <a title="日期+信息ID：201210011.html">date()</a>
              <input type="radio" name="filename" value="5"<?=$r[filename]==5?' checked':''?>>
              <a title="各表信息在同一个目录不会重复：1000010000000001.html">公共信息ID</a> 
              <input type="radio" name="filename" value="2"<?=$r[filename]==2?' checked':''?>>
              <a title="MD5加密地址：c4ca4238a0b923820dcc509a6f75849b.html">md5()</a> 
              <input type="radio" name="filename" value="3"<?=$r[filename]==3?' checked':''?>>
              <a title="信息ID目录：/1/">目录</a></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">内容页文件扩展名</td>
            <td><input name="filetype" type="text" id="filetype" value="<?=$r[filetype]?>" size="38"> 
              <select name="select3" onchange="document.form1.filetype.value=this.value">
                <option value=".html">扩展名</option>
                <option value=".html">.html</option>
                <option value=".htm">.htm</option>
                <option value=".php">.php</option>
                <option value=".shtml">.shtml</option>
              </select> <font color="#666666">(如.html,.xml,.htm等)</font></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25">内容关键字替换</td>
            <td><select name="keycid" id="keycid">
                <option value="0"<?=$r['keycid']==0?' selected':''?>>替换所有</option>
                <option value="-1"<?=$r['keycid']==-1?' selected':''?>>不替换</option>
				<?php
				$keycsql=$empire->query("select classid,classname from {$dbtbpre}enewskeyclass");
				while($keycr=$empire->fetch($keycsql))
				{
				?>
					<option value="<?=$keycr['classid']?>"<?=$r['keycid']==$keycr['classid']?' selected':''?>><?=$keycr['classname']?></option>
				<?php
				}
				?>
              </select>
              <input type="button" name="Submit6232" value="管理内容关键字" onclick="window.open('NewsSys/key.php<?=$ecms_hashur['whehref']?>');"></td>
          </tr>
        </tbody>
      </table>
  </div>
  <div class="tab-page" id="setjs"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">JS调用设置</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "setjs" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
      <td height="30" colspan="2">JS调用相关设置</td>
    </tr>
    <tr bgcolor="#FFFFFF">
          <td height="25">所用JS模板</td>
      <td><select name="jstempid" id="jstempid">
	  <?=$jstemp?>
        </select>
            <input type="button" name="Submit62223" value="管理JS模板" onclick="window.open('template/ListJstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td width="23%" height="25">最新信息JS显示</td>
          <td> 
            <input name="newline" type="text" id="newline" value="<?=$r[newline]?>" size="38">
            条记录</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">热门信息JS显示</td>
      <td>
<input name="hotline" type="text" id="hotline" value="<?=$r[hotline]?>" size="38">
            条记录</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">推荐信息JS显示</td>
      <td>
<input name="goodline" type="text" id="goodline" value="<?=$r[goodline]?>" size="38">
            条记录</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">热门评论信息JS显示</td>
      <td>
<input name="hotplline" type="text" id="hotplline" value="<?=$r[hotplline]?>" size="38">
            条记录</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
          <td height="25">头条信息JS显示</td>
      <td>
<input name="firstline" type="text" id="firstline" value="<?=$r[firstline]?>" size="38">
            条记录</td>
    </tr>
  </table>
  </div>
  <?php
  $classfnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsclassf");
  if($classfnum)
  {
  	$editorfnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsclassf where fform='editor' limit 1");	
	if($editorfnum)
	{
		include('ecmseditor/infoeditor/fckeditor.php');
	}
  ?>
  <div class="tab-page" id="setaddfield"> 
      <h2 class="tab">&nbsp;<font class="tabcolor">自定义字段设置</font>&nbsp;</h2>
                    <script type="text/javascript">tb1.addTabPage( document.getElementById( "setaddfield" ) );</script>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td width="23%" height="30">自定义字段设置</td>
          <td height="30">&nbsp;</td>
        </tr>
        <?php
		@include('../data/html/classaddform.php');
		?>
        <tr bgcolor="#FFFFFF"> 
          <td height="30" colspan="2"><strong>栏目自定义字段调用说明</strong><br>
            内置调用栏目自定义字段函数：ReturnClassAddField(栏目ID,字段名)，栏目ID=0为当前栏目ID。取多个字段内容可用逗号隔开，例子：<br>
            取得'classtext'字段内容：$value=ReturnClassAddField(0,'classtext'); //$value就是字段内容。<br>
            取得多个字段内容：$value=ReturnClassAddField(1,'classid,classtext'); //$value['classtext']才是字段内容。</td>
        </tr>
      </table>
  </div>
  <?php
  }
  ?>
</div>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
      <td width="100%" height="30"><div align="center"><strong> 
          <input type="submit" name="Submit" value="提交">
          &nbsp;&nbsp;<input type="reset" name="Submit2" value="重置">
          <input type=hidden name=from value="<?=ehtmlspecialchars($_GET['from'])?>"></strong></div></td>
    </tr>
  </table>
  </form>
</body>
</html>
<?php
db_close();
$empire=null;
?>
<?=$hiddenclass?>
