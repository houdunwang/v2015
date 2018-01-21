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

//返回碎片信息内容
function ReturnSpInfoidGetData($add,$userid,$username){
	global $empire,$dbtbpre,$class_r,$emod_r;
	$idr=explode(',',$add['getinfoid']);
	$classid=(int)$idr[0];
	$id=(int)$idr[1];
	if(!$classid||!$id||!$class_r[$classid][tbname])
	{
		return '';
	}
	$mid=$class_r[$classid]['modid'];
	$smalltextf=$emod_r[$mid]['smalltextf'];
	$sf='';
	if($smalltextf&&$smalltextf<>',')
	{
		$smr=explode(',',$smalltextf);
		$sf=$smr[1];
	}
	$addf='';
	if($sf&&!strstr($emod_r[$mid]['tbdataf'],','.$sf.','))
	{
		$addf=','.$sf;
	}
	$index_r=$empire->fetch1("select id,checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$id' limit 1");
	if(!$index_r['id'])
	{
		return '';
	}
	//返回表
	$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
	$infor=$empire->fetch1("select id,classid,isurl,titleurl,isgood,firsttitle,plnum,totaldown,onclick,newstime,titlepic,title,stb".$addf." from ".$infotb." where id='$id' limit 1");
	if($sf&&!$addf)
	{
		//返回表信息
		$infodatatb=ReturnInfoDataTbname($class_r[$classid][tbname],$index_r['checked'],$infor['stb']);
		$finfor=$empire->fetch1("select ".$sf." from ".$infodatatb." where id='$id' limit 1");
		$infor[$sf]=$finfor[$sf];
	}
	$ret_r['title']=$infor[title];
	$ret_r['titleurl']=sys_ReturnBqTitleLink($infor);
	$ret_r['titlepic']=$infor[titlepic];
	$ret_r['smalltext']=$infor[$sf];
	$ret_r['newstime']=$infor[newstime];
	return $ret_r;
}

$spid=(int)$_GET['spid'];
//碎片
$spr=$empire->fetch1("select spid,spname,varname,sptype,maxnum,groupid,userclass,username from {$dbtbpre}enewssp where spid='$spid'");
if(!$spr['spid'])
{
	printerror('ErrorUrl','');
}
//验证操作权限
CheckDoLevel($lur,$spr[groupid],$spr[userclass],$spr[username]);
$enews=ehtmlspecialchars($_GET['enews']);
$postword='增加碎片信息';
$todaytime=date("Y-m-d H:i:s");
$url="<a href=UpdateSp.php".$ecms_hashur['whehref'].">更新碎片</a>&nbsp;>&nbsp;<a href=ListSpInfo.php?spid=$spid".$ecms_hashur['ehref'].">".$spr[spname]."</a>&nbsp;>&nbsp;增加碎片信息";
$filepass=$spid;
//修改
if($enews=="EditSpInfo")
{
	$postword='修改碎片信息';
	$sid=(int)$_GET['sid'];
	if($spr[sptype]==1)
	{
		$r=$empire->fetch1("select * from {$dbtbpre}enewssp_1 where sid='$sid' and spid='$spid'");
		$newstime=date('Y-m-d H:i:s',$r[newstime]);
		//标题属性
		if(strstr($r[titlefont],','))
		{
			$tfontr=explode(',',$r[titlefont]);
			$r[titlecolor]=$tfontr[0];
			$r[titlefont]=$tfontr[1];
		}
		if(strstr($r[titlefont],"b|"))
		{
			$titlefontb=" checked";
		}
		if(strstr($r[titlefont],"i|"))
		{
			$titlefonti=" checked";
		}
		if(strstr($r[titlefont],"s|"))
		{
			$titlefonts=" checked";
		}
		$url="<a href=UpdateSp.php".$ecms_hashur['whehref'].">更新碎片</a>&nbsp;>&nbsp;<a href=ListSpInfo.php?spid=$spid".$ecms_hashur['ehref'].">".$spr[spname]."</a>&nbsp;>&nbsp;修改碎片信息";
	}
	elseif($spr[sptype]==2)
	{
		$r=$empire->fetch1("select * from {$dbtbpre}enewssp_2 where sid='$sid' and spid='$spid'");
		$newstime=date('Y-m-d H:i:s',$r[newstime]);
		$url="<a href=UpdateSp.php".$ecms_hashur['whehref'].">更新碎片</a>&nbsp;>&nbsp;<a href=ListSpInfo.php?spid=$spid".$ecms_hashur['ehref'].">".$spr[spname]."</a>&nbsp;>&nbsp;修改碎片信息";
	}
	elseif($spr[sptype]==3)
	{
		$r=$empire->fetch1("select * from {$dbtbpre}enewssp_3 where spid='$spid' limit 1");
		$url="<a href=UpdateSp.php".$ecms_hashur['whehref'].">更新碎片</a>&nbsp;>&nbsp;".$spr[spname]."&nbsp;>&nbsp;修改碎片信息";
	}
}
//取得信息
$ecms=RepPostStr($_GET['ecms'],1);
if($ecms=='InfoidGetData')
{
	include("../../data/dbcache/class.php");
	$getinfor=ReturnSpInfoidGetData($_GET,$logininid,$loginin);
	if($getinfor['title'])
	{
		$r['title']=$getinfor['title'];
		$r['titlepic']=$getinfor['titlepic'];
		$r['titleurl']=$getinfor['titleurl'];
		$r['newstime']=$getinfor['newstime'];
		$r['smalltext']=$getinfor['smalltext'];
		$newstime=date('Y-m-d H:i:s',$r[newstime]);
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>碎片</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function foreColor(){
  if(!Error())	return;
  var arr = showModalDialog("../../data/html/selcolor.html", "", "dialogWidth:18.5em; dialogHeight:17.5em; status:0");
  if (arr != null) document.form1.titlecolor.value=arr;
  else document.form1.titlecolor.focus();
}
</script>
<script>
function ToGetInfo(){
	var infoid;
	infoid=prompt('请输入信息ID，格式：栏目ID,信息ID',',');
	if(infoid==''||infoid==null||infoid==',')
	{
		return false;
	}
	self.location.href='AddSpInfo.php?<?=$ecms_hashur['ehref']?>&enews=<?=$enews?>&spid=<?=$spid?>&sid=<?=$sid?>&ecms=InfoidGetData&getinfoid='+infoid;
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<?php
if($spr['sptype']==1)
{
?>
<form name="form1" method="post" action="ListSpInfo.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
	<?=$ecms_hashur['form']?>
  <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>">
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="14%" height="25">标题：</td>
      <td width="86%" height="25"><input name="title" type="text" id="title" size="60" value="<?=ehtmlspecialchars(stripSlashes($r[title]))?>">
        <input type="button" name="Submit5" value="通过信息ID获取" onclick="ToGetInfo();"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">标题链接：</td>
      <td height="25"><input name="titleurl" type="text" id="titleurl" size="60" value="<?=stripSlashes($r[titleurl])?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">标题属性：</td>
      <td height="25"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td> <input name="titlefont[b]" type="checkbox" value="b"<?=$titlefontb?>>
              粗体 
              <input name="titlefont[i]" type="checkbox" value="i"<?=$titlefonti?>>
              斜体 
              <input name="titlefont[s]" type="checkbox" value="s"<?=$titlefonts?>>
              删除线 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;颜色: 
              <input name="titlecolor" type="text" value="<?=stripSlashes($r[titlecolor])?>" size="10"> 
              <a onclick="foreColor();"><img src="../../data/images/color.gif" width="21" height="21" align="absbottom"></a></td>
          </tr>
          <tr> 
            <td>左边: 
              <input name="titlepre" type="text" id="titlepre3" value="<?=ehtmlspecialchars(stripSlashes($r[titlepre]))?>" size="21">
              右边: 
              <input name="titlenext" type="text" id="titlenext" value="<?=ehtmlspecialchars(stripSlashes($r[titlenext]))?>" size="21"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">标题缩图：</td>
      <td height="25"><input name="titlepic" type="text" id="titlepic" size="60" value="<?=stripSlashes($r[titlepic])?>">
        <a onclick="window.open('../ecmseditor/FileMain.php?<?=$ecms_hashur['ehref']?>&modtype=7&type=1&classid=&doing=2&field=titlepic&filepass=<?=$filepass?>&sinfo=1','','width=700,height=550,scrollbars=yes');" title="选择已上传的图片"><img src="../../data/images/changeimg.gif" alt="选择/上传图片" width="22" height="22" border="0" align="absbottom"></a></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">标题大图：</td>
      <td height="25"><input name="bigpic" type="text" id="bigpic" size="60" value="<?=stripSlashes($r[bigpic])?>">
        <a onclick="window.open('../ecmseditor/FileMain.php?<?=$ecms_hashur['ehref']?>&modtype=7&type=1&classid=&doing=2&field=bigpic&filepass=<?=$filepass?>&sinfo=1','','width=700,height=550,scrollbars=yes');" title="选择已上传的图片"><img src="../../data/images/changeimg.gif" alt="选择/上传图片" width="22" height="22" border="0" align="absbottom"></a></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">发布时间：</td>
      <td height="25"><input name="newstime" type="text" id="title3" size="60" value="<?=$newstime?>">
        <input type="button" name="Submit3" value="当前时间" onclick="document.form1.newstime.value='<?=$todaytime?>';"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">内容简介：</td>
      <td height="25"><textarea name="smalltext" cols="60" rows="5" id="smalltext"><?=ehtmlspecialchars(stripSlashes($r[smalltext]))?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="sid" type="hidden" id="sid" value="<?=$r['sid']?>"> 
        <input name="spid" type="hidden" id="spid" value="<?=$spid?>"></td>
    </tr>
  </table>
</form>
<?php
}
elseif($spr['sptype']==2)
{
?>
<form name="form1" method="post" action="ListSpInfo.php">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
	<?=$ecms_hashur['form']?>
  <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>">
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="14%" height="25">信息位置：</td>
      <td width="86%" height="25">栏目ID: 
        <input name="classid" type="text" id="titlepre5" value="<?=$r[classid]?>" size="21">
        信息ID: 
        <input name="id" type="text" id="classid" value="<?=$r[id]?>" size="21"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">发布时间：</td>
      <td height="25"><input name="newstime" type="text" id="newstime" size="60" value="<?=$newstime?>"> 
        <input type="button" name="Submit32" value="当前时间" onclick="document.form1.newstime.value='<?=$todaytime?>';"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit4" value="提交"> <input type="reset" name="Submit22" value="重置"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="sid" type="hidden" id="sid3" value="<?=$r['sid']?>"> 
        <input name="spid" type="hidden" id="spid" value="<?=$spid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25"><font color="#666666">不设置时间直接读取信息本身的发布时间.</font></td>
    </tr>
  </table>
</form>
<?php
}
elseif($spr['sptype']==3)
{
?>
	<script>
	function ReSpInfoBak(){
		self.location.href='AddSpInfo.php?<?=$ecms_hashur['ehref']?>&enews=EditSpInfo&spid=<?=$spid?>';
	}
	</script>
<form name="form1" method="post" action="ListSpInfo.php">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
		<?=$ecms_hashur['form']?>
  <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>">
    <tr class="header"> 
      <td height="25">
        <div align="center"><?=$postword?></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="86%" height="25"><div align="center"> 
          <textarea name="sptext" cols="80" rows="27" id="sptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[sptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="center"> 
          <input type="submit" name="Submit4" value="提交">&nbsp;&nbsp;
          &nbsp;&nbsp;<input type="reset" name="Submit22" value="重置">
          &nbsp;&nbsp; [<a href="#ecms" onclick="window.open('../template/editor.php?<?=$ecms_hashur['ehref']?>&getvar=opener.document.form1.sptext.value&returnvar=opener.document.form1.sptext.value&fun=ReturnHtml&notfullpage=1','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');">可视化编辑</a>]&nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('SpInfoBak.php?spid=<?=$r[spid]?>&sid=<?=$r['sid']?><?=$ecms_hashur['ehref']?>','ViewSpInfoBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
          <input name="enews" type="hidden" id="enews" value="<?=$enews?>">
          <input name="sid" type="hidden" id="sid" value="<?=$r['sid']?>">
          <input name="spid" type="hidden" id="spid" value="<?=$spid?>">
        </div></td>
    </tr>
  </table>
</form>
<?php
}
?>
</body>
</html>
<?php
db_close();
$empire=null;
?>