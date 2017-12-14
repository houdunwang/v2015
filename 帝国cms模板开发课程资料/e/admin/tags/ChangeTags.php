<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require '../'.LoadLang("pub/fun.php");
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

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$field=RepPostVar($_GET['field']);
$form=RepPostVar($_GET['form']);
$line=50;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
//搜索
$search="&field=$field&form=$form".$ecms_hashur['ehref'];
$add='';
//推荐
$isgood=(int)$_GET[isgood];
if($isgood)
{
	$add.=' and isgood=1';
	$search.="&isgood=$isgood";
}
//分类
$cid=(int)$_GET[cid];
if($cid)
{
	$add.=" and cid='$cid'";
	$search.="&cid=$cid";
}
//关键字
if($_GET['keyboard'])
{
	$keyboard=RepPostVar($_GET['keyboard']);
	$show=(int)$_GET['show'];
	if($show==1)
	{
		$add.=" and tagid='$keyboard'";
	}
	else
	{
		$add.=" and tagname like '%$keyboard%'";
	}
	$search.="&show=$show&keyboard=$keyboard";
}
//排序
$orderby=RepPostStr($_GET['orderby'],1);
if($orderby==1)//按TAGID升序排序
{$doorder='tagid asc';}
elseif($orderby==2)//按信息数降序排序
{$doorder='num desc';}
elseif($orderby==3)//按信息数升序排序
{$doorder='num asc';}
else//按TAGID降序排序
{$doorder='tagid desc';}
$search.="&orderby=$orderby";
$add=$add?' where '.substr($add,5):'';
$totalquery="select count(*) as total from {$dbtbpre}enewstags".$add;
$query="select tagid,tagname,isgood from {$dbtbpre}enewstags".$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by ".$doorder." limit $offset,$line";
$sql=$empire->query($query);
//分类
$csql=$empire->query("select classid,classname from {$dbtbpre}enewstagsclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cid==$cr[classid])
	{
		$select=" selected";
	}
	$cs.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$changeline=5;//一行几个
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择TAGS</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ChangeTags(tags){
	var v;
	var str;
	var r;
	str=','+opener.document.<?=$form?>.<?=$field?>.value+',';
	//重复
	r=str.split(','+tags+',');
	if(r.length!=1)
	{
		return false;
	}
	if(str==",,")
	{v="";}
	else
	{v=",";}
	opener.document.<?=$form?>.<?=$field?>.value+=v+tags;
}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <form name="searchform" method="GET" action="ChangeTags.php">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">搜索： 
        <select name="show" id="select">
          <option value="0"<?=$show==0?' selected':''?>>TAG名称</option>
          <option value="1"<?=$show==1?' selected':''?>>TAGID</option>
        </select> <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>"> 
        <select name="cid" id="cid">
          <option value="0">不限分类</option>
          <?=$cs?>
        </select> <input name="isgood" type="checkbox" id="isgood" value="1"<?=$isgood==1?' checked':''?>>
        推荐TAGS 
        <select name="orderby" id="orderby">
          <option value="0"<?=$orderby==0?' selected':''?>>按TAGID降序排序</option>
          <option value="1"<?=$orderby==1?' selected':''?>>按TAGID升序排序</option>
          <option value="2"<?=$orderby==2?' selected':''?>>按信息数降序排序</option>
          <option value="3"<?=$orderby==3?' selected':''?>>按信息数升序排序</option>
        </select> <input type="submit" name="Submit2" value="显示">
        <input name="form" type="hidden" id="form" value="<?=$form?>">
        <input name="field" type="hidden" id="field" value="<?=$field?>"></td>
    </tr>
  </form>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr> 
    <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
    <?php
	//输出
	$i=0;
	$class_text="";
	while($r=$empire->fetch($sql))
	{
		$tagname=$r[tagname];
		if($r[isgood])
		{
			$tagname='<b>'.$tagname.'</b>';
		}
		$i++;
        if(($i-1)%$changeline==0||$i==1)
		{
			$class_text.="<tr>";
		}
		$class_text.="<td align=center height=25><a href='#empirecms' onclick=\"ChangeTags('".$r[tagname]."');\" title='TAGID：".$r[tagid]."'>".$tagname."</a></td>";
		//分割
        if($i%$changeline==0)
		{
			$class_text.="</tr>";
		}
	}
	if($i<>0)
	{
		 $table="<table width=100% border=0 cellpadding=3 cellspacing=0>";$table1="</table>";
         $ys=$changeline-$i%$changeline;
		 $p=0;
         for($j=0;$j<$ys&&$ys!=$changeline;$j++)
		 {
			  $p=1;
              $class_text.="<td></td>";
         }
		 if($p==1)
		 {
			  $class_text.="</tr>";
		 }
	 }
     $text=$table.$class_text.$table1;
     echo"$text";
	?>
      </div></td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#FFFFFF" align=center> 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
