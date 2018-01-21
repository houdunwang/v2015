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
CheckLevel($logininid,$loginin,$classid,"vote");

//增加投票
function AddVote($title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$userid,$username){
	global $empire,$dbtbpre;
	if(!$title||!$tempid)
	{printerror("EmptyVoteTitle","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"vote");
	//返回组合
	$votetext=ReturnVote($votename,$votenum,$delvid,$vid,0);
	//统计总票数
	for($i=0;$i<count($votename);$i++)
	{$t_votenum+=$votenum[$i];}
	$votetime=to_date($dotime);
	$addtime=date("Y-m-d H:i:s");
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$voteclass;
	$votetime=(int)$votetime;
	$width=(int)$width;
	$height=(int)$height;
	$doip=(int)$doip;
	$tempid=(int)$tempid;
	$sql=$empire->query("insert into {$dbtbpre}enewsvote(title,votetext,votenum,voteip,voteclass,doip,votetime,dotime,width,height,addtime,tempid) values('$title','$votetext',$t_votenum,'',$voteclass,$doip,$votetime,'$dotime',$width,$height,'$addtime',$tempid);");
	//生成投票js
	$voteid=$empire->lastid();
	GetVoteJs($voteid);
	if($sql)
	{
		//操作日志
		insert_dolog("voteid=".$voteid."<br>title=".$title);
		printerror("AddVoteSuccess","AddVote.php?enews=AddVote".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改投票
function EditVote($voteid,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$userid,$username){
	global $empire,$dbtbpre;
	$voteid=(int)$voteid;
	if(!$voteid||!$title||!$tempid)
	{printerror("EmptyVoteTitle","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"vote");
	//返回组合
	$votetext=ReturnVote($votename,$votenum,$delvid,$vid,1);
	//统计总票数
	for($i=0;$i<count($votename);$i++)
	{$t_votenum+=$votenum[$i];}
	$r=$empire->fetch1("select dotime,votetime from {$dbtbpre}enewsvote where voteid='$voteid'");
	$votetime=to_date($dotime);
	//处理变量
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$voteclass;
	$votetime=(int)$votetime;
	$width=(int)$width;
	$height=(int)$height;
	$doip=(int)$doip;
	$tempid=(int)$tempid;
	$sql=$empire->query("update {$dbtbpre}enewsvote set title='$title',votetext='$votetext',votenum=$t_votenum,voteclass=$voteclass,doip=$doip,dotime='$dotime',votetime=$votetime,width=$width,height=$height,tempid=$tempid where voteid='$voteid'");
	//生成投票js
	GetVoteJs($voteid);
	if($sql)
	{
		//操作日志
		insert_dolog("voteid=".$voteid."<br>title=".$title);
		printerror("EditVoteSuccess","ListVote.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除投票
function DelVote($voteid,$userid,$username){
	global $empire,$dbtbpre;
	$voteid=(int)$voteid;
	if(!$voteid)
	{printerror("NotDelVoteid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"vote");
	$r=$empire->fetch1("select title from {$dbtbpre}enewsvote where voteid='$voteid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsvote where voteid='$voteid'");
	$file="../../../d/js/vote/vote".$voteid.".js";
	DelFiletext($file);
	if($sql)
	{
		//操作日志
		insert_dolog("voteid=".$voteid."<br>title=".$r[title]);
		printerror("DelVoteSuccess","ListVote.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//批量生成投票
function ReVoteJs_all($start=0,$from,$userid,$username){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$start=(int)$start;
	$b=0;
	$sql=$empire->query("select voteid from {$dbtbpre}enewsvote where voteid>$start order by voteid limit ".$public_r['revotejsnum']);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r[voteid];
		GetVoteJs($r[voteid]);
	}
	if(empty($b))
	{
		//操作日志
	    insert_dolog("");
		printerror("ReVoteJsSuccess",$from);
	}
	echo $fun_r['OneReVoteJsSuccess']."(ID:<font color=red><b>".$newstart."</b></font>)<script>self.location.href='ListVote.php?enews=ReVoteJs_all&start=$newstart&from=".urlencode($from).hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//生成投票js
function GetVoteJs($voteid){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsvote where voteid='$voteid'");
	//模板
	$votetemp=ReturnVoteTemp($r[tempid],1);
	$votetemp=RepVoteTempAllvar($votetemp,$r);
	$listexp="[!--empirenews.listtemp--]";
	$listtemp_r=explode($listexp,$votetemp);
	$file="../../../d/js/vote/vote".$voteid.".js";
	$r_exp="\r\n";
	$f_exp="::::::";
	//项目数
	$r_r=explode($r_exp,$r[votetext]);
	$checked=0;
	for($i=0;$i<count($r_r);$i++)
	{
		$checked++;
		$f_r=explode($f_exp,$r_r[$i]);
		//投票类型
		if($r[voteclass])
		{$vote="<input type=checkbox name=vote[] value=".$checked.">";}
		else
		{$vote="<input type=radio name=vote value=".$checked.">";}
		$votetext.=RepVoteTempListvar($listtemp_r[1],$vote,$f_r[0]);
    }
	$votetext="document.write(\"".addslashes(stripSlashes($listtemp_r[0].$votetext.$listtemp_r[2]))."\");";
	WriteFiletext_n($file,$votetext);
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//增加投票
if($enews=="AddVote")
{
	$title=$_POST['title'];
	$votename=$_POST['votename'];
	$votenum=$_POST['votenum'];
	$delvid=$_POST['delvid'];
	$vid=$_POST['vid'];
	$voteclass=$_POST['voteclass'];
	$doip=$_POST['doip'];
	$dotime=$_POST['dotime'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	$tempid=$_POST['tempid'];
	AddVote($title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$logininid,$loginin);
}
//修改投票
elseif($enews=="EditVote")
{
	$voteid=$_POST['voteid'];
	$title=$_POST['title'];
	$votename=$_POST['votename'];
	$votenum=$_POST['votenum'];
	$delvid=$_POST['delvid'];
	$vid=$_POST['vid'];
	$voteclass=$_POST['voteclass'];
	$doip=$_POST['doip'];
	$dotime=$_POST['dotime'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	$tempid=$_POST['tempid'];
	EditVote($voteid,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$logininid,$loginin);
}
//删除投票
elseif($enews=="DelVote")
{
	$voteid=$_GET['voteid'];
	DelVote($voteid,$logininid,$loginin);
}
//批量刷新投票JS
elseif($enews=="ReVoteJs_all")
{
	ReVoteJs_all($_GET['start'],$_GET['from'],$logininid,$loginin);
}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select voteid,title,addtime from {$dbtbpre}enewsvote";
$num=$empire->num($query);//取得总条数
$query=$query." order by voteid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="<a href=ListVote.php".$ecms_hashur['whehref'].">管理投票</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>投票</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">位置: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加投票" onclick="self.location.href='AddVote.php?enews=AddVote<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="32%" height="25"><div align="center">投票标题</div></td>
    <td width="18%" height="25"><div align="center">发布时间</div></td>
    <td width="26%" height="25">调用地址</td>
    <td width="19%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"><?=$r[voteid]?></div></td>
    <td height="25"><?=$r[title]?></td>
    <td height="25"><div align="center"><?=$r[addtime]?></div>
      </td>
    <td height="25"><input name="textfield" type="text" value="<?=$public_r[newsurl]?>d/js/vote/vote<?=$r[voteid]?>.js">
      [<a href="../view/js.php?js=vote<?=$r[voteid]?>&p=vote<?=$ecms_hashur['ehref']?>" target="_blank">预览</a>]</td>
    <td height="25"><div align="center">[<a href="AddVote.php?enews=EditVote&voteid=<?=$r[voteid]?><?=$ecms_hashur['ehref']?>">修改</a>] 
        [<a href="ListVote.php?enews=DelVote&voteid=<?=$r[voteid]?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除?');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF">
    <td height="25" colspan="5">&nbsp;<?=$returnpage?></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="5"><font color="#666666">说明:模板中显示投票的地方加上:&lt;script 
      src=调用地址&gt;&lt;/script&gt; 或者 [phomevote]投票ID[/phomevote]</font></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
