<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$lur=is_login();
$logininid=(int)$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

//显示无限级栏目缓存
function CreateClassCache($bclassid,$exp,$expjs,$expmodjs,$adminclass,$doall,$mid,$addminfocid,$oldmid,$oldaddminfocid,$userid){
	global $empire,$fun_r,$dbtbpre,$public_r;
	if(empty($bclassid))
	{
		$bclassid=0;
		$exp='';
		$expjs='|-';
		$expmodjs='|-';
    }
	else
	{
		$exp='&nbsp;&nbsp;&nbsp;'.$exp;
		$expjs='&nbsp;&nbsp;'.$expjs;
		$expmodjs="&nbsp;&nbsp;".$expmodjs;
	}
	$sql=$empire->query("select classid,classname,bclassid,islast,classpath,classurl,listdt,sonclass,tbname,modid,myorder,onclick,openadd,wburl from {$dbtbpre}enewsclass where bclassid='$bclassid' order by myorder,classid");
	$returnr['listclass']='';
	$returnr['listclasshidden']='';
	$returnr['listenews']='';
	$returnr['userenews']='';
	$returnr['jsstr']='';
	$returnr['jsmod']='';
	$returnr['oldjsmod']='';
	$returnr['userjs']='';
	$num=$empire->num1($sql);
	if($num==0)
	{
		return $returnr;
	}
	$returnr['listenews'].='<table border=0 cellspacing=0 cellpadding=0>';
	$returnr['userenews'].='<table border=0 cellspacing=0 cellpadding=0>';
	$i=1;
	while($r=$empire->fetch($sql))
	{
		$classurl=sys_ReturnBqClassUrl($r);
		//------ 管理栏目页面 ------
		$divonclick="";
		$start_tbody="";
		$end_tbody="";
		$start_tbody1="";
		$docinfo="";
		$classinfotype='';
		//终级栏目
		if($r[islast])
		{
			$img="<a href='#e' onclick=addi(".$r[classid].")><img src='../data/images/txt.gif' border=0></a>";
			$bgcolor="#ffffff";
			$renewshtml=" <a href='#e' onclick=renews(".$r[classid].",'".$r[tbname]."')>".$fun_r['news']."</a> ";
			$docinfo=" <a href='#e' onclick=docinfo(".$r[classid].")>归档</a>";
			$classinfotype=" <a href='#e' onclick=ttc(".$r[classid].")>分类</a>";
		}
		else
		{
			$img="<img src='../data/images/dir.gif'>";
			if(empty($r[bclassid]))
			{
				$bgcolor="#DBEAF5";
				$divonclick=" onMouseUp='turnit(classdiv".$r[classid].");' style='CURSOR:hand'";
				$start_tbody="<tbody id='classdiv".$r[classid]."'>";
				$end_tbody="</tbody>";
				//缩
				$start_tbody1="<tbody id='classdiv".$r[classid]."' style='display=none'>";
		    }
			else
			{$bgcolor="#ffffff";}
			$renewshtml=" <a href='#e' onclick=renews(".$r[classid].",'".$r[tbname]."')>".$fun_r['news']."</a> ";
		}
		//外部栏目
		$classname=$r[classname];
		if($r['wburl'])
		{
			$classname="<font color='#666666'>".$classname."&nbsp;(外部)</font>";
		}
		$onelistclass="<tr bgcolor='".$bgcolor."' height=25><td><input type=text name=myorder[] value=".$r[myorder]." size=2><input type=hidden name=classid[] value=".$r[classid]."></td><td".$divonclick.">".$exp.$img."</td><td align=center>".$r[classid]."</td><td><input type=checkbox name=reclassid[] value=".$r[classid]."> <a href='".$classurl."' target=_blank>".$classname."</a></td><td align=center>".$r[onclick]."</td><td><a href='#e' onclick=editc(".$r[classid].")>".$fun_r['edit']."</a> <a href='#e' onclick=copyc(".$r[classid].")>".$fun_r['copyclass']."</a> <a href='#e' onclick=delc(".$r[classid].")>".$fun_r['del']."</a></td><td><a href='#e' onclick=relist(".$r[classid].")>".$fun_r['re']."</a>".$renewshtml."<a href='#e' onclick=rejs(".$r[classid].")>JS</a> <a href='#e' onclick=tvurl(".$r[classid].")>调用</a>".$classinfotype.$docinfo."</td></tr>";
		$returnr['listclass'].=$onelistclass;
		$returnr['listclasshidden'].=$onelistclass;
		if(empty($r['wburl']))
		{
		//------ 管理信息页面 ------
		//链接地址
		$infoclassurl='';
		//终级栏目
		if($r[islast])
		{
			//最后一个子栏目
			if($i==$num)
			{$menutype="file1";}
			else
			{$menutype="file";}
			$infoclassname="<a onclick=tourl($r[bclassid],$r[classid]) onmouseout=chft(this,0,$r[classid]) onmouseover=chft(this,1,$r[classid]) oncontextmenu=ShRM(this,".$r[bclassid].",".$r[classid].",'".$infoclassurl."',1)>".$r[classname]."</a>";
			$onmouseup="";
		}
		else
		{
			//最后一个大栏目
			if($i==$num)
			{
				$menutype="menu3";
				$listtype="list1";
				$onmouseup="chengstate('".$r[classid]."')";
			}
			else
			{
				$menutype="menu1";
				$listtype="list";
				$onmouseup="chengstate('".$r[classid]."')";
			}
			$infoclassname="<a onmouseout=chft(this,0,$r[classid]) onmouseover=chft(this,1,$r[classid]) oncontextmenu=ShRM(this,".$r[bclassid].",".$r[classid].",'".$infoclassurl."',0)>".$r[classname]."</a>";
		}
		$returnr['listenews'].='<tr><td id="pr'.$r[classid].'" class="'.$menutype.'" onclick="'.$onmouseup.'">'.$infoclassname.'</td></tr>';
		//JS颜色
		if($r[islast])
		{
			$jscolor=" style='background:".$public_r['chclasscolor']."'";
		}
		else
		{
			$jscolor="";
		}
		//------ 权限栏目显示 ------
		$havelevel=0;
		if($userid&&empty($doall))
		{
			if(CheckHaveInClassid($r,$adminclass))
			{
				$returnr['userenews'].='<tr><td id="pr'.$r[classid].'" class="'.$menutype.'" onclick="'.$onmouseup.'">'.$infoclassname.'</td></tr>';
				$returnr['userjs'].="<option value='".$r[classid]."'".$jscolor.">".$expjs.$r[classname]."</option>";
				$havelevel=1;
			}
		}
		//------ JS显示 ------
		$returnr['jsstr'].="<option value='".$r[classid]."'".$jscolor.">".$expjs.$r[classname]."</option>";
		//------ 投稿 ------
		$haveadd=0;
		if($mid)
		{
			if($r[openadd]==0&&CheckHaveInClassid($r,$addminfocid))
			{
				$returnr['jsmod'].="<option value='".$r[classid]."'".$jscolor.">".$expmodjs.$r[classname]."</option>";
				$haveadd=1;
			}
		}
		$oldhaveadd=0;
		if($oldmid)
		{
			if($r[openadd]==0&&CheckHaveInClassid($r,$oldaddminfocid))
			{
				$returnr['oldjsmod'].="<option value='".$r[classid]."'".$jscolor.">".$expmodjs.$r[classname]."</option>";
				$oldhaveadd=1;
			}
		}
		}
		//取得子栏目
		if(empty($r[islast]))
		{
			$retr=CreateClassCache($r['classid'],$exp,$expjs,$expmodjs,$adminclass,$doall,$mid,$addminfocid,$oldmid,$oldaddminfocid,$userid);
			$returnr['listclass'].=$start_tbody.$retr['listclass'].$end_tbody;
			$returnr['listclasshidden'].=$start_tbody1.$retr['listclasshidden'].$end_tbody;
			if(empty($r['wburl']))
			{
			$returnr['listenews'].='<tr id="item'.$r[classid].'" style="display:none"><td class="'.$listtype.'">'.$retr['listenews'].'</td></tr>';
			if($havelevel)
			{
				$returnr['userenews'].='<tr id="item'.$r[classid].'" style="display:none"><td class="'.$listtype.'">'.$retr['userenews'].'</td></tr>';
				$returnr['userjs'].=$retr['userjs'];
			}
			$returnr['jsstr'].=$retr['jsstr'];
			if($haveadd)
			{
				$returnr['jsmod'].=$retr['jsmod'];
			}
			if($oldhaveadd)
			{
				$returnr['oldjsmod'].=$retr['oldjsmod'];
			}
			}
		}
		$i+=1;
	}
	$returnr['listenews'].='</table>';
	$returnr['userenews'].='</table>';
	return $returnr;
}

