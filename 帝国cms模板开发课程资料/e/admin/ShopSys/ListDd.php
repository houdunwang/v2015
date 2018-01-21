<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
require "../".LoadLang("pub/fun.php");
require("class/hShopSysFun.php");
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
CheckLevel($logininid,$loginin,$classid,"shopdd");

//订单设定
function SetShopDd($add,$userid,$username){
	global $empire,$dbtbpre;
	//验证权限
	CheckLevel($userid,$username,$classid,"shopdd");
	$ddid=$add['ddid'];
	$doing=$add['doing'];
	$checked=(int)$add['checked'];
	$haveprice=(int)$add['haveprice'];
	$outproduct=(int)$add['outproduct'];
	$count=count($ddid);
	if(empty($count))
	{
		printerror("NotSetDdid","history.go(-1)");
	}
	$shoppr=ShopSys_hReturnSet();
	$add='';
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$ddid[$i]=(int)$ddid[$i];
		$ids.=$dh.$ddid[$i];
		$dh=',';
    }
	$add='ddid in ('.$ids.')';
	$mess='ErrorUrl';
	$log='';
	if($doing==1)	//订单状态
	{
		$sql=$empire->query("update {$dbtbpre}enewsshopdd set checked='$checked' where ".$add);
		$mess="SetCheckedSuccess";
		$log="doing=$doing&do=SetChecked&checked=$checked<br>ddid=$ids";
		//订单日志
		$log_ecms='SetChecked';
		$log_bz='';
		if($checked==1)
		{
			$log_addbz='确认';
		}
		elseif($checked==2)
		{
			$log_addbz='取消';
		}
		elseif($checked==3)
		{
			$log_addbz='退货';
		}
		elseif($checked==0)
		{
			$log_addbz='未确认';
		}
		//写入订单日志
		if($ids)
		{
			$logsql=$empire->query("select ddid,havecutnum from {$dbtbpre}enewsshopdd where ".$add);
			while($logr=$empire->fetch($logsql))
			{
				ShopSys_DdInsertLog($logr['ddid'],$log_ecms,$log_bz,$log_addbz);//订单日志
				//库存
				if($shoppr['cutnumtype']==0&&$checked==2&&$logr['havecutnum'])
				{
					$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$logr[ddid]'");
					Shopsys_hCutMaxnum($logr['ddid'],$ddaddr['buycar'],$logr['havecutnum'],$shoppr,1);
				}
			}
		}
    }
	elseif($doing==2)	//发货状态
	{
		$sql=$empire->query("update {$dbtbpre}enewsshopdd set outproduct='$outproduct' where ".$add);
		$mess="SetOutProductSuccess";
		$log="doing=$doing&do=SetOutProduct&outproduct=$outproduct<br>ddid=$ids";
		//订单日志
		$log_ecms='SetOutProduct';
		$log_bz='';
		if($outproduct==1)
		{
			$log_addbz='已发货';
		}
		elseif($outproduct==2)
		{
			$log_addbz='备货中';
		}
		elseif($outproduct==0)
		{
			$log_addbz='未发货';
		}
		//写入订单日志
		if($ids)
		{
			$logsql=$empire->query("select ddid from {$dbtbpre}enewsshopdd where ".$add);
			while($logr=$empire->fetch($logsql))
			{
				ShopSys_DdInsertLog($logr['ddid'],$log_ecms,$log_bz,$log_addbz);//订单日志
			}
		}
    }
	elseif($doing==3)	//付款状态
	{
		$sql=$empire->query("update {$dbtbpre}enewsshopdd set haveprice='$haveprice' where ".$add);
		$mess="SetHavepriceSuccess";
		$log="doing=$doing&do=SetHaveprice&haveprice=$haveprice<br>ddid=$ids";
		//订单日志
		$log_ecms='SetHaveprice';
		$log_bz='';
		if($haveprice==1)
		{
			$log_addbz='已付款';
		}
		elseif($haveprice==0)
		{
			$log_addbz='未付款';
		}
		//写入订单日志
		if($ids)
		{
			$logsql=$empire->query("select ddid,havecutnum from {$dbtbpre}enewsshopdd where ".$add);
			while($logr=$empire->fetch($logsql))
			{
				ShopSys_DdInsertLog($logr['ddid'],$log_ecms,$log_bz,$log_addbz);//订单日志
				//库存
				if($shoppr['cutnumtype']==1&&$haveprice==1&&!$logr['havecutnum'])
				{
					$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$logr[ddid]'");
					Shopsys_hCutMaxnum($logr['ddid'],$ddaddr['buycar'],$logr['havecutnum'],$shoppr,0);
				}
			}
		}
    }
	elseif($doing==4)	//删除订单
	{
		$log_ecms='DelDd';
		$log_bz='';
		$log_addbz='';
		//库存
		if($ids)
		{
			$logsql=$empire->query("select ddid,havecutnum,checked,haveprice from {$dbtbpre}enewsshopdd where ".$add." and havecutnum=1");
			while($logr=$empire->fetch($logsql))
			{
				if($logr['haveprice']==1)
				{
					continue;
				}
				if($logr['havecutnum'])
				{
					$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$logr[ddid]'");
					Shopsys_hCutMaxnum($logr['ddid'],$ddaddr['buycar'],$logr['havecutnum'],$shoppr,1);
				}
			}
		}
		$sql=$empire->query("delete from {$dbtbpre}enewsshopdd where ".$add);
		$sql2=$empire->query("delete from {$dbtbpre}enewsshopdd_add where ".$add);
		$sql3=$empire->query("delete from {$dbtbpre}enewsshop_ddlog where ".$add);
		$mess="DelDdSuccess";
		$log="doing=$doing&do=DelDd<br>ddid=$ids";
    }
	else
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	if($sql)
	{
		//操作日志
		insert_dolog($log);
		printerror($mess,$_SERVER['HTTP_REFERER']);
	}
	else
	{printerror("DbError","history.go(-1)");}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="SetShopDd")
{
	SetShopDd($_POST,$logininid,$loginin);
}
else
{}

