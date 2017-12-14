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
//CheckLevel($logininid,$loginin,$classid,"table");
$url="<a href='ListTable.php".$ecms_hashur['whehref']."'>管理数据表</a>";
$sql=$empire->query("select tid,tname,tbname,isdefault from {$dbtbpre}enewstable order by tid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理数据表</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit" value="增加数据表" onclick="self.location.href='AddTable.php?enews=AddTable<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
		<input type="button" name="Submit" value="导入系统模型" onclick="self.location.href='LoadInM.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<br>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="35%" height="25"><div align="center">表名称</div></td>
    <td width="32%"><div align="center">管理</div></td>
    <td width="28%" height="25"><div align="center">操作</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
	//默认表
	if($r[isdefault])
	{
		$bgcolor="#DBEAF5";
		$movejs='';
	}
	else
	{
		$bgcolor="#ffffff";
		$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	}
  ?>
  <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
    <td height="32"><div align="center"> 
        <?=$r[tid]?>
      </div></td>
    <td height="25"> 
      <?=$r[tname]?>
      &nbsp;( <?=$dbtbpre?>ecms_<b><?=$r[tbname]?></b> ) </td>
    <td><div align="center">[<a href="#ecms" onclick="window.open('ListF.php?tid=<?=$r[tid]?>&tbname=<?=$r[tbname]?><?=$ecms_hashur['ehref']?>','','width=700,height=560,scrollbars=yes,top=70,left=100,resizable=yes');"><strong>管理字段</strong></a>] &nbsp;
        [<a href="#ecms" onclick="window.open('ListM.php?tid=<?=$r[tid]?>&tbname=<?=$r[tbname]?><?=$ecms_hashur['ehref']?>','','width=860,height=560,scrollbars=yes,top=70,left=100,resizable=yes');"><strong>管理系统模型</strong></a>] &nbsp;
        [<a href="#ecms" onclick="window.open('ListDataTable.php?tid=<?=$r[tid]?>&tbname=<?=$r[tbname]?><?=$ecms_hashur['ehref']?>','','width=700,height=560,scrollbars=yes,top=70,left=100,resizable=yes');"><strong>管理分表</strong></a>]</div></td>
    <td height="25"><div align="center"> [<a href="../ecmsmod.php?enews=DefaultTable&tid=<?=$r[tid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要默认?');"><strong>设为默认表</strong></a>] &nbsp;
        [<a href="CopyTable.php?enews=CopyNewTable&tid=<?=$r[tid]?><?=$ecms_hashur['ehref']?>"><strong>复制</strong></a>] &nbsp;
        [<a href="AddTable.php?enews=EditTable&tid=<?=$r[tid]?><?=$ecms_hashur['ehref']?>"><strong>修改</strong></a>] &nbsp;
        [<a href="../ecmsmod.php?enews=DelTable&tid=<?=$r[tid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除?');"><strong>删除</strong></a>] 
      </div></td>
  </tr>
  <?php
	}
	?>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>