//验证缓存
function HaveNavClassCache($where){
	global $empire,$dbtbpre;
	if(empty($where))
	{
		return '';
	}
	$navcachenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsclassnavcache where ".$where." limit 1");
	return $navcachenum;
}

//写入缓存
function InsertNavClassCache($navtype,$userid,$modid){
	global $empire,$dbtbpre;
	$userid=(int)$userid;
	$modid=(int)$modid;
	$empire->query("insert into {$dbtbpre}enewsclassnavcache(navtype,userid,modid) values('$navtype','$userid','$modid');");
}

$enews=RepPostVar($_GET['enews']);
$mess=RepPostVar($_GET['mess']);
$ecmstourl=RepPostStrUrl($_GET['ecmstourl']);
if(!$mess)
{
	db_close();
	$empire=null;
	exit();
}
if(!$enews)
{
	printerror($mess,$ecmstourl);
}
$uid=(int)$_GET['uid'];
if(empty($uid))
{
	$thisuid=$logininid;
}
else
{
	$thisuid=$uid;
}
$user_r=$empire->fetch1("select adminclass,groupid from {$dbtbpre}enewsuser where userid='$thisuid'");
if(!$user_r['groupid'])
{
	db_close();
	$empire=null;
	exit();
}
//用户组权限
$gr=$empire->fetch1("select doall from {$dbtbpre}enewsgroup where groupid='$user_r[groupid]'");
//用户
$userid=$thisuid;
if($gr['doall'])
{
	$userid=0;
}
//模型
$mid=(int)$_GET['mid'];
if($mid&&$emod_r[$mid]['mid'])
{
	$modr=$empire->fetch1("select sonclass from {$dbtbpre}enewsmod where mid='$mid'");
	$addminfocid=$modr['sonclass'];
}
else
{
	$mid=0;
	$addminfocid='';
}
//模型2
$oldmid=(int)$_GET['oldmid'];
if($oldmid&&$emod_r[$oldmid]['mid'])
{
	$oldmodr=$empire->fetch1("select sonclass from {$dbtbpre}enewsmod where mid='$oldmid'");
	$oldaddminfocid=$oldmodr['sonclass'];
}
else
{
	$oldmid=0;
	$oldaddminfocid='';
}
$cacher=CreateClassCache(0,'','','',$user_r['adminclass'],$gr['doall'],$mid,$addminfocid,$oldmid,$oldaddminfocid,$userid);
$enews=','.$enews.',';
//------ 管理栏目缓存 ------
if(stristr($enews,',doclass,'))
{
	if(!HaveNavClassCache("navtype='listclass'"))
	{
		$classfcfile='../data/fc/ListClass0.php';
		$classfcfile2='../data/fc/ListClass1.php';
		WriteFiletext($classfcfile,AddCheckViewTempCode().$cacher['listclass']);
		WriteFiletext($classfcfile2,AddCheckViewTempCode().$cacher['listclasshidden']);
		InsertNavClassCache('listclass',0,0);
	}
}
//------ 管理信息缓存 ------
$notrecordword="您还未添加栏目,<br><a href='#ecms' onclick=goaddclass()><u><b>点击这里</b></u></a>进行添加操作";
if(stristr($enews,',doinfo,'))
{
	if(!HaveNavClassCache("navtype='listenews'"))
	{
		if(empty($cacher['listenews']))
		{
			$cacher['listenews']=$notrecordword;
		}
		$infofcfile='../data/fc/ListEnews.php';
		WriteFiletext($infofcfile,AddCheckViewTempCode().$cacher['listenews']);
		InsertNavClassCache('listenews',0,0);
	}
}
//用户信息缓存
if(stristr($enews,',douserinfo,'))
{
	if($userid)
	{
		if(!HaveNavClassCache("navtype='userenews' and userid='$userid'"))
		{
			$userinfofcfile='../data/fc/ListEnews'.$userid.'.php';
			WriteFiletext($userinfofcfile,AddCheckViewTempCode().$cacher['userenews']);
			$userinfojsfile='../data/fc/userclass'.$userid.'.js';
			WriteFiletext_n($userinfojsfile,"document.write(\"".addslashes($cacher['userjs'])."\");");
			InsertNavClassCache('userenews',$userid,0);
		}
	}
}
//------ JS ------
if(stristr($enews,',doinfo,'))
{
	if(!HaveNavClassCache("navtype='jsclass'"))
	{
		$jsfile="../data/fc/cmsclass.js";
		$search_jsfile="../data/fc/searchclass.js";
		$search_jsstr=str_replace(" style='background:".$public_r['chclasscolor']."'","",$cacher['jsstr']);
		WriteFiletext_n($jsfile,"document.write(\"".addslashes($cacher['jsstr'])."\");");
		WriteFiletext_n($search_jsfile,"document.write(\"".addslashes($search_jsstr)."\");");
		InsertNavClassCache('jsclass',0,0);
	}
}
//------ 投稿JS ------
if(stristr($enews,',domod,'))
{
	if($mid)
	{
		if(!HaveNavClassCache("navtype='modclass' and modid='$mid'"))
		{
			$addinfofile="../../d/js/js/addinfo".$mid.".js";
			$addnews_class="document.write(\"".addslashes($cacher['jsmod'])."\");";
			WriteFiletext_n($addinfofile,$addnews_class);
			InsertNavClassCache('modclass',0,$mid);
		}
	}
	if($oldmid)
	{
		if(!HaveNavClassCache("navtype='modclass' and modid='$oldmid'"))
		{
			$oldaddinfofile="../../d/js/js/addinfo".$oldmid.".js";
			$oldaddnews_class="document.write(\"".addslashes($cacher['oldjsmod'])."\");";
			WriteFiletext_n($oldaddinfofile,$oldaddnews_class);
			InsertNavClassCache('modclass',0,$oldmid);
		}
	}
}
//------ 更新模板 ------
if(stristr($enews,',dostemp,'))
{
	GetSearch();
}

printerror($mess,$ecmstourl);
//echo"<meta http-equiv=\"refresh\" content=\"0;url=$ecmstourl\">缓存更新完毕，正在返回......";
?>