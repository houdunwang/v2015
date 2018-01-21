<?php
require("../../class/connect.php");
$id=(int)$_GET['id'];
$classid=(int)$_GET['classid'];
if($id&&$classid)
{
	include("../../class/db_sql.php");
	include("../../data/dbcache/class.php");
	$link=db_connect();
	$empire=new mysqlquery();
	$doajax=(int)$_GET['doajax'];
	$editor=1;
	if(empty($class_r[$classid][tbname]))
	{
		$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
    }
	$checkid=$classid.'n'.$id;
	$checktime=time()+30*24*3600;
	//连续提交
	if(getcvar('lastdiggid')==$checkid)
	{
		$doajax==1?ajax_printerror('','','ReDigg',1):printerror('ReDigg','',1);
	}
	//字段
	$fnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsf where tbname='".$class_r[$classid][tbname]."' and (f='diggtop' or f='diggdown')");
	if(empty($fnum))
	{
		$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
	}
	//验证信息
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' and classid='$classid' limit 1");
	if(empty($num))
	{
		$doajax==1?ajax_printerror('','','ErrorUrl',1):printerror('ErrorUrl','',1);
	}
	//验证IP
	$ip=egetip();
	$ipr=$empire->fetch1("select classid,ips from {$dbtbpre}enewsdiggips where id='$id' and classid='$classid' limit 1");
	if(strstr($ipr['ips'],','.$ip.','))
	{
		$doajax==1?ajax_printerror('','','ReDigg',1):printerror('ReDigg','',1);
	}
	else
	{
		if(empty($ipr['classid']))
		{
			$newips=','.$ip.',';
			$usql=$empire->query("insert into {$dbtbpre}enewsdiggips(id,classid,ips) values('$id','$classid','$newips');");
		}
		else
		{
			$newips=$ipr['ips']?$ipr['ips'].$ip.',':','.$ip.',';
			$usql=$empire->query("update {$dbtbpre}enewsdiggips set ips='$newips' where id='$id' and classid='$classid' limit 1");
		}
	}
	$dotop=(int)$_GET['dotop'];
	$f='diggtop';
	$n='+1';
	if($dotop)
	{
		$mess='DoDiggGSuccess';
	}
	else
	{
		if($fnum==2)
		{
			$f='diggdown';
		}
		else
		{
			$n='-1';
		}
		$mess='DoDiggBSuccess';
	}
	$sql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]." set ".$f."=".$f.$n." where id='$id'");
	if($sql)
	{
		esetcookie('lastdiggid',$checkid,$checktime);	//最后发布
		if($doajax==1)
		{
			$nr=$empire->fetch1("select ".$f." from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id'");
			ajax_printerror($nr[$f],$_GET['ajaxarea'],$mess,1);
		}
		else
		{
			printerror($mess,$_SERVER['HTTP_REFERER'],1);
		}
    }
	else
	{
		$doajax==1?ajax_printerror('','','DbError',1):printerror('DbError','',1);
	}
}
?>