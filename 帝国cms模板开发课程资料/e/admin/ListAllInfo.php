<?php
define('EmpireCMSAdmin','1');
require('../class/connect.php');
require('../class/db_sql.php');
require('../class/functions.php');
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
//取得数据表
$tid=(int)$public_r['tid'];
$tbname=$_GET['tbname']?$_GET['tbname']:$public_r['tbname'];
$tbname=RepPostVar($tbname);
$changetbs='';
$havetb=0;
$tbsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable order by tid");
while($tbr=$empire->fetch($tbsql))
{
	$selected='';
	if($tbname==$tbr[tbname])
	{
		$tid=$tbr[tid];
		$selected=' selected';
		$havetb=1;
	}
	$changetbs.="<option value='".$tbr[tbname]."'".$selected.">".$tbr[tname]."(".$tbr[tbname].")</option>";
}
if($havetb==0)
{
	printerror('ErrorUrl','');
}
//取得相应的信息
$user_r=$empire->fetch1("select groupid,adminclass from {$dbtbpre}enewsuser where userid='$logininid'");
//取得用户组
$gr=$empire->fetch1("select doall,doselfinfo from {$dbtbpre}enewsgroup where groupid='$user_r[groupid]'");
//管理员
$where='';
$and='';
$ewhere='';
$search="&tbname=$tbname".$ecms_hashur['ehref'];
$ecmscheck=(int)$_GET['ecmscheck'];
$addecmscheck='';
$indexchecked=1;
if($ecmscheck)
{
	$search.='&ecmscheck='.$ecmscheck;
	$addecmscheck='&ecmscheck='.$ecmscheck;
	$indexchecked=0;
}
$infotb=ReturnInfoMainTbname($tbname,$indexchecked);
//优化
$modid=$etable_r[$tbname][mid];
$yhadd='';
$yhvar='hlist';
$yhid=$etable_r[$tbname][yhid];
if($yhid)
{
	$yhadd=ReturnYhSql($yhid,$yhvar);
	if($yhadd)
	{
		$and=$where?' and ':' where ';
		$where.=$and.$yhadd;
	}
}
if(empty($yhadd))
{
	//时间范围
	$infolday=(int)$_GET['infolday'];
	if(empty($infolday))
	{
		$infolday=$public_r['infolday'];
	}
	if($infolday&&$infolday!=1)
	{
		$ckinfolday=time()-$infolday;
		$and=$where?' and ':' where ';
		$where.=$and."newstime>'$ckinfolday'";
		$search.="&infolday=$infolday";
	}
}
if(!$gr['doall'])
{
	$cids='';
	$a=explode("|",$user_r['adminclass']);
	for($i=1;$i<count($a)-1;$i++)
	{
		$dh=',';
		if(empty($cids))
		{
			$dh='';
		}
		$cids.=$dh.$a[$i];
	}
	if($cids=='')
	{
		$cids=0;
	}
	$and=$where?' and ':' where ';
	$where.=$and.'classid in ('.$cids.')';
}
//只能编辑自己的信息
if($gr['doselfinfo'])
{
	$and=$where?' and ':' where ';
	$where.=$and."userid='$logininid' and ismember=0";
}
$url="<a href=ListAllInfo.php?tbname=".$tbname.$addecmscheck.$ecms_hashur['ehref'].">管理信息</a>";
$start=0;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$line=intval($public_r['hlistinfonum']);//每页显示
$page_line=21;
$offset=$page*$line;
//栏目ID
$classid=intval($_GET['classid']);
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
	$search.="&classid=$classid";
}
//模型
$infomod_r=$empire->fetch1("select mid,listfile from {$dbtbpre}enewsmod where mid='$modid'");
//标题分类
$ttid=(int)$_GET['ttid'];
if($ttid)
{
	$and=$where?' and ':' where ';
	$where.=$and."ttid='$ttid'";
	$search.="&ttid=$ttid";
}
//标题分类
$tts='';
$ttsql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype where mid='$infomod_r[mid]' order by myorder");
while($ttr=$empire->fetch($ttsql))
{
	$select='';
	if($ttr[typeid]==$ttid)
	{
		$select=' selected';
	}
	$tts.="<option value='$ttr[typeid]'".$select.">$ttr[tname]</option>";
}
$stts=$tts?"<select name='ttid'><option value='0'>标题分类</option>$tts</select>":"";
//搜索
$sear=(int)$_GET['sear'];
if($sear)
{
	$and=$where?' and ':' where ';
	$showspecial=(int)$_GET['showspecial'];
	if($showspecial==1)//置顶
	{
		$where.=$and.'istop>0';
	}
	elseif($showspecial==2)//推荐
	{
		$where.=$and.'isgood>0';
	}
	elseif($showspecial==3)//头条
	{
		$where.=$and.'firsttitle>0';
	}
	elseif($showspecial==5)//签发
	{
		$where.=$and.'isqf=1';
	}
	elseif($showspecial==7)//投稿
	{
		$where.=$and.'ismember=1';
	}
	elseif($showspecial==8)//我的信息
	{
		$where.=$and."userid='$logininid' and ismember=0";
	}
	$and=$where?' and ':' where ';
	if($_GET['keyboard'])
	{
		$keyboard=RepPostVar2($_GET['keyboard']);
		$show=RepPostStr($_GET['show'],1);
		if($show==0)//搜索全部
		{
			$where.=$and."(title like '%$keyboard%' or username like '%$keyboard%' or id='$keyboard')";
		}
		elseif($show==1)//搜索标题
		{
			$where.=$and."(title like '%$keyboard%')";
		}
		elseif($show==3)//ID
		{
			$where.=$and."(id='$keyboard')";
		}
		else
		{
			$where.=$and."(username like '%$keyboard%')";
		}
	}
	$search.="&sear=1&keyboard=$keyboard&show=$show&showspecial=$showspecial";
}
//显示重复标题
if($_GET['showretitle']==1)
{
	$and=$where?' and ':' where ';
	$search.="&showretitle=1&srt=".intval($_GET['srt']);
	$addsrt="";
	$srtid="";
	$first=1;
	$srtsql=$empire->query("select id,title from ".$infotb." group by title having(count(*))>1");
	while($srtr=$empire->fetch($srtsql))
	{
		if($first==1)
		{
			$addsrt.="title='".addslashes($srtr['title'])."'";
			$srtid.=$srtr['id'];
			$first=0;
		}
		else
		{
			$addsrt.=" or title='".addslashes($srtr['title'])."'";
			$srtid.=",".$srtr['id'];
		}
	}
	if(!empty($addsrt))
	{
		if($_GET['srt']==1)
		{
			$where.=$and."(".$addsrt.") and id not in (".$srtid.")";
		}
		else
		{
			$where.=$and."(".$addsrt.")";
		}
	}
	else
	{
		printerror("HaveNotReInfo","ListAllInfo.php?tbname=".$tbname.$addecmscheck.$ecms_hashur['ehref']);
	}
}
//排序
$orderby=RepPostStr($_GET['orderby'],1);
$doorderby=$orderby?'asc':'desc';
$myorder=RepPostStr($_GET['myorder'],1);
if($myorder==1)//ID号
{$doorder="id";}
elseif($myorder==2)//时间
{$doorder="newstime";}
elseif($myorder==5)//评论数
{$doorder="plnum";}
elseif($myorder==3)//人气
{$doorder="onclick";}
elseif($myorder==4)//下载
{$doorder="totaldown";}
else//默认排序
{$doorder="id";}
$doorder.=' '.$doorderby;
$search.="&myorder=$myorder&orderby=$orderby";
$totalquery="select count(*) as total from ".$infotb.$where;
//表信息数
$tbinfos=eGetTableRowNum("{$dbtbpre}ecms_".$tbname);
$tbckinfos=eGetTableRowNum("{$dbtbpre}ecms_".$tbname."_check");
//取得总条数
$totalnum=intval($_GET['totalnum']);
if($totalnum<1)
{
	if(empty($where))
	{
		$num=$indexchecked==1?$tbinfos:$tbckinfos;
	}
	else
	{
		$num=$empire->gettotal($totalquery);
	}
}
else
{
	$num=$totalnum;
}
$search1=$search;
$search.="&totalnum=$num";
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$phpmyself=urlencode(eReturnSelfPage(1));
//导入页面
$deftempfile=ECMS_PATH.'e/data/html/list/alllistinfo.php';
if($infomod_r[listfile])
{
	$tempfile=ECMS_PATH.'e/data/html/list/all'.$infomod_r[listfile].'.php';
	if(!file_exists($tempfile))
	{
		$tempfile=$deftempfile;
	}
}
else
{
	$tempfile=$deftempfile;
}
require($tempfile);
db_close();
$empire=null;
?>