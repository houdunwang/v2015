<?php

//商城参数设置
function ShopSys_set($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"public");
	$add['shopddgroupid']=(int)$add['shopddgroupid'];
	$add['buycarnum']=(int)$add['buycarnum'];
	$add['havefp']=(int)$add['havefp'];
	$add['fpnum']=(int)$add['fpnum'];
	$add['fpname']=ehtmlspecialchars($add['fpname']);
	$add['haveatt']=(int)$add['haveatt'];
	$add['buystep']=(int)$add['buystep'];
	$add['shoppsmust']=(int)$add['shoppsmust'];
	$add['shoppayfsmust']=(int)$add['shoppayfsmust'];
	$add['dddeltime']=(int)$add['dddeltime'];
	$add['cutnumtype']=(int)$add['cutnumtype'];
	$add['cutnumtime']=(int)$add['cutnumtime'];
	$add['freepstotal']=(int)$add['freepstotal'];
	$add['singlenum']=(int)$add['singlenum'];
	//必填项
	$ddmuststr='';
	$ddmustf=$add['ddmustf'];
	$mfcount=count($ddmustf);
	for($i=0;$i<$mfcount;$i++)
	{
		if(empty($ddmustf[$i]))
		{
			continue;
		}
		$ddmuststr.=','.$ddmustf[$i];
	}
	if($ddmuststr)
	{
		$ddmuststr.=',';
	}
	//商城表
	$shoptbs='';
	$tbname=$add['tbname'];
	$tbcount=count($tbname);
	for($ti=0;$ti<$tbcount;$ti++)
	{
		if(empty($tbname[$ti]))
		{
			continue;
		}
		$shoptbs.=','.$tbname[$ti];
	}
	if($shoptbs)
	{
		$shoptbs.=',';
	}
	$sql=$empire->query("update {$dbtbpre}enewsshop_set set shopddgroupid='$add[shopddgroupid]',buycarnum='$add[buycarnum]',havefp='$add[havefp]',fpnum='$add[fpnum]',fpname='".eaddslashes($add[fpname])."',ddmust='$ddmuststr',haveatt='$add[haveatt]',shoptbs='$shoptbs',buystep='$add[buystep]',shoppsmust='$add[shoppsmust]',shoppayfsmust='$add[shoppayfsmust]',dddeltime='$add[dddeltime]',cutnumtype='$add[cutnumtype]',cutnumtime='$add[cutnumtime]',freepstotal='$add[freepstotal]',singlenum='$add[singlenum]' limit 1");
	if($sql)
	{
		insert_dolog("");//操作日志
		printerror('SetShopSysSuccess','SetShopSys.php'.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror('DbError','history.go(-1)');
	}
}

//返回商城参数
function ShopSys_hReturnSet(){
	global $empire,$dbtbpre;
	$shoppr=$empire->fetch1("select * from {$dbtbpre}enewsshop_set limit 1");
	return $shoppr;
}

//后台订单增加备注
function ShopSys_DdRetext($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"shopdd");
	$ddid=(int)$add['ddid'];
	$retext=eaddslashes(ehtmlspecialchars($add['retext']));
	if(!$ddid)
	{
		printerror('ErrorUrl','');
	}
	$r=$empire->fetch1("select ddid,ddno from {$dbtbpre}enewsshopdd where ddid='$ddid'");
	if(!$r['ddid'])
	{
		printerror('ErrorUrl','');
	}
	$sql=$empire->query("update {$dbtbpre}enewsshopdd_add set retext='$retext' where ddid='$ddid'");
	if($sql)
	{
		$log_bz='';
		$log_addbz="";
		ShopSys_DdInsertLog($ddid,'DdRetext',$log_bz,$log_addbz);//订单日志
		insert_dolog("ddid=$ddid<br>ddno=$r[ddno]");//操作日志
		printerror('DdRetextSuccess',"ShowDd.php?ddid=$ddid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror('DbError','history.go(-1)');
	}
}

//修改优惠金额
function ShopSys_EditPretotal($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"shopdd");
	$ddid=(int)$add['ddid'];
	$bz=eaddslashes(ehtmlspecialchars($add['bz']));
	$pretotal=(float)$add['pretotal'];
	if(!$ddid)
	{
		printerror('ErrorUrl','');
	}
	$r=$empire->fetch1("select ddid,ddno,pretotal from {$dbtbpre}enewsshopdd where ddid='$ddid'");
	if(!$r['ddid'])
	{
		printerror('ErrorUrl','');
	}
	$sql=$empire->query("update {$dbtbpre}enewsshopdd set pretotal='$pretotal' where ddid='$ddid'");
	if($sql)
	{
		$log_bz=$bz;
		$log_addbz="oldpre=$r[pretotal]&newpre=$pretotal";
		ShopSys_DdInsertLog($ddid,'EditPretotal',$log_bz,$log_addbz);//订单日志
		insert_dolog("ddid=$ddid&ddno=$r[ddno]<br>oldpre=$r[pretotal]&newpre=$pretotal");//操作日志
		printerror('DdEditPretotalSuccess',"ShowDd.php?ddid=$ddid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror('DbError','history.go(-1)');
	}
}

