<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择好友</title>
<link href="../../../data/images/qcss.css" rel="stylesheet" type="text/css">
<script>
function ChangeHy()
{
	var fname=document.changeuser.fname.value;
	if(fname!="")
	{
		opener.document.<?=$fm?>.<?=$f?>.value=fname;
	}
	window.close();
}
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="changeuser" method="GET" action="index.php?<?=$addvar?>">
    <tr class="header"> 
      <td height="23">选择用户</td>
    </tr>
    <tr> 
      <td width="82%" height="25" bgcolor="#FFFFFF">分类：
        <select name="cid" id="select" onchange=window.location='index.php?<?=$addvar?>&cid='+this.options[this.selectedIndex].value>
          <option value="0">显示全部</option>
          <?=$select?>
        </select></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">
<select name="fname" size="16" id="fname" style="width:200">
<?=$hyselect?>
        </select></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">
<input type="button" name="Submit" value="确定" onclick="ChangeHy();"></td>
    </tr>
	</form>
  </table>
</body>
</html>