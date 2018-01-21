<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
require("../../data/dbcache/class.php");
require("../../data/dbcache/MemberLevel.php");
require("../class/DownSysFun.php");
eCheckCloseMods('down');//关闭模块
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$ecmsreurl=2;
//验证IP
eCheckAccessDoIp('downinfo');
$id=(int)$_GET['id'];
$pathid=(int)$_GET['pathid'];
$classid=(int)$_GET['classid'];
if(!$classid||empty($class_r[$classid][tbname])||!$id)
{
	echo"<script>alert('此信息不存在');window.close();</script>";
	exit();
}
$mid=$class_r[$classid][modid];
$tbname=$class_r[$classid][tbname];
$query="select * from {$dbtbpre}ecms_".$tbname." where id='$id' limit 1";
$r=$empire->fetch1($query);
if(!$r['id']||$r['classid']!=$classid)
{
	echo"<script>alert('此信息不存在');window.close();</script>";
	exit();
}
//副表
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$r[id]' limit 1");
$r=array_merge($r,$finfor);
//区分下载地址
$path_r=explode("\r\n",$r[downpath]);
if(!$path_r[$pathid])
{
	echo"<script>alert('此信息不存在');window.close();</script>";
	exit();
}
$showdown_r=explode("::::::",$path_r[$pathid]);
//下载权限
$user=array();
$downgroup=$showdown_r[2];
if($downgroup)
{
	$user=islogin();
	//取得会员资料
	$u=$empire->fetch1("select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$user[userid]' and ".egetmf('rnd')."='$user[rnd]' limit 1");
	if(empty($u['userid']))
	{
		echo"<script>alert('同一帐号，只能一人在线');window.close();</script>";
        exit();
    }
	//下载次数限制
	if($level_r[$u['groupid']]['daydown'])
	{
		$setuserday=DoCheckMDownNum($user['userid'],$u['groupid'],2);
		if($setuserday=='error')
		{
			echo"<script>alert('您的下载与观看次数已超过系统限制(".$level_r[$u['groupid']]['daydown']." 次)!');window.close();</script>";
			exit();
		}
	}
	if($level_r[$downgroup][level]>$level_r[$u['groupid']][level])
	{
		echo"<script>alert('您的会员级别不足(".$level_r[$downgroup][groupname].")，没有下载此软件的权限!');window.close();</script>";
		exit();
	}
	//点数是否足够
	if($showdown_r[3])
	{
		//---------是否有历史记录
		$bakr=$empire->fetch1("select id,truetime from {$dbtbpre}enewsdownrecord where id='$id' and classid='$classid' and userid='$user[userid]' and pathid='$pathid' and online=0 order by truetime desc limit 1");
		if($bakr[id]&&(time()-$bakr[truetime]<=$public_r[redodown]*3600))
		{}
		else
		{
			//包月卡
			if($u['userdate']-time()>0)
			{}
			//点数
			else
			{
				if($showdown_r[3]>$u['userfen'])
			    {
					echo"<script>alert('您的点数不足 $showdown_r[3] 点，无法下载此软件');window.close();</script>";
					exit();
			    }
			}
		}
	}
}
//变量
$thisdownname=$showdown_r[0];	//当前下载地址名称
$classname=$class_r[$r[classid]]['classname'];	//栏目名
$bclassid=$class_r[$r[classid]]['bclassid'];	//父栏目ID
$bclassname=$class_r[$bclassid]['classname'];	//父栏目名
$titleurl=sys_ReturnBqTitleLink($r);	//信息链接
$newstime=date('Y-m-d H:i:s',$r['newstime']);
$titlepic=$r['titlepic']?$r['titlepic']:$public_r[newsurl]."e/data/images/notimg.gif";
$ip=egetip();
$pass=md5(ReturnDownSysCheckIp()."wm_chief".$public_r[downpass].$user[userid]);	//验证码
$url="../doaction.php?enews=DownSoft&classid=$classid&id=$id&pathid=$pathid&pass=".$pass."&p=".$user[userid].":::".$user[rnd];	//下载地址
$trueurl=ReturnDSofturl($showdown_r[1],$showdown_r[4],'../../',1);	//真实文件地址
$fen=$showdown_r[3];	//下载点数
$downuser=$level_r[$downgroup][groupname];	//下载等级
@include('../../data/template/downpagetemp.php');
db_close();
$empire=null;
?>