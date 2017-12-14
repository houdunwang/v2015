<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
//位置
$url="$spacename &gt; ".$pagename;
include("header.temp.php");
$pagetext=nl2br(RepFieldtextNbsp($pagetext));
?>
<?=$spacegg?>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#96C8F1">
  <tr>
    <td background="template/default/images/bg_title_sider.gif"><b><?=$pagename?></b></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <?=$pagetext?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
include("footer.temp.php");
?>