//减少或恢复库存
function Shopsys_DoCutMaxnum($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"shopdd");
	$ddid=$add['ddid'];
	$ecms=(int)$add['cutmaxnum'];
	$count=count($ddid);
	if(!$count)
	{
		printerror('NotSetDdid','');
	}
	$log_ecms='DoCutMaxnum';
	$log_bz='';
	$log_addbz="ecms=$ecms";
	$shoppr=ShopSys_hReturnSet();
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$doddid=(int)$ddid[$i];
		if(!$doddid)
		{
			continue;
		}
		$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$doddid'");
		if(empty($ddaddr['buycar']))
		{
			continue;
		}
		$ddr=$empire->fetch1("select havecutnum from {$dbtbpre}enewsshopdd where ddid='$doddid'");
		Shopsys_hCutMaxnum($doddid,$ddaddr['buycar'],$ddr['havecutnum'],$shoppr,$ecms);
		$ids.=$dh.$doddid;
		$dh=',';
		//写入订单日志
		ShopSys_DdInsertLog($doddid,$log_ecms,$log_bz,$log_addbz);
	}
	insert_dolog("ddid=$ids<br>ecms=$ecms");//操作日志
	printerror('CutMaxnumSuccess',$_SERVER['HTTP_REFERER']);
}

//减少库存
function Shopsys_hCutMaxnum($ddid,$buycar,$havecut,$shoppr,$ecms=0){
	global $class_r,$empire,$dbtbpre,$public_r;
	if(empty($buycar))
	{
		return '';
	}
	if($ecms==0&&$havecut)
	{
		return '';
	}
	if($ecms==1&&!$havecut)
	{
		return '';
	}
	if($ecms==0)
	{
		$fh='-';
		$salefh='+';
	}
	else
	{
		$fh='+';
		$salefh='-';
	}
	$record="!";
	$field="|";
	$buycarr=explode($record,$buycar);
	$bcount=count($buycarr);
	for($i=0;$i<$bcount-1;$i++)
	{
		$pr=explode($field,$buycarr[$i]);
		$productid=$pr[1];
		$fr=explode(",",$pr[1]);
		//ID
		$classid=(int)$fr[0];
		$id=(int)$fr[1];
		//数量
		$pnum=(int)$pr[3];
		if($pnum<1)
		{
			$pnum=1;
		}
		if(empty($class_r[$classid][tbname]))
		{
			continue;
		}
		$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]." set pmaxnum=pmaxnum".$fh.$pnum.",psalenum=psalenum".$salefh.$pnum." where id='$id'");
	}
	$newhavecut=$ecms==0?1:0;
	$empire->query("update {$dbtbpre}enewsshopdd set havecutnum='$newhavecut' where ddid='$ddid'");
}

//过期取消订单并还原库存
function ShopSys_hTimeCutMaxnum($userid,$shoppr){
	global $empire,$dbtbpre,$class_r;
	if($shoppr['cutnumtype']==1||$shoppr['cutnumtime']==0)
	{
		return '';
	}
	$userid=(int)$userid;
	$where=$userid?"userid='$userid' and ":"";
	$time=time()-($shoppr['cutnumtime']*60);
	$ddsql=$empire->query("select ddid,havecutnum from {$dbtbpre}enewsshopdd where ".$where."haveprice=0 and checked=0 and havecutnum=1 and ddtruetime<$time");
	while($ddr=$empire->fetch($ddsql))
	{
		$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$ddr[ddid]'");
		Shopsys_hCutMaxnum($ddr['ddid'],$ddaddr['buycar'],$ddr['havecutnum'],$shoppr,1);
	}
	$empire->query("update {$dbtbpre}enewsshopdd set checked=2 where ".$where."haveprice=0 and checked=0 and havecutnum=1 and ddtruetime<$time");
}

//写入订单日志
function ShopSys_DdInsertLog($ddid,$ecms,$bz,$addbz){
	global $empire,$dbtbpre,$logininid,$loginin;
	$ddid=(int)$ddid;
	$ecms=RepPostVar($ecms);
	$logtime=date("Y-m-d H:i:s");
	if(empty($addbz))
	{$addbz="---";}
	$bz=hRepPostStr($bz,1);
	$addbz=addslashes(stripSlashes($addbz));
	$empire->query("insert into {$dbtbpre}enewsshop_ddlog(ddid,userid,username,ecms,bz,addbz,logtime) values('$ddid','$logininid','$loginin','$ecms','$bz','$addbz','$logtime');");
}
?>