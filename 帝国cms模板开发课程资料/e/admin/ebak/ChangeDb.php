<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
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
CheckLevel($logininid,$loginin,$classid,"dbdata");
//默认数据库
if(!empty($public_r['ebakthisdb'])){
	echo"正转到默认的数据库,请稍等......<script>self.location.href='ChangeTable.php?mydbname=".$ecms_config['db']['dbname'].$ecms_hashur['ehref']."'</script>";
	exit();
}
$sql=$empire->query("SHOW DATABASES");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择数据库</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function DoDrop(dbname)
{var ok;
ok=confirm("确认要删除此数据库?");
if(ok)
{
self.location.href='phome.php?<?=$ecms_hashur['href']?>&phome=DropDb&mydbname='+dbname;
}
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：备份数据 -&gt; <a href="ChangeDb.php<?=$ecms_hashur['whehref']?>">选择数据库</a></td>
  </tr>
  <tr>
    <td height="25"><div align="center">备份步骤：<font color="#FF0000">选择数据库</font> 
        -&gt; 选择要备份的表 -&gt; 开始备份 -&gt; 完成</div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="60%" height="25"> 
      <div align="center">数据库名</div></td>
    <td width="40%" height="25"> 
      <div align="center">备份</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  if($r[0]==$ecms_config['db']['dbname'])
  {
  $bgcolor="#DBEAF5";
  }
  else
  {
  $bgcolor="#FFFFFF";
  }
  ?>
  <tr bgcolor="<?=$bgcolor?>"> 
    <td height="25"> 
      <div align="center"><?=$r[0]?></div></td>
    <td height="25"> 
      <div align="center"> 
        <input type="button" name="Submit" value="备份数据" onclick="self.location.href='ChangeTable.php?mydbname=<?=$r[0]?><?=$ecms_hashur['ehref']?>';">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Submit3" value="删除数据库" onclick="javascript:DoDrop('<?=$r[0]?>')">
      </div></td>
  </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="2"><form name="form1" method="post" action="phome.php">
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
		<?=$ecms_hashur['form']?>
          <tr class="header"> 
            <td height="25">建立数据库
              <input name="phome" type="hidden" id="phome" value="CreateDb">
              </td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF">数据库名： 
              <input name="mydbname" type="text" id="mydbname">
              <select name="mydbchar" id="mydbchar">
                <option value="">默认编码</option>
                <option value="gbk">gbk</option>
                <option value="utf8">utf8</option>
                <option value="gb2312">gb2312</option>
                <option value="big5">big5</option>
				<option value="latin1">latin1</option>
              </select> 
              <input type="submit" name="Submit2" value="建立">
            </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</body>
</html>
