<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require("../data/dbcache/class.php");
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

//排行显示
function ecmsShowInfoTop($query,$where,$field,$topnum,$day){
	global $empire,$dbtbpre,$class_r;
	if($day)
	{
		$and=$where?' and ':' where ';
		$query.=$and."newstime>=".time()."-".($day*24*3600);
	}
	if($field=='plnum')
	{
		$word='评论数';
	}
	elseif($field=='totaldown')
	{
		$word='下载数';
	}
	elseif($field=='onclick')
	{
		$word='点击数';
	}
	$query.=" order by ".$field." desc limit ".$topnum;
	echo"<table width='100%' border='0' cellpadding='3' cellspacing='1' class='tableborder'><tr><td width='85%'>标题</td><td width='15%'>$word</td></tr>";
	$sql=$empire->query($query);
	while($r=$empire->fetch($sql))
	{
		$classurl=sys_ReturnBqClassname($r,9);
		$titleurl=sys_ReturnBqTitleLink($r);
		echo"<tr bgcolor='#ffffff' height='23'><td>[<a href='".$classurl."' target='_blank'>".$class_r[$r[classid]][classname]."</a>] <a href='$titleurl' target='_blank' title='发布时间：".date("Y-m-d H:i:s",$r[newstime])."'>".stripSlashes($r[title])."</a></td><td>".$r[$field]."</td></tr>";
	}
	echo"</table>";
}

$where='';
//数据表
$tbname=RepPostVar($_GET['tbname']);
if(empty($tbname))
{
	$tbname=$public_r['tbname'];
}
$htb=0;
$tbsql=$empire->query("select tbname,tname from {$dbtbpre}enewstable order by tid");
while($tbr=$empire->fetch($tbsql))
{
	$select="";
	if($tbr[tbname]==$tbname)
	{
		$htb=1;
		$select=" selected";
	}
	$tbs.="<option value='".$tbr[tbname]."'".$select.">".$tbr[tname]."</option>";
}
if($htb==0)
{
	printerror('ErrorUrl','');
}
//栏目
$classid=(int)$_GET['classid'];
if($classid)
{
	$and=$where?' and ':' where ';
	if($class_r[$classid][islast])
	{
		$where.=$and."classid='$classid'";
	}
	else
	{
		$where.=$and."(".ReturnClass($class_r[$classid][sonclass]).")";
	}
}
//标题分类
$ttid=(int)$_GET['ttid'];
if($ttid)
{
	$and=$where?' and ':' where ';
	$where.=$and." ttid='$ttid'";
}
$ttclass="";
$tt_sql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype order by typeid");
while($tt_r=$empire->fetch($tt_sql))
{
	$selected='';
	if($tt_r[typeid]==$ttid)
	{
		$selected=" selected";
	}
	$ttclass.="<option value='".$tt_r[typeid]."'".$selected.">".$tt_r[tname]."</option>";
}
//字段
$myorder=(int)$_GET['myorder'];
if($myorder==1)
{
	$field='plnum';
}
elseif($myorder==2)
{
	$field='totaldown';
}
else
{
	$field='onclick';
}
//搜索
if($_GET['keyboard'])
{
	$and=$where?' and ':' where ';
	$keyboard=RepPostVar2($_GET['keyboard']);
	$show=RepPostStr($_GET['show'],1);
	if($show==0)//搜索标题
	{
		$where.=$and."title like '%$keyboard%'";
	}
	else//搜索作者
	{
		$where.=$and."username like '%$keyboard%'";
	}
}
//显示条数
$topnum=(int)$_GET['topnum'];
if($topnum<1||$topnum>100)
{
	$topnum=10;
}
$query="select id,title,classid,newstime,isurl,titleurl,".$field." from {$dbtbpre}ecms_".$tbname.$where;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>信息排行</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<a href="infotop.php<?=$ecms_hashur['whehref']?>">信息排行</a></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<form name="searchform" method="GET" action="infotop.php">
<?=$ecms_hashur['eform']?>
  <tr>
      <td>数据表 
        <select name="tbname" id="tbname">
		<?=$tbs?>
        </select>
        ，栏目 <span id="listfileclassnav"></span> ，标题分类 
        <select name="ttid" id="ttid">
            <option value="0">所有专题</option>
            <?=$ttclass?>
        </select>
        ，排行 
        <select name="myorder" id="myorder">
          <option value="0"<?=$myorder==0?' selected':''?>>点击排行</option>
          <option value="1"<?=$myorder==1?' selected':''?>>评论排行</option>
          <option value="2"<?=$myorder==2?' selected':''?>>下载排行</option>
        </select>
        ，显示 
        <input name="topnum" type="text" id="topnum" value="<?=$topnum?>" size="6">
        ，关键字
<input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
        <select name="show" id="show">
          <option value="0"<?=$show==0?' selected':''?>>标题</option>
          <option value="1"<?=$show==1?' selected':''?>>发布者</option>
        </select> 
        <input type="submit" name="Submit" value="显示排行"></td>
  </tr>
</form>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr valign="top"> 
    <td width="50%"> 
      <table width="98%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">24小时排行</td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF">
            <?php ecmsShowInfoTop($query,$where,$field,$topnum,1);?>
          </td>
        </tr>
      </table></td>
    <td width="50%"><table width="98%" border="0" align="right" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">一周排行</td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF"> 
            <?php ecmsShowInfoTop($query,$where,$field,$topnum,7);?>
          </td>
        </tr>
      </table> </td>
  </tr>
  <tr valign="top"> 
    <td> 
      <table width="98%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">一个月排行</td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF">
            <?php ecmsShowInfoTop($query,$where,$field,$topnum,30);?>
          </td>
        </tr>
      </table></td>
    <td><table width="98%" border="0" align="right" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">三个月排行</td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF">
            <?php ecmsShowInfoTop($query,$where,$field,$topnum,90);?>
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
  <tr valign="top"> 
    <td><table width="98%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">一年排行</td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF"> 
            <?php ecmsShowInfoTop($query,$where,$field,$topnum,365);?>
          </td>
        </tr>
      </table> </td>
    <td><table width="98%" border="0" align="right" cellpadding="3" cellspacing="1" class="tableborder">
        <tr class="header"> 
          <td height="25">所有排行</td>
        </tr>
        <tr> 
          <td height="25" bgcolor="#FFFFFF">
            <?php ecmsShowInfoTop($query,$where,$field,$topnum,0);?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<IFRAME frameBorder="0" id="showclassnav" name="showclassnav" scrolling="no" src="ShowClassNav.php?ecms=5&classid=<?=$classid?><?=$ecms_hashur['ehref']?>" style="HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1"></IFRAME>
</body>
</html>
<?php
db_close();
$empire=null;
?>