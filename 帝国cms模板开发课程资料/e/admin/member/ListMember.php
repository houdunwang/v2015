<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
require "../".LoadLang("pub/fun.php");
require("../../data/dbcache/MemberLevel.php");
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
CheckLevel($logininid,$loginin,$classid,"member");

$addgethtmlpath="../";
$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
//导入处理会员函数
if($enews)
{
	hCheckEcmsRHash();
	include('../../member/class/member_adminfun.php');
	include('../../member/class/member_modfun.php');
}
//修改会员
if($enews=="EditMember")
{
	$add=$_POST['add'];
	admin_EditMember($add,$logininid,$loginin);
}
//删除会员
elseif($enews=="DelMember")
{
	$userid=$_GET['userid'];
	admin_DelMember($userid,$logininid,$loginin);
}
//批量删除会员
elseif($enews=="DelMember_all")
{
	$userid=$_POST['userid'];
	admin_DelMember_all($userid,$logininid,$loginin);
}
//审核会员
elseif($enews=="DoCheckMember_all")
{
	$userid=$_POST['userid'];
	admin_DoCheckMember_all($userid,$logininid,$loginin);
}
else
{}

$search=$ecms_hashur['ehref'];
$line=25;
$page_line=12;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$offset=$page*$line;
$url="<a href=ListMember.php".$ecms_hashur['whehref'].">管理会员</a>";
$add="";
//搜索
$sear=$_POST['sear'];
if(empty($sear))
{$sear=$_GET['sear'];}
$sear=RepPostStr($sear,1);
if($sear)
{
	$groupid=$_POST['groupid'];
	if(empty($groupid))
	{$groupid=$_GET['groupid'];}
	$keyboard=$_POST['keyboard'];
	if(empty($keyboard))
	{$keyboard=$_GET['keyboard'];}
	$keyboard=RepPostVar2($keyboard);
	$show=(int)$_GET['show'];
	if($keyboard)
	{
		if($show==2)//邮箱
		{
			$add=" where ".egetmf('email')." like '%$keyboard%'";
		}
		else
		{
			$add=" where ".egetmf('username')." like '%$keyboard%'";
		}
	}
	$groupid=(int)$groupid;
	if($groupid)
	{
		if(empty($keyboard))
		{$add.=" where ".egetmf('groupid')."='$groupid'";}
		else
		{$add.=" and ".egetmf('groupid')."='$groupid'";}
	}
	$search.="&sear=1&show=$show&groupid=".$groupid."&keyboard=".$keyboard;
}
//审核
$schecked=(int)$_GET['schecked'];
if($schecked)
{
	$and=$add?' and ':' where ';
	if($schecked==1)
	{
		$add.=$and.egetmf('checked')."=0";
	}
	else
	{
		$add.=$and.egetmf('checked')."=1";
	}
	$search.="&schecked=$schecked";
}
$totalquery="select count(*) as total from ".eReturnMemberTable().$add;
$num=$empire->gettotal($totalquery);
$query="select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable().$add;
$query.=" order by ".egetmf('userid')." desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//----------会员组
$sql1=$empire->query("select * from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	if($groupid==$l_r[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$l_r[groupid].$select.">".$l_r[groupname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理会员</title>
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
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="注册会员" onclick="window.open('../../member/register/');">
		&nbsp;&nbsp;
		<input type="button" name="Submit5" value="前台会员列表" onclick="window.open('../../member/list/');">
      </div></td>
  </tr>
</table>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <form name="form2" method="GET" action="ListMember.php">
  <?=$ecms_hashur['eform']?>
  <input type=hidden name=sear value=1>
    <tr>
      <td><div align="center">关键字:
          <select name="show" id="show">
            <option value="1"<?=$show==1?' selected':''?>>用户名</option>
            <option value="2"<?=$show==2?' selected':''?>>邮箱</option>
          </select>
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="groupid" id="groupid">
            <option value="0">不限级别</option>
			<?=$group?>
          </select>
          <select name="schecked" id="schecked">
            <option value="0"<?=$schecked==0?' selected':''?>>不限</option>
            <option value="1"<?=$schecked==1?' selected':''?>>未审核</option>
            <option value="2"<?=$schecked==2?' selected':''?>>审核</option>
          </select>
          <input type="submit" name="Submit" value="搜索">
          &nbsp;&nbsp; [<a href="ListMember.php?schecked=1<?=$ecms_hashur['ehref']?>">未审核会员</a>] [<a href="ListMember.php?schecked=2<?=$ecms_hashur['ehref']?>">已审核会员</a>] </div></td>
    </tr>
	</form>
  </table>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="memberform" method="post" action="ListMember.php" onsubmit="return confirm('确认要操作?');">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="7%" height="25"><div align="center">ID</div></td>
      <td width="22%" height="25"><div align="center">用户名</div></td>
      <td width="15%"><div align="center">会员组</div></td>
      <td width="19%"><div align="center">注册时间</div></td>
      <td width="13%"><div align="center">记录</div></td>
      <td width="17%" height="25"><div align="center">操作</div></td>
    </tr>
	<?
	while($r=$empire->fetch($sql))
	{
		if(empty($r['checked']))
		{
			$checked=" title='未审核' style='background:#99C4E3'";
		}
		else
		{
			$checked="";
		}
		$registertime=date("Y-m-d H:i:s",$r['registertime']);
	  //编码转换
	  $m_username=$r['username'];
	  $email=$r['email'];
  ?>
    <tr bgcolor="ffffff" id=user<?=$r['userid']?>> 
      <td height="25"><div align="center"> 
          <?=$r['userid']?>
        </div></td>
      <td height="25"><div align="center"> <a href="../../space/?userid=<?=$r['userid']?>" title="查看会员空间" target="_blank"> 
          <?=$m_username?>
          </a> </div></td>
      <td><div align="center"> <a href="ListMember.php?sear=1&groupid=<?=$r['groupid']?><?=$ecms_hashur['ehref']?>"> 
          <?=$level_r[$r['groupid']][groupname]?>
          </a> </div></td>
      <td><div align="center"> 
          <?=$registertime?>
        </div></td>
      <td><div align="center">[<a href="#ecms" onclick="window.open('ListBuyBak.php?userid=<?=$r['userid']?>&username=<?=$m_username?><?=$ecms_hashur['ehref']?>','','width=650,height=600,scrollbars=yes,top=70,left=100');">购买</a>] 
          [<a href="#ecms" onclick="window.open('ListDownBak.php?userid=<?=$r['userid']?>&username=<?=$m_username?><?=$ecms_hashur['ehref']?>','','width=650,height=600,scrollbars=yes,top=70,left=100');">消费</a>]</div></td>
      <td height="25"><div align="center">[<a href="AddMember.php?enews=EditMember&userid=<?=$r['userid']?><?=$ecms_hashur['ehref']?>">修改</a>] 
          [<a href="ListMember.php?enews=DelMember&userid=<?=$r['userid']?><?=$ecms_hashur['href']?>" onclick="return confirm('确认要删除？');">删除</a>] 
          <input name="userid[]" type="checkbox" id="userid[]" value="<?=$r['userid']?>"<?=$checked?> onclick="if(this.checked){user<?=$r['userid']?>.style.backgroundColor='#DBEAF5';}else{user<?=$r['userid']?>.style.backgroundColor='#ffffff';}">
        </div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="ffffff"> 
      <td height="25" colspan="6"> 
        <?=$returnpage?>
        &nbsp;&nbsp;&nbsp; 
        <input type="submit" name="Submit3" value="审核" onclick="document.memberform.enews.value='DoCheckMember_all';"> &nbsp;&nbsp;&nbsp;  <input type="submit" name="Submit2" value="删除" onclick="document.memberform.enews.value='DelMember_all';">
        <input name="enews" type="hidden" id="enews" value="DelMember_all">
        &nbsp;&nbsp;<input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>全选</td>
    </tr>
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
