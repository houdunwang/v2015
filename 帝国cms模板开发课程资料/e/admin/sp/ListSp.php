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
CheckLevel($logininid,$loginin,$classid,"sp");

//返回用户组
function ReturnSpGroup($groupid){
	$count=count($groupid);
	if($count==0)
	{
		return '';
	}
	$ids=',';
	for($i=0;$i<$count;$i++)
	{
		$ids.=$groupid[$i].',';
	}
	return $ids;
}

//增加碎片
function AddSp($add,$userid,$username){
	global $empire,$dbtbpre;
	$add['varname']=RepPostVar($add['varname']);
	if(!$add[spname]||!$add[varname])
	{
		printerror("EmptySp","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"sp");
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssp where varname='$add[varname]' limit 1");
	if($num)
	{
		printerror("HaveSp","history.go(-1)");
	}
	$add[sptype]=(int)$add[sptype];
	$add[cid]=(int)$add[cid];
	$add[classid]=(int)$add[classid];
	$add[tempid]=(int)$add[tempid];
	$add[maxnum]=(int)$add[maxnum];
	$sptime=time();
	$groupid=ReturnSpGroup($add[groupid]);
	$userclass=ReturnSpGroup($add[userclass]);
	$username=','.$add[username].',';
	$add[isclose]=(int)$add[isclose];
	$add[cladd]=(int)$add[cladd];
	$add['refile']=(int)$add['refile'];
	$add['spfile']=DoRepFileXg($add['spfile']);
	$add['spfileline']=(int)$add['spfileline'];
	$add['spfilesub']=(int)$add['spfilesub'];
	$add['filepass']=(int)$add['filepass'];
	$sql=$empire->query("insert into {$dbtbpre}enewssp(spname,varname,sppic,spsay,sptype,cid,classid,tempid,maxnum,sptime,groupid,userclass,username,isclose,cladd,refile,spfile,spfileline,spfilesub) values('$add[spname]','$add[varname]','$add[sppic]','$add[spsay]','$add[sptype]','$add[cid]','$add[classid]','$add[tempid]','$add[maxnum]','$sptime','$groupid','$userclass','$username','$add[isclose]','$add[cladd]','$add[refile]','$add[spfile]','$add[spfileline]','$add[spfilesub]');");
	$spid=$empire->lastid();
	//更新附件
	UpdateTheFileOther(7,$spid,$add['filepass'],'other');
	//生成碎片文件
	if($add['refile'])
	{
		DoSpReFile($add,0);
	}
	if($sql)
	{
		//操作日志
		insert_dolog("spid=".$spid."<br>spname=".$add[spname]);
		printerror("AddSpSuccess","AddSp.php?enews=AddSp".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改碎片
function EditSp($add,$userid,$username){
	global $empire,$dbtbpre;
	$add['varname']=RepPostVar($add['varname']);
	$spid=(int)$add[spid];
	if(!$spid||!$add[spname]||!$add[varname])
	{
		printerror("EmptySp","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"sp");
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssp where varname='$add[varname]' and spid<>$spid limit 1");
	if($num)
	{
		printerror("HaveSp","history.go(-1)");
	}
	$add[sptype]=(int)$add[sptype];
	$add[cid]=(int)$add[cid];
	$add[classid]=(int)$add[classid];
	$add[tempid]=(int)$add[tempid];
	$add[maxnum]=(int)$add[maxnum];
	$sptime=time();
	$groupid=ReturnSpGroup($add[groupid]);
	$userclass=ReturnSpGroup($add[userclass]);
	$username=','.$add[username].',';
	$add[isclose]=(int)$add[isclose];
	$add[cladd]=(int)$add[cladd];
	$add['refile']=(int)$add['refile'];
	$add['spfile']=DoRepFileXg($add['spfile']);
	$add['oldspfile']=DoRepFileXg($add['oldspfile']);
	$add['spfileline']=(int)$add['spfileline'];
	$add['spfilesub']=(int)$add['spfilesub'];
	$add['filepass']=(int)$add['filepass'];
	$sql=$empire->query("update {$dbtbpre}enewssp set spname='$add[spname]',varname='$add[varname]',sppic='$add[sppic]',spsay='$add[spsay]',sptype='$add[sptype]',cid='$add[cid]',classid='$add[classid]',tempid='$add[tempid]',maxnum='$add[maxnum]',groupid='$groupid',userclass='$userclass',username='$username',isclose='$add[isclose]',cladd='$add[cladd]',refile='$add[refile]',spfile='$add[spfile]',spfileline='$add[spfileline]',spfilesub='$add[spfilesub]' where spid='$spid'");
	//更新附件
	UpdateTheFileEditOther(7,$spid,'other');
	//生成碎片文件
	if($add['refile'])
	{
		//旧文件
		if($add['spfile']!=$add['oldspfile'])
		{
			DelSpReFile($add['oldspfile']);
		}
		DoSpReFile($add,0);
	}
	if($sql)
	{
		//操作日志
		insert_dolog("spid=".$spid."<br>spname=".$add[spname]);
		printerror("EditSpSuccess","ListSp.php?cid=$add[fcid]&fclassid=$add[fclassid]&fsptype=$add[fsptype]".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除碎片
function DelSp($add,$userid,$username){
	global $empire,$dbtbpre;
	$spid=(int)$add[spid];
	if(!$spid)
	{
		printerror("NotDelSpid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"sp");
	$r=$empire->fetch1("select spname,sptype,refile,spfile from {$dbtbpre}enewssp where spid='$spid'");
	$sql=$empire->query("delete from {$dbtbpre}enewssp where spid='$spid'");
	if($r[sptype]==1)
	{
		$empire->query("delete from {$dbtbpre}enewssp_1 where spid='$spid'");
	}
	elseif($r[sptype]==2)
	{
		$empire->query("delete from {$dbtbpre}enewssp_2 where spid='$spid'");
	}
	if($r[sptype]==3)
	{
		$empire->query("delete from {$dbtbpre}enewssp_3 where spid='$spid'");
		$empire->query("delete from {$dbtbpre}enewssp_3_bak where spid='$spid'");
	}
	//删除碎片文件
	if($r['refile'])
	{
		DelSpReFile($r['spfile']);
	}
	//删除附件
	DelFileOtherTable("modtype=7 and id='$spid'");
	if($sql)
	{
		//操作日志
		insert_dolog("spid=".$spid."<br>spname=".$r[spname]);
		printerror("DelSpSuccess","ListSp.php?cid=$add[fcid]&fclassid=$add[fclassid]&fsptype=$add[fsptype]".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//删除碎片文件
function DelSpReFile($file){
	$filename=ECMS_PATH.$file;
	if($file&&file_exists($filename)&&!stristr('/'.$file,'/e/'))
	{
		DelFiletext($filename);
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include('../../class/chtmlfun.php');
	include('../../data/dbcache/class.php');
	include('../../class/t_functions.php');
}
if($enews=="AddSp")//增加碎片
{
	AddSp($_POST,$logininid,$loginin);
}
elseif($enews=="EditSp")//修改碎片
{
	EditSp($_POST,$logininid,$loginin);
}
elseif($enews=="DelSp")//删除碎片
{
	DelSp($_GET,$logininid,$loginin);
}
elseif($enews=='ReSp')//刷新碎片文件
{
	ReSp($_POST,$logininid,$loginin,0);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=30;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$add='';
$and='';
$search='';
$search.=$ecms_hashur['ehref'];
//碎片类型
$sptype=(int)$_GET['sptype'];
if($sptype)
{
	$add.=$and."sptype='$sptype'";
	$and=' and ';
	$search.="&sptype=$sptype";
}
//分类
$cid=(int)$_GET['cid'];
if($cid)
{
	$add.=$and."cid='$cid'";
	$and=' and ';
	$search.="&cid=$cid";
}
//栏目
$classid=(int)$_GET['classid'];
if($classid)
{
	$add.=$and."classid='$classid'";
	$search.="&classid=$classid";
}
if($add)
{
	$add=' where '.$add;
}
$query="select spid,spname,varname,cid,classid,isclose,sptype,sptime,refile,spfile from {$dbtbpre}enewssp".$add;
$totalquery="select count(*) as total from {$dbtbpre}enewssp".$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by spid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="<a href=ListSp.php".$ecms_hashur['whehref'].">管理碎片</a>";
//分类
$scstr="";
$scsql=$empire->query("select classid,classname from {$dbtbpre}enewsspclass order by classid");
while($scr=$empire->fetch($scsql))
{
	$select="";
	if($scr[classid]==$cid)
	{
		$select=" selected";
	}
	$scstr.="<option value='".$scr[classid]."'".$select.">".$scr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>碎片</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
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
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">位置: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加碎片" onclick="self.location.href='AddSp.php?enews=AddSp<?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit52" value="管理碎片分类" onclick="self.location.href='ListSpClass.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td> 选择分类： 
      <select name="classid" id="classid" onchange=window.location='ListSp.php?<?=$ecms_hashur['ehref']?>&cid='+this.options[this.selectedIndex].value>
        <option value="0">显示所有分类</option>
        <?=$scstr?>
      </select> </td>
  </tr>
</table>
<br>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="listspform" method="post" action="ListSp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td width="4%"><div align="center"><input type=checkbox name=chkall value=on onClick="CheckAll(this.form)"></div></td>
      <td width="6%" height="25"><div align="center">ID</div></td>
      <td width="20%" height="25"><div align="center">碎片名称</div></td>
      <td width="17%"><div align="center">变量名</div></td>
      <td width="15%"><div align="center">所属分类</div></td>
      <td width="12%"><div align="center">碎片类型</div></td>
      <td width="6%"><div align="center">状态</div></td>
      <td width="20%" height="25"><div align="center">操作</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  	$spclassname='--';
  	if($r[cid])
	{
		$scr=$empire->fetch1("select classname from {$dbtbpre}enewsspclass where classid='$r[cid]'");
		$spclassname=$scr['classname'];
	}
	if($r[sptype]==1)
	{
		$sptypename='静态信息';
	}
	elseif($r[sptype]==2)
	{
		$sptypename='动态信息';
	}
	else
	{
		$sptypename='代码碎片';
	}
	//链接
	$sphref='';
	if($r['refile'])
	{
		$sphref=' href="'.$public_r['newsurl'].$r['spfile'].'" target="_blank"';
	}
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'">
      <td><div align="center">
        <?php
		if($r['refile'])
		{
		?>
		<input name="spid[]" type="checkbox" id="spid[]" value="<?=$r[spid]?>">
		<?php
		}
		?>
      </div></td>
      <td height="32"><div align="center">
          <?=$r[spid]?>
      </div></td>
      <td height="25"><a<?=$sphref?> title="增加时间：<?=date('Y-m-d H:i:s',$r[sptime])?>">
        <?=$r[spname]?>
      </a> </td>
      <td><div align="center">
        <?=$r[varname]?>
      </div></td>
      <td><div align="center"><a href="ListSp.php?cid=<?=$r[cid]?><?=$ecms_hashur['ehref']?>">
        <?=$spclassname?>
      </a></div></td>
      <td><div align="center"><a href="ListSp.php?sptype=<?=$r[sptype]?><?=$ecms_hashur['ehref']?>">
        <?=$sptypename?>
      </a></div></td>
      <td><div align="center">
        <?=$r[isclose]==1?'<font color="red">关闭</font>':'开启'?>
      </div></td>
      <td height="25"><div align="center">[<a href="AddSp.php?enews=EditSp&spid=<?=$r[spid]?>&fcid=<?=$cid?>&fclassid=<?=$classid?>&fsptype=<?=$sptype?><?=$ecms_hashur['ehref']?>">修改</a>] 
        [<a href="AddSp.php?enews=AddSp&spid=<?=$r[spid]?>&fcid=<?=$cid?>&fclassid=<?=$classid?>&fsptype=<?=$sptype?>&docopy=1<?=$ecms_hashur['ehref']?>">复制</a>] 
        [<a href="ListSp.php?enews=DelSp&spid=<?=$r[spid]?>&fcid=<?=$cid?>&fclassid=<?=$classid?>&fsptype=<?=$sptype?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除?');">删除</a>]</div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF">
      <td height="25" colspan="8">&nbsp;
          <?=$returnpage?>
      &nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" name="Submit" value="刷新碎片文件">
      <input name="enews" type="hidden" id="enews" value="ReSp"></td>
    </tr>
  </form>
  </table>
</body>
</html>
<?
db_close();
$empire=null;
?>
