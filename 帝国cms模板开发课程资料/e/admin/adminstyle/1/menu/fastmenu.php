<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>菜单</title>
<link href="../../../data/menu/menu.css" rel="stylesheet" type="text/css">
<script src="../../../data/menu/menu.js" type="text/javascript"></script>
<SCRIPT lanuage="JScript">
function tourl(url){
	parent.main.location.href=url;
}
</SCRIPT>
</head>
<body onLoad="initialize()">
<table border='0' cellspacing='0' cellpadding='0'>
	<tr height=20>
			<td id="home"><img src="../../../data/images/homepage.gif" border=0></td>
			<td><b>常用操作</b></td>
	</tr>
</table>

<table border='0' cellspacing='0' cellpadding='0'>
<?php
$b=0;
//自定义常用操作菜单
$menucsql=$empire->query("select classid,classname from {$dbtbpre}enewsmenuclass where classtype=1 and (groupids='' or groupids like '%,".intval($lur[groupid]).",%') order by myorder,classid");
while($menucr=$empire->fetch($menucsql))
{
	$menujsvar='diymenu'.$menucr['classid'];
	$b=1;
?>
  <tr> 
    <td id="pr<?=$menujsvar?>" class="menu1" onclick="chengstate('<?=$menujsvar?>')"> 
      <a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'"> 
      <?=$menucr['classname']?>
      </a> </td>
  </tr>
  <tr id="item<?=$menujsvar?>" style="display:none"> 
    <td class="list"> <table border='0' cellspacing='0' cellpadding='0'>
        <?php
		$menusql=$empire->query("select menuid,menuname,menuurl,addhash from {$dbtbpre}enewsmenu where classid='$menucr[classid]' order by myorder,menuid");
		while($menur=$empire->fetch($menusql))
		{
			if(!(strstr($menur['menuurl'],'://')||substr($menur['menuurl'],0,1)=='/'))
			{
				$menur['menuurl']='../../'.$menur['menuurl'];
			}
			$menu_ecmshash='';
			if($menur['addhash'])
			{
				if(strstr($menur['menuurl'],'?'))
				{
					$menu_ecmshash=$menur['addhash']==2?$ecms_hashur['href']:$ecms_hashur['ehref'];
				}
				else
				{
					$menu_ecmshash=$menur['addhash']==2?$ecms_hashur['whhref']:$ecms_hashur['whehref'];
				}
				$menur['menuurl'].=$menu_ecmshash;
			}
		?>
        <tr> 
          <td class="file"> <a href="<?=$menur['menuurl']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'"> 
            <?=$menur['menuname']?>
            </a> </td>
        </tr>
        <?php
		}
		?>
      </table></td>
  </tr>
  <?php
}
//没菜单
if(!$b)
{
	$notrecordword="您还未添加常用菜单,<br><a href='../../other/MenuClass.php".$ecms_hashur['whehref']."' target='main'><u><b>点击这里</b></u></a>进行添加操作";
	echo"<tr><td>$notrecordword</td></tr>";
}
?>
</table>
</body>
</html>