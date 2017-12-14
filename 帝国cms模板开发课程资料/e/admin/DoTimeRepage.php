<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
require("../data/dbcache/MemberLevel.php");
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

@set_time_limit(0);

//定时刷新任务
function DoTimeRepage($time){
	global $empire,$dbtbpre;
	if(empty($time))
	{$time=120;}
	echo"<meta http-equiv=\"refresh\" content=\"".$time.";url=DoTimeRepage.php".hReturnEcmsHashStrHref(1)."\">";
	DoAutoUpAndDownInfo();//自动上/下线
	$todaytime=time();
	$b=0;
	$sql=$empire->query("select doing,classid,doid from {$dbtbpre}enewsdo where isopen=1 and lasttime+dotime*60<$todaytime");
	while($r=$empire->fetch($sql))
	{
		$b=1;
		if($r[doing]==1)//生成栏目
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				ReListHtml($cr[$i],1);
			}
	    }
		elseif($r[doing]==2)//生成专题
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				ListHtmlIndex($cr[$i],$ret_r[0],0);
			}
	    }
		elseif($r[doing]==3)//生成自定义列表
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				$ur=$empire->fetch1("select listid,pagetitle,filepath,filetype,totalsql,listsql,maxnum,lencord,listtempid,pagekeywords,pagedescription from {$dbtbpre}enewsuserlist where listid='".$cr[$i]."'");
				ReUserlist($ur,"");
			}
	    }
		elseif($r[doing]==4)//生成自定义页面
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				$ur=$empire->fetch1("select id,path,pagetext,title,pagetitle,pagekeywords,pagedescription,tempid from {$dbtbpre}enewspage where id='".$cr[$i]."'");
				ReUserpage($ur[id],$ur[pagetext],$ur[path],$ur[title],$ur[pagetitle],$ur[pagekeywords],$ur[pagedescription],$ur[tempid]);
			}
	    }
		elseif($r[doing]==5)//生成自定义JS
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				$ur=$empire->fetch1("select jsid,jsname,jssql,jstempid,jsfilename from {$dbtbpre}enewsuserjs where jsid='".$cr[$i]."'");
				ReUserjs($ur,'');
			}
	    }
		elseif($r[doing]==6)//生成标题分类页面
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				ListHtml($cr[$i],$ret_r,5);
			}
	    }
		else//生成首页
		{
			$indextemp=GetIndextemp();
			NewsBq($classid,$indextemp,1,0);
	    }
		$empire->query("update {$dbtbpre}enewsdo set lasttime=$todaytime where doid='$r[doid]'");
    }
	if($b)
	{
		echo "最后执行时间：".date("Y-m-d H:i:s",$todaytime)."<br><br>";
	}
}

//定时上线/下线
function DoAutoUpAndDownInfo(){
	global $empire,$dbtbpre,$class_r,$emod_r,$public_r;
	$todaytime=time();
	$sql=$empire->query("select id,classid,infouptime,infodowntime from {$dbtbpre}enewsinfovote where infouptime>0 or infodowntime>0");
	while($r=$empire->fetch($sql))
	{
		if(!$class_r[$r[classid]]['tbname'])
		{
			continue;
		}
		//上线
		if($r['infouptime']&&$r['infouptime']<=$todaytime)
		{
			$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_check where id='$r[id]' limit 1");
			if(!$infor['id'])
			{
				continue;
			}
			//签发
			if($infor['isqf'])
			{
				$qfr=$empire->fetch1("select checktno from {$dbtbpre}enewswfinfo where id='$r[id]' and classid='$r[classid]' limit 1");
				if($qfr['checktno']!='100')
				{
					continue;
				}
			}
			$empire->query("update {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_index set checked=1 where id='$r[id]' limit 1");
			$pubid=ReturnInfoPubid($r['classid'],$r['id']);
			$empire->query("update {$dbtbpre}enewsinfovote set infouptime=0 where pubid='$pubid' limit 1");
			//互转
			MoveCheckInfoData($class_r[$r[classid]][tbname],0,$infor['stb'],"id='$r[id]'");
			AddClassInfos($r['classid'],'','+1');
			//刷新信息
			GetHtml($infor['classid'],$infor['id'],$infor,1);
			//刷新列表
			ReListHtml($r[classid],1);
		}
		//下线
		if($r['infodowntime']&&$r['infodowntime']<=$todaytime)
		{
			$mid=$class_r[$r[classid]][modid];
			$tbname=$class_r[$r[classid]][tbname];
			$pf=$emod_r[$mid]['pagef'];
			$stf=$emod_r[$mid]['savetxtf'];
			//主表
			$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]." where id='".$r[id]."' limit 1");
			if(!$infor['id'])
			{
				continue;
			}
			//签发
			if($infor['isqf'])
			{
				$qfr=$empire->fetch1("select checktno from {$dbtbpre}enewswfinfo where id='$r[id]' and classid='$r[classid]' limit 1");
				if($qfr['checktno']!='100')
				{
					continue;
				}
			}
			//分页字段
			if($pf)
			{
				if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
				{
					$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_data_".$infor[stb]." where id='$r[id]' limit 1");
					$infor[$pf]=$finfor[$pf];
				}
				if($stf&&$stf==$pf)//存放文本
				{
					$infor[$pf]=GetTxtFieldText($infor[$pf]);
				}
			}
			DelNewsFile($infor[filename],$infor[newspath],$infor[classid],$infor[$pf],$infor[groupid]);
			$empire->query("update {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_index set checked=0,havehtml=0 where id='$r[id]' limit 1");
			$pubid=ReturnInfoPubid($r['classid'],$r['id']);
			$empire->query("update {$dbtbpre}enewsinfovote set infodowntime=0 where pubid='$pubid' limit 1");
			//互转
			MoveCheckInfoData($class_r[$r[classid]][tbname],1,$infor['stb'],"id='$r[id]'");
			AddClassInfos($r['classid'],'','-1');
			//刷新列表
			ReListHtml($r[classid],1);
		}
	}
}

DoTimeRepage(120);//自动刷新页面
db_close();
$empire=null;
?>
<b>说明：本页面为定时刷新任务执行窗口.</b>