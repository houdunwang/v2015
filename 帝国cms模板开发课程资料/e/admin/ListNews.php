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

$classid=(int)$_GET['classid'];
$bclassid=(int)$class_r[$classid]['bclassid'];
//取得栏目名
if(!$class_r[$classid][classid]||!$class_r[$classid][tbname])
{
	printerror('ErrorUrl','history.go(-1)');
}
//栏目
$thiscr=$empire->fetch1("select tbname,listorder,allinfos,infos from {$dbtbpre}enewsclass where classid='$classid'");
if(!$thiscr['tbname'])
{
	printerror('ErrorUrl','history.go(-1)');
}
$classallinfos=$thiscr['allinfos'];
$classinfos=$thiscr['infos'];
$classckinfos=$classallinfos-$classinfos;
//验证权限
$doselfinfo=CheckLevel($logininid,$loginin,$classid,"news");
//取得模型表
$fieldexp="<!--field--->";
$recordexp="<!--record-->";
//返回搜索字段列表
function ReturnSearchOptions($enter,$field,$record){
	global $modid,$emod_r;
	$r=explode($record,$enter);
	$count=count($r)-1;
	for($i=0;$i<$count;$i++)
	{
		if($i==0)
		{
			$or="";
		}
		else
		{
			$or=" or ";
		}
		$r1=explode($field,$r[$i]);
		if($r1[1]=="special.field"||strstr($emod_r[$modid]['tbdataf'],','.$r1[1].','))
		{
			continue;
		}
		if($r1[1]=="id")
		{
			$sr['searchallfield'].=$or.$r1[1]."='[!--key--]'";
			$sr['select'].="<option value=\"".$r1[1]."\">".$r1[0]."</option>";
			continue;
		}
		$sr['searchallfield'].=$or.$r1[1]." like '%[!--key--]%'";
		$sr['select'].="<option value=\"".$r1[1]."\">".$r1[0]."</option>";
	}
	return $sr;
}
$modid=(int)$class_r[$classid][modid];
$infomod_r=$empire->fetch1("select enter,tbname,sonclass,listfile from {$dbtbpre}enewsmod where mid=".$modid);
if(empty($infomod_r['tbname']))
{
	printerror("ErrorUrl","history.go(-1)");
}
$infomod_r['enter'].='发布者<!--field--->username<!--record-->ID<!--field--->id<!--record-->';
$searchoptions_r=ReturnSearchOptions($infomod_r['enter'],$fieldexp,$recordexp);
//审核表
$search='';
$search.=$ecms_hashur['ehref'];
$addecmscheck='';
$ecmscheck=(int)$_GET['ecmscheck'];
$indexchecked=1;
if($ecmscheck)
{
	$search.='&ecmscheck='.$ecmscheck;
	$addecmscheck='&ecmscheck='.$ecmscheck;
	$indexchecked=0;
}
$infotb=ReturnInfoMainTbname($class_r[$classid]['tbname'],$indexchecked);
//导航
$url=AdminReturnClassLink($classid).'&nbsp;>&nbsp;信息列表';
$start=0;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$line=intval($public_r['hlistinfonum']);//每页显示
$page_line=12;
$offset=$page*$line;
$search.="&bclassid=$bclassid&classid=$classid";
$add='';
$ewhere='';
//搜索
$sear=(int)$_GET['sear'];
if($sear)
{
	$keyboard=RepPostVar2($_GET['keyboard']);
	$show=RepPostVar($_GET['show']);
	//关键字
	if($keyboard)
	{
		//搜索全部
		if(!$show)
		{
			$add=" and (".str_replace("[!--key--]",$keyboard,$searchoptions_r['searchallfield']).")";
		}
		//搜索字段
		elseif($show&&strstr($infomod_r['enter'],"<!--field--->".$show."<!--record-->"))
		{
			$add=$show!="id"?" and (".$show." like '%$keyboard%')":" and (".$show."='$keyboard')";
			$searchoptions_r['select']=str_replace(" value=\"".$show."\">"," value=\"".$show."\" selected>",$searchoptions_r['select']);
		}
	}
	//特殊属性
	$showspecial=(int)$_GET['showspecial'];
	if($showspecial==1)//置顶
	{
		$add.=' and istop>0';
	}
	elseif($showspecial==2)//推荐
	{
		$add.=' and isgood>0';
	}
	elseif($showspecial==3)//头条
	{
		$add.=' and firsttitle>0';
	}
	elseif($showspecial==5)//签发
	{
		$add.=' and isqf=1';
	}
	elseif($showspecial==7)//投稿
	{
		$add.=' and ismember=1';
	}
	elseif($showspecial==8)//我的信息
	{
		$add.=" and userid='$logininid' and ismember=0";
	}
	//标题分类
	$ttid=(int)$_GET['ttid'];
	if($ttid)
	{
		$add.=" and ttid='$ttid'";
	}
	$search.="&sear=1&keyboard=$keyboard&show=$show&showspecial=$showspecial&ttid=$ttid";
}
//显示重复标题
if($_GET['showretitle']==1)
{
	$search.="&showretitle=1&srt=".intval($_GET['srt']);
	$addsrt="";
	$srtid="";
	$first=1;
	$srtsql=$empire->query("select id,title from ".$infotb." where classid='$classid' group by title having(count(*))>1");
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
			$add.=" and (".$addsrt.") and id not in (".$srtid.")";
		}
		else
		{
			$add.=" and (".$addsrt.")";
		}
	}
	else
	{
		printerror("HaveNotReInfo","ListNews.php?bclassid=$bclassid&classid=$classid".$addecmscheck.$ecms_hashur['ehref']);
	}
}
//只能编辑自己的信息
if($doselfinfo['doselfinfo'])
{
	$add.=" and userid='$logininid' and ismember=0";
}
//优化
$yhadd='';
$yhid=$class_r[$classid][yhid];
$yhvar='hlist';
if($yhid)
{
	$yhadd=ReturnYhSql($yhid,$yhvar);
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
		$yhadd.="newstime>'$ckinfolday'";
		$search.="&infolday=$infolday";
	}
}
//单栏目单表
$singletable=0;
if($infomod_r[sonclass]=='|'.$classid.'|')
{
	$singletablenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsclass where tbname='".$class_r[$classid][tbname]."' and islast=1");
	$singletable=$singletablenum==1?1:0;
}
if($infomod_r[sonclass]=='|'.$classid.'|'&&$singletable==1)
{
	if($yhadd)
	{
		$ewhere=$add?' where '.$yhadd.$add:' where '.$yhadd;
	}
	else
	{
		$ewhere=$add?' where '.substr($add,5):'';
	}
}
else
{
	if($yhadd)
	{
		$ewhere=" where ".$yhadd." and classid='$classid'".$add;
	}
	else
	{
		$ewhere=" where classid='$classid'".$add;
	}
}
//统计
$totalquery="select count(*) as total from ".$infotb.$ewhere;
$totalnum=(int)$_GET['totalnum'];
if($totalnum<1)
{
	if(empty($ewhere)||$ewhere==" where classid='$classid'")
	{
		$num=$indexchecked==1?$classinfos:$classckinfos;
	}
	else
	{
		$num=$empire->gettotal($totalquery);//取得总条数
	}
}
else
{
	$num=$totalnum;
}
//排序
$myorder=RepPostStr($_GET['myorder'],1);
if($myorder==1)//时间
{$doorder="newstime desc";}
elseif($myorder==2)//评论数
{$doorder="plnum desc";}
elseif($myorder==3)//人气
{$doorder="onclick desc";}
elseif($myorder==4)//ID号
{$doorder="id desc";}
else//默认排序
{
	if(empty($thiscr['listorder']))
	{
		$doorder="id desc";
	}
	else
	{
		$doorder=$thiscr['listorder'];
	}
}
$search.="&totalnum=$num";
$search1=$search;
$search.="&myorder=$myorder";
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$phpmyself=urlencode(eReturnSelfPage(1));
//标题分类
$tts='';
$ttsql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype where mid='$modid' order by myorder");
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
//栏目链接
$getcurlr['classid']=$classid;
$classurl=sys_ReturnBqClassname($getcurlr,9);
//导入页面
$deftempfile=ECMS_PATH.'e/data/html/list/listinfo.php';
if($infomod_r[listfile])
{
	$tempfile=ECMS_PATH.'e/data/html/list/'.$infomod_r[listfile].'.php';
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