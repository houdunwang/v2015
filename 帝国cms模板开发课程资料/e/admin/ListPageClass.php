<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();
//验证权限
CheckLevel($logininid,$loginin,$classid,"class");
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$add="";
$search="";
$search.=$ecms_hashur['ehref'];
//搜索
if($_GET['sear'])
{
	$search.="&sear=1";
	//关键字
	$keyboard=RepPostVar2($_GET['keyboard']);
	if($keyboard)
	{
		$show=RepPostStr($_GET['show'],1);
		if($show==1)
		{
			$add=" and (classname like '%$keyboard%')";
		}
		elseif($show==2)
		{
			$add=" and (intro like '%$keyboard%')";
		}
		elseif($show==3)
		{
			$add=" and (bname like '%$keyboard%')";
		}
		elseif($show==4)
		{
			$add=" and (classid='$keyboard')";
		}
		elseif($show==6)
		{
			$add=" and (bclassid='$keyboard')";
		}
		elseif($show==5)
		{
			$add=" and (classpath like '%$keyboard%')";
		}
		else
		{
			$add=" and (classname like '%$keyboard%' or intro like '%$keyboard%' or bname like '%$keyboard%' or classpath like '%$keyboard%' or classid='$keyboard')";
		}
		$search.="&keyboard=$keyboard&show=$show";
	}
	//条件
	$scond=(int)$_GET['scond'];
	if($scond)
	{
		if($scond==1)
		{
			$add.=" and islast=1";
		}
		elseif($scond==2)
		{
			$add.=" and islast=0";
		}
		elseif($scond==3)
		{
			$add.=" and islist=1 and islast=0";
		}
		elseif($scond==4)
		{
			$add.=" and islist=0 and islast=0";
		}
		elseif($scond==11)
		{
			$add.=" and islist=2 and islast=0";
		}
		elseif($scond==12)
		{
			$add.=" and islist=3 and islast=0";
		}
		elseif($scond==5)
		{
			$add.=" and islast=1 and openadd=1";
		}
		elseif($scond==6)
		{
			$add.=" and islast=1 and openpl=1";
		}
		elseif($scond==7)
		{
			$add.=" and listdt=1";
		}
		elseif($scond==8)
		{
			$add.=" and showdt=1";
		}
		elseif($scond==9)
		{
			$add.=" and showclass=1";
		}
		elseif($scond==10)
		{
			$add.=" and showdt=2";
		}
		$search.="&scond=$scond";
	}
	//模型
	$modid=(int)$_GET['modid'];
	if($modid)
	{
		$add.=" and modid=$modid";
		$search.="&modid=$modid";
	}
}
if($add)
{
	$add=" where".substr($add,4,strlen($add));
}
//系统模型
$modselect="";
$msql=$empire->query("select mid,mname from {$dbtbpre}enewsmod where usemod=0 order by myorder,mid");
while($mr=$empire->fetch($msql))
{
	$select="";
	if($mr[mid]==$modid)
	{
		$select=" selected";
	}
	$modselect.="<option value='".$mr[mid]."'".$select.">".$mr[mname]."</option>";
}
$totalquery="select count(*) as total from {$dbtbpre}enewsclass".$add;
$query="select * from {$dbtbpre}enewsclass".$add;
$num=$empire->gettotal($totalquery);//取得总条数
//排序
$myorder=(int)$_GET['myorder'];
if($myorder==1)
{
	$doorder="myorder";
}
else
{
	$doorder="classid";
}
$orderby=(int)$_GET['orderby'];
if($orderby==1)
{
	$doorderby="";
	$ordername="降序";
	$neworderby=0;
}
else
{
	$doorderby=" desc";
	$ordername="升序";
	$neworderby=1;
}
$orderidlink="<a href='ListPageClass.php?myorder=0&orderby=$neworderby".$search."' title='点击按 栏目ID ".$ordername."排列'><u>ID</u></a>";
$ordertwolink="<a href='ListPageClass.php?myorder=1&orderby=$neworderby".$search."' title='点击按 栏目顺序 ".$ordername."排列'><u>顺序</u></a>";
$search.="&myorder=$myorder&orderby=$orderby";
$query=$query." order by ".$doorder.$doorderby." limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理栏目</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="18%">位置: <a href="ListPageClass.php<?=$ecms_hashur['whehref']?>">管理栏目</a></td>
    <td width="82%"> <div align="right" class="emenubutton">
        <input type="button" name="Submit6" value="增加栏目" onclick="self.location.href='AddClass.php?enews=AddClass&from=1<?=$ecms_hashur['ehref']?>'">
        <input type="button" name="Submit" value="刷新首页" onclick="self.location.href='ecmschtml.php?enews=ReIndex<?=$ecms_hashur['href']?>'">
        <input type="button" name="Submit2" value="刷新所有栏目页" onclick="window.open('ecmschtml.php?enews=ReListHtml_all&from=ListPageClass.php<?=urlencode($ecms_hashur['whehref'])?><?=$ecms_hashur['href']?>','','');">
        <input type="button" name="Submit3" value="刷新所有信息页面" onclick="window.open('ReHtml/DoRehtml.php?enews=ReNewsHtml&start=0&from=ListPageClass.php<?=urlencode($ecms_hashur['whehref'])?><?=$ecms_hashur['href']?>','','');">
        <input type="button" name="Submit4" value="刷新所有JS调用" onclick="window.open('ecmschtml.php?enews=ReAllNewsJs&from=ListPageClass.php<?=urlencode($ecms_hashur['whehref'])?><?=$ecms_hashur['href']?>','','');">
      </div></td>
  </tr>
