<?php
define('EmpireCMSAdmin','1');
require('../../class/connect.php');
require('../../class/db_sql.php');
require('../../class/functions.php');
require '../'.LoadLang('pub/fun.php');
require('../../data/dbcache/class.php');
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

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=intval($public_r['hlistinfonum']);//每页显示
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$add=" and (groupid like '%,".$lur[groupid].",%' or userclass like '%,".$lur[classid].",%' or username like '%,".$lur[username].",%')";
$totalquery="select count(*) as total from {$dbtbpre}enewswfinfo where checktno=0".$add;
$num=$empire->gettotal($totalquery);
$query="select id,classid,tstatus,checktno from {$dbtbpre}enewswfinfo where checktno=0".$add;
$query=$query." order by id desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理签发信息</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<a href="../ListAllInfo.php<?=$ecms_hashur['whehref']?>">管理信息</a> &gt; <a href="ListWfInfo.php<?=$ecms_hashur['whehref']?>">管理签发信息</a></td>
  </tr>
</table>
<br>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="">
    <tr class="header"> 
      <td width="6%" height="25"> <div align="center">ID</div></td>
      <td width="46%" height="25"> <div align="center">标题</div></td>
      <td width="9%"><div align="center">状态</div></td>
      <td width="13%"><div align="center">发布者</div></td>
      <td width="16%"><div align="center">提交时间</div></td>
      <td width="10%" height="25"> <div align="center">操作</div></td>
    </tr>
    <?php
	while($r=$empire->fetch($sql))
	{
		if($class_r[$r[classid]][tbname])
		{
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_index where id='$r[id]' limit 1");
			//返回表
			$infotb=ReturnInfoMainTbname($class_r[$r[classid]][tbname],$index_r['checked']);
			$nr=$empire->fetch1("select title,newstime,userid,username,ismember from ".$infotb." where id='$r[id]' limit 1");
		}
		$do=$r[classid];
		$dob=$class_r[$r[classid]][bclassid];
		$addecmscheck='';
		if(empty($index_r['checked']))
		{
			$addecmscheck='&ecmscheck='.$ecmscheck;
		}
		//状态
		$st='';
		if($r[checktno]=='100')
		{
			$st='审核通过';
		}
		elseif($r[checktno]=='101')
		{
			$st='返工';
		}
		elseif($r[checktno]=='102')
		{
			$st='已否决';
		}
		else
		{
			$st=$r[tstatus];
		}
		//发布者
		if($nr[ismember])
		{
			$username=empty($nr[userid])?'游客':"会员：<a href='../member/AddMember.php?enews=EditMember&userid=".$nr[userid].$ecms_hashur['ehref']."' target='_blank'>".$nr[username]."</a>";
		}
		else
		{
			$username="<a href='../user/AddUser.php?enews=EditUser&userid=".$nr[userid].$ecms_hashur['ehref']."' target='_blank'>".$nr[username]."</a>";
		}
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="42"> <div align="center"> 
          <?=$r[id]?>
        </div></td>
      <td height="25"> 
        <a href="ShowWfInfo.php?classid=<?=$r[classid]?>&id=<?=$r[id]?><?=$addecmscheck?><?=$ecms_hashur['ehref']?>" title="查看内容" target="_blank"><?=$nr[title]?></a>
        <br>
        <font color="#574D5C">栏目:<a href='../ListNews.php?bclassid=<?=$class_r[$r[classid]][bclassid]?>&classid=<?=$r[classid]?><?=$addecmscheck?><?=$ecms_hashur['ehref']?>'> 
        <font color="#574D5C"><?=$class_r[$dob][classname]?></font>
        </a> > <a href='../ListNews.php?bclassid=<?=$class_r[$r[classid]][bclassid]?>&classid=<?=$r[classid]?><?=$addecmscheck?><?=$ecms_hashur['ehref']?>'> 
        <font color="#574D5C"><?=$class_r[$r[classid]][classname]?></font>
        </a></font> </td>
      <td><div align="center"><?=$st?></div></td>
      <td><div align="center"><?=$username?></div></td>
      <td><div align="center"> 
          <?=date("Y-m-d H:i:s",$nr[newstime])?>
        </div></td>
      <td height="25"> <div align="center">[<a href="#ecms" onclick="window.open('DoWfInfo.php?classid=<?=$r[classid]?>&id=<?=$r[id]?><?=$addecmscheck?><?=$ecms_hashur['ehref']?>','','width=600,height=520,scrollbars=yes');">签发</a>]</div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="6"> &nbsp;&nbsp; 
        <?=$returnpage?>
      </td>
    </tr>
	</form>
  </table>
</body>
</html>
<?
db_close();
$empire=null;
?>
