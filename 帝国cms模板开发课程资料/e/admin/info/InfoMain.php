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

//今日信息
$pur=$empire->fetch1("select lasttimeinfo,lastnuminfo,lastnuminfotb,todaytimeinfo,todaytimepl,todaynuminfo,yesterdaynuminfo from {$dbtbpre}enewspublic_update limit 1");
//更新昨日信息
$todaydate=date('Y-m-d');
if(date('Y-m-d',$pur['todaytimeinfo'])<>$todaydate||date('Y-m-d',$pur['todaytimepl'])<>$todaydate)
{
	DoUpdateYesterdayAddDataNum();
	$pur=$empire->fetch1("select lasttimeinfo,lastnuminfo,lastnuminfotb,todaytimeinfo,todaytimepl,todaynuminfo,yesterdaynuminfo from {$dbtbpre}enewspublic_update limit 1");
}
$sql=$empire->query("select tid,tbname,tname,isdefault from {$dbtbpre}enewstable order by tid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>信息</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href="InfoMain.php<?=$ecms_hashur['whehref']?>">信息统计</a></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="10%" height="25" class="header"><div align="center"><a href="../info/InfoMain.php<?=$ecms_hashur['whehref']?>">信息统计</a></div></td>
    <td width="10%" bgcolor="#C9F1FF"><div align="center"><a href="../pl/PlMain.php<?=$ecms_hashur['whehref']?>">评论统计</a></div></td>
    <td width="10%" bgcolor="#C9F1FF"><div align="center"><a href="../other/OtherMain.php<?=$ecms_hashur['whehref']?>">其他统计</a></div></td>
    <td width="58%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="25" colspan="6">信息发布统计 (今日信息数：<?=$pur['todaynuminfo']?>，昨天信息数：<?=$pur['yesterdaynuminfo']?>) </td>
  </tr>
  <tr class="header">
    <td width="14%" height="25"><div align="center">表名</div></td>
    <td width="8%"><div align="center">已审核</div></td>
    <td width="8%"><div align="center">未审核</div></td>
    <td width="8%"><div align="center">未审核投稿</div></td>
    <td width="8%"><div align="center">总数</div></td>
    <td width="54%">从 
      <?=date('Y-m-d H:i:s',$pur['lasttimeinfo'])?> 
    截止至现在的新增数量</td>
  </tr>
	  <?php
	  $i=0;
	  $alltbinfos=0;
	  while($tr=$empire->fetch($sql))
	  {
	  	$i++;
		$bgcolor='#FFFFFF';
		if($i%2==0)
		{
			$bgcolor='';
		}
		$thistb=$tr['tid'];
		$infotbname='ecms_'.$tr['tbname'];
		$tbinfos=eGetTableRowNum($dbtbpre.$infotbname);//已审核
		$checkinfotbname='ecms_'.$tr['tbname'].'_check';
		$checktbinfos=eGetTableRowNum($dbtbpre.$checkinfotbname);//未审核
		$qchecktbinfos=$empire->gettotal("select count(*) as total from ".$dbtbpre.$checkinfotbname." where ismember=1");//投稿数
		$alltbinfos=$tbinfos+$checktbinfos;//总数
		$tname=$tr['tname'];
		if($tr['isdefault'])
		{
			$tname='<b>'.$tname.'</b>';
		}
		$exp='|'.$thistb.',';
		$addnumr=explode($exp,$pur['lastnuminfotb']);
		$addnumrt=explode('|',$addnumr[1]);
		$addnum=(int)$addnumrt[0];
		$totaltbinfos+=$tbinfos;
		$totalchecktbinfos+=$checktbinfos;
		$totalqchecktbinfos+=$qchecktbinfos;
		$totalalltbinfos+=$alltbinfos;
	  ?>
  <tr bgcolor="<?=$bgcolor?>"> 
    <td height="25">
		<div align="center"><a href="../ListAllInfo.php?tbname=<?=$tr['tbname']?><?=$ecms_hashur['ehref']?>" title="*<?=$infotbname?>" target="_blank">
	    <?=$tname?>
	    </a></div></td>
    <td align="right"><div align="right"><a href="../ListAllInfo.php?tbname=<?=$tr['tbname']?><?=$ecms_hashur['ehref']?>" target="_blank"><?=$tbinfos?></a></div></td>
    <td align="right"><div align="right"><a href="../ListAllInfo.php?tbname=<?=$tr['tbname']?>&ecmscheck=1<?=$ecms_hashur['ehref']?>" target="_blank"><?=$checktbinfos?></a></div></td>
    <td align="right"><a href="../ListAllInfo.php?tbname=<?=$tr['tbname']?>&ecmscheck=1&sear=1&showspecial=7<?=$ecms_hashur['ehref']?>" target="_blank"><?=$qchecktbinfos?></a></td>
    <td align="right"><?=$alltbinfos?></td>
    <td><table width="320" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40%" align="right"><?=$addnum?></td>
          <td width="60%"><div align="center"></div></td>
        </tr>
      </table></td>
  </tr>
	  <?php
	  }
	  ?>
  <tr class="header">
    <td height="25"><div align="right">总计：</div></td>
    <td align="right"><div align="right"><?=$totaltbinfos?></div></td>
    <td align="right"><div align="right"><?=$totalchecktbinfos?></div></td>
    <td align="right"><?=$totalqchecktbinfos?></td>
    <td align="right"><?=$totalalltbinfos?></td>
    <td><table width="320" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40%" align="right"><font color="#FFFFFF"><b><?=$pur['lastnuminfo']?></b></font></td>
          <td width="60%"><div align="center">
            <input type="button" name="Submit" value="重置截止统计" onclick="if(confirm('确认要重置信息数统计?')){self.location.href='../ecmscom.php?enews=ResetAddDataNum&type=info&from=info/InfoMain.php<?=urlencode($ecms_hashur['whehref'])?><?=$ecms_hashur['href']?>';}">
          </div></td>
        </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="23"><font color="#666666">说明：点击“已审核”、“未审核”或“未审核投稿”数可进入相应的管理。</font></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
db_close();
$empire=null;
?>