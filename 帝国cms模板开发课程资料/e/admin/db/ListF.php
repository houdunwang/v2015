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
CheckLevel($logininid,$loginin,$classid,"f");
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(!$tid||!$tbname)
{
	printerror("ErrorUrl","history.go(-1)");
}
$url="数据表:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListF.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">字段管理</a>";
$sql=$empire->query("select * from {$dbtbpre}enewsf where tid='$tid' order by myorder,fid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理字段</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsmod.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td class="emenubutton"><input type="button" name="Submit2" value="增加字段" onclick="self.location.href='AddF.php?enews=AddF&tid=<?=$tid?>&tbname=<?=$tbname?><?=$ecms_hashur['ehref']?>';"></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td width="6%" height="25"><div align="center">顺序</div></td>
      <td width="8%"><div align="center">表</div></td>
      <td width="29%" height="25"><div align="center">字段名</div></td>
      <td width="20%"><div align="center">字段标识</div></td>
      <td width="15%"> <div align="center">字段类型</div></td>
      <td width="8%"><div align="center">采集项</div></td>
      <td width="14%" height="25"><div align="center">操作</div></td>
    </tr>
    <?php
  	while($r=$empire->fetch($sql))
  	{
  		$ftype=$r[ftype];
  		if($r[flen])
  		{
			if($r[ftype]!="TEXT"&&$r[ftype]!="MEDIUMTEXT"&&$r[ftype]!="LONGTEXT"&&$r[ftype]!="DATE"&&$r[ftype]!="DATETIME")
			{
				$ftype.="(".$r[flen].")";
			}
  		}
  		if($r[iscj])
  		{$iscj="是";}
  		else
  		{$iscj="否";}
  		if($r[isadd])
  		{
  			$do="[<a href='AddF.php?tid=$tid&tbname=$tbname&enews=EditF&fid=".$r[fid].$ecms_hashur['ehref']."'>修改</a>]&nbsp;&nbsp;[<a href='../ecmsmod.php?tid=$tid&tbname=$tbname&enews=DelF&fid=".$r[fid].$ecms_hashur['href']."' onclick=\"return confirm('确认要删除？');\">删除</a>]";
 		 }
  		else
  		{
  			$ftype="系统字段";
  			$r[f]="<a title='系统字段'><font color=red>".$r[f]."</font></a>";
  			$do="<a href='EditSysF.php?tid=$tid&tbname=$tbname&fid=".$r[fid].$ecms_hashur['ehref']."'><font color=red>[修改系统字段]</font></a>";
  		}
  		if($r[tbdataf]==1)
  		{
  			$tbdataf=$r[isadd]?"<a href='ChangeDataTableF.php?tid=$tid&tbname=$tbname&fid=".$r[fid].$ecms_hashur['ehref']."' title='点击将字段转移到主表'>副表</a>":"副表";
  		}
  		else
  		{
			$tbdataf=$r[isadd]?"<a href='ChangeDataTableF.php?tid=$tid&tbname=$tbname&fid=".$r[fid].$ecms_hashur['ehref']."' title='点击将字段转移到副表'>主表</a>":"主表";
  		}
  ?>
    <tr bgcolor="#ffffff" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25"><div align="center"> 
          <input name="myorder[]" type="text" id="myorder[]" value="<?=$r[myorder]?>" size="3">
          <input type=hidden name=fid[] value=<?=$r[fid]?>>
        </div></td>
      <td><div align="center">
          <?=$tbdataf?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[f]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[fname]?>
        </div></td>
      <td><div align="center"> 
          <?=$ftype?>
        </div></td>
      <td><div align="center"> 
          <?=$iscj?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$do?>
        </div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="ffffff"> 
      <td height="25">&nbsp;</td>
      <td height="25" colspan="6"><input type="submit" name="Submit" value="修改字段顺序">
        <input name="enews" type="hidden" id="enews" value="EditFOrder"> <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> 
        <input name="tbname" type="hidden" id="tbname" value="<?=$tbname?>"></td>
    </tr>
    <tr bgcolor="ffffff">
      <td height="25">&nbsp;</td>
      <td height="25" colspan="6"><font color="#666666">说明：顺序值越小越显示前面，红色字段名为系统字段，点击“主表”/“副表”可以进行字段转移.</font></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
      <td><div align="center"> [<a href="javascript:window.close();">关闭</a>] </div></td>
    </tr>
  </table>
</body>
</html>
<?
db_close();
$empire=null;
?>
