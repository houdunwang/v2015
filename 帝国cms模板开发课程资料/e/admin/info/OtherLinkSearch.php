<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require '../'.LoadLang("pub/fun.php");
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

$pclassid=(int)$_GET['pclassid'];
$pid=(int)$_GET['pid'];
$enews=ehtmlspecialchars($_GET['enews']);
$keyid=RepPostVar($_GET['keyid']);
$keyboard=RepPostVar2($_GET['keyboard']);
$show=(int)$_GET['show'];
$sear=(int)$_GET['sear'];
$returnkeyid=RepPostVar($_GET['returnkeyid']);
$classid=(int)$_GET['classid'];
if(!$pclassid||!$class_r[$pclassid]['tbname']||!trim($keyboard))
{
	exit();
}
$search="&pclassid=$pclassid&pid=$pid&enews=$enews&keyid=$keyid&keyboard=$keyboard&show=$show&sear=$sear&returnkeyid=$returnkeyid&classid=$classid".$ecms_hashur['ehref'];
$add='';
//分页
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;//每页显示条数
$page_line=6;//每页显示链接数
$offset=$page*$line;//总偏移量
//已选信息
$ids='';
$dh='';
$keyr=explode(',',$returnkeyid);
$count=count($keyr);
for($i=0;$i<$count;$i++)
{
	$infoid=(int)$keyr[$i];
	if(!$infoid)
	{
		continue;
	}
	$ids.=$dh.$infoid;
	$dh=',';
}
if($ids)
{
	if($pid)
	{
		$ids.=','.$pid;
	}
}
else
{
	$ids=$pid;
}
//栏目
if($classid)
{
	if($class_r[$classid][islast])
	{
		$add.=" and classid='$classid'";
	}
	else
	{
		$add.=" and (".ReturnClass($class_r[$classid][sonclass]).")";
	}
}
//搜索
if($keyboard)
{
	$kbr=explode(' ',$keyboard);
	$kbcount=count($kbr);
	$kbor='';
	$kbwhere='';
	for($kbi=0;$kbi<$kbcount;$kbi++)
	{
		if(!$kbr[$kbi])
		{
			continue;
		}
		if($show==1)
		{
			$kbwhere.=$kbor."title like '%".$kbr[$kbi]."%'";
		}
		elseif($show==2)
		{
			$kbwhere.=$kbor."keyboard like '%".$kbr[$kbi]."%'";
		}
		else
		{
			$kbwhere.=$kbor."id='".$kbr[$kbi]."'";
		}
		$kbor=' or ';
	}
	if($kbwhere)
	{
		$add.=' and ('.$kbwhere.')';
	}
}
$query="select isurl,titleurl,classid,id,newstime,username,userid,title from {$dbtbpre}ecms_".$class_r[$pclassid][tbname]." where id not in (".$ids.")".$add;
$totalquery="select count(*) as total from {$dbtbpre}ecms_".$class_r[$pclassid][tbname]." where id not in (".$ids.")".$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by newstime desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>相关链接</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function AddKeyid(infoid){
	var str;
	var r;
	var kr;
	var keyid;
	var ckinfoid;
	var showlinknum=<?=$class_r[$pclassid]['link_num']?>;
	keyid=parent.document.otherlinkform.returnkeyid.value;
	str=','+keyid+',';
	ckinfoid=','+infoid+',';
	r=str.split(ckinfoid);
	if(r.length!=1)
	{
		alert('此信息已添加');
		return false;
	}
	kr=keyid.split(',');
	if(kr.length>=showlinknum)
	{
		alert('添加数量已超过栏目设定('+showlinknum+'个)');
		return false;
	}
	if(keyid=='')
	{
		keyid=infoid;
	}
	else
	{
		keyid+=','+infoid;
	}
	parent.showinfopage.location.href='OtherLinkShow.php?<?=$ecms_hashur['ehref']?>&classid=<?=$pclassid?>&id=<?=$pid?>&enews=<?=$enews?>&keyid='+keyid;
	//document.getElementById('doaddkey'+infoid).innerHTML='---';
}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
<?php
while($infor=$empire->fetch($sql))
{
	$titleurl=sys_ReturnBqTitleLink($infor);
	?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td width="11%" height="25"> 
      <div align="center"> 
        <?=$infor['id']?>
      </div></td>
    <td width="75%"><a href="<?=$titleurl?>" target="_blank" title="发布时间：<?=date('Y-m-d H:i:s',$infor['newstime'])?>"> 
      <?=stripSlashes($infor['title'])?>
      </a></td>
    <td width="14%"><div align="center" id="doaddkey<?=$infor['id']?>"><a href="#empirecms" onclick="AddKeyid('<?=$infor['id']?>');">添加</a></div></td>
  </tr>
<?php
}
?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="3"> 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>