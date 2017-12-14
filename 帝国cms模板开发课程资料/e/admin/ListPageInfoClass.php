<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
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
//验证权限
CheckLevel($logininid,$loginin,$classid,"cj");

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$add="";
$search="";
$search.=$ecms_hashur['ehref'];
//搜索
if($_GET['sear'])
{
	$search.="&sear=1";
	//关键字
	$keyboard=RepPostVar2($_GET['keyboard']);
	if($keyboard)
	{
		$show=RepPostStr($_GET['show'],1);
		if($show==1)
		{
			$add=" where (classname like '%$keyboard%')";
		}
		elseif($show==2)
		{
			$add=" where (bz like '%$keyboard%')";
		}
		elseif($show==3)
		{
			$add=" where (infourl like '%$keyboard%')";
		}
		else
		{
			$add=" where (classname like '%$keyboard%' or bz like '%$keyboard%' or infourl like '%$keyboard%')";
		}
		$search.="&keyboard=$keyboard&show=$show";
	}
}
$totalquery="select count(*) as total from {$dbtbpre}enewsinfoclass".$add;
$query="select * from {$dbtbpre}enewsinfoclass".$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by classid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理节点</title>
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
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="50%">位置：采集 &gt; <a href="ListPageInfoClass.php<?=$ecms_hashur['whehref']?>">管理节点</a></td>
    <td><div align="right"> </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <form name="searchinfoclass" method="GET" action="ListPageInfoClass.php">
  <?=$ecms_hashur['eform']?>
    <tr>
      <td width="50%" class="emenubutton"><input type="button" name="Submit52" value="增加节点" onclick="self.location.href='AddInfoC.php?from=1<?=$ecms_hashur['ehref']?>';">
	  &nbsp;&nbsp;
        <input type="button" name="Submit52" value="导入采集规则" onclick="self.location.href='cj/LoadInCj.php?from=1<?=$ecms_hashur['ehref']?>';"></td>
      <td width="50%" height="32">
<div align="right">搜索: 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="0"<?=$show==0?' selected':''?>>不限</option>
            <option value="1"<?=$show==1?' selected':''?>>节点名称</option>
            <option value="2"<?=$show==2?' selected':''?>>备注</option>
            <option value="3"<?=$show==3?' selected':''?>>采集页面地址</option>
          </select>
          <input type="submit" name="Submit8" value="搜索">
          <input name="sear" type="hidden" id="sear" value="1">
        </div></td>
    </tr>
  </form>
</table>
<form name=form1 method=get action="DoCj.php" onsubmit="return confirm('确认要采集?');" target=_blank>
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=DoCj>
	<input type=hidden name=from value=1>
    <tr class="header"> 
      <td width="3%"><div align="center"></div></td>
      <td width="8%" height="25"> <div align="center">采集</div></td>
      <td width="27%" height="25"> <div align="center">节点(点击访问采集页)</div></td>
      <td width="6%" height="25"> <div align="center">预览</div></td>
      <td width="16%" height="25"> <div align="center">绑定栏目</div></td>
      <td width="9%" height="25"> <div align="center">审核采集</div></td>
      <td width="24%" height="25"> <div align="center">操作</div></td>
    </tr>
    <?php
	while($r=$empire->fetch($sql))
	{
		//采集页面
		$pager=explode("\r\n",$r[infourl]);
	    $infourl=$pager[0];
		if($r[newsclassid])
		{
			$lastcjtime=!$r['lasttime']?'从未采集':date("Y-m-d H:i:s",$r['lasttime']);
			$cj="<a href='DoCj.php?enews=CjUrl&classid[]=".$r[classid]."&from=1".$ecms_hashur['href']."' title='最后采集时间：".$lastcjtime."'><u>".$fun_r['StartCj']."</u></a>";
			$emptydb="&nbsp;[<a href='ListInfoClass.php?enews=EmptyCj&classid=$r[classid]&from=1".$ecms_hashur['href']."' onclick=\"return confirm('".$fun_r['CheckEmptyCjRecord']."');\">".$fun_r['EmptyCjRecord']."</a>]";
			$loadoutcj="&nbsp;[<a href=ecmscj.php?enews=LoadOutCj&classid=$r[classid]&from=1".$ecms_hashur['href']." onclick=\"return confirm('确认要导出?');\">导出</a>]";
			$checkbox="<input type=checkbox name=classid[] value='$r[classid]' onClick=\"if(this.checked){c".$r[classid].".style.backgroundColor='#DBEAF5';}else{c".$r[classid].".style.backgroundColor='#ffffff';}\">";
		}
		else
		{
			$cj=$fun_r['StartCj'];
			$emptydb="";
			$checkbox="";
		}
		//栏目链接
		$getcurlr['classid']=$r[newsclassid];
		$classurl=sys_ReturnBqClassname($getcurlr,9);
	?>
    <tr bgcolor="#FFFFFF" id="c<?=$r[classid]?>" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td> <div align="center">
          <?=$checkbox?>
        </div></td>
      <td height="25"> <div align="center">
          <?=$cj?>
        </div></td>
      <td height="25"> <div align="center"><a href='<?=$infourl?>' target=_blank>
          <?=$r[classname]?>
          </a></div></td>
      <td height="25"> <div align="center"><a href='ecmscj.php?enews=ViewCjList&classid=<?=$r[classid]?>&from=1<?=$ecms_hashur['href']?>' target=_blank>
          <?=$fun_r['view']?>
          </a></div></td>
      <td height="25"> <div align="center"><a href='<?=$classurl?>' target=_blank>
          <?=$class_r[$r[newsclassid]][classname]?>
          </a></div></td>
      <td height="25"> <div align="center"><a href='CheckCj.php?classid=<?=$r[classid]?>&from=1<?=$ecms_hashur['ehref']?>'>
          <?=$fun_r['CheckCj']?>
          </a></div></td>
      <td height="25"> <div align="center">
          <?="[<a href=AddInfoClass.php?enews=AddInfoClass&docopy=1&classid=".$r[classid]."&newsclassid=".$r[newsclassid]."&from=1".$ecms_hashur['ehref'].">".$fun_r['Copy']."</a>]&nbsp;[<a href=AddInfoClass.php?enews=EditInfoClass&classid=".$r[classid]."&from=1".$ecms_hashur['ehref'].">".$fun_r['edit']."</a>]&nbsp;[<a href=ListInfoClass.php?enews=DelInfoClass&classid=".$r[classid]."&from=1".$ecms_hashur['href']." onclick=\"return confirm('".$fun_r['CheckDelCj']."');\">".$fun_r['del']."</a>]".$emptydb.$loadoutcj;?>
        </div></td>
    </tr>
    <?php
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td> <div align="center"> 
          <input type=checkbox name=chkall value=on onClick="CheckAll(this.form)">
        </div></td>
      <td height="25" colspan="6"> <input type="submit" name="Submit" value="批量采集节点"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td height="25" colspan="6"> 
        <?=$returnpage?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td height="25" colspan="6"><font color="#666666">备注：弹出采集窗口，请按住&quot;Shift&quot;+点击”开始采集&quot;</font></td>
    </tr>
  </table>
  </form>
</body>
</html>
<?
db_close();
$empire=null;
?>