</table>
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
  <form name="searchclass" method="GET" action="ListPageClass.php">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td height="32"><div align="right">搜索: 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="0"<?=$show==0?' selected':''?>>不限字段</option>
            <option value="1"<?=$show==1?' selected':''?>>栏目名</option>
            <option value="2"<?=$show==2?' selected':''?>>栏目简介</option>
            <option value="3"<?=$show==3?' selected':''?>>栏目别名</option>
            <option value="4"<?=$show==4?' selected':''?>>栏目ID</option>
			<option value="6"<?=$show==6?' selected':''?>>父栏目ID</option>
            <option value="5"<?=$show==5?' selected':''?>>栏目目录</option>
          </select>
          <select name="scond" id="scond">
            <option value="0"<?=$scond==0?' selected':''?>>不限条件</option>
            <option value="1"<?=$scond==1?' selected':''?>>终极栏目</option>
            <option value="2"<?=$scond==2?' selected':''?>>大栏目</option>
            <option value="3"<?=$scond==3?' selected':''?>>列表式大栏目</option>
            <option value="4"<?=$scond==4?' selected':''?>>封面式大栏目</option>
			<option value="12"<?=$scond==12?' selected':''?>>绑定信息式大栏目</option>
			<option value="11"<?=$scond==11?' selected':''?>>页面内容式大栏目</option>
            <option value="5"<?=$scond==5?' selected':''?>>未开放投稿的栏目</option>
            <option value="6"<?=$scond==6?' selected':''?>>未开放评论的栏目</option>
            <option value="7"<?=$scond==7?' selected':''?>>动态列表的栏目</option>
            <option value="8"<?=$scond==8?' selected':''?>>动态生成内容的栏目</option>
			<option value="10"<?=$scond==10?' selected':''?>>动态内容页面的栏目</option>
            <option value="9"<?=$scond==9?' selected':''?>>不显示到导航的栏目</option>
          </select>
          <select name="modid" id="modid">
            <option value="0">不限模型</option>
            <?=$modselect?>
          </select>
          <input type="submit" name="Submit8" value="显示">
          <input name="sear" type="hidden" id="sear" value="1">
          <input name="myorder" type="hidden" id="myorder" value="<?=$myorder?>">
          <input name="orderby" type="hidden" id="orderby" value="<?=$orderby?>">
        </div></td>
    </tr>
	</form>
  </table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name=editorder method=post action=ecmsclass.php onsubmit="return confirm('确认要操作?');">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="5%"><div align="center"> 
          <?=$ordertwolink?>
        </div></td>
      <td width="5%"><div align="center"></div></td>
      <td width="5%" height="25"> <div align="center"> 
          <?=$orderidlink?>
        </div></td>
      <td width="36%" height="25">栏目名</td>
      <td width="6%" height="25"> <div align="center">访问</div></td>
      <td width="14%" height="25">栏目管理</td>
      <td width="29%" height="25">操作</td>
    </tr>
    <?
	while($r=$empire->fetch($sql))
	{
		$docinfo="";
		$classinfotype='';
		$classurl=sys_ReturnBqClassUrl($r);
		if($r[islast]==1)
		{
			$img="<a href='AddNews.php?enews=AddNews&classid=".$r[classid].$ecms_hashur['ehref']."' target=_blank title='增加信息'><img src='../data/images/txt.gif' border=0></a>";
			$renewshtml=" <a href='ReHtml/DoRehtml.php?enews=ReNewsHtml&from=ListPageClass.php".urlencode($ecms_hashur['whehref'])."&classid=".$r[classid]."&tbname[]=".$r[tbname].$ecms_hashur['href']."'>".$fun_r['news']."</a> ";
			$docinfo=" <a href='ecmsinfo.php?enews=InfoToDoc&ecmsdoc=1&docfrom=ListPageClass.php".urlencode($ecms_hashur['whehref'])."&classid=".$r[classid].$ecms_hashur['href']."' onclick=\"return confirm('确认归档?');\">归档</a>";
			$classinfotype=" <a href='#e' onclick=window.open('ClassInfoType.php?classid=".$r[classid].$ecms_hashur['ehref']."');>分类</a>";
		}
		else
		{
			$img="<img src='../data/images/dir.gif'>";
			$renewshtml=" <a href='ReHtml/DoRehtml.php?enews=ReNewsHtml&from=ListPageClass.php".urlencode($ecms_hashur['whehref'])."&classid=".$r[classid]."&tbname[]=".$r[tbname].$ecms_hashur['href']."'>".$fun_r['news']."</a> ";
		}
		//外部栏目
		$classname=$r[classname];
		if($r[wburl])
		{
			$classname="<font color='#666666'>".$classname."&nbsp;(外部)</font>";
		}
		//上级栏目
		$bclassname='';
		if($r[bclassid])
		{
			$bcr=$empire->fetch1("select classid,classname from {$dbtbpre}enewsclass where classid='$r[bclassid]'");
			$bclassname=$bcr[classname].'&nbsp;>&nbsp;';
		}
	?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center">
	  <input type=text name=myorder[] value="<?=$r[myorder]?>" size=2>
	  <input type=hidden name=classid[] value="<?=$r[classid]?>">
	  </div></td>
      <td><div align="center"><?=$img?></div></td>
      <td height="25"><div align="center"><?=$r[classid]?></div></td>
      <td height="25"><?="<input type=checkbox name=reclassid[] value='".$r[classid]."'>&nbsp;".$bclassname."<a href='".$classurl."' target=_blank><b>".$classname."</b></a>";?></td>
      <td height="25"><div align="center"><?=$r[onclick]?></div></td>
      <td height="25"><?="<a href='AddClass.php?classid=".$r[classid]."&enews=EditClass&from=1".$ecms_hashur['ehref']."'>修改</a> <a href='AddClass.php?classid=".$r[classid]."&enews=AddClass&docopy=1&from=1".$ecms_hashur['ehref']."'>复制</a> <a href='ecmsclass.php?classid=".$r[classid]."&enews=DelClass&from=1".$ecms_hashur['href']."' onclick=\"return confirm('".$fun_r['CheckDelClass']."');\">删除</a>"?></td>
      <td height="25"><?="<a href='enews.php?enews=ReListHtml&from=ListPageClass.php".urlencode($ecms_hashur['whehref'])."&classid=".$r[classid].$ecms_hashur['href']."'>刷新</a>".$renewshtml."<a href='ecmschtml.php?enews=ReSingleJs&doing=0&classid=".$r[classid].$ecms_hashur['href']."'>JS</a> <a href='#ecms' onclick=window.open('view/ClassUrl.php?classid=".$r[classid].$ecms_hashur['ehref']."','','width=500,height=250');>调用</a>".$classinfotype.$docinfo;?>
	  </td>
    </tr>
    <?
	}
  	?>
    <tr bgcolor="#ffffff"> 
      <td height="25" colspan="7"> <div align="right">
          <input type="submit" name="Submit5" value="修改栏目顺序" onClick="document.editorder.enews.value='EditClassOrder';document.editorder.action='ecmsclass.php';">
          <input name="enews" type="hidden" id="enews" value="EditClassOrder">
          &nbsp;&nbsp; 
          <input type="submit" name="Submit7" value="刷新栏目页面" onClick="document.editorder.enews.value='GoReListHtmlMoreA';document.editorder.action='ecmschtml.php';"">
          &nbsp;&nbsp; 
          <input type="submit" name="Submit72" value="终极栏目属性转换" onClick="document.editorder.enews.value='ChangeClassIslast';document.editorder.action='ecmsclass.php';"">
        </div></td>
    </tr>
    <tr bgcolor="#ffffff"> 
      <td height="25" colspan="7">&nbsp;&nbsp; 
        <?=$returnpage?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="65" colspan="7"><strong>终极栏目属性转换说明(只能选择单个栏目)：</strong><br>
        如果你选择的是<font color="#FF0000">非终极栏目</font>，则转为<font color="#FF0000">终极栏目</font><font color="#666666">(此栏目不能有子栏目)</font><br>
        如果你选择的是<font color="#FF0000">终极栏目</font>，则转为<font color="#FF0000">非终极栏目</font><font color="#666666">(请先把当前栏目的数据转移，否则会出现冗余数据)<br>
        </font><strong>修改栏目顺序:顺序值越小越前面</strong></td>
    </tr>
    <input name="from" type="hidden" value="ListPageClass.php<?=$ecms_hashur['whehref']?>">
    <input name="gore" type="hidden" value="0">
  </form>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
