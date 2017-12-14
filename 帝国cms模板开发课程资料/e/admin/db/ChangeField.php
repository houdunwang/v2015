<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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

$tid=(int)$_GET['tid'];
if($tid)
{
	$tbwhere="tid='$tid'";
	$search="&tid=$tid";
}
else
{
	$tbname=RepPostVar($_GET['tbname']);
	$tbwhere="tbname='$tbname'";
	$search="&tbname=$tbname";
}
$search.=$ecms_hashur['ehref'];
$viewf=RepPostVar($_GET['viewf']);
$changef=RepPostVar($_GET['changef']);
if(!$viewf||!$changef)
{
	printerror('ErrorUrl','');
}
//取得表名
$tbr=$empire->fetch1("select tbname from {$dbtbpre}enewstable where ".$tbwhere);
if(!$tbr['tbname'])
{
	printerror('ErrorUrl','');
}
$tbname=$tbr['tbname'];
//字段
$sysf=',id,classid,onclick,newspath,keyboard,userid,username,istop,truetime,ismember,userfen,isgood,titlefont,isurl,filename,groupid,plnum,firsttitle,isqf,totaldown,havehtml,lastdotime,stb,ttid,';
$viewfr=$empire->fetch1("select f,fname from {$dbtbpre}enewsf where ".$tbwhere." and f='$viewf' and tbdataf=0 limit 1");
$changefr=$empire->fetch1("select f,fname from {$dbtbpre}enewsf where ".$tbwhere." and f='$changef' and tbdataf=0 limit 1");
if(!$viewfr[f]&&!strstr($sysf,','.$viewf.','))
{
	printerror('ErrorUrl','');
}
if(!$changefr[f]&&!strstr($sysf,','.$changef.','))
{
	printerror('ErrorUrl','');
}
if(strstr($sysf,','.$viewf.','))
{
	$viewfr[fname]=$viewf;
}
if(strstr($sysf,','.$changef.','))
{
	$changefr[fname]=$changef;
}
$form=RepPostVar($_GET['form']);
if(empty($form))
{
	$form='add';
}
$field=RepPostVar($_GET['field']);
$add='';
//关键字
$keyboard=RepPostVar2($_GET['keyboard']);
if(!empty($keyboard))
{
	$show=RepPostVar($_GET['show']);
	if($show==$viewf||$show==$changef)
	{
		$add=" where ".$show." like '%".$keyboard."%'";
	}
	if($show==$changef)
	{
		$searchoptionselect=' selected';
	}
}
$changeline=(int)$_GET['changeline'];
if($changeline<1)
{
	$changeline=2;
}
$search.="&viewf=$viewf&changef=$changef&form=$form&field=$field&show=$show&keyboard=$keyboard&changeline=$changeline";
if($viewf==$changef)
{
	$searchoption="<option value='$viewf'>$viewfr[fname]</option>";
}
else
{
	$searchoption="<option value='$viewf'>$viewfr[fname]</option><option value='$changef'".$searchoptionselect.">$changefr[fname]</option>";
}
//分页
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=50;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select ".$viewf.",".$changef." from {$dbtbpre}ecms_".$tbname.$add;
$totalquery="select count(*) as total from {$dbtbpre}ecms_".$tbname.$add;
$num=$empire->gettotal($totalquery);//取得总条数
$query=$query." order by id desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择</title>
<link href="edit.css" rel="stylesheet" type="text/css">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ChangeFieldVal(val)
{
	opener.document.<?=$form?>.<?=$field?>.value=val;
	window.close();
}
</script>
</head>
<body>
<form name="form1" id="form1" method="get" action="ChangeField.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td width="70%"><div align="center">搜索： 
          <input name="keyboard" type="text" value="<?=$keyboard?>">
          <select name="show">
            <?=$searchoption?>
          </select>
          <input type="submit" name="Submit" value="搜索">
          <input type=hidden name="form" value="<?=$form?>">
          <input type=hidden name="field" value="<?=$field?>">
          <input name="tid" type="hidden" id="tid" value="<?=$tid?>">
          <input name="tbname" type="hidden" value="<?=$tbname?>">
          <input name="viewf" type="hidden" id="viewf" value="<?=$viewf?>">
          <input name="changef" type="hidden" id="changef" value="<?=$changef?>">
          <input name="changeline" type="hidden" value="<?=$changeline?>">
        </div></td>
      <td width="30%">
	  <span id="showaddclassnav"></span>
      <input type="button" name="Submit" value="增加信息" onclick="if(document.getElementById('addclassid').value!=0){window.open('../AddNews.php?<?=$ecms_hashur['ehref']?>&enews=AddNews&classid='+document.getElementById('addclassid').value,'','');}else{alert('请选择要增加信息的栏目');document.getElementById('addclassid').focus();}">
	  </td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr> 
    <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
    <?php
	//输出
	$i=0;
	$class_text="";
	while($r=$empire->fetch($sql))
	{
		$i++;
        if(($i-1)%$changeline==0||$i==1)
		{
			$class_text.="<tr>";
		}
		$class_text.="<td align=center height=25><a href='#ecms' onclick=\"ChangeFieldVal('".ehtmlspecialchars(stripSlashes($r[$changef]))."');\" title='选择'>".stripSlashes($r[$viewf])."</a></td>";
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
<div align="center"> <br>
  [<a href="#empirecms" onclick="window.close();">关闭</a>]</div>
<IFRAME frameBorder="0" id="showclassnav" name="showclassnav" scrolling="no" src="../ShowClassNav.php?ecms=7<?=$ecms_hashur['ehref']?>" style="HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1"></IFRAME>
</body>
</html>
<?php
db_close();
$empire=null;
?>
