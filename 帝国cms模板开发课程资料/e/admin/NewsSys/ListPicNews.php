<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
CheckLevel($logininid,$loginin,$classid,"picnews");

//增加图片信息
function AddPicNews($add,$title,$pic_url,$url,$pic_width,$pic_height,$open_pic,$border,$pictext,$userid,$username){
	global $empire,$dbtbpre;
	if(!$title||!$pic_url||!$url||!$add[classid])
	{printerror("MustEnter","history.go(-1)");}
	//操作权限
	CheckLevel($userid,$username,$classid,"picnews");
	$add[classid]=(int)$add[classid];
	$border=(int)$border;
	$sql=$empire->query("insert into {$dbtbpre}enewspic(title,pic_url,url,pic_width,pic_height,open_pic,border,pictext,classid) values('$title','$pic_url','$url','$pic_width','$pic_height','$open_pic',$border,'$pictext',$add[classid]);");
	//生成js
	$picid=$empire->lastid();
	GetPicJs($picid);
	if($sql)
	{
		//操作日志
		insert_dolog("picid=".$picid."<br>title=".$title);
		printerror("AddPicNewsSuccess","AddPicNews.php?enews=AddPicNews".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//生成图片信息js
function GetPicJs($picid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewspic where picid='$picid'");
	$string="<a href='".$r[url]."' title='".$r[title]."' target='".$r[open_pic]."'><img src='".$r[pic_url]."' width=".$r[pic_width]." height=".$r[pic_height]." border=".$r[border]."><br>".$r[title]."</a>";
	$string="document.write(\"".addslashes($string)."\");";
	$filename="../../../d/js/pic/pic_".$picid.".js";
	WriteFiletext_n($filename,$string);
}

//删除图片信息js
function DelPicJs($picid){
	$filename="../../../d/js/pic/pic_".$picid.".js";
	DelFiletext($filename);
}

//修改图片信息
function EditPicNews($add,$picid,$title,$pic_url,$url,$pic_width,$pic_height,$open_pic,$border,$pictext,$userid,$username){
	global $empire,$dbtbpre;
	$picid=(int)$picid;
	if(!$picid||!$title||!$pic_url||!$url||!$add[classid])
	{printerror("MustEnter","history.go(-1)");}
	//操作权限
	CheckLevel($userid,$username,$classid,"picnews");
	$add[classid]=(int)$add[classid];
	$border=(int)$border;
	$sql=$empire->query("update {$dbtbpre}enewspic set title='$title',pic_url='$pic_url',url='$url',pic_width='$pic_width',pic_height='$pic_height',open_pic='$open_pic',border=$border,pictext='$pictext',classid=$add[classid] where picid='$picid'");
	//生成js
	GetPicJs($picid);
	if($sql)
	{
		//操作日志
		insert_dolog("picid=".$picid."<br>title=".$title);
		printerror("EditPicNewsSuccess","ListPicNews.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除图片信息
function DelPicNews($picid,$userid,$username){
	global $empire,$dbtbpre;
	$picid=(int)$picid;
	if(!$picid)
	{printerror("NotDelPicnewsid","history.go(-1)");}
	//操作权限
	CheckLevel($userid,$username,$classid,"picnews");
	$r=$empire->fetch1("select title from {$dbtbpre}enewspic where picid='$picid'");
	$sql=$empire->query("delete from {$dbtbpre}enewspic where picid='$picid'");
	//删除图片js
	DelPicJs($picid);
	if($sql)
	{
		//操作日志
		insert_dolog("picid=".$picid."<br>title=".$r[title]);
		printerror("DelPicNewsSuccess","ListPicNews.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//批量删除图片信息
function DelPicNews_all($picid,$userid,$username){
	global $empire,$dbtbpre;
	//操作权限
	CheckLevel($userid,$username,$classid,"picnews");
	$count=count($picid);
	if(!$count)
	{printerror("NotDelPicnewsid","history.go(-1)");}
	for($i=0;$i<$count;$i++)
	{
		$picid[$i]=(int)$picid[$i];
		$add.="picid='$picid[$i]' or ";
		//删除图片js
		DelPicJs($picid[$i]);
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("delete from {$dbtbpre}enewspic where ".$add);
	if($sql)
	{
		//操作日志
		insert_dolog("");
		printerror("DelPicNewsSuccess","ListPicNews.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//增加图片新闻
if($enews=="AddPicNews")
{
	$add=$_POST['add'];
	$title=$_POST['title'];
	$pic_url=$_POST['pic_url'];
	$url=$_POST['url'];
	$pic_width=$_POST['pic_width'];
	$pic_height=$_POST['pic_height'];
	$open_pic=$_POST['open_pic'];
	$border=$_POST['border'];
	$pictext=$_POST['pictext'];
	AddPicNews($add,$title,$pic_url,$url,$pic_width,$pic_height,$open_pic,$border,$pictext,$logininid,$loginin);
}
//修改图片新闻
elseif($enews=="EditPicNews")
{
	$add=$_POST['add'];
	$picid=$_POST['picid'];
	$title=$_POST['title'];
	$pic_url=$_POST['pic_url'];
	$url=$_POST['url'];
	$pic_width=$_POST['pic_width'];
	$pic_height=$_POST['pic_height'];
	$open_pic=$_POST['open_pic'];
	$border=$_POST['border'];
	$pictext=$_POST['pictext'];
	EditPicNews($add,$picid,$title,$pic_url,$url,$pic_width,$pic_height,$open_pic,$border,$pictext,$logininid,$loginin);
}
//删除图片新闻
elseif($enews=="DelPicNews")
{
	$picid=$_GET['picid'];
	DelPicNews($picid,$logininid,$loginin);
}
//批量删除图片新闻
elseif($enews=="DelPicNews_all")
{
	$picid=$_POST['picid'];
	DelPicNews_all($picid,$logininid,$loginin);
}

$start=0;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$add="";
$search="";
$search.=$ecms_hashur['ehref'];
$classid=(int)$_GET['classid'];
if($classid)
{
	$add=" where classid='$classid'";
    $search.="&classid=$classid";
}
$line=10;//每行显示
$page_line=15;
$offset=$page*$line;
$totalquery="select count(*) as total from {$dbtbpre}enewspic".$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query="select picid,title,pic_url,url,pic_width,pic_height,open_pic,border,pictext from {$dbtbpre}enewspic".$add;
$query.=" order by picid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//图片类别
$csql=$empire->query("select classid,classname from {$dbtbpre}enewspicclass order by classid");
while($cr=$empire->fetch($csql))
{
	if($classid==$cr[classid])
	{$select=" selected";}
	else
	{$select="";}
	$class.="<option value=".$cr[classid].$select.">".$cr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理图片信息</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置：<a href="ListPicNews.php<?=$ecms_hashur['whehref']?>">管理图片信息</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加图片信息" onclick="self.location.href='AddPicNews.php?enews=AddPicNews<?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit52" value="管理图片信息分类" onclick="self.location.href='PicClass.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td>分类：
      <select name="classid" id="classid" onchange=window.location='ListPicNews.php?<?=$ecms_hashur['ehref']?>&classid='+this.options[this.selectedIndex].value>
        <option value="0">所有类别</option>
		<?=$class?>
      </select></td>
  </tr>
</table>
<form name="form1" method="post" action="ListPicNews.php" onsubmit="return confirm('确认要删除?');">
<input type=hidden name=enews value=DelPicNews_all>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="10%" height="25"><div align="center">ID</div></td>
      <td width="64%" height="25"><div align="center">预览</div></td>
      <td width="26%" height="25"><div align="center">操作</div></td>
    </tr>
    <?
	while($r=$empire->fetch($sql))
	{
	?>
    <tr bgcolor="#FFFFFF" id=pic<?=$r[picid]?>> 
      <td height="25"><div align="center">
          <?=$r[picid]?>
        </div></td>
      <td height="25"><div align="center"><a href="<?=$r[url]?>" target="<?=$r[open_pic]?>" title="<?=$r[title]?>"><img src="<?=$r[pic_url]?>" height="<?=$r[pic_height]?>" width="<?=$r[pic_width]?>" border="<?=$r[border]?>"></a><br>
          <?=$r[title]?>
        </div></td>
      <td height="25"><div align="center">[<a href="AddPicNews.php?enews=EditPicNews&picid=<?=$r[picid]?><?=$ecms_hashur['ehref']?>">修改</a>] 
          [<a href="ListPicNews.php?enews=DelPicNews&picid=<?=$r[picid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除?');">删除</a> 
          <input name="picid[]" type="checkbox" id="picid[]" value="<?=$r[picid]?>" onclick="if(this.checked){pic<?=$r[picid]?>.style.backgroundColor='#DBEAF5';}else{pic<?=$r[picid]?>.style.backgroundColor='#ffffff';}">
          ]</div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3">&nbsp;
        <?=$returnpage?>
        &nbsp;&nbsp;
        <input type="submit" name="Submit" value="批量删除"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25" colspan="3"><font color="#666666">JS调用方式：&lt;script src= 
        <?=$public_r[newsurl]?>
        d/js/pic/pic_图片信息ID.js&gt;&lt;/script&gt;</font></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
