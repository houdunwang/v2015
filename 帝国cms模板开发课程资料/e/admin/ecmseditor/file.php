<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
require "../".LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//验证
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

//返回按钮事件
function ToReturnDoFileButton($doing,$tranfrom,$field,$file,$filename,$fileid,$filesize,$filetype,$no,$type){
	if($doing==1)//返回地址
	{
		$bturl="ChangeFile1(1,'".$file."');";
		$button="<input type=button name=button value='选择' onclick=\"javascript:".$bturl."\">";
	}
	elseif($doing==2)//返回地址
	{
		$bturl="ChangeFile1(2,'".$file."');";
		$button="<input type=button name=button value='选择' onclick=\"javascript:".$bturl."\">";
	}
	else
	{
		if($tranfrom==1)//编辑器选择
		{
			$bturl="EditorChangeFile('".$file."','".addslashes($filename)."','".$filetype."','".$filesize."','".addslashes($no)."');";
			$button="<input type=button name=button value='选择' onclick=\"javascript:".$bturl."\">";
		}
		elseif($tranfrom==2)//特殊字段选择
		{
			$bturl="SFormIdChangeFile('".addslashes($no)."','$file','$filesize','$filetype','$field');";
			$button="<input type=button name=button value='选择' onclick=\"javascript:".$bturl."\">";
		}
		else
		{
			$bturl="InsertFile('".$file."','".addslashes($filename)."','".$fileid."','".$filesize."','".$filetype."','','".$type."');";
			$button="<input type=button name=button value='插入' onclick=\"javascript:".$bturl."\">";
		}
	}
	$retr['button']=$button;
	$retr['bturl']=$bturl;
	return $retr;
}

