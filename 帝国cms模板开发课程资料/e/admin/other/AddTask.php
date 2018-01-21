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
CheckLevel($logininid,$loginin,$classid,"task");

//返回选项
function ReturnDaySelect($zero,$num,$thisno){
	global $enews;
	$start=1;
	if($zero)
	{
		$start=0;
	}
	for($i=$start;$i<=$num;$i++)
	{
		$select='';
		if($enews=='EditTask'&&(','.$i.','==','.$thisno.','||strstr($thisno,','.$i.',')))
		{
			$select=' selected';
		}
		$options.="<option value='".$i."'".$select.">".$i."</option>";
	}
	echo $options;
}

$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href='ListTask.php".$ecms_hashur['whehref']."'>管理计划任务</a>  &gt; 增加计划任务";
$postword='增加计划任务';
$r['isopen']=1;
$r['doday']='*';
$r['doweek']='*';
$r['dohour']='*';
$r['dominute']=',';
if($enews=="EditTask")
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewstask where id='$id'");
	$url="<a href='ListTask.php".$ecms_hashur['whehref']."'>管理计划任务</a>  &gt; 修改计划任务：<b>".$r[taskname]."</b>";
	$postword='修改计划任务';
}
//用户
$userselect='';
$usersql=$empire->query("select userid,username from {$dbtbpre}enewsuser order by userid");
while($ur=$empire->fetch($usersql))
{
	$select="";
	if($ur[userid]==$r[userid])
	{
		$select=" selected";
	}
	$userselect.="<option value='".$ur[userid]."'".$select.">".$ur[username]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>计划任务</title>
<script>
function selectalls(doselect,formvar)
{  
	 var bool=doselect==1?true:false;
	 var selectform=document.getElementById(formvar);
	 for(var i=0;i<selectform.length;i++)
	 { 
		  selectform.all[i].selected=bool;
	 } 
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListTask.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><?=$postword?> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="id" type="hidden" id="id" value="<?=$id?>"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="30%" height="25">任务名称</td>
      <td width="70%" height="25"> <input name="taskname" type="text" id="taskname" value="<?=$r[taskname]?>" size="42"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">是否开启该计划任务</td>
      <td height="25"><input type="radio" name="isopen" value="1"<?=$r[isopen]==1?' checked':''?>>
        是 <input type="radio" name="isopen" value="0"<?=$r[isopen]==0?' checked':''?>>
        否</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">执行者</td>
      <td height="25"><select name="userid" id="userid">
          <option value="0">*</option>
		  <?=$userselect?>
        </select>
        <font color="#666666"> (选择用户后，只有此登陆帐号才会执行这个计划任务) </font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">每月几号执行</td>
      <td height="25"><select name="doday" id="doday">
          <option value="*">*</option>
          <?php
		  ReturnDaySelect(0,31,$r[doday]);
		  ?>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">每周星期几执行</td>
      <td height="25"><select name="doweek" id="doweek">
          <option value="*"<?=$r['doweek']=='*'?' selected':''?>>*</option>
          <option value="1"<?=$r['doweek']=='1'?' selected':''?>>星期一</option>
          <option value="2"<?=$r['doweek']=='2'?' selected':''?>>星期二</option>
          <option value="3"<?=$r['doweek']=='3'?' selected':''?>>星期三</option>
          <option value="4"<?=$r['doweek']=='4'?' selected':''?>>星期四</option>
          <option value="5"<?=$r['doweek']=='5'?' selected':''?>>星期五</option>
          <option value="6"<?=$r['doweek']=='6'?' selected':''?>>星期六</option>
          <option value="0"<?=$r['doweek']=='0'?' selected':''?>>星期日</option>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">每日几点执行</td>
      <td height="25"><select name="dohour">
          <option value="*">*</option>
          <?php
		  ReturnDaySelect(1,23,$r[dohour]);
		  ?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">每小时几分钟执行<br>
        <font color="#666666">设置哪些分钟执行本任务<br>
        不选为不限，选择多个可以用CTRL/SHIFT</font></td>
      <td height="25">
		<select name="min[]" size="12" multiple id="minselect" style="width:180">
          <?php
		ReturnDaySelect(1,59,$r['dominute']);
		?>
        </select>
        [<a href="#empirecms" onclick="selectalls(0,'minselect')">全部取消</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">执行文件名<br>
        (在e/tasks/目录下)</td>
      <td height="25"><input name="filename" type="text" id="filename" value="<?=$r[filename]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><font color="#666666">说明：“*”表示不限</font></td>
    </tr>
  </table>
</form>
</body>
</html>
