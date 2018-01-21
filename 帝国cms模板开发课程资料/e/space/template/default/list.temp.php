<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
//位置
$url="$spacename &gt; $mr[qmname]";
include("header.temp.php");
?>
<?=$spacegg?>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#96C8F1">
  <tr>
    <td height="24" background="template/default/images/bg_title_sider.gif">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><?=$mr['qmname']?></td>
			<td align="right"><a href="../DoInfo/ChangeClass.php?mid=<?=$mid?>" target="_blank">增加<?=$mr['qmname']?></a></td>
		</tr>
	  </table>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php
	while($r=$empire->fetch($sql))
	{
		$titleurl=sys_ReturnBqTitleLink($r);//链接
	?>
		<tr> 
          <td height="23"><img src="template/default/images/li.gif" width="15" height="10"><a href="<?=$titleurl?>" target="_blank"><?=$r[title]?></a>&nbsp;&nbsp;<font color="#666666">(<?=date("Y-m-d H:i:s",$r[newstime])?>)</font></td>
        </tr>
	<?php
	}
	?>
		<tr>
          <td height="25">&nbsp;<?=$returnpage?></td>
        </tr>
	</table>
	</td>
  </tr>
</table>
<?php
include("footer.temp.php");
?>
