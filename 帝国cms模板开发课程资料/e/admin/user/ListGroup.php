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
//验证权限
CheckLevel($logininid,$loginin,$classid,"group");

//增加用户组
function AddGroup($groupname,$gr,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($groupname))
	{printerror("EmptyGroupname","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"group");
	//处理变量
	$gr[doall]=(int)$gr[doall];
	$gr[dopublic]=(int)$gr[dopublic];
	$gr[doclass]=(int)$gr[doclass];
	$gr[dotemplate]=(int)$gr[dotemplate];
	$gr[dopicnews]=(int)$gr[dopicnews];
	$gr[dofile]=(int)$gr[dofile];
	$gr[douser]=(int)$gr[douser];
	$gr[dolog]=(int)$gr[dolog];
	$gr[domember]=(int)$gr[domember];
	$gr[dobefrom]=(int)$gr[dobefrom];
	$gr[doword]=(int)$gr[doword];
	$gr[dokey]=(int)$gr[dokey];
	$gr[doad]=(int)$gr[doad];
	$gr[dovote]=(int)$gr[dovote];
	$gr[dogroup]=(int)$gr[dogroup];
	$gr[docj]=(int)$gr[docj];
	$gr[dobq]=(int)$gr[dobq];
	$gr[domovenews]=(int)$gr[domovenews];
	$gr[dopostdata]=(int)$gr[dopostdata];
	$gr[dochangedata]=(int)$gr[dochangedata];
	$gr[dopl]=(int)$gr[dopl];
	$gr[dof]=(int)$gr[dof];
	$gr[dom]=(int)$gr[dom];
	$gr[dodo]=(int)$gr[dodo];
	$gr[dodbdata]=(int)$gr[dodbdata];
	$gr[dorepnewstext]=(int)$gr[dorepnewstext];
	$gr[dotempvar]=(int)$gr[dotempvar];
	$gr[dostats]=(int)$gr[dostats];
	$gr[dowriter]=(int)$gr[dowriter];
	$gr[dototaldata]=(int)$gr[dototaldata];
	$gr[dosearchkey]=(int)$gr[dosearchkey];
	$gr[dozt]=(int)$gr[dozt];
	$gr[docard]=(int)$gr[docard];
	$gr[dolink]=(int)$gr[dolink];
	$gr[doselfinfo]=(int)$gr[doselfinfo];
	$gr[dotable]=(int)$gr[dotable];
	$gr[doexecsql]=(int)$gr[doexecsql];
	$gr[dodownurl]=(int)$gr[dodownurl];
	$gr[dodeldownrecord]=(int)$gr[dodeldownrecord];
	$gr[doshoppayfs]=(int)$gr[doshoppayfs];
	$gr[doshopps]=(int)$gr[doshopps];
	$gr[doshopdd]=(int)$gr[doshopdd];
	$gr[dogbook]=(int)$gr[dogbook];
	$gr[dofeedback]=(int)$gr[dofeedback];
	$gr[donotcj]=(int)$gr[donotcj];
	$gr[dodownerror]=(int)$gr[dodownerror];
	$gr[douserpage]=(int)$gr[douserpage];
	$gr[dodelinfodata]=(int)$gr[dodelinfodata];
	$gr[doaddinfo]=(int)$gr[doaddinfo];
	$gr[doeditinfo]=(int)$gr[doeditinfo];
	$gr[dodelinfo]=(int)$gr[dodelinfo];
	$gr[doadminstyle]=(int)$gr[doadminstyle];
	$gr[dorepdownpath]=(int)$gr[dorepdownpath];
	$gr[douserjs]=(int)$gr[douserjs];
	$gr[douserlist]=(int)$gr[douserlist];
	$gr[domsg]=(int)$gr[domsg];
	$gr[dosendemail]=(int)$gr[dosendemail];
	$gr[dosetmclass]=(int)$gr[dosetmclass];
	$gr[doinfodoc]=(int)$gr[doinfodoc];
	$gr[dotempgroup]=(int)$gr[dotempgroup];
	$gr[dofeedbackf]=(int)$gr[dofeedbackf];
	$gr[dotask]=(int)$gr[dotask];
	$gr[domemberf]=(int)$gr[domemberf];
	$gr[dospacestyle]=(int)$gr[dospacestyle];
	$gr[dospacedata]=(int)$gr[dospacedata];
	$gr[dovotemod]=(int)$gr[dovotemod];
	$gr[doplayer]=(int)$gr[doplayer];
	$gr[dowap]=(int)$gr[dowap];
	$gr[dopay]=(int)$gr[dopay];
	$gr[dobuygroup]=(int)$gr[dobuygroup];
	$gr[dosearchall]=(int)$gr[dosearchall];
	$gr[doinfotype]=(int)$gr[doinfotype];
	$gr[doplf]=(int)$gr[doplf];
	$gr[dopltable]=(int)$gr[dopltable];
	$gr[dochadminstyle]=(int)$gr[dochadminstyle];
	$gr[dotags]=(int)$gr[dotags];
	$gr[dosp]=(int)$gr[dosp];
	$gr[doyh]=(int)$gr[doyh];
	$gr[dofirewall]=(int)$gr[dofirewall];
	$gr[dosetsafe]=(int)$gr[dosetsafe];
	$gr[douserclass]=(int)$gr[douserclass];
	$gr[doworkflow]=(int)$gr[doworkflow];
	$gr[domenu]=(int)$gr[domenu];
	$gr[dopubvar]=(int)$gr[dopubvar];
	$gr[doclassf]=(int)$gr[doclassf];
	$gr[doztf]=(int)$gr[doztf];
	$gr[dofiletable]=(int)$gr[dofiletable];
	$gr[docheckinfo]=(int)$gr[docheckinfo];
	$gr[dogoodinfo]=(int)$gr[dogoodinfo];
	$gr[dodocinfo]=(int)$gr[dodocinfo];
	$gr[domoveinfo]=(int)$gr[domoveinfo];
	$gr[dodttemp]=(int)$gr[dodttemp];
	$gr[doloadcj]=(int)$gr[doloadcj];
	$gr[domustcheck]=(int)$gr[domustcheck];
	$gr[docheckedit]=(int)$gr[docheckedit];
	$gr[domemberconnect]=(int)$gr[domemberconnect];
	$gr[doprecode]=(int)$gr[doprecode];
	$gr[domoreport]=(int)$gr[domoreport];
	$sql=$empire->query("insert into 	{$dbtbpre}enewsgroup(groupname,doall,dopublic,doclass,dotemplate,dopicnews,dofile,douser,dolog,domember,dobefrom,doword,dokey,doad,dovote,dogroup,docj,dobq,domovenews,dopostdata,dochangedata,dopl,dof,dom,dodo,dodbdata,dorepnewstext,dotempvar,dostats,dowriter,dototaldata,dosearchkey,dozt,docard,dolink,doselfinfo,dotable,doexecsql,dodownurl,dodeldownrecord,doshoppayfs,doshopps,doshopdd,dogbook,dofeedback,donotcj,dodownerror,douserpage,dodelinfodata,doaddinfo,doeditinfo,dodelinfo,doadminstyle,dorepdownpath,douserjs,douserlist,domsg,dosendemail,dosetmclass,doinfodoc,dotempgroup,dofeedbackf,dotask,domemberf,dospacestyle,dospacedata,dovotemod,doplayer,dowap,dopay,dobuygroup,dosearchall,doinfotype,doplf,dopltable,dochadminstyle,dotags,dosp,doyh,dofirewall,dosetsafe,douserclass,doworkflow,domenu,dopubvar,doclassf,doztf,dofiletable,docheckinfo,dogoodinfo,dodocinfo,domoveinfo,dodttemp,doloadcj,domustcheck,docheckedit,domemberconnect,doprecode,domoreport) values('$groupname',$gr[doall],$gr[dopublic],$gr[doclass],$gr[dotemplate],$gr[dopicnews],$gr[dofile],$gr[douser],$gr[dolog],$gr[domember],$gr[dobefrom],$gr[doword],$gr[dokey],$gr[doad],$gr[dovote],$gr[dogroup],$gr[docj],$gr[dobq],$gr[domovenews],$gr[dopostdata],$gr[dochangedata],$gr[dopl],$gr[dof],$gr[dom],$gr[dodo],$gr[dodbdata],$gr[dorepnewstext],$gr[dotempvar],$gr[dostats],$gr[dowriter],$gr[dototaldata],$gr[dosearchkey],$gr[dozt],$gr[docard],$gr[dolink],$gr[doselfinfo],$gr[dotable],$gr[doexecsql],$gr[dodownurl],$gr[dodeldownrecord],$gr[doshoppayfs],$gr[doshopps],$gr[doshopdd],$gr[dogbook],$gr[dofeedback],$gr[donotcj],$gr[dodownerror],$gr[douserpage],$gr[dodelinfodata],$gr[doaddinfo],$gr[doeditinfo],$gr[dodelinfo],$gr[doadminstyle],$gr[dorepdownpath],$gr[douserjs],$gr[douserlist],$gr[domsg],$gr[dosendemail],$gr[dosetmclass],$gr[doinfodoc],$gr[dotempgroup],$gr[dofeedbackf],$gr[dotask],$gr[domemberf],$gr[dospacestyle],$gr[dospacedata],$gr[dovotemod],$gr[doplayer],$gr[dowap],$gr[dopay],$gr[dobuygroup],$gr[dosearchall],$gr[doinfotype],$gr[doplf],$gr[dopltable],$gr[dochadminstyle],$gr[dotags],$gr[dosp],$gr[doyh],$gr[dofirewall],$gr[dosetsafe],$gr[douserclass],$gr[doworkflow],$gr[domenu],$gr[dopubvar],$gr[doclassf],$gr[doztf],$gr[dofiletable],'$gr[docheckinfo]','$gr[dogoodinfo]','$gr[dodocinfo]','$gr[domoveinfo]','$gr[dodttemp]','$gr[doloadcj]','$gr[domustcheck]','$gr[docheckedit]','$gr[domemberconnect]','$gr[doprecode]','$gr[domoreport]');");
	$groupid=$empire->lastid();
	if($sql)
	{
		//操作日志
		insert_dolog("groupid=".$groupid."<br>groupname=".$groupname);
		printerror("AddGroupSuccess","AddGroup.php?enews=AddGroup".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改用户组
function EditGroup($groupid,$groupname,$gr,$userid,$username){
	global $empire,$dbtbpre;
	$groupid=(int)$groupid;
	if(empty($groupname)||empty($groupid))
	{printerror("EmptyGroupname","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"group");
	//处理变量
	$gr[doall]=(int)$gr[doall];
	$gr[dopublic]=(int)$gr[dopublic];
	$gr[doclass]=(int)$gr[doclass];
	$gr[dotemplate]=(int)$gr[dotemplate];
	$gr[dopicnews]=(int)$gr[dopicnews];
	$gr[dofile]=(int)$gr[dofile];
	$gr[douser]=(int)$gr[douser];
	$gr[dolog]=(int)$gr[dolog];
	$gr[domember]=(int)$gr[domember];
	$gr[dobefrom]=(int)$gr[dobefrom];
	$gr[doword]=(int)$gr[doword];
	$gr[dokey]=(int)$gr[dokey];
	$gr[doad]=(int)$gr[doad];
	$gr[dovote]=(int)$gr[dovote];
	$gr[dogroup]=(int)$gr[dogroup];
	$gr[docj]=(int)$gr[docj];
	$gr[dobq]=(int)$gr[dobq];
	$gr[domovenews]=(int)$gr[domovenews];
	$gr[dopostdata]=(int)$gr[dopostdata];
	$gr[dochangedata]=(int)$gr[dochangedata];
	$gr[dopl]=(int)$gr[dopl];
	$gr[dof]=(int)$gr[dof];
	$gr[dom]=(int)$gr[dom];
	$gr[dodo]=(int)$gr[dodo];
	$gr[dodbdata]=(int)$gr[dodbdata];
	$gr[dorepnewstext]=(int)$gr[dorepnewstext];
	$gr[dotempvar]=(int)$gr[dotempvar];
	$gr[dostats]=(int)$gr[dostats];
	$gr[dowriter]=(int)$gr[dowriter];
	$gr[dototaldata]=(int)$gr[dototaldata];
	$gr[dosearchkey]=(int)$gr[dosearchkey];
	$gr[dozt]=(int)$gr[dozt];
	$gr[docard]=(int)$gr[docard];
	$gr[dolink]=(int)$gr[dolink];
	$gr[doselfinfo]=(int)$gr[doselfinfo];
	$gr[dotable]=(int)$gr[dotable];
	$gr[doexecsql]=(int)$gr[doexecsql];
	$gr[dodownurl]=(int)$gr[dodownurl];
	$gr[dodeldownrecord]=(int)$gr[dodeldownrecord];
	$gr[doshoppayfs]=(int)$gr[doshoppayfs];
	$gr[doshopps]=(int)$gr[doshopps];
	$gr[doshopdd]=(int)$gr[doshopdd];
	$gr[dogbook]=(int)$gr[dogbook];
	$gr[dofeedback]=(int)$gr[dofeedback];
	$gr[donotcj]=(int)$gr[donotcj];
	$gr[dodownerror]=(int)$gr[dodownerror];
	$gr[douserpage]=(int)$gr[douserpage];
	$gr[dodelinfodata]=(int)$gr[dodelinfodata];
	$gr[doaddinfo]=(int)$gr[doaddinfo];
	$gr[doeditinfo]=(int)$gr[doeditinfo];
	$gr[dodelinfo]=(int)$gr[dodelinfo];
	$gr[doadminstyle]=(int)$gr[doadminstyle];
	$gr[dorepdownpath]=(int)$gr[dorepdownpath];
	$gr[douserjs]=(int)$gr[douserjs];
	$gr[douserlist]=(int)$gr[douserlist];
	$gr[domsg]=(int)$gr[domsg];
	$gr[dosendemail]=(int)$gr[dosendemail];
	$gr[dosetmclass]=(int)$gr[dosetmclass];
	$gr[doinfodoc]=(int)$gr[doinfodoc];
	$gr[dotempgroup]=(int)$gr[dotempgroup];
	$gr[dofeedbackf]=(int)$gr[dofeedbackf];
	$gr[dotask]=(int)$gr[dotask];
	$gr[domemberf]=(int)$gr[domemberf];
	$gr[dospacestyle]=(int)$gr[dospacestyle];
	$gr[dospacedata]=(int)$gr[dospacedata];
	$gr[dovotemod]=(int)$gr[dovotemod];
	$gr[doplayer]=(int)$gr[doplayer];
	$gr[dowap]=(int)$gr[dowap];
	$gr[dopay]=(int)$gr[dopay];
	$gr[dobuygroup]=(int)$gr[dobuygroup];
	$gr[dosearchall]=(int)$gr[dosearchall];
	$gr[doinfotype]=(int)$gr[doinfotype];
	$gr[doplf]=(int)$gr[doplf];
	$gr[dopltable]=(int)$gr[dopltable];
	$gr[dochadminstyle]=(int)$gr[dochadminstyle];
	$gr[dotags]=(int)$gr[dotags];
	$gr[dosp]=(int)$gr[dosp];
	$gr[doyh]=(int)$gr[doyh];
	$gr[dofirewall]=(int)$gr[dofirewall];
	$gr[dosetsafe]=(int)$gr[dosetsafe];
	$gr[douserclass]=(int)$gr[douserclass];
	$gr[doworkflow]=(int)$gr[doworkflow];
	$gr[domenu]=(int)$gr[domenu];
	$gr[dopubvar]=(int)$gr[dopubvar];
	$gr[doclassf]=(int)$gr[doclassf];
	$gr[doztf]=(int)$gr[doztf];
	$gr[dofiletable]=(int)$gr[dofiletable];
	$gr[docheckinfo]=(int)$gr[docheckinfo];
	$gr[dogoodinfo]=(int)$gr[dogoodinfo];
	$gr[dodocinfo]=(int)$gr[dodocinfo];
	$gr[domoveinfo]=(int)$gr[domoveinfo];
	$gr[dodttemp]=(int)$gr[dodttemp];
	$gr[doloadcj]=(int)$gr[doloadcj];
	$gr[domustcheck]=(int)$gr[domustcheck];
	$gr[docheckedit]=(int)$gr[docheckedit];
	$gr[domemberconnect]=(int)$gr[domemberconnect];
	$gr[doprecode]=(int)$gr[doprecode];
	$gr[domoreport]=(int)$gr[domoreport];
	$sql=$empire->query("update {$dbtbpre}enewsgroup set groupname='$groupname',doall=$gr[doall],dopublic=$gr[dopublic],doclass=$gr[doclass],dotemplate=$gr[dotemplate],dopicnews=$gr[dopicnews],dofile=$gr[dofile],douser=$gr[douser],dolog=$gr[dolog],domember=$gr[domember],dobefrom=$gr[dobefrom],doword=$gr[doword],dokey=$gr[dokey],doad=$gr[doad],dovote=$gr[dovote],dogroup=$gr[dogroup],docj=$gr[docj],dobq=$gr[dobq],domovenews=$gr[domovenews],dopostdata=$gr[dopostdata],dochangedata=$gr[dochangedata],dopl=$gr[dopl],dof=$gr[dof],dom=$gr[dom],dodo=$gr[dodo],dodbdata=$gr[dodbdata],dorepnewstext=$gr[dorepnewstext],dotempvar=$gr[dotempvar],dostats=$gr[dostats],dowriter=$gr[dowriter],dototaldata=$gr[dototaldata],dosearchkey=$gr[dosearchkey],dozt=$gr[dozt],docard=$gr[docard],dolink=$gr[dolink],doselfinfo=$gr[doselfinfo],dotable=$gr[dotable],doexecsql=$gr[doexecsql],dodownurl=$gr[dodownurl],dodeldownrecord=$gr[dodeldownrecord],doshoppayfs=$gr[doshoppayfs],doshopps=$gr[doshopps],doshopdd=$gr[doshopdd],dogbook=$gr[dogbook],dofeedback=$gr[dofeedback],donotcj=$gr[donotcj],dodownerror=$gr[dodownerror],douserpage=$gr[douserpage],dodelinfodata=$gr[dodelinfodata],doaddinfo=$gr[doaddinfo],doeditinfo=$gr[doeditinfo],dodelinfo=$gr[dodelinfo],doadminstyle=$gr[doadminstyle],dorepdownpath=$gr[dorepdownpath],douserjs=$gr[douserjs],douserlist=$gr[douserlist],domsg=$gr[domsg],dosendemail=$gr[dosendemail],dosetmclass=$gr[dosetmclass],doinfodoc=$gr[doinfodoc],dotempgroup=$gr[dotempgroup],dofeedbackf=$gr[dofeedbackf],dotask=$gr[dotask],domemberf=$gr[domemberf],dospacestyle=$gr[dospacestyle],dospacedata=$gr[dospacedata],dovotemod=$gr[dovotemod],doplayer=$gr[doplayer],dowap=$gr[dowap],dopay=$gr[dopay],dobuygroup=$gr[dobuygroup],dosearchall=$gr[dosearchall],doinfotype='$gr[doinfotype]',doplf='$gr[doplf]',dopltable='$gr[dopltable]',dochadminstyle='$gr[dochadminstyle]',dotags='$gr[dotags]',dosp='$gr[dosp]',doyh='$gr[doyh]',dofirewall='$gr[dofirewall]',dosetsafe='$gr[dosetsafe]',douserclass='$gr[douserclass]',doworkflow='$gr[doworkflow]',domenu='$gr[domenu]',dopubvar='$gr[dopubvar]',doclassf='$gr[doclassf]',doztf='$gr[doztf]',dofiletable='$gr[dofiletable]',docheckinfo='$gr[docheckinfo]',dogoodinfo='$gr[dogoodinfo]',dodocinfo='$gr[dodocinfo]',domoveinfo='$gr[domoveinfo]',dodttemp='$gr[dodttemp]',doloadcj='$gr[doloadcj]',domustcheck='$gr[domustcheck]',docheckedit='$gr[docheckedit]',domemberconnect='$gr[domemberconnect]',doprecode='$gr[doprecode]',domoreport='$gr[domoreport]' where groupid='$groupid'");
	if($sql)
	{
		//操作日志
		insert_dolog("groupid=".$groupid."<br>groupname=".$groupname);
		printerror("EditGroupSuccess","ListGroup.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除用户组
function DelGroup($groupid,$userid,$username){
	global $empire,$dbtbpre;
	$groupid=(int)$groupid;
	if(empty($groupid))
	{printerror("NotDelGroupid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"group");
	$r=$empire->fetch1("select groupname from {$dbtbpre}enewsgroup where groupid='$groupid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsgroup where groupid='$groupid'");
	if($sql)
	{
		//操作日志
		insert_dolog("groupid=".$groupid."<br>groupname=".$r[groupname]);
		printerror("DelGroupSuccess","ListGroup.php".hReturnEcmsHashStrHref2(1));
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
//增加用户组
if($enews=="AddGroup")
{
	$groupname=$_POST['groupname'];
	$gr=$_POST['gr'];
	AddGroup($groupname,$gr,$logininid,$loginin);
}
//修改用户组
elseif($enews=="EditGroup")
{
	$groupid=$_POST['groupid'];
	$groupname=$_POST['groupname'];
	$gr=$_POST['gr'];
	EditGroup($groupid,$groupname,$gr,$logininid,$loginin);
}
//删除用户组
elseif($enews=="DelGroup")
{
	$groupid=$_GET['groupid'];
	DelGroup($groupid,$logininid,$loginin);
}

$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsgroup order by groupid desc");
$url="位置：<a href=ListGroup.php".$ecms_hashur['whehref'].">管理用户组</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>用户组</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%"> 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加用户组" onclick="self.location.href='AddGroup.php?enews=AddGroup<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header">
    <td width="13%"><div align="center">ID</div></td>
    <td width="63%" height="25"><div align="center">用户组名称</div></td>
    <td width="24%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center"><?=$r[groupid]?></div></td>
      <td height="25"><div align="center"><?=$r[groupname]?></div></td>
      <td height="25"><div align="center"> [<a href="AddGroup.php?enews=EditGroup&groupid=<?=$r[groupid]?><?=$ecms_hashur['ehref']?>">修改</a>] 
        [<a href="ListGroup.php?enews=DelGroup&groupid=<?=$r[groupid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除此用户组？');">删除</a>]</div></td>
    </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
</table>
</body>
</html>
