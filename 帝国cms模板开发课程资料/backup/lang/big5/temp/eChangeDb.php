<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>選擇數據庫</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function DoDrop(dbname)
{
	var ok;
	var oktwo;
	var okthree;
	ok=confirm("確認要刪除此數據庫?");
	if(ok==false)
	{
		return false;
	}
	oktwo=confirm("再次確認要刪除此數據庫?");
	if(oktwo==false)
	{
		return false;
	}
	okthree=confirm("最後確認要刪除此數據庫?");
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
    <td>位置：備份數據 -&gt; <a href="ChangeDb.php">選擇數據庫</a></td>
  </tr>
  <tr>
    <td height="25"><div align="center">備份步驟：<font color="#FF0000">選擇數據庫</font> 
        -&gt; 選擇要備份的表 -&gt; 開始備份 -&gt; 完成</div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="56%" height="25"> 
    <div align="center">數據庫名</div></td>
    <td width="44%" height="25"> 
    <div align="center">備份</div></td>
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
        <input type="button" name="Submit" value="備份數據" onclick="self.location.href='ChangeTable.php?mydbname=<?=$r[0]?>';">
        &nbsp;&nbsp;&nbsp;<input type="button" name="Submit" value="執行SQL" onclick="self.location.href='DoSql.php?mydbname=<?=$r[0]?>';">
		&nbsp;&nbsp;&nbsp;<input type="button" name="Submit3" value="刪除數據庫" onclick="javascript:DoDrop('<?=$r[0]?>')">
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
            <td height="25">建立數據庫
              <input name="phome" type="hidden" id="phome" value="CreateDb">
              </td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF">數據庫名： 
              <input name="mydbname" type="text" id="mydbname">
              <select name="mydbchar" id="mydbchar">
                <option value="">默認編碼</option>
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