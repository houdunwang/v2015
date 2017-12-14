<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
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

//审核
$ecmscheck=(int)$_GET['ecmscheck'];
$addecmscheck='';
$indexchecked=1;
if($ecmscheck)
{
	$addecmscheck='&ecmscheck='.$ecmscheck;
	$indexchecked=0;
}
//是否关闭
$isclose=(int)$_GET['isclose'];
if($isclose)
{
	$reload=(int)$_GET['reload'];
	$reloadjs='';
	if($reload)
	{
		$reloadjs='opener.parent.main.location.reload();';
	}
	echo"<script>".$reloadjs."window.close();</script>";
	exit();
}

$classid=(int)$_GET['classid'];
if(empty($class_r[$classid][classid]))
{
	printerror("ErrorUrl","history.go(-1)");
}
//验证权限
$doselfinfo=CheckLevel($logininid,$loginin,$classid,"news");
if(!$class_r[$classid][tbname]||!$class_r[$classid][classid])
{
	printerror("ErrorUrl","history.go(-1)");
}
//非终极栏目
if(!$class_r[$classid]['islast'])
{
	printerror("AddInfoErrorClassid","history.go(-1)");
}
$bclassid=$class_r[$classid][bclassid];
$id=(int)$_GET['id'];
//附件验证码
if(!$doselfinfo['doeditinfo'])//编辑权限
{
	printerror("NotEditInfoLevel","EditInfoSimple.php?isclose=1".$ecms_hashur['ehref']);
}
$filepass=$id;
$ecmsfirstpost=0;
//模型
$modid=$class_r[$classid][modid];
$enter=$emod_r[$modid]['enter'];
//会员组
$sql1=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	$ygroup.="<option value=".$l_r[groupid].">".$l_r[groupname]."</option>";
}
//初始化数据
$r=array();
$todaytime=date("Y-m-d H:i:s");