//更新库存
$shoppr=ShopSys_hReturnSet();
ShopSys_hTimeCutMaxnum(0,$shoppr);

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=18;//每页显示链接数
$offset=$page*$line;//总偏移量
$totalquery="select count(*) as total from {$dbtbpre}enewsshopdd";
$query="select ddid,ddno,ddtime,userid,username,outproduct,haveprice,checked,truename,psid,psname,pstotal,alltotal,payfsid,payfsname,payby,alltotalfen,fp,fptotal,pretotal from {$dbtbpre}enewsshopdd";
$add='';
$and=' where ';
//搜索
$sear=RepPostStr($_GET['sear'],1);
if($sear)
{
	$keyboard=$_GET['keyboard'];
	$keyboard=RepPostVar2($keyboard);
	if($keyboard)
	{
		$show=(int)$_GET['show'];
		if($show==1)//搜索订单号
		{
			$add=$and."ddno like '%$keyboard%'";
		}
		elseif($show==2)//用户名
		{
			$add=$and."username like '%$keyboard%'";
		}
		elseif($show==3)//姓名
		{
			$add=$and."truename like '%$keyboard%'";
		}
		elseif($show==4)//邮箱
		{
			$add=$and."email like '%$keyboard%'";
		}
		else//地址
		{
			$add=$and."address like '%$keyboard%'";
		}
		$and=' and ';
	}
	//订单状态
	$checked=(int)$_GET['checked'];
	if($checked==1)//已确认
	{
		$add.=$and."checked=1";
		$and=' and ';
	}
	elseif($checked==9)//未确认
	{
		$add.=$and."checked=0";
		$and=' and ';
	}
	elseif($checked==2)//取消
	{
		$add.=$and."checked=2";
		$and=' and ';
	}
	elseif($checked==3)//退货
	{
		$add.=$and."checked=3";
		$and=' and ';
	}
	//是否付款
	$haveprice=(int)$_GET['haveprice'];
	if($haveprice==1)//已付款
	{
		$add.=$and."haveprice=1";
		$and=' and ';
	}
	elseif($haveprice==9)//未付款
	{
		$add.=$and."haveprice=0";
		$and=' and ';
	}
	//是否发货
	$outproduct=(int)$_GET['outproduct'];
	if($outproduct==1)//已发货
	{
		$add.=$and."outproduct=1";
		$and=' and ';
	}
	elseif($outproduct==9)//未发货
	{
		$add.=$and."outproduct=0";
		$and=' and ';
	}
	elseif($outproduct==2)//备货中
	{
		$add.=$and."outproduct=2";
		$and=' and ';
	}
	//时间
	$starttime=RepPostVar($_GET['starttime']);
	$endtime=RepPostVar($_GET['endtime']);
	if($endtime!="")
	{
		$ostarttime=$starttime." 00:00:00";
		$oendtime=$endtime." 23:59:59";
		$add.=$and."ddtime>='$ostarttime' and ddtime<='$oendtime'";
		$and=' and ';
	}
	$search.="&sear=1&keyboard=$keyboard&show=$show&checked=$checked&outproduct=$outproduct&haveprice=$haveprice&starttime=$starttime&endtime=$endtime";
}
//排序
$myorder=(int)$_GET['myorder'];
if($myorder==2)//商品金额
{
	$orderby='alltotal desc';
}
elseif($myorder==3)
{
	$orderby='alltotal asc';
}
elseif($myorder==4)//商品点数
{
	$orderby='alltotalfen desc';
}
elseif($myorder==5)
{
	$orderby='alltotalfen asc';
}
elseif($myorder==6)//优惠金额
{
	$orderby='pretotal desc';
}
elseif($myorder==7)
{
	$orderby='pretotal asc';
}
elseif($myorder==1)//订单时间
{
	$orderby='ddid asc';
}
else
{
	$orderby='ddid desc';
}
$totalquery.=$add;
$query.=$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by ".$orderby." limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理订单</title>
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
<script src="../ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<a href="ListDd.php<?=$ecms_hashur['whehref']?>">管理订单</a></td>
  </tr>
</table>

  
<form name="form1" method="get" action="ListDd.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td>搜索: <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>"> 
        <select name="show" id="show">
          <option value="1"<?=$show==1?' selected':''?>>订单号</option>
          <option value="2"<?=$show==2?' selected':''?>>用户名</option>
		  <option value="3"<?=$show==3?' selected':''?>>收货人姓名</option>
		  <option value="4"<?=$show==4?' selected':''?>>收货人邮箱</option>
		  <option value="5"<?=$show==5?' selected':''?>>收货人地址</option>
        </select> 
        <select name="checked" id="checked">
          <option value="0"<?=$checked==0?' selected':''?>>不限订单状态</option>
          <option value="1"<?=$checked==1?' selected':''?>>已确认</option>
          <option value="9"<?=$checked==9?' selected':''?>>未确认</option>
		  <option value="2"<?=$checked==2?' selected':''?>>取消</option>
		  <option value="3"<?=$checked==3?' selected':''?>>退货</option>
        </select> 
        <select name="outproduct" id="outproduct">
          <option value="0"<?=$outproduct==0?' selected':''?>>不限发货状态</option>
          <option value="1"<?=$outproduct==1?' selected':''?>>已发货</option>
          <option value="9"<?=$outproduct==9?' selected':''?>>未发货</option>
		  <option value="2"<?=$outproduct==2?' selected':''?>>备货中</option>
        </select>
        <select name="haveprice" id="haveprice">
          <option value="0"<?=$haveprice==0?' selected':''?>>不限付款状态</option>
          <option value="1"<?=$haveprice==1?' selected':''?>>已付款</option>
          <option value="9"<?=$haveprice==9?' selected':''?>>未付款</option>
        </select>
        <select name="myorder" id="myorder">
          <option value="0"<?=$myorder==0?' selected':''?>>订单时间降序</option>
          <option value="1"<?=$myorder==1?' selected':''?>>订单时间升序</option>
          <option value="2"<?=$myorder==2?' selected':''?>>商品金额降序</option>
          <option value="3"<?=$myorder==3?' selected':''?>>商品金额升序</option>
          <option value="4"<?=$myorder==4?' selected':''?>>商品点数降序</option>
          <option value="5"<?=$myorder==5?' selected':''?>>商品点数升序</option>
          <option value="6"<?=$myorder==6?' selected':''?>>优惠金额升序</option>
          <option value="7"<?=$myorder==7?' selected':''?>>优惠金额降序</option>
        </select></td>
    </tr>
    <tr>
      <td>时间:从 
        <input name="starttime" type="text" id="starttime2" value="<?=$starttime?>" size="12" onclick="setday(this)">
        到 
        <input name="endtime" type="text" id="endtime2" value="<?=$endtime?>" size="12" onclick="setday(this)">
        止的订单 
        <input type="submit" name="Submit6" value="搜索"> <input name="sear" type="hidden" id="sear2" value="1"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class=tableborder>
  <form name="listdd" method="post" action="ListDd.php" onsubmit="return confirm('确认要操作?');">
  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=SetShopDd>
    <input type=hidden name=doing value=0>
    <tr class=header> 
      <td width="5%" height="23"> <div align="center">选择</div></td>
      <td width="19%"><div align="center">编号(点击查看)</div></td>
      <td width="21%"><div align="center">订购时间</div></td>
      <td width="13%"><div align="center">订购者</div></td>
      <td width="11%"><div align="center">总金额</div></td>
      <td width="12%"><div align="center">支付方式</div></td>
      <td width="19%"><div align="center">状态</div></td>
    </tr>
    <?
	while($r=$empire->fetch($sql))
	{
		if(empty($r[userid]))//非会员
		{
			$username="<font color=cccccc>".$r[truename]."</font>";
		}
		else
		{
			$username="<a href='../member/AddMember.php?enews=EditMember&userid=".$r[userid].$ecms_hashur['ehref']."' target=_blank>".$r[username]."</a>";
		}
		//点数购买
		$total=0;
		if($r[payby]==1)
		{
			$total=$r[alltotalfen]+$r[pstotal];
			$mytotal="<a href='#ecms' title='商品额(".$r[alltotalfen].")+运费(".$r[pstotal].")'>".$total." 点</a>";
		}
		else
		{
			//发票
			$fpa='';
			$pre='';
			if($r[fp])
			{
				$fpa="+发票费(".$r[fptotal].")";
			}
			//优惠
			if($r['pretotal'])
			{
				$pre="-优惠(".$r[pretotal].")";
			}
			$total=$r[alltotal]+$r[pstotal]+$r[fptotal]-$r[pretotal];
			$mytotal="<a href='#ecms' title='商品额(".$r[alltotal].")+运费(".$r[pstotal].")".$fpa.$pre."'>".$total." 元</a>";
		}
		//支付方式
		if($r[payby]==1)
		{
			$payfsname=$r[payfsname]."<br>(点数购买)";
		}
		elseif($r[payby]==2)
		{
			$payfsname=$r[payfsname]."<br>(余额购买)";
		}
		else
		{
			$payfsname=$r[payfsname];
		}
		//订单状态
		if($r['checked']==1)
		{
			$ch="已确认";
		}
		elseif($r['checked']==2)
		{
			$ch="取消";
		}
		elseif($r['checked']==3)
		{
			$ch="退货";
		}
		else
		{
			$ch="<font color=red>未确认</font>";
		}
		//发货状态
		if($r['outproduct']==1)
		{
			$ou="已发货";
		}
		elseif($r['outproduct']==2)
		{
			$ou="备货中";
		}
		else
		{
			$ou="<font color=red>未发货</font>";
		}
		//付款状态
		if($r['haveprice']==1)
		{
			$ha="已付款";
		}
		else
		{
			$ha="<font color=red>未付款</font>";
		}
	?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td height="25"> <div align="center"> 
          <input name="ddid[]" type="checkbox" id="ddid[]" value="<?=$r[ddid]?>">
        </div></td>
      <td> <div align="center"><a href="#ecms" onclick="window.open('ShowDd.php?ddid=<?=$r[ddid]?><?=$ecms_hashur['ehref']?>','','width=700,height=600,scrollbars=yes,resizable=yes');">
          <?=$r[ddno]?>
          </a></div></td>
      <td> <div align="center">
          <?=$r[ddtime]?>
        </div></td>
      <td> <div align="center">
          <?=$username?>
        </div></td>
      <td> <div align="center">
          <?=$mytotal?>
        </div></td>
      <td><div align="center">
          <?=$payfsname?>
        </div></td>
      <td> <div align="center"><strong><?=$ha?></strong>/<strong><?=$ou?></strong>/<strong><?=$ch?></strong></div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td> <div align="center"> 
          <input type=checkbox name=chkall value=on onClick='CheckAll(this.form)'>
        </div></td>
      <td colspan="6"><select name="checked" id="checked">
        <option value="1">确认</option>
        <option value="2">取消</option>
        <option value="3">退货</option>
        <option value="0">未确认</option>
      </select>
      <input type="submit" name="Submit" value="设置订单状态" onClick="document.listdd.doing.value='1';document.listdd.enews.value='SetShopDd';document.listdd.action='ListDd.php';"> 
        &nbsp;
        <select name="outproduct" id="outproduct">
          <option value="1">已发货</option>
          <option value="2">备货中</option>
          <option value="0">未发货</option>
        </select> 
        <input type="submit" name="Submit2" value="设置发货状态" onClick="document.listdd.doing.value='2';document.listdd.enews.value='SetShopDd';document.listdd.action='ListDd.php';"> 
        &nbsp;
        <select name="haveprice" id="haveprice">
          <option value="1">已付款</option>
          <option value="0">未付款</option>
        </select> 
        <input type="submit" name="Submit3" value="设置付款状态" onClick="document.listdd.doing.value='3';document.listdd.enews.value='SetShopDd';document.listdd.action='ListDd.php';">
&nbsp;
<select name="cutmaxnum" id="cutmaxnum">
  <option value="1">还原库存</option>
  <option value="0">减少库存</option>
</select>
<input type="submit" name="Submit32" value="设置库存" onClick="document.listdd.doing.value='5';document.listdd.enews.value='DoCutMaxnum';document.listdd.action='ecmsshop.php';">
        &nbsp; 
		<input type="submit" name="Submit5" value="删除订单" onClick="document.listdd.doing.value='4';document.listdd.enews.value='SetShopDd';document.listdd.action='ListDd.php';"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td> <div align="center"></div></td>
      <td colspan="6"> <div align="left">&nbsp;
          <?=$returnpage?>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td colspan="6"><font color="#666666">订购者为灰色,则为非会员购买；退货不自动还原库存，需手动还原库存；已还原过的库存系统不会重复还原。</font></td>
    </tr>
  </form>
</table>

</body>
</html>
<?
db_close();
$empire=null;
?>