$classid=(int)$_GET['classid'];
$infoid=(int)$_GET['infoid'];
$filepass=(int)$_GET['filepass'];
$type=(int)$_GET['type'];
$modtype=(int)$_GET['modtype'];
$doing=(int)$_GET['doing'];
$field=RepPostVar($_GET['field']);
$tranfrom=RepPostStr($_GET['tranfrom'],1);
$fileno=RepPostStr($_GET['fileno'],1);
if(empty($field))
{
	$field="ecms";
}
$add='';
//附件类型
$isinfofile=0;
$fstb=0;
if($modtype==1)//栏目
{
	$query="select fileid,filename,filesize,path,filetime,no,fpath from {$dbtbpre}enewsfile_other where modtype=1 and type='$type'";
	$totalquery="select count(*) as total from {$dbtbpre}enewsfile_other where modtype=1 and type='$type'";
	$tranname='栏目';
}
elseif($modtype==2)//专题
{
	$query="select fileid,filename,filesize,path,filetime,no,fpath from {$dbtbpre}enewsfile_other where modtype=2 and type='$type'";
	$totalquery="select count(*) as total from {$dbtbpre}enewsfile_other where modtype=2 and type='$type'";
	$tranname='专题';
}
elseif($modtype==3)//广告
{
	$query="select fileid,filename,filesize,path,filetime,no,fpath from {$dbtbpre}enewsfile_other where modtype=3 and type='$type'";
	$totalquery="select count(*) as total from {$dbtbpre}enewsfile_other where modtype=3 and type='$type'";
	$tranname='广告';
}
elseif($modtype==4)//反馈
{
	$query="select fileid,filename,filesize,path,filetime,no,fpath from {$dbtbpre}enewsfile_other where modtype=4 and type='$type'";
	$totalquery="select count(*) as total from {$dbtbpre}enewsfile_other where modtype=4 and type='$type'";
	$tranname='反馈';
}
elseif($modtype==5)//公共
{
	$query="select fileid,filename,filesize,path,filetime,no,fpath from {$dbtbpre}enewsfile_public where type='$type'";
	$totalquery="select count(*) as total from {$dbtbpre}enewsfile_public where type='$type'";
	$tranname='公共';
}
elseif($modtype==7)//碎片
{
	$query="select fileid,filename,filesize,path,filetime,no,fpath from {$dbtbpre}enewsfile_other where modtype=7 and type='$type'";
	$totalquery="select count(*) as total from {$dbtbpre}enewsfile_other where modtype=7 and type='$type'";
	$tranname='碎片';
}
else//信息
{
	$isinfofile=1;
	if(!$classid||!$class_r[$classid]['tbname'])
	{
		printerror('ErrorUrl','history.go(-1)');
	}
	if($infoid)
	{
		$index_r=$empire->fetch1("select id,classid,checked from {$dbtbpre}ecms_".$class_r[$classid]['tbname']."_index where id='$infoid' limit 1");
		if(!$index_r['id'])
		{
			printerror('ErrorUrl','history.go(-1)');
		}
		//主表
		$infotb=ReturnInfoMainTbname($class_r[$classid]['tbname'],$index_r['checked']);//返回表
		$infor=$empire->fetch1("select fstb from ".$infotb." where id='$infoid' limit 1");
		$fstb=$infor['fstb'];
	}
	else
	{
		$fstb=$public_r['filedeftb'];
	}
	$fstb=(int)$fstb;
	$query="select fileid,filename,filesize,path,filetime,classid,no,fpath from {$dbtbpre}enewsfile_{$fstb} where type='$type'";
	$totalquery="select count(*) as total from {$dbtbpre}enewsfile_{$fstb} where type='$type'";
	$tranname='信息';
}
//栏目
$searchclassid=0;
$searchvarclassid='';
if($isinfofile==1)
{
	$searchclassid=RepPostStr($_GET['searchclassid'],1);
	if($searchclassid=='all')
	{
		$searchclassid=0;
		$searchvarclassid='all';
	}
	else
	{
		$searchclassid=$searchclassid?$searchclassid:$classid;
		$searchvarclassid=$searchclassid;
	}
	$searchclassid=(int)$searchclassid;
	if($searchclassid)
	{
		if($class_r[$searchclassid]['islast'])
		{
			$add.=" and classid='$searchclassid'";
		}
		else
		{
			$add.=" and ".ReturnClass($class_r[$searchclassid]['sonclass']);
		}
	}
}
//时间范围
$filelday=(int)$_GET['filelday'];
if(empty($filelday))
{
	$filelday=$public_r['filelday'];
}
if($filelday&&$filelday!=1)
{
	$ckfilelday=time()-$filelday;
	$add.=" and filetime>$ckfilelday";
}
//当前信息
$sinfo=(int)$_GET['sinfo'];
$select_sinfo='';
if($isinfofile==1)
{
	if($sinfo)
	{
		$add.=$infoid?" and id='$infoid'":" and id='$filepass'";
	}
	$select_sinfo='<input name="sinfo" type="checkbox" id="sinfo" value="1"'.($sinfo?' checked':'').'>当前信息';
}
elseif($modtype!=5)
{
	if($sinfo)
	{
		$add.=" and id='$filepass'";
	}
	$select_sinfo='<input name="sinfo" type="checkbox" id="sinfo" value="1"'.($sinfo?' checked':'').'>当前'.$tranname;
}
//关键字
$keyboard=RepPostVar2($_GET['keyboard']);
if(!empty($keyboard))
{
	$show=RepPostStr($_GET['show'],1);
	if($show==0)//搜索全部
	{
		$add.=" and (filename like '%$keyboard%' or no like '%$keyboard%' or adduser like '%$keyboard%')";
	}
	elseif($show==1)//搜索文件名
	{
		$add.=" and filename like '%$keyboard%'";
	}
	elseif($show==2)//搜索编号
	{
		$add.=" and no like '%$keyboard%'";
	}
	else//搜索上传者
	{
		$add.=" and adduser like '%$keyboard%'";
	}
}
$search="&classid=$classid&infoid=$infoid&filepass=$filepass&type=$type&modtype=$modtype&doing=$doing&tranfrom=$tranfrom&field=$field&show=$show&searchclassid=$searchvarclassid&keyboard=$keyboard&fileno=$fileno&filelday=$filelday&sinfo=$sinfo".$ecms_hashur['ehref'];
//分页
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
if($type==1)//图片
{
	$line=12;
}
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query.=$add;
$totalquery.=$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query.=" order by fileid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择文件</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function InsertFile(filename,fname,fileid,filesize,filetype,fileno,dotype){
	var vstr="";
	if(dotype!=undefined)
	{
		vstr=showModalDialog("infoeditor/epage/insertfile.php?<?=$ecms_hashur['ehref']?>&ecms="+dotype+"&fname="+fname+"&fileid="+fileid+"&filesize="+filesize+"&filetype="+filetype+"&filename="+filename, "", "dialogWidth:45.5em; dialogHeight:27.5em; status:0");
		if(vstr==undefined)
		{
			return false;
		}
	}
	parent.opener.DoFile(vstr);
	parent.window.close();
}
function TInsertFile(vstr){
	parent.opener.DoFile(vstr);
	parent.window.close();
}
//选择字段
function ChangeFile1(obj,str){
<?php
if(strstr($field,'.'))
{
?>
	parent.<?=$field?>.value=str;
<?php
}
else
{
?>
	if(obj==1)
	{
		parent.opener.document.add.<?=$field?>.value=str;
	}
	else
	{
		parent.opener.document.form1.<?=$field?>.value=str;
	}
<?php
}
?>
	parent.window.close();
}
//编辑器选择
function EditorChangeFile(fileurl,filename,filetype,filesize,name){
	parent.opener.OnUploadCompleted(2,fileurl,filename,'',name,filesize);
<?php
if($type==1)
{
?>
	if(parent.opener.document.getElementById('txtAlt').value=='')
	{
		parent.opener.document.getElementById('txtAlt').value=name;
	}
<?php
}
elseif($type==0)
{
?>
	if(parent.opener.document.getElementById('fname').value=='')
	{
		parent.opener.document.getElementById('fname').value=name;
	}
	if(parent.opener.document.getElementById('filesize').value=='')
	{
		parent.opener.document.getElementById('filesize').value=filesize;
	}
<?php
}
?>
	parent.window.close();
}
//变量层选择
function SFormIdChangeFile(name,url,filesize,filetype,idvar){
	parent.opener.doSpChangeFile(name,url,filesize,filetype,idvar);
	parent.window.close();
}
//全选
function CheckAll(form){
  for(var i=0;i<form.elements.length;i++)
  {
    var e = form.elements[i];
	if(e.name=='getmark'||e.name=='getsmall')
		{
			continue;
		}
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
}

//返回编号
function ExpStr(str,exp){
	var pos,len,ext;
	pos=str.lastIndexOf(exp)+1;
	len=str.length;
	ext=str.substring(pos,len);
	return ext;
}
function ReturnFileNo(obj){
	var filename,str,exp;
	if(obj.no.value!='')
	{
		return '';
	}
	if(obj.file.value!='')
	{
		str=obj.file.value;
	}
	else
	{
		str=obj.tranurl.value;
	}
	if(str.indexOf("\\")>=0)
	{
		exp="\\";
	}
	else
	{
		exp="/";
	}
	filename=ExpStr(str,exp);
	obj.no.value=filename;
}
//重新载入页面
function ReloadChangeFilePage(){
	self.location.reload();
}

//上传附件时
function eTranMoreForFileMain(htmlstr){
	self.location.reload();
}
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td width="68%"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form action="ecmseditor.php" target="ECUploadWindow" method="post" enctype="multipart/form-data" name="etform" onsubmit="return ReturnFileNo(document.etform);">
		<?=$ecms_hashur['form']?>
          <input type=hidden name=classid value="<?=$classid?>">
          <input type=hidden name=infoid value="<?=$infoid?>">
          <input type=hidden name=filepass value="<?=$filepass?>">
          <input type=hidden name=enews value="TranFile">
          <input type=hidden name=type value="<?=$type?>">
          <input type=hidden name=modtype value="<?=$modtype?>">
          <input type=hidden name=doing value="<?=$doing?>">
		  <input type=hidden name=fstb value="<?=$fstb?>">
		  <input type=hidden name=sinfo value="<?=$sinfo?>">
          <tr class="header"> 
            <td colspan="2">上传<?=$tranname?>附件</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="16%">远程保存</td>
            <td width="84%"><input name="tranurl" type="text" id="tranurl" value="http://" size="36"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>本地上传</td>
            <td><input name="file" type="file" size="32"> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>文件别名</td>
            <td><input name="no" type="text" id="no" value="<?=RepPostStr($_GET['fileno'],1)?>" size="36"> 
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>图片选项</td>
            <td> <input name="getmark" type="checkbox" id="getmark" value="1"> 
              <a href="../SetEnews.php<?=$ecms_hashur['whehref']?>" target="_blank">加水印</a> <input name="getsmall" type="checkbox" id="getsmall" value="1">
              生成缩略图：宽度 <input name="width" type="text" id="width" value="<?=$public_r['spicwidth']?>" size="6">
              * 高度 <input name="height" type="text" id="height" value="<?=$public_r['spicheight']?>" size="6"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit3" value="上传">
			<?php
			if($type==1&&TranmoreIsOpen('filemain'))
			{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Submit" value="多选上传" onclick="window.open('tranmore/tranmore.php?type=<?=$type?>&classid=<?=$classid?>&filepass=<?=$filepass?>&infoid=<?=$infoid?>&modtype=<?=$modtype?>&sinfo=<?=$sinfo?>&doing=<?=$doing?>&fstb=<?=$fstb?>&ecmsdo=ecmstmfilemain&tranfrom=0<?=$ecms_hashur['ehref']?>','ecmstmpage','width=700,height=550,scrollbars=yes');">
			<?php
			}
			?>
			</td>
          </tr>
        </form>
      </table>
	  <script type="text/javascript">
					document.write( '<iframe name="ECUploadWindow" style="DISPLAY: none" src="images/blank.html"><\/iframe>' ) ;
	  </script>
	  </td>
  </tr>
  <tr> 
    <td> <div align="center"> </div></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <form name="searchfile" method="get" action="file.php">
  <?=$ecms_hashur['eform']?>
  <input type=hidden name=type value="<?=$type?>">
  <input type=hidden name=classid value="<?=$classid?>">
  <input type=hidden name=infoid value="<?=$infoid?>">
  <input type=hidden name=filepass value="<?=$filepass?>">
  <input type=hidden name=modtype value="<?=$modtype?>">
  <input type=hidden name=doing value="<?=$doing?>">
  <input type=hidden name=tranfrom value="<?=$tranfrom?>">
  <input type=hidden name=field value="<?=$field?>">
  <input type=hidden name=fileno value="<?=$fileno?>">
    <tr> 
      <td><div align="center">搜索<?=$tranname?>附件： 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
		  <option value="0">不限</option>
		  <option value="1">文件名</option>
		  <option value="2" selected>编号</option>
		  <option value="3">上传者</option>
          </select> 
		  <span id="fileclassnav"></span> 
          <select name="filelday" id="filelday">
            <option value="1"<?=$filelday==1?' selected':''?>>全部时间</option>
            <option value="86400"<?=$filelday==86400?' selected':''?>>1 天</option>
            <option value="172800"<?=$filelday==172800?' selected':''?>>2 
              天</option>
            <option value="604800"<?=$filelday==604800?' selected':''?>>一周</option>
            <option value="2592000"<?=$filelday==2592000?' selected':''?>>1 
              个月</option>
            <option value="7948800"<?=$filelday==7948800?' selected':''?>>3 
              个月</option>
            <option value="15897600"<?=$filelday==15897600?' selected':''?>>6 
              个月</option>
            <option value="31536000"<?=$filelday==31536000?' selected':''?>>1 
              年</option>
          </select>
          <?=$select_sinfo?>
          <input type="submit" name="Submit2" value="搜索">
        </div></td>
    </tr>
  </form>
</table>
<form name="dofile" method="post" action="../ecmsfile.php" onsubmit="return confirm('确认要操作?');">
<?=$ecms_hashur['form']?>
<input type=hidden name=enews value="DoMarkSmallPic">
  <input type=hidden name=type value="<?=$type?>">
  <input type=hidden name=classid value="<?=$classid?>">
  <input type=hidden name=searchclassid value="<?=$searchclassid?>">
  <input type=hidden name=infoid value="<?=$infoid?>">
  <input type=hidden name=filepass value="<?=$filepass?>">
  <input type=hidden name=modtype value="<?=$modtype?>">
  <input type=hidden name=doing value="<?=$doing?>">
  <input type=hidden name=field value="<?=$field?>">
  <input type=hidden name=fstb value="<?=$fstb?>">
  <input type=hidden name=sinfo value="<?=$sinfo?>">
<?
if($type==1)//图片
{
	include('fileinc/editorpic.php');
}
elseif($type==2)//flash
{
	include('fileinc/editorflash.php');
}
elseif($type==3)//多媒体文件
{
	include('fileinc/editormedia.php');
}
else//附件
{
	include('fileinc/editorfile.php');
}
?>
</form>
<?php
if($isinfofile==1)
{
?>
<IFRAME frameBorder="0" id="showclassnav" name="showclassnav" scrolling="no" src="../ShowClassNav.php?ecms=4&classid=<?=$searchclassid?><?=$ecms_hashur['ehref']?>" style="HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1"></IFRAME>
<?php
}
?>
</body>
</html>
<?
db_close();
$empire=null;
?>