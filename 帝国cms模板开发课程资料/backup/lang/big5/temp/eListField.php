<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>表字段列表</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function ChangeAutoField(f)
{
	var tbname="<?=$mytbname?>";
	var chstr=tbname+"."+f;
	var r;
	var dh=",";
	var a;
	a=opener.document.<?=$form?>.autofield.value;
	r=a.split(chstr);
	if(r.length!=1)
	{return true;}
	if(a=="")
	{
		dh="";
	}
	opener.document.<?=$form?>.autofield.value+=dh+chstr;
	window.close();
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>位置：<b>
      <?=$mydbname?>
      .
      <?=$mytbname?>
      </b> 字段列表&nbsp;<font color="#666666">(點擊字段名可「加入去除自增值字段列表」)</font></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="27"> <div align="center">字段名</div></td>
    <td><div align="center">字段類型</div></td>
    <td><div align="center">字段屬性</div></td>
    <td><div align="center">默認值</div></td>
    <td><div align="center">附加屬性</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
	$r[Field]="<a href='#ebak' onclick=\"ChangeAutoField('".$r[Field]."');\" title='加入去除自增值字段列表'>$r[Field]</a>";
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="27"> <div align="center">
        <?=$r[Field]?>
      </div></td>
    <td> <div align="center">
        <?=$r[Type]?>
      </div></td>
    <td> <div align="center">
        <?=$r[Key]?>
      </div></td>
    <td> <div align="center">
        <?=$r['Default']?>
      </div></td>
    <td> <div align="center">
        <?=$r[Extra]?>
      </div></td>
  </tr>
  <?
  }
  ?>
</table>
<br>
</body>
</html>