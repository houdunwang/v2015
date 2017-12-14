<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>选择数据库</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function DoDrop(dbname)
{
	var ok;
	var oktwo;
	var okthree;
	ok=confirm("确认要删除此数据库?");
	if(ok==false)
	{
		return false;
	}
	oktwo=confirm("再次确认要删除此数据库?");
	if(oktwo==false)
	{
		return false;
	}
	okthree=confirm("最后确认要删除此数据库?");
	if(okthree==false)
	{
		return false;
	}
	if(ok&&oktwo&&okthree)
	{
		self.location.href='phome.php?phome=DropDb&mydbname='+dbname;
	}
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：备份数据 -&gt; <a href="ChangeDb.php">选择数据库</a></td>
  </tr>
  <tr>
    <td height="25"><div align="center">备份步骤：<font color="#FF0000">选择数据库</font> 
        -&gt; 选择要备份的表 -&gt; 开始备份 -&gt; 完成</div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="56%" height="25"> 
    <div align="center">数据库名</div></td>
    <td width="44%" height="25"> 
    <div align="center">备份</div></td>
  </tr>
  <?php
  $i=0;
  while($r=$empire->fetch($sql))
  {
	$i++;
	if($i%2==0)
	{
		$bgcolor="#DBEAF5";
	}
	else
	{
		$bgcolor="#ffffff";
	}
	if($ebak_set_hidedbs&&stristr(','.$ebak_set_hidedbs.',',','.$r[0].','))
	{
		continue;
	}
  ?>
  <tr bgcolor="<?=$bgcolor?>"> 
    <td height="25"> 
      <div align="center"><strong><?=$r[0]?></strong></div></td>
    <td height="25"> 
      <div align="center"> 
        <input type="button" name="Submit" value="备份数据" onclick="self.location.href='ChangeTable.php?mydbname=<?=$r[0]?>';">
        &nbsp;&nbsp;&nbsp;<input type="button" name="Submit" value="执行SQL" onclick="self.location.href='DoSql.php?mydbname=<?=$r[0]?>';">
		&nbsp;&nbsp;&nbsp;<input type="button" name="Submit3" value="删除数据库" onclick="javascript:DoDrop('<?=$r[0]?>')">
      </div></td>
  </tr>
  <?
  }
  ?>
  </table>
  <br>
  <br>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
		<form name="form1" method="post" action="phome.php">
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
                <?php
				echo Ebak_ReturnDbCharList('');
				?>
              </select>
              <input type="submit" name="Submit2" value="建立">            </td>
          </tr>
		  </form>
        </table>
		<br>
</body>
</html>