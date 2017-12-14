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
CheckLevel($logininid,$loginin,$classid,"vote");
$enews=ehtmlspecialchars($_GET['enews']);
$r[width]=500;
$r[height]=300;
$voteclass0=" checked";
$doip0=" checked";
$editnum=8;
$url="<a href=ListVote.php".$ecms_hashur['whehref'].">管理投票</a>&nbsp;>&nbsp;增加投票";
//复制
$docopy=RepPostStr($_GET['docopy'],1);
if($docopy&&$enews=="AddVote")
{
	$copyvote=1;
}
//修改
if($enews=="EditVote"||$copyvote)
{
	if($copyvote)
	{
		$thisdo="复制";
	}
	else
	{
		$thisdo="修改";
	}
	$voteid=(int)$_GET['voteid'];
	$r=$empire->fetch1("select voteid,title,votetext,voteclass,doip,dotime,width,height,tempid from {$dbtbpre}enewsvote where voteid='$voteid'");
	$url="<a href=ListVote.php".$ecms_hashur['whehref'].">管理投票</a>&nbsp;>&nbsp;".$thisdo."投票：<b>".$r[title]."</b>";
	$str="dotime".$r[dotime];
	$$str=" selected";
	if($r[voteclass]==1)
	{
		$voteclass0="";
		$voteclass1=" checked";
	}
	if($r[doip]==1)
	{
		$doip0="";
		$doip1=" checked";
	}
	$d_record=explode("\r\n",$r[votetext]);
	for($i=0;$i<count($d_record);$i++)
	{
		$j=$i+1;
		$d_field=explode("::::::",$d_record[$i]);
		$allv.="<tr><td width=9%><div align=center>".$j."</div></td><td width=65%><input name=votename[] type=text id=votename[] value='".$d_field[0]."' size=30></td><td width=26%><input name=votenum[] type=text id=votenum[] value='".$d_field[1]."' size=6><input type=hidden name=vid[] value=".$j."><input type=checkbox name=delvid[] value=".$j.">删除</td></tr>";
	}
	$editnum=$j;
	$allv="<table width=100% border=0 cellspacing=1 cellpadding=3>".$allv."</table>";
}
//模板
$votetemp="";
$tsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsvotetemp")." order by tempid");
while($tr=$empire->fetch($tsql))
{
	if($r[tempid]==$tr[tempid])
	{
		$select=" selected";
	}
	else
	{
		$select="";
	}
	$votetemp.="<option value='".$tr[tempid]."'".$select.">".$tr[tempname]."</option>";
}
//当前使用的模板组
$thegid=GetDoTempGid();
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加投票</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function doadd()
{var i;
var str="";
var oldi=0;
var j=0;
oldi=parseInt(document.add.editnum.value);
for(i=1;i<=document.add.vote_num.value;i++)
{
j=i+oldi;
str=str+"<tr><td width=9% height=20> <div align=center>"+j+"</div></td><td width=65%> <div align=center><input type=text name=votename[] size=30></div></td><td width=26%> <div align=center><input type=text name=votenum[] value=0 size=6></div></td></tr>";
}
document.getElementById("addvote").innerHTML="<table width=100% border=0 cellspacing=1 cellpadding=3>"+str+"</table>";
}
</script>
<script src="../ecmseditor/fieldfile/setday.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="add" method="post" action="ListVote.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="AddVotetb">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><p>增加投票</p></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="21%" height="25">主题标题(最大60个汉字)</td>
      <td width="79%" height="25"><input name="title" type="text" id="title" size="50" value="<?=$r[title]?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="voteid" type="hidden" id="voteid" value="<?=$r[voteid]?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"><p>投票项目<br>
        </p></td>
      <td height="25"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr bgcolor="#DBEAF5"> 
                  <td width="9%" height="20"> <div align="center">编号</div></td>
                  <td width="65%"> <div align="center">项目名称</div></td>
                  <td width="26%"> <div align="center">投票数</div></td>
                </tr>
              </table>
              <?
				if($enews=="EditVote"||$copyvote)
				{echo"$allv";}
				else
				{
				?>
              <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td height="24" width="9%"> <div align="center">1</div></td>
                  <td height="24" width="65%"> <div align="center"> 
                      <input name="votename[]" type="text" id="votename[]" size="30">
                    </div></td>
                  <td height="24" width="26%"> <div align="center"> 
                      <input name="votenum[]" type="text" id="votenum[]" value="0" size="6">
                    </div></td>
                </tr>
                <tr> 
                  <td height="24"> <div align="center">2</div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votename[]" type="text" id="votename[]" size="30">
                    </div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votenum[]" type="text" id="votenum[]" value="0" size="6">
                    </div></td>
                </tr>
                <tr> 
                  <td height="24"> <div align="center">3</div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votename[]" type="text" id="votename[]" size="30">
                    </div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votenum[]" type="text" id="votenum[]" value="0" size="6">
                    </div></td>
                </tr>
                <tr> 
                  <td height="24"> <div align="center">4</div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votename[]" type="text" id="votename[]" size="30">
                    </div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votenum[]" type="text" id="votenum[]" value="0" size="6">
                    </div></td>
                </tr>
                <tr> 
                  <td height="24"> <div align="center">5</div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votename[]" type="text" id="votename[]" size="30">
                    </div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votenum[]" type="text" id="votenum[]" value="0" size="6">
                    </div></td>
                </tr>
                <tr> 
                  <td height="24"> <div align="center">6</div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votename[]" type="text" id="votename[]" size="30">
                    </div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votenum[]" type="text" id="votenum[]" value="0" size="6">
                    </div></td>
                </tr>
                <tr> 
                  <td height="24"> <div align="center">7</div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votename[]" type="text" id="votename[]" size="30">
                    </div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votenum[]" type="text" id="votenum[]" value="0" size="6">
                    </div></td>
                </tr>
                <tr> 
                  <td height="24"> <div align="center">8</div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votename[]" type="text" id="votename[]" size="30">
                    </div></td>
                  <td height="24"> <div align="center"> 
                      <input name="votenum[]" type="text" id="votenum[]" value="0" size="6">
                    </div></td>
                </tr>
              </table>
              <?
			  }
			  ?>
            </td>
          </tr>
          <tr> 
            <td>投票扩展数量: 
              <input name="vote_num" type="text" id="vote_num" value="1" size="6"> 
              <input type="button" name="Submit52" value="输出地址" onclick="javascript:doadd();"> 
              <input name="editnum" type="hidden" id="editnum" value="<?=$editnum?>"> 
            </td>
          </tr>
          <tr> 
            <td id=addvote></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">投票类型:</td>
      <td height="25"><input name="voteclass" type="radio" value="0"<?=$voteclass0?>>
        单选 
        <input type="radio" name="voteclass" value="1"<?=$voteclass1?>>
        复选</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">限制IP:</td>
      <td height="25"><input type="radio" name="doip" value="0"<?=$doip0?>>
        不限制 
        <input name="doip" type="radio" value="1"<?=$doip1?>>
        限制<font color="#666666">(限制后同一IP只能投一次票)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">过期时间:</td>
      <td height="25"> <input name=olddotime type=hidden value="<?=$r[dotime]?>"> 
        <input name="dotime" type="text" id="dotime2" value="<?=$r[dotime]?>" size="12" onClick="setday(this)">
        <font color="#666666">(超过此期限,将不能投票,0000-00-00为不限制)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">查看投票窗口:</td>
      <td height="25">宽度: 
        <input name="width" type="text" id="width" value="<?=$r[width]?>" size="6">
        高度: 
        <input name="height" type="text" id="height" value="<?=$r[height]?>" size="6"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">选择模板：</td>
      <td height="25"><select name="tempid" id="tempid">
	  <?=$votetemp?>
        </select>
        <input type="button" name="Submit62223" value="管理投票模板" onclick="window.open('../template/ListVotetemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
