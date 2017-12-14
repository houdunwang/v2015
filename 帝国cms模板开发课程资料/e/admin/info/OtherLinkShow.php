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

$classid=(int)$_GET['classid'];
$id=(int)$_GET['id'];
$enews=ehtmlspecialchars($_GET['enews']);
$keyid=RepPostVar($_GET['keyid']);
$delid=(int)$_GET['delid'];
if(!$classid||!$class_r[$classid]['tbname'])
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>相关链接</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
<?php
$ids='';
$retids='';
if($keyid)
{
	$showlinknum=$class_r[$classid]['link_num'];
	if(!$showlinknum)
	{
		$showlinknum=10;
	}
	$dh='';
	$keyr=explode(',',$keyid);
	$count=count($keyr);
	$showno=0;
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$keyr[$i];
		if(!$infoid||$infoid==$delid)
		{
			continue;
		}
		if($showno>$showlinknum)
		{
			break;
		}
		$ids.=$dh.$infoid;
		$dh=',';
		$showno++;
	}
	if($ids)
	{
	$dh='';
	$infosql=$empire->query("select isurl,titleurl,classid,id,newstime,username,userid,title from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id in (".$ids.") order by newstime desc limit ".$showlinknum);
	while($infor=$empire->fetch($infosql))
	{
		$retids.=$dh.$infor['id'];
		$dh=',';
		$titleurl=sys_ReturnBqTitleLink($infor);
		?>
          <tr bgcolor="#ffffff" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
            <td width="11%" height="25"> <div align="center">
                <?=$infor['id']?>
              </div></td>
            <td width="75%"><a href="<?=$titleurl?>" target="_blank" title="发布时间：<?=date('Y-m-d H:i:s',$infor['newstime'])?>">
              <?=stripSlashes($infor['title'])?>
              </a></td>
            <td width="14%"><div align="center"><a href="OtherLinkShow.php?classid=<?=$classid?>&id=<?=$id?>&enews=<?=$enews?>&keyid=<?=$ids?>&delid=<?=$infor['id']?><?=$ecms_hashur['ehref']?>" onclick="return confirm('确认要从相关链接移除?');">删</a></div></td>
          </tr>
	<?php
	}
	}
}	
?>
</table>
<script>
parent.document.otherlinkform.returnkeyid.value='<?=$retids?>';
parent.document.searchinfoform.returnkeyid.value='<?=$retids?>';
</script>
</body>
</html>
<?php
db_close();
$empire=null;
?>