//-----------------------------------------修改信息
//索引表
$index_r=$empire->fetch1("select classid,id,checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$id' limit 1");
if(!$index_r['id']||$index_r['classid']!=$classid)
{
	printerror("ErrorUrl","history.go(-1)");
}
//返回表
$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
//主表
$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");
//返回表信息
$infodatatb=ReturnInfoDataTbname($class_r[$classid][tbname],$index_r['checked'],$r['stb']);
//副表
$finfor=$empire->fetch1("select closepl from ".$infodatatb." where id='$id'");
$r=array_merge($r,$finfor);
//签发表
if($r[isqf])
{
	$wfinfor=$empire->fetch1("select tstatus,checktno from {$dbtbpre}enewswfinfo where id='$id' and classid='$classid' limit 1");
}
//只能编辑自己的信息
if($doselfinfo['doselfinfo']&&($r[userid]<>$logininid||$r[ismember]))
{
	printerror("NotDoSelfinfo","EditInfoSimple.php?isclose=1".$ecms_hashur['ehref']);
}
//已审核信息不可修改
if($doselfinfo['docheckedit']&&$index_r['checked'])
{
	printerror("NotEditCheckInfoLevel","EditInfoSimple.php?isclose=1".$ecms_hashur['ehref']);
}
//时间
$newstime=$r['newstime'];
$r['newstime']=date("Y-m-d H:i:s",$r['newstime']);
//链接地址
$titleurl=$r['titleurl'];
if(!$r['isurl'])
{
	$r['titleurl']='';
}
//会员组
$group=str_replace(" value=".$r[groupid].">"," value=".$r[groupid]." selected>",$ygroup);
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
//标题分类
$cttidswhere='';
$tts='';
$caddr=$empire->fetch1("select ttids from {$dbtbpre}enewsclassadd where classid='$classid'");
if($caddr['ttids']!='-')
{
	if($caddr['ttids']&&$caddr['ttids']!=',')
	{
		$cttidswhere=' and typeid in ('.substr($caddr['ttids'],1,-1).')';
	}
	$ttsql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype where mid='$modid'".$cttidswhere." order by myorder");
	while($ttr=$empire->fetch($ttsql))
	{
		$select='';
		if($ttr[typeid]==$r[ttid])
		{
			$select=' selected';
		}
		$tts.="<option value='$ttr[typeid]'".$select.">$ttr[tname]</option>";
	}
}
//栏目链接
$getcurlr['classid']=$classid;
$classurl=sys_ReturnBqClassname($getcurlr,9);
//当前使用的模板组
$thegid=GetDoTempGid();
$phpmyself=urlencode(eReturnSelfPage(1));
//返回头条和推荐级别名称
$ftnr=ReturnFirsttitleNameList($r['firsttitle'],$r['isgood']);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=stripSlashes($r[title])?></title>
<link rel="stylesheet" href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" type="text/css">
<script>
function foreColor(){
  if(!Error())	return;
  var arr = showModalDialog("../../data/html/selcolor.html", "", "dialogWidth:18.5em; dialogHeight:17.5em; status:0");
  if (arr != null) document.add.titlecolor.value=arr;
  else document.add.titlecolor.focus();
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="add" method="post" action="../ecmsinfo.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> 快速修改信息基本属性 
        <input type=hidden value=EditInfoSimple name=enews> <input type=hidden value=<?=$classid?> name=classid> 
        <input type=hidden value=<?=$bclassid?> name=bclassid> <input name=id type=hidden value=<?=$id?>> 
        <input type=hidden value="<?=$r[newspath]?>" name=newspath> <input type=hidden value="<?=$r[ztid]?>" name=oldztid> 
        <input type=hidden value="<?=$filepass?>" name=filepass> <input type=hidden value="<?=$r[username]?>" name=username> 
        <input name="oldfilename" type="hidden" value="<?=$r[filename]?>"> <input name="oldgroupid" type="hidden" value="<?=$r[groupid]?>"> 
        <input name="oldchecked" type="hidden" value="<?=$index_r[checked]?>">
        <input name="ecmsfrom" type="hidden" value="<?=RepPostStrUrl($_SERVER['HTTP_REFERER'])?>"> 
        <input name="ecmsnfrom" type="hidden" value="<?=RepPostStrUrl($_GET['ecmsnfrom'])?>">
		<input name="ecmscheck" type="hidden" id="ecmscheck" value="<?=$ecmscheck?>">
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="16%" height="25">标题</td>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#DBEAF5">
          <tr> 
            <td height="25" bgcolor="#FFFFFF"> 
              <?=$tts?"<select name='ttid'><option value='0'>标题分类</option>$tts</select>":""?>
              <input type=text name=title value="<?=ehtmlspecialchars(stripSlashes($r[title]))?>" size="60"> 
            </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF">属性: 
              <input name="titlefont[b]" type="checkbox" value="b"<?=$titlefontb?>>
              粗体 
              <input name="titlefont[i]" type="checkbox" value="i"<?=$titlefonti?>>
              斜体 
              <input name="titlefont[s]" type="checkbox" value="s"<?=$titlefonts?>>
              删除线 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;颜色: 
              <input name="titlecolor" type="text" value="<?=stripSlashes($r[titlecolor])?>" size="10"> 
              <a onclick="foreColor();"><img src="../../data/images/color.gif" width="21" height="21" align="absbottom"></a> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">特殊属性</td>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#DBEAF5">
          <tr> 
            <td height="25" bgcolor="#FFFFFF">信息属性: 
              <input name="checked" type="checkbox" value="1"<?=$index_r[checked]?' checked':''?>>
              审核 &nbsp;&nbsp; 推荐
              <select name="isgood" id="isgood">
                <option value="0"<?=$r[isgood]==0?' selected':''?>>不推荐</option>
                <?=$ftnr['igname']?>
              </select>
              &nbsp;&nbsp; 头条 
              <select name="firsttitle" id="firsttitle">
                <option value="0"<?=$r[firsttitle]==0?' selected':''?>>非头条</option>
                <?=$ftnr['ftname']?>
              </select> </td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#FFFFFF">外部链接: 
              <input name="titleurl" type="text" value="<?=stripSlashes($r[titleurl])?>" size="49"> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">发布时间</td>
      <td><input name="newstime" type="text" value="<?=$r[newstime]?>"> <input type=button name=button2 value="设为当前时间" onclick="document.add.newstime.value='<?=$todaytime?>'"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">标题图片</td>
      <td><input name="titlepic" type="text" id="titlepic" value="<?=$ecmsfirstpost==1?"":ehtmlspecialchars(stripSlashes($r[titlepic]))?>" size="45"> 
        <a onclick="window.open('../ecmseditor/FileMain.php?type=1&classid=<?=$classid?>&infoid=<?=$id?>&filepass=<?=$filepass?>&doing=1&field=titlepic&sinfo=1<?=$ecms_hashur['ehref']?>','','width=700,height=550,scrollbars=yes');" title="选择已上传的图片"><img src="../../data/images/changeimg.gif" border="0" align="absbottom"></a> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="2">其它选项</td>
      <td height="25">置顶级别: 
        <select name="istop">
          <option value="0"<?=$r[istop]==0?' selected':''?>>不置顶</option>
          <option value="1"<?=$r[istop]==1?' selected':''?>>一级置顶</option>
          <option value="2"<?=$r[istop]==2?' selected':''?>>二级置顶</option>
          <option value="3"<?=$r[istop]==3?' selected':''?>>三级置顶</option>
          <option value="4"<?=$r[istop]==4?' selected':''?>>四级置顶</option>
          <option value="5"<?=$r[istop]==5?' selected':''?>>五级置顶</option>
          <option value="6"<?=$r[istop]==6?' selected':''?>>六级置顶</option>
          <option value="7"<?=$r[istop]==7?' selected':''?>>七级置顶</option>
          <option value="8"<?=$r[istop]==8?' selected':''?>>八级置顶</option>
		  <option value="9"<?=$r[istop]==9?' selected':''?>>九级置顶</option>
        </select>
        , 
        <input type=checkbox name=closepl value=1<?=$r[closepl]==1?" checked":""?>>
        关闭评论</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">点击数&nbsp;&nbsp;&nbsp;: 
        <input name="onclick" type="text" id="onclick2" value="<?=$r[onclick]?>" size="8">
        下载数&nbsp;&nbsp;&nbsp;: 
        <input name="totaldown" type="text" id="totaldown2" value="<?=$r[totaldown]?>" size="8"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td><input type="submit" name="addnews" value=" 提 交 "> &nbsp;&nbsp;&nbsp; 
        <input type="reset" name="Submit2" value="重置">
        &nbsp;&nbsp;&nbsp; <input type="button" name="Submit22" value="取消" onclick="window.close();"></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>