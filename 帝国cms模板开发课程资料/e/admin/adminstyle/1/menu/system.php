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
			<td><b>系统设置</b></td>
	</tr>
</table>

<table border='0' cellspacing='0' cellpadding='0'>
<?
if($r[dopublic]||$r[dofirewall]||$r[dosetsafe]||$r[dopubvar])
{
?>
  <tr> 
    <td id="prsetting" class="menu1" onclick="chengstate('setting')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">系统设置</a>
	</td>
  </tr>
  <tr id="itemsetting" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<?
		if($r[dopublic])
		{
		?>
        <tr> 
          <td class="file">
			<a href="../../SetEnews.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">系统参数设置</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../pub/SetRewrite.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">伪静态参数设置</a>
          </td>
        </tr>
		<?
		}
		if($r[dopubvar])
		{
		?>
        <tr> 
          <td class="file">
			<a href="../../pub/ListPubVar.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">扩展变量</a>
          </td>
        </tr>
		<?
		}
		if($r[dosetsafe])
		{
		?>
        <tr> 
          <td class="file">
			<a href="../../pub/SetSafe.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">安全参数配置</a>
          </td>
        </tr>
		<?
		}
		if($r[dofirewall])
		{
		?>
		<tr> 
          <td class="file1">
			<a href="../../pub/SetFirewall.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">网站防火墙</a>
          </td>
        </tr>
		<?
		}
		?>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dochangedata]||$r[dopostdata])
{
?>
  <tr> 
    <td id="prchangedata" class="menu1" onclick="chengstate('changedata')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">数据更新</a>
	</td>
  </tr>
  <tr id="itemchangedata" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<?
		if($r[dochangedata])
		{
		?>
		<tr> 
          <td class="file">
			<a href="../../ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">数据更新中心</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../ReHtml/ReInfoUrl.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">更新信息页地址</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../ReHtml/DoUpdateData.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">数据整理</a>
          </td>
        </tr>
		<?
		}
		if($r[dopostdata])
		{
		?>
		<tr> 
          <td class="file1">
			<a href="../../PostUrlData.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">远程发布</a>
          </td>
        </tr>
		<?
		}
		?>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dof]||$r[dom]||$r[dotable])
{
?>
  <tr> 
    <td id="prtable" class="menu1" onclick="chengstate('table')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">数据表与系统模型</a>
	</td>
  </tr>
  <tr id="itemtable" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../db/AddTable.php?enews=AddTable<?=$ecms_hashur['ehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">新建数据表</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../db/ListTable.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理数据表</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dodo]||$r[dotask])
{
?>
  <tr> 
    <td id="prtask" class="menu1" onclick="chengstate('task')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">计划任务</a>
	</td>
  </tr>
  <tr id="itemtask" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<?
		if($r[dodo])
		{
		?>
        <tr> 
          <td class="file">
			<a href="../../ListDo.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理刷新任务</a>
          </td>
        </tr>
		<?
		}
		if($r[dotask])
		{
		?>
		<tr> 
          <td class="file1">
			<a href="../../other/ListTask.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理计划任务</a>
          </td>
        </tr>
		<?
		}
		?>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[doworkflow])
{
?>
  <tr> 
    <td id="prwf" class="menu1" onclick="chengstate('wf')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">工作流</a>
	</td>
  </tr>
  <tr id="itemwf" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../workflow/AddWf.php?enews=AddWorkflow<?=$ecms_hashur['ehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">增加工作流</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../workflow/ListWf.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理工作流</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[doyh])
{
?>
  <tr> 
    <td id="pryh" class="menu1" onclick="chengstate('yh')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">优化方案</a>
	</td>
  </tr>
  <tr id="itemyh" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file1">
			<a href="../../db/ListYh.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理优化方案</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?php
if($r['domoreport'])
{
?>
  <tr> 
    <td id="prmport" class="menu1" onclick="chengstate('mport')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">网站多访问端</a>
    </td>
  </tr>
  <tr id="itemmport" style="display:none"> 
    <td class="list">
      <table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file1">
		<a href="../../moreport/ListMoreport.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理网站访问端</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
<?
}
?>

<?
if($r[domenu])
{
?>
  <tr> 
    <td id="prmenu" class="menu1" onclick="chengstate('menu')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">扩展菜单</a>
	</td>
  </tr>
  <tr id="itemmenu" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file1">
			<a href="../../other/MenuClass.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理菜单</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dodbdata]||$r[doexecsql])
{
?>
  <tr> 
    <td id="prbak" class="menu3" onclick="chengstate('bak')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">备份与恢复数据</a>
	</td>
  </tr>
  <tr id="itembak" style="display:none"> 
    <td class="list1">
		<table border='0' cellspacing='0' cellpadding='0'>
		<?
		if($r[dodbdata])
		{
		?>
        <tr> 
          <td class="file">
			<a href="../../ebak/ChangeDb.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">备份数据</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../ebak/ReData.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">恢复数据</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../ebak/ChangePath.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理备份目录</a>
          </td>
        </tr>
		<?
		}
		if($r[doexecsql])
		{
		?>
		<tr> 
          <td class="file1">
			<a href="../../db/DoSql.php<?=$ecms_hashur['whehref']?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">执行SQL语句</a>
          </td>
        </tr>
		<?
		}
		?>
      </table>
	</td>
  </tr>
<?
}
?>
</table>
</body>
</html>