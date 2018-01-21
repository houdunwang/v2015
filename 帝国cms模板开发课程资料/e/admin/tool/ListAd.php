<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
CheckLevel($logininid,$loginin,$classid,"ad");

//增加广告
function AddAd($add,$titlefont,$titlecolor,$userid,$username){
	global $empire,$dbtbpre;
	if(!$add[classid]||!$add[title]||!$add[adtype])
	{printerror("EmptyAd","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"ad");
	$add[htmlcode]=AddAddsData(RepPhpAspJspcodeText($add[htmlcode]));
	$add[reptext]=AddAddsData(RepPhpAspJspcodeText($add[reptext]));
	$ttitlefont=TitleFont($titlefont,'no');
	//变量处理
	$add['title']=hRepPostStr($add['title'],1);
	$add[pic_width]=(int)$add[pic_width];
	$add[pic_height]=(int)$add[pic_height];
	$add[classid]=(int)$add[classid];
	$add[adtype]=(int)$add[adtype];
	$add[t]=(int)$add[t];
	$add[ylink]=(int)$add[ylink];
	$add['filepass']=(int)$add['filepass'];
	$sql=$empire->query("insert into {$dbtbpre}enewsad(picurl,url,pic_width,pic_height,onclick,classid,adtype,title,target,alt,starttime,endtime,adsay,titlefont,titlecolor,htmlcode,t,ylink,reptext) values('$add[picurl]','$add[url]',$add[pic_width],$add[pic_height],0,$add[classid],$add[adtype],'$add[title]','$add[target]','$add[alt]','$add[starttime]','$add[endtime]','$add[adsay]','$ttitlefont','$titlecolor','$add[htmlcode]',$add[t],$add[ylink],'$add[reptext]');");
	$adid=$empire->lastid();
	//更新附件
	UpdateTheFileOther(3,$adid,$add['filepass'],'other');
	GetAdJs($adid);
	if($sql)
	{
		//操作日志
		insert_dolog("adid=".$adid."<br>title=".$add[title]);
		printerror("AddAdSuccess","AddAd.php?enews=AddAd&t=".$add[t].hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改广告
function EditAd($add,$titlefont,$titlecolor,$userid,$username){
	global $empire,$time,$dbtbpre;
	$add[adid]=(int)$add[adid];
	if(!$add[classid]||!$add[title]||!$add[adtype]||!$add[adid])
	{printerror("EmptyAd","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"ad");
	$add[htmlcode]=AddAddsData(RepPhpAspJspcodeText($add[htmlcode]));
	$add[reptext]=AddAddsData(RepPhpAspJspcodeText($add[reptext]));
	$ttitlefont=TitleFont($titlefont,'no');
	//重置
	if($add[reset])
	{$a=",onclick=0";}
	//变量处理
	$add['title']=hRepPostStr($add['title'],1);
	$add[pic_width]=(int)$add[pic_width];
	$add[pic_height]=(int)$add[pic_height];
	$add[classid]=(int)$add[classid];
	$add[adtype]=(int)$add[adtype];
	$add[t]=(int)$add[t];
	$add[ylink]=(int)$add[ylink];
	$add['filepass']=(int)$add['filepass'];
	$sql=$empire->query("update {$dbtbpre}enewsad set picurl='$add[picurl]',url='$add[url]',pic_width=$add[pic_width],pic_height=$add[pic_height],classid=$add[classid],adtype=$add[adtype],title='$add[title]',target='$add[target]',alt='$add[alt]',starttime='$add[starttime]',endtime='$add[endtime]',adsay='$add[adsay]',titlefont='$ttitlefont',titlecolor='$titlecolor',htmlcode='$add[htmlcode]',t=$add[t],ylink=$add[ylink],reptext='$add[reptext]'".$a." where adid='$add[adid]'");
	UpdateTheFileEditOther(3,$add['adid'],'other');
	GetAdJs($add[adid]);
	if($sql)
	{
		//操作日志
		insert_dolog("adid=".$add[adid]."<br>title=".$add[title]);
		printerror("EditAdSuccess","ListAd.php?time=$time".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除广告
function DelAd($adid,$userid,$username){
	global $empire,$time,$public_r,$dbtbpre;
	$adid=(int)$adid;
	if(!$adid)
	{printerror("NotDelAdid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"ad");
	$r=$empire->fetch1("select title from {$dbtbpre}enewsad where adid='$adid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsad where adid='$adid'");
	$file="../../../d/js/acmsd/".$public_r[adfile].$adid.".js";
	DelFiletext($file);
	//删除附件
	DelFileOtherTable("modtype=3 and id='$adid'");
	if($sql)
	{
		//操作日志
		insert_dolog("adid=".$adid."<br>title=".$r[title]);
		printerror("DelAdSuccess","ListAd.php?time=$time".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//批量生成广告
function ReAdJs_all($start=0,$from,$userid,$username){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$start=(int)$start;
	if(empty($start))
	{
		$start=0;
    }
	$b=0;
	$sql=$empire->query("select adid from {$dbtbpre}enewsad where adid>$start order by adid limit ".$public_r['readjsnum']);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r[adid];
		GetAdJs($r[adid]);
	}
	if(empty($b))
	{
		//操作日志
		insert_dolog("");
		printerror("ReAdJsSuccess",$from);
	}
	echo $fun_r['OneReAdJsSuccess']."(ID:<font color=red><b>".$newstart."</b></font>)<script>self.location.href='ListAd.php?enews=ReAdJs_all&start=$newstart&from=".urlencode($from).hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//清除注释
function ClearHtmlZs($text){
	$text=str_replace('<!--','',$text);
	$text=str_replace('//-->','',$text);
	$text=str_replace('-->','',$text);
	return $text;
}

//生成广告js
function GetAdJs($adid){
	global $empire,$public_r,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsad where adid='$adid'");
	$file="../../../d/js/acmsd/".$public_r[adfile].$adid.".js";
	//到期
	if($r['endtime']<>'0000-00-00'&&time()>to_time($r['endtime']))
	{
		$r[reptext]=ClearHtmlZs($r[reptext]);
		$h=addslashes(str_replace("\r\n","",$r[reptext]));
		$html="document.write(\"".$h."\")";
		WriteFiletext_n($file,$html);
		return '';
	}
	if($r['ylink'])
	{
		$ad_url=$r['url'];
	}
	else
	{
		$ad_url=$public_r[newsurl]."e/public/ClickAd?adid=".$adid;//广告链接
	}
	//----------------------文字广告
	if($r[t]==1)
	{
		$r[titlefont]=$r[titlecolor].','.$r[titlefont];
		$picurl=DoTitleFont($r[titlefont],$r[picurl]);//文字属性
		$h="<a href='".$ad_url."' target=".$r[target]." title='".$r[alt]."'>".addslashes($picurl)."</a>";
		//普通显示
		if($r[adtype]==1)
		{
			$html="document.write(\"".$h."\")";
	    }
		//可移动透明对话框
		else
		{
			$html="document.write(\"<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_dialog.js></script>\"); 
document.write(\"<div style='position:absolute;left:300px;top:150px;width:".$r[pic_width]."; height:".$r[pic_height].";z-index:1;solid;filter:alpha(opacity=90)' id=DGbanner5 onmousedown='down1(this)' onmousemove='move()' onmouseup='down=false'><table cellpadding=0 border=0 cellspacing=1 width=".$r[pic_width]." height=".$r[pic_height]." bgcolor=#000000><tr><td height=18 bgcolor=#5A8ACE align=right style='cursor:move;'><a href=# style='font-size: 9pt; color: #eeeeee; text-decoration: none' onClick=clase('DGbanner5') >关闭>>><img border='0' src='".$public_r[newsurl]."d/js/acmsd/close_o.gif'></a>&nbsp;</td></tr><tr><td bgcolor=f4f4f4 >&nbsp;".$h."</td></tr></table></div>\");";
	    }
    }
	//------------------html广告
	elseif($r[t]==2)
	{
		$r[htmlcode]=ClearHtmlZs($r[htmlcode]);
		$h=addslashes(str_replace("\r\n","",$r[htmlcode]));
		//普通显示
		if($r[adtype]==1)
		{
			$html="document.write(\"".$h."\")";
		}
		//可移动透明对话框
		else
		{
			$html="document.write(\"<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_dialog.js></script>\"); 
document.write(\"<div style='position:absolute;left:300px;top:150px;width:".$r[pic_width]."; height:".$r[pic_height].";z-index:1;solid;filter:alpha(opacity=90)' id=DGbanner5 onmousedown='down1(this)' onmousemove='move()' onmouseup='down=false'><table cellpadding=0 border=0 cellspacing=1 width=".$r[pic_width]." height=".$r[pic_height]." bgcolor=#000000><tr><td height=18 bgcolor=#5A8ACE align=right style='cursor:move;'><a href=# style='font-size: 9pt; color: #eeeeee; text-decoration: none' onClick=clase('DGbanner5') >关闭>>><img border='0' src='".$public_r[newsurl]."d/js/acmsd/close_o.gif'></a>&nbsp;</td></tr><tr><td bgcolor=f4f4f4 >&nbsp;".$h."</td></tr></table></div>\");";
		}
    }
	//------------------弹出广告
	elseif($r[t]==3)
	{
		//打开新窗口
		if($r[adtype]==8)
		{
			$html="window.open('".$r[url]."');";
		}
		//弹出窗口
	    elseif($r[adtype]==9)
		{
			$html="window.open('".$r[url]."','','width=".$r[pic_width].",height=".$r[pic_height].",scrollbars=yes');";
		}
		//普能网页窗口
		else
		{
			$html="window.showModalDialog('".$r[url]."','','dialogWidth:".$r[pic_width]."px;dialogHeight:".$r[pic_height]."px;scroll:no;status:no;help:no');";
		}
    }
	//---------------------图片与flash广告
	else
	{
	$filetype=GetFiletype($r[picurl]);
	
	//flash
		if($filetype==".swf")
		{
		$h="<object classid=\\\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\\\" codebase=\\\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\\\" name=\\\"movie\\\" width=\\\"".$r[pic_width]."\\\" height=\\\"".$r[pic_height]."\\\" id=\\\"movie\\\"><param name=\\\"movie\\\" value=\\\"".$r[picurl]."\\\"><param name=\\\"quality\\\" value=\\\"high\\\"><param name=\\\"menu\\\" value=\\\"false\\\"><embed src=\\\"".$r[picurl]."\\\" width=\\\"".$r[pic_width]."\\\" height=\\\"".$r[pic_height]."\\\" quality=\\\"high\\\" pluginspage=\\\"http://www.macromedia.com/go/getflashplayer\\\" type=\\\"application/x-shockwave-flash\\\" id=\\\"movie\\\" name=\\\"movie\\\" menu=\\\"false\\\"></embed><PARAM NAME='wmode' VALUE='Opaque'></object>";
	    }
	else
		{
		$h="<a href='".$ad_url."' target=".$r[target]."><img src='".$r[picurl]."' border=0 width='".$r[pic_width]."' height='".$r[pic_height]."' alt='".$r[alt]."'></a>";
	    }
		//普通显示
			if($r[adtype]==1)
		{
			$html="document.write(\"".$h."\");";
		}
		//满屏浮动显示
		elseif($r[adtype]==4)
		{
			$html="ns4=(document.layers)?true:false;
ie4=(document.all)?true:false;
if(ns4){document.write(\"<layer id=DGbanner2 width=".$r[pic_width]." height=".$r[pic_height]." onmouseover=stopme('DGbanner2') onmouseout=movechip('DGbanner2')>".$h."</layer>\");}
else{document.write(\"<div id=DGbanner2 style='position:absolute; width:".$r[pic_width]."px; height:".$r[pic_height]."px; z-index:9; filter: Alpha(Opacity=90)' onmouseover=stopme('DGbanner2') onmouseout=movechip('DGbanner2')>".$h."</div>\");}
document.write(\"<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_float_fullscreen.js></script>\");";
		}
		//上下浮动显示 - 右
		elseif($r[adtype]==5)
		{
			$html="if (navigator.appName == 'Netscape')
{document.write(\"<layer id=DGbanner3 top=150 width=".$r[pic_width]." height=".$r[pic_height].">".$h."</layer>\");}
else{document.write(\"<div id=DGbanner3 style='position: absolute;width:".$r[pic_height].";top:150;visibility: visible;z-index: 1'>".$h."</div>\");}
document.write(\"<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_float_upanddown.js></script>\");";
		}
		//上下浮动显示 - 左
		elseif($r[adtype]==6)
		{
			$html="if(navigator.appName == 'Netscape')
{document.write(\"<layer id=DGbanner10 top=150 width=".$r[pic_width]." height=".$r[pic_height].">".$h."</layer>\");}
else{document.write(\"<div id=DGbanner10 style='position: absolute;width:".$r[pic_width].";top:150;visibility: visible;z-index: 1'>".$h."</div>\");}
document.write(\"<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_float_upanddown_L.js></script>\");";
		}
		//全屏幕渐隐消失
		elseif($r[adtype]==7)
		{
			$html="ns4=(document.layers)?true:false;
if(ns4){document.write(\"<layer id=DGbanner4Cont onLoad='moveToAbsolute(layer1.pageX-160,layer1.pageY);clip.height=".$r[pic_height].";clip.width=".$r[pic_width]."; visibility=show;'><layer id=DGbanner4News position:absolute; top:0; left:0>".$h."</layer></layer>\");}
else{document.write(\"<div id=DGbanner4 style='position:absolute;top:0; left:0;'><div id=DGbanner4Cont style='position:absolute;width:".$r[pic_width].";height:".$r[pic_height].";clip:rect(0,".$r[pic_width].",".$r[pic_height].",0)'><div id=DGbanner4News style='position:absolute;top:0;left:0;right:820'>".$h."</div></div></div>\");} 
document.write(\"<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_fullscreen.js></script>\");";
		}
		//可移动透明对话框
		elseif($r[adtype]==3)
		{
			$html="document.write(\"<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_dialog.js></script>\"); 
document.write(\"<div style='position:absolute;left:300px;top:150px;width:".$r[pic_width]."; height:".$r[pic_height].";z-index:1;solid;filter:alpha(opacity=90)' id=DGbanner5 onmousedown='down1(this)' onmousemove='move()' onmouseup='down=false'><table cellpadding=0 border=0 cellspacing=1 width=".$r[pic_width]." height=".$r[pic_height]." bgcolor=#000000><tr><td height=18 bgcolor=#5A8ACE align=right style='cursor:move;'><a href=# style='font-size: 9pt; color: #eeeeee; text-decoration: none' onClick=clase('DGbanner5') >关闭>>><img border='0' src='".$public_r[newsurl]."d/js/acmsd/close_o.gif'></a>&nbsp;</td></tr><tr><td bgcolor=f4f4f4 >&nbsp;".$h."</td></tr></table></div>\");";
		}
		else
		{
			$html="function closeAd(){huashuolayer2.style.visibility='hidden';huashuolayer3.style.visibility='hidden';}function winload(){huashuolayer2.style.top=109;huashuolayer2.style.left=5;huashuolayer3.style.top=109;huashuolayer3.style.right=5;}//if(document.body.offsetWidth>800){
				{document.write(\"<div id=huashuolayer2 style='position: absolute;visibility:visible;z-index:1'><table width=0  border=0 cellspacing=0 cellpadding=0><tr><td height=10 align=right bgcolor=666666><a href=javascript:closeAd()><img src=".$public_r[newsurl]."d/js/acmsd/close.gif width=12 height=10 border=0></a></td></tr><tr><td>".$h."</td></tr></table></div>\"+\"<div id=huashuolayer3 style='position: absolute;visibility:visible;z-index:1'><table width=0  border=0 cellspacing=0 cellpadding=0><tr><td height=10 align=right bgcolor=666666><a href=javascript:closeAd()><img src=".$public_r[newsurl]."d/js/acmsd/close.gif width=12 height=10 border=0></a></td></tr><tr><td>".$h."</td></tr></table></div>\");}winload()//}";
		}
    }
	WriteFiletext_n($file,$html);
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//增加广告
if($enews=="AddAd")
{
	$add=$_POST['add'];
	$add[picurl]=$_POST['picurl'];
	$titlefont=$_POST['titlefont'];
	$titlecolor=$_POST['titlecolor'];
	$add['filepass']=$_POST['filepass'];
	AddAd($add,$titlefont,$titlecolor,$logininid,$loginin);
}
//修改广告
elseif($enews=="EditAd")
{
	$add=$_POST['add'];
	$add[picurl]=$_POST['picurl'];
	$titlefont=$_POST['titlefont'];
	$titlecolor=$_POST['titlecolor'];
	$time=$_POST['time'];
	$add['filepass']=$_POST['filepass'];
	EditAd($add,$titlefont,$titlecolor,$logininid,$loginin);
}
//删除广告
elseif($enews=="DelAd")
{
	$adid=$_GET['adid'];
	$time=$_POST['time'];
	DelAd($adid,$logininid,$loginin);
}
//批量刷新广告JS
elseif($enews=="ReAdJs_all")
{
	ReAdJs_all($_GET['start'],$_GET['from'],$logininid,$loginin);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$totalquery="select count(*) as total from {$dbtbpre}enewsad";
$query="select * from {$dbtbpre}enewsad";
//过期广告
$search='';
$search.=$ecms_hashur['ehref'];
$where='';
$and='';
$time=(int)$_GET['time'];
if($time)
{
	$date=date("Y-m-d");
	$where.="endtime<'$date' and endtime<>'0000-00-00'";
	$and=' and ';
	$search.="&time=$time";
}
//搜索
$sear=(int)$_GET['sear'];
if($sear)
{
	$keyboard=RepPostVar2($_GET['keyboard']);
	$show=(int)$_GET['show'];
	$classid=(int)$_GET['classid'];
	$t=(int)$_GET['t'];
	if($keyboard)
	{
		if($show==1)
		{
			$where.=$and."title like '%$keyboard%'";
		}
		elseif($show==2)
		{
			$where.=$and."adsay like '%$keyboard%'";
		}
		else
		{
			$where.=$and."(title like '%$keyboard%' or adsay like '%$keyboard%')";
		}
		$and=' and ';
	}
	if($classid)
	{
		$where.=$and."classid='$classid'";
		$and=' and ';
	}
	if($t!=9)
	{
		$where.=$and."t='$t'";
		$and=' and ';
	}
	$search.="&classid=$classid&show=$show&t=$t&sear=1&keyboard=$keyboard";
}
if($where)
{
	$totalquery.=' where '.$where;
	$query.=' where '.$where;
}
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by adid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$ty[1]="普通显示";
$ty[2]="";
$ty[3]="可移动透明对话框";
$ty[4]="满屏浮动显示";
$ty[5]="上下浮动显示 - 右";
$ty[6]="上下浮动显示 - 左";
$ty[7]="全屏幕渐隐消失";
$ty[8]="打开新窗口";
$ty[9]="弹出窗口";
$ty[10]="普通网页对话框";
$ty[11]="对联式广告";
$myt[1]="文字广告";
$myt[2]="html广告";
$myt[3]="弹出广告";
$myt[0]="图片与flash广告";
//广告类别
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsadclass");
while($cr=$empire->fetch($csql))
{
	$cselected='';
	if($classid==$cr['classid'])
	{
		$cselected=' selected';
	}
	$options.="<option value=".$cr[classid].$cselected.">".$cr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理广告</title>
<script>
function eCopyAdStr(adid,isjs){
	var str='';
	if(isjs==1)
	{
		str='<scri'+'pt src="<?=$public_r[newsurl]?>d/js/acmsd/<?=$public_r[adfile]?>'+adid+'.js"></scri'+'pt>';
	}
	else
	{
		str='[phomead]'+adid+'[/phomead]';
	}
	window.clipboardData.setData('Text',str);
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="20%" height="25">位置：<a href="ListAd.php<?=$ecms_hashur['whehref']?>">管理广告</a></td>
    <td width="80%"><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加广告" onclick="self.location.href='AddAd.php?enews=AddAd<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
        <input type="button" name="Submit52" value="管理过期广告" onclick="self.location.href='ListAd.php?time=1<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
        <input type="button" name="Submit522" value="管理广告分类" onclick="self.location.href='AdClass.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<form name="form1" method="get" action="ListAd.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
			<?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">关键字： 
        <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
        <select name="show">
		<option value="0"<?=$show==0?' selected':''?>>不限</option>
		<option value="1"<?=$show==1?' selected':''?>>广告名称 </option>
		<option value="2"<?=$show==2?' selected':''?>>备注</option>
        </select>
        <select name="classid" id="classid">
          <option value="0">不限类别</option>
          <?=$options?>
        </select> <select name="t" id="t">
          <option value="9"<?=$sear&&$t==9?' selected':''?>>不限广告类型</option>
          <option value="0"<?=$sear&&$t==0?' selected':''?>>图片与flash广告</option>
          <option value="1"<?=$sear&&$t==1?' selected':''?>>文字广告</option>
          <option value="2"<?=$sear&&$t==2?' selected':''?>>html广告</option>
          <option value="3"<?=$sear&&$t==3?' selected':''?>>弹出广告</option>
        </select>
        <input name="time" type="checkbox" id="time" value="1"<?=$time==1?' checked':''?>>
        过期广告 
        <input type="submit" name="Submit" value="搜索"> <input name="sear" type="hidden" id="sear" value="1"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <tr class="header"> 
    <td width="4%" height="25"><div align="center">ID</div></td>
    <td width="20%"><div align="center">广告名称</div></td>
    <td width="11%"><div align="center">广告类型</div></td>
    <td width="7%"><div align="center">过期时间</div></td>
    <td width="18%"><div align="center">JS调用</div></td>
    <td width="5%"><div align="center">点击</div></td>
    <td width="18%"><div align="center">备注</div></td>
    <td width="17%"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[adid]?>
      </div></td>
    <td> <div align="center"> 
        <b><?=$r[title]?></b>
      </div></td>
    <td> <div align="center"> 
        <?=$myt[$r[t]]?>
        <br>
        (<?=$ty[$r[adtype]]?>)</div></td>
    <td> <div align="center"> 
        <?=$r[endtime]?>
      </div></td>
    <td> <div align="center"> 
        <input name="textfield" type="text" value="<?=$public_r[newsurl]?>d/js/acmsd/<?=$public_r['adfile']?><?=$r[adid]?>.js" size="26">
        <br>
        <a href="#ecms" onclick="eCopyAdStr(<?=$r[adid]?>,1);" title="点击复制JS调用代码">JS调用</a> | <a href="#ecms" onclick="eCopyAdStr(<?=$r[adid]?>,0);" title="点击复制标签调用代码">标签调用</a><br>
      </div></td>
    <td> <div align="center"> 
        <?=$r[onclick]?>
      </div></td>
    <td> <div align="center"> 
        <textarea name="textarea" cols="20" rows="3"><?=$r[adsay]?></textarea>
      </div></td>
    <td> <div align="center"><a href="../view/js.php?js=<?=$public_r['adfile']?><?=$r[adid]?>&p=acmsd<?=$ecms_hashur['ehref']?>" target="_blank">预览</a> | <a href="AddAd.php?enews=EditAd&adid=<?=$r[adid]?>&time=<?=$time?><?=$ecms_hashur['ehref']?>">修改</a> | <a href="ListAd.php?enews=DelAd&adid=<?=$r[adid]?>&time=<?=$time?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a></div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="8"> 
      <?=$returnpage?>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="25"><font color="#666666">说明：调用方式：&lt;script src=广告js地址&gt;&lt;/script&gt;或用标签调用</font></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
