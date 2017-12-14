<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require("../data/dbcache/class.php");
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
CheckLevel($logininid,$loginin,$classid,"cj");

//显示无限级结点[增加结点时]
function ShowClass_AddInfoClass($obclassid,$bclassid,$exp,$enews=0){
	global $empire,$dbtbpre;
	if(empty($bclassid))
	{
		$bclassid=0;
		$exp="|-";
    }
	else
	{$exp="&nbsp;&nbsp;".$exp;}
	$sql=$empire->query("select classid,classname,bclassid from {$dbtbpre}enewsinfoclass where bclassid='$bclassid' order by classid");
	$returnstr="";
	while($r=$empire->fetch($sql))
	{
		if($r[classid]==$obclassid)
		{$select=" selected";}
		else
		{$select="";}
		$returnstr.="<option value=".$r[classid].$select.">".$exp.$r[classname]."</option>";
		$returnstr.=ShowClass_AddInfoClass($obclassid,$r[classid],$exp,$enews);
	}
	return $returnstr;
}

$enews=ehtmlspecialchars($_GET['enews']);
$r[newsclassid]=(int)$_GET['newsclassid'];
/*
if(empty($r[newsclassid])&&($enews=="AddInfoClass"||empty($enews)))
{
echo"<script>self.location.href='AddInfoC.php".$ecms_hashur['whehref']."';</script>";
exit();
}
*/
if($_GET['from'])
{
	$listclasslink="ListPageInfoClass.php";
}
else
{
	$listclasslink="ListInfoClass.php";
}

$docopy=ehtmlspecialchars($_GET['docopy']);
$url="采集&nbsp;>&nbsp;<a href=".$listclasslink.$ecms_hashur['whehref'].">管理节点</a>&nbsp;>&nbsp;增加节点";
//初使化数据
$r[startday]=date("Y-m-d");
$r[endday]="2099-12-31";
$r[num]=0;
$r[renum]=2;
$r[relistnum]=1;
$r[insertnum]=10;
$r[keynum]=0;
$r[keeptime]=0;
$r[smalltextlen]=200;
$r[titlelen]=0;
$r['getfirstspicw']=$public_r['spicwidth'];
$r['getfirstspich']=$public_r['spicheight'];
$pagetype0="";
$pagetype1=" checked";
//复制结点
if($docopy)
{
	$classid=(int)$_GET['classid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//采集节点
	if($r[newsclassid])
	{
		$ra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
		$r=TogTwoArray($r,$ra);
	}
	if(empty($r[pagetype]))
	{
		$pagetype0=" checked";
		$pagetype1="";
	}
	else
	{
		$pagetype0="";
		$pagetype1=" checked";
	}
	$url="采集&nbsp;>&nbsp;<a href=".$listclasslink.$ecms_hashur['whehref'].">管理节点</a>&nbsp;>&nbsp;复制节点：".$r[classname];
	$r[classname].="(1)";
}
//修改节点
if($enews=="EditInfoClass")
{
	$classid=(int)$_GET['classid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//采集节点
	if($r[newsclassid])
	{
		$ra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
		$r=TogTwoArray($r,$ra);
	}
	if(empty($r[pagetype]))
	{
		$pagetype0=" checked";
		$pagetype1="";
	}
	else
	{
		$pagetype0="";
		$pagetype1=" checked";
	}
	$url="采集&nbsp;>&nbsp;<a href=".$listclasslink.$ecms_hashur['whehref'].">管理节点</a>&nbsp;>&nbsp;修改节点";
}
//模型
$modid=$class_r[$r[newsclassid]][modid];
$modr=$empire->fetch1("select enter from {$dbtbpre}enewsmod where mid='$modid'");
//栏目
$options=ShowClass_AddClass("",$r[newsclassid],0,"|-",$class_r[$r[newsclassid]][modid],4);
if($r[retitlewriter])
{
	$retitlewriter=" checked";
}
if($r[copyimg])
{
	$copyimg=" checked";
}
if($r[copyflash])
{$copyflash=" checked";}
//节点
$infoclass=ShowClass_AddInfoClass($r[bclassid],0,"|-",0);

//采集表单文件
$cjfile="../data/html/cj".$class_r[$r[newsclassid]][modid].".php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加节点</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function AddRepAd(obj,val){
	var dh='';
	if(obj==1)
	{
		if(document.form1.pagerepad.value!='')
		{
			dh=',';
		}
		document.form1.pagerepad.value+=dh+val;
	}
	else
	{
		if(document.form1.repad.value!='')
		{
			dh=',';
		}
		document.form1.repad.value+=dh+val;
	}
}
</script>
</head>

<body>
<script src="ecmseditor/fieldfile/setday.js"></script>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListInfoClass.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="30%">基本信息</td>
      <td width="70%"><input type=hidden name=from value="<?=ehtmlspecialchars($_GET['from'])?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="add[classid]" type="hidden" id="add[classid]" value="<?=$classid?>"> 
        <input name="add[oldbclassid]" type="hidden" id="add[oldbclassid]" value="<?=$r[bclassid]?>"> 
        <input name="add[oldnewsclassid]" type="hidden" id="add[oldnewsclassid]" value="<?=$r[newsclassid]?>"></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">节点名称：</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[classname]" type="text" id="add[classname]" value="<?=$r[classname]?>" size=50> 
        <font color="#666666">(如：体育，娱乐等)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">父节点：</td>
      <td height="23" bgcolor="#FFFFFF"> <select name="bclassid" id="bclassid">
          <option value="0">新建父节点</option>
          <?=$infoclass?>
        </select></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">采集页面地址：<br>
        <font color="#666666">(一行为一个列表)<br>
        <br>
        <br>
        <input name="add[infourlispage]" type="checkbox" id="add[infourlispage]" value="1"<?=$r[infourlispage]?' checked':''?>>
        </font>采集页面为直接内容页</td>
      <td height="23" bgcolor="#FFFFFF"> <textarea name="add[infourl]" cols="72" rows="10" id="add[infourl]"><?=stripSlashes($r[infourl])?></textarea></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">采集页面地址方式二：<br> <font color="#666666">(此方式，系统自动生成页面地址)</font></td>
      <td height="23" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td>地址： 
              <input name="add[infourl1]" type="text" id="add[infourl1]2" size="42">
              (分页变量用 
              <input name="textfield" type="text" value="[page]" size="8">
              替换)</td>
          </tr>
          <tr> 
            <td>页码从 
              <input name="add[urlstart]" type="text" id="add[urlstart]4" value="1" size="6">
              到 
              <input name="add[urlend]" type="text" id="add[urlend]3" value="1" size="6">
              之间,间隔倍数 
              <input name="add[urlbs]" type="text" id="add[urlbs]" value="1" size="6"> 
              <input name="add[urldx]" type="checkbox" id="add[urldx]" value="1">
              倒序 
              <input name="add[urlbl]" type="checkbox" id="add[urlbl]" value="1">
              补零</td>
          </tr>
          <tr> 
            <td><font color="#666666">(如:http://www.phome.net/index.php?page=[page])</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">内容页地址前缀：</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[httpurl]" type="text" id="add[httpurl]" value="<?=$r[httpurl]?>" size="50"> 
        <br> <font color="#666666">(如地址前面没域名的话，系统会加上此前缀)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">图片/FLASH地址前缀(内容)：</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[imgurl]" type="text" id="add[imgurl]" value="<?=$r[imgurl]?>" size="50"> 
        <font color="#666666">(图片地址为相对地址时使用)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">入库栏目：</td>
      <td height="23" bgcolor="#FFFFFF"> <select name="newsclassid" id="newsclassid">
          <option value="0">选择栏目</option>
          <?=$options?>
        </select> <input type="button" name="Submit622232" value="管理栏目" onclick="window.open('ListClass.php<?=$ecms_hashur['whehref']?>');"> 
        <font color="#666666">(如本节点不是采集节点，请不选)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">开始时间：</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[startday]" type="text" id="add[startday]" value="<?=$r[startday]?>" size="12" onclick="setday(this)"> 
        <font color="#666666">(格式：2007-11-01)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">结束时间：</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[endday]" type="text" id="add[endday]" value="<?=$r[endday]?>" size="12" onclick="setday(this)"> 
        <font color="#666666">(格式：2007-11-01)</font></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">备注：</td>
      <td height="23" bgcolor="#FFFFFF"> <textarea name="add[bz]" cols="72" rows="8" id="add[bz]"><?=ehtmlspecialchars(stripSlashes($r[bz]))?></textarea></td>
    </tr>
    <tr class="header"> 
      <td height="23" colspan="2">选项</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">默认相关关键字：</td>
      <td height="23" bgcolor="#FFFFFF">截取标题前 
        <input name="add[keynum]" type="text" id="add[keynum]" value="<?=$r[keynum]?>" size="6">
        个字</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF"> <p>采集记录数：</p></td>
      <td height="23" bgcolor="#FFFFFF">采集前 
        <input name="add[num]" type="text" id="add[num]" value="<?=$r[num]?>" size="6">
        条记录<font color="#666666">(&quot;0&quot;为不限，系统会从头采到页面尾)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">远程保存图片到本地(内容)：</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[copyimg]" type="checkbox" id="add[copyimg]" value="1"<?=$copyimg?>>
        (入库时才会保存, 
        <input name="add[mark]" type="checkbox" id="add[mark]" value="1"<?=$r[mark]==1?' checked':''?>> 
        <a href="SetEnews.php<?=$ecms_hashur['whehref']?>" target="_blank">加水印</a>) </td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">远程保存FLASH到本地(内容)：</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[copyflash]" type="checkbox" id="add[copyflash]" value="1"<?=$copyflash?>>
        (入库时才会保存) </td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">标题图片设置：</td>
      <td height="23" bgcolor="#FFFFFF">取第 
        <input name="add[getfirstpic]" type="text" id="add[getfirstpic]" value="<?=$r[getfirstpic]?>" size="3">
        张图片为标题图片( 
        <input name="add[getfirstspic]" type="checkbox" id="add[getfirstspic]" value="1"<?=$r[getfirstspic]==1?' checked':''?>>
        生成缩略图:宽度 
        <input name="add[getfirstspicw]" type="text" id="add[getfirstspicw]" value="<?=$r[getfirstspicw]?>" size="3">
        ×高度 
        <input name="add[getfirstspich]" type="text" id="add[getfirstspich]" value="<?=$r[getfirstspich]?>" size="3">
        )</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">每组列表采集个数：</td>
      <td height="23" bgcolor="#FFFFFF">每组采集 
        <input name="add[relistnum]" type="text" id="add[relistnum]" value="<?=$r[relistnum]?>" size="6">
        个列表页<font color="#666666">(防止采集超时) </font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">每组信息采集个数：</td>
      <td height="23" bgcolor="#FFFFFF">每组采集 
        <input name="add[renum]" type="text" id="add[renum]" value="<?=$r[renum]?>" size="6">
        个信息页<font color="#666666">(防止采集超时)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">每组入库数：</td>
      <td height="23" bgcolor="#FFFFFF">每组入 
        <input name="add[insertnum]" type="text" id="add[insertnum]" value="<?=$r[insertnum]?>" size="6">
        条记录<font color="#666666">(防止入库超时) </font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">每组采集时间间隔</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[keeptime]" type="text" id="add[keeptime]" value="<?=$r[keeptime]?>" size="6">
        秒 <font color="#666666">(0为连续采集)</font></td>
    </tr>
    <tr class="header"> 
      <td height="23" colspan="2">附加选项</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">页面编码转换</td>
      <td height="23" bgcolor="#FFFFFF"> <table width="100%" border="0" cellpadding="1" cellspacing="1">
          <?php
	  $trueenpagecode="<input type='radio' name='add[enpagecode]' value='0'".($r[enpagecode]==0?' checked':'').">正常编码";
	  if(empty($ecms_config['sets']['pagechar'])||$ecms_config['sets']['pagechar']=='gb2312')
	  {
	  ?>
          <tr> 
            <td height="22">
              <?=$trueenpagecode?>            </td>
            <td><input type="radio" name="add[enpagecode]" value="1"<?=$r[enpagecode]==1?' checked':''?>>
              UTF8-&gt;GB2312</td>
            <td> <input type="radio" name="add[enpagecode]" value="3"<?=$r[enpagecode]==3?' checked':''?>>
              BIG5-&gt;GB2312</td>
            <td><input type="radio" name="add[enpagecode]" value="5"<?=$r[enpagecode]==5?' checked':''?>>
              UNICODE-&gt;GB2312</td>
          </tr>
          <?php
		$trueenpagecode='';
		}
		if(empty($ecms_config['sets']['pagechar'])||$ecms_config['sets']['pagechar']=='big5')
		{
		?>
          <tr> 
            <td height="22">
              <?=$trueenpagecode?>            </td>
            <td> <input type="radio" name="add[enpagecode]" value="2"<?=$r[enpagecode]==2?' checked':''?>>
              UTF8-&gt;BIG5</td>
            <td> <input type="radio" name="add[enpagecode]" value="4"<?=$r[enpagecode]==4?' checked':''?>>
              GB2312-&gt;BIG5</td>
            <td><input type="radio" name="add[enpagecode]" value="6"<?=$r[enpagecode]==6?' checked':''?>>
              UNICODE-&gt;BIG5</td>
          </tr>
          <?php
		 $trueenpagecode='';
		 }
		 if($ecms_config['sets']['pagechar']=='utf-8')
		 {
		 ?>
          <tr> 
            <td height="22">
              <?=$trueenpagecode?>            </td>
            <td><input type="radio" name="add[enpagecode]" value="7"<?=$r[enpagecode]==7?' checked':''?>>
              GB2312-&gt;UTF8</td>
            <td><input type="radio" name="add[enpagecode]" value="8"<?=$r[enpagecode]==8?' checked':''?>>
              BIG5-&gt;UTF8</td>
            <td><input type="radio" name="add[enpagecode]" value="9"<?=$r[enpagecode]==9?' checked':''?>>
              UNICODE-&gt;UTF8</td>
          </tr>
          <?php
		  }
		  ?>
        </table></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">是否重复采集同一链接</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[recjtheurl]" type="checkbox" id="add[recjtheurl]" value="1"<?=$r[recjtheurl]==1?' checked':''?>>
        重复采集<font color="#666666">（不选为不重复采集）</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF"><p>是否隐藏已导入的信息</p></td>
      <td height="23" bgcolor="#FFFFFF"><input type="radio" name="add[hiddenload]" value="0"<?=$r[hiddenload]==0?' checked':''?>>
        是 
        <input type="radio" name="add[hiddenload]" value="1"<?=$r[hiddenload]==1?' checked':''?>>
        否</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">采集后自动入库</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[justloadin]" type="checkbox" id="add[justloadin]" value="1"<?=$r[justloadin]==1?' checked':''?>>
        是， 
        <input name="add[justloadcheck]" type="checkbox" id="add[justloadcheck]" value="1"<?=$r[justloadcheck]==1?' checked':''?>>
        直接审核<font color="#666666">(不推荐选择，因为可能入库超时)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[delloadinfo]" type="checkbox" id="add[delloadinfo]" value="1"<?=$r[delloadinfo]==1?' checked':''?>>
        入库后自动删除已导入的信息记录</td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">整体页面过滤正则<br> <font color="#666666">格式：广告开始[!--pad--]广告结束</font></td>
      <td height="23" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td> <textarea name="pagerepad" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[pagerepad]))?></textarea>            </td>
            <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<iframe[!--pad--]</iframe>,<IFRAME[!--pad--]</IFRAME>');">IFRAME</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<table[!--pad--]>,</table>,<TABLE[!--pad--]>,</TABLE>');">TABLE</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<form[!--pad--]</form>,<FORM[!--pad--]</FORM>');">FORM</a></td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<object[!--pad--]</object>,<OBJECT[!--pad--]</OBJECT>');">OBJECT</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<tr[!--pad--]>,</tr>,<TR[!--pad--]>,</TR>');">TR</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<tbody[!--pad--]>,</tbody>,<TBODY[!--pad--]>,</TBODY>');">TBODY</a></td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<script[!--pad--]</script>,<SCRIPT[!--pad--]</SCRIPT>');">SCRIPT</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<td[!--pad--]>,</td>,<TD[!--pad--]>,</TD>');">TD</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<style[!--pad--]</style>,<STYLE[!--pad--]</STYLE>');">STYLE</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<a[!--pad--]>,</a>,<A[!--pad--]>,</A>');">A</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<div[!--pad--]>,</div>,<DIV[!--pad--]>,</DIV>');">DIV</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<font[!--pad--]>,</font>,<FONT[!--pad--]>,</FONT>');">FONT</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<span[!--pad--]>,</span>,<SPAN[!--pad--]>,</SPAN>');">SPAN</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<img[!--pad--]>,<IMG[!--pad--]>');">IMG</a></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td><font color="#666666">(多个请用&quot;,&quot;格开)</font></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="23" rowspan="2" valign="top" bgcolor="#FFFFFF">整体页面替换</td>
      <td height="11" bgcolor="#FFFFFF">将 
        <textarea name="add[oldpagerep]" cols="36" rows="10" id="add[oldpagerep]"><?=ehtmlspecialchars(stripSlashes($r[oldpagerep]))?></textarea>
        替换成 
        <textarea name="add[newpagerep]" cols="36" rows="10" id="textarea4"><?=ehtmlspecialchars(stripSlashes($r[newpagerep]))?></textarea>      </td>
    </tr>
    <tr> 
      <td height="11" bgcolor="#FFFFFF"><font color="#666666">(原字符多个请用&quot;,&quot;格开,如果是新字符是多个，可以用&quot;,&quot;格开，系统会对应替换)</font></td>
    </tr>
    <tr class="header"> 
      <td height="23" colspan="2">过滤选项</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">采集关键字(包含关键字才会采)：</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[keyboard]" type="text" id="add[keyboard]" value="<?=$r[keyboard]?>"> 
        <font color="#666666">(只针对标题。如不限制，请留空。多个请用&quot;,&quot;格开)</font></td>
    </tr>
    <tr> 
      <td rowspan="2" valign="top" bgcolor="#FFFFFF">替换：<br>
        (针对标题与内容) </td>
      <td height="23" bgcolor="#FFFFFF">将 
        <textarea name="add[oldword]" cols="36" rows="10" id="add[oldword]"><?=ehtmlspecialchars(stripSlashes($r[oldword]))?></textarea>
        替换成 
        <textarea name="add[newword]" cols="36" rows="10" id="add[newword]"><?=ehtmlspecialchars(stripSlashes($r[newword]))?></textarea>      </td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF"><font color="#666666">(原字符多个请用&quot;,&quot;格开,如果是新字符是多个，可以用&quot;,&quot;格开，系统会对应替换)</font></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF"><strong>过滤广告正则：</strong><br> 
        <font color="#666666">格式：广告开始[!--ad--]广告结束<br>
        (针对内容) </font></td>
      <td height="23" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td> <textarea name="repad" cols="60" rows="10" id="repad"><?=ehtmlspecialchars(stripSlashes($r[repad]))?></textarea>            </td>
            <td valign="top"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<iframe[!--ad--]</iframe>,<IFRAME[!--ad--]</IFRAME>');">IFRAME</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<table[!--ad--]>,</table>,<TABLE[!--ad--]>,</TABLE>');">TABLE</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<form[!--ad--]</form>,<FORM[!--ad--]</FORM>');">FORM</a></td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<object[!--ad--]</object>,<OBJECT[!--ad--]</OBJECT>');">OBJECT</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<tr[!--ad--]>,</tr>,<TR[!--ad--]>,</TR>');">TR</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<tbody[!--ad--]>,</tbody>,<TBODY[!--ad--]>,</TBODY>');">TBODY</a></td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<script[!--ad--]</script>,<SCRIPT[!--ad--]</SCRIPT>');">SCRIPT</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<td[!--ad--]>,</td>,<TD[!--ad--]>,</TD>');">TD</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<style[!--ad--]</style>,<STYLE[!--ad--]</STYLE>');">STYLE</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<a[!--ad--]>,</a>,<A[!--ad--]>,</A>');">A</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<div[!--ad--]>,</div>,<DIV[!--ad--]>,</DIV>');">DIV</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<font[!--ad--]>,</font>,<FONT[!--ad--]>,</FONT>');">FONT</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<span[!--ad--]>,</span>,<SPAN[!--ad--]>,</SPAN>');">SPAN</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<img[!--ad--]>,<IMG[!--ad--]>');">IMG</a></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td><font color="#666666">(多个请用&quot;,&quot;格开)</font></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">内容为空不采集</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[newstextisnull]" type="checkbox" id="add[newstextisnull]" value="1"<?=$r[newstextisnull]==1?' checked':''?>>
        是<font color="#666666"> (newstext字段)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">过滤相似：</td>
      <td height="23" bgcolor="#FFFFFF">不采集标题相似超过 
        <input name="add[titlelen]" type="text" id="add[titlelen]" value="<?=$r[titlelen]?>" size="6">
        字的信息[与入库信息比较]<font color="#666666">(如不限制请填&quot;0&quot;)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="23" bgcolor="#FFFFFF">不采集标题完全相同的信息(与入库信息比较) 
        <input name="add[retitlewriter]" type="checkbox" id="add[retitlewriter]" value="1"<?=$retitlewriter?>></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">截取内容简介：</td>
      <td height="23" bgcolor="#FFFFFF"> <p>截取信息内容 
          <input name="add[smalltextlen]" type="text" id="add[smalltextlen]" value="<?=$r[smalltextlen]?>" size="6">
          个字<font color="#666666">（在没有设置“内容简介”正则，系统采取的措施）</font></p></td>
    </tr>
    <tr class="header"> 
      <td height="25" colspan="2">采集内容正则(不采集项，请留空)</td>
    </tr>
    <tr> 
      <td bgcolor="#C7D4F7">列表页</td>
      <td bgcolor="#C7D4F7">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><strong>信息链接区域正则：</strong><br>
        (<font color="#FF0000">如不限，请为空</font>)<br>
        截取的地方加上 
        <input name="textfield" type="text" id="textfield" value="[!--smallurl--]" size="20"> 
        <br>
        如：&lt;tr&gt;&lt;td&gt;链接区域&lt;/td&gt;&lt;/tr&gt;<br>
        正则就是:<br> &lt;tr&gt;&lt;td&gt;[!--smallurl--]&lt;/td&gt;&lt;/tr&gt;</td>
      <td bgcolor="#FFFFFF"> <textarea name="add[zz_smallurl]" cols="60" rows="10" id="textarea8"><?=ehtmlspecialchars(stripSlashes($r[zz_smallurl]))?></textarea></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><strong>信息页链接正则：</strong><br>
        截取的地方加上 
        <input name="textfield" type="text" id="textfield3" value="[!--newsurl--]" size="20"> 
        <br>
        如：&lt;a href=&quot;信息链接&quot;&gt;标题&lt;/a&gt;<br>
        正则就是:<br> &lt;a href=&quot;[!--newsurl--]&quot;&gt;*&lt;/a&gt;</td>
      <td bgcolor="#FFFFFF"> <textarea name="add[zz_newsurl]" cols="60" rows="10" id="add[zz_newsurl]"><?=ehtmlspecialchars(stripSlashes($r[zz_newsurl]))?></textarea></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><p><strong>标题图片正则：<br>
          (如图片在内容页，请留空)</strong><br>
          <input name="textfield" type="text" id="textfield" value="[!--titlepic--]" size="20">
        </p></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td>图片地址前缀： 
              <input name="add[qz_titlepicl]" type="text" id="add[qz_titlepicl]" value="<?=stripSlashes($r[qz_titlepicl])?>" size="32"> 
              <input name="add[save_titlepicl]" type="checkbox" id="add[save_titlepicl]" value=" checked"<?=$r[save_titlepicl]?>>
              保存本地 </td>
          </tr>
          <tr> 
            <td><textarea name="add[zz_titlepicl]" cols="60" rows="10" id="add[zz_titlepicl]"><?=ehtmlspecialchars(stripSlashes($r[zz_titlepicl]))?></textarea></td>
          </tr>
          <tr> 
            <td><input name="add[z_titlepicl]" type="text" id="add[z_titlepicl]" value="<?=stripSlashes($r[z_titlepicl])?>" size="32">
              (如填这里，将为此字段值)</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="C7D4F7">内容页(文件过大的请不要选择保存本地)</td>
    </tr>
    <?
	@include($cjfile);
	?>
    <tr> 
      <td colspan="2" bgcolor="C7D4F7">内容页分页采集设置:(如没有分页请留空,只对newstext有效)</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">入库是否保留原分页：</td>
      <td bgcolor="#FFFFFF"><input type="radio" name="add[doaddtextpage]" value="0"<?=$r[doaddtextpage]==0?' checked':''?>>
        保留分页
        <input type="radio" name="add[doaddtextpage]" value="1"<?=$r[doaddtextpage]==1?' checked':''?>>
        不保留分页</td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">分页形式:</td>
      <td bgcolor="#FFFFFF"> <input type="radio" name="add[pagetype]" value="0"<?=$pagetype0?>>
        上下页导航式 
        <input type="radio" name="add[pagetype]" value="1"<?=$pagetype1?>>
        全部列出式 </td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF">&quot;全部列出&quot;式正则设置:</td>
      <td bgcolor="#FFFFFF"> <table width="100%%" border="0" cellspacing="1" cellpadding="2">
          <tr> 
            <td width="50%" height="23"><strong>分页区域正则(<font color="#FF0000">[!--smallpageallzz--]</font>)</strong></td>
            <td><strong>分页链接正则(<font color="#FF0000">[!--pageallzz--]</font>)</strong></td>
          </tr>
          <tr> 
            <td><textarea name="add[smallpageallzz]" cols="42" rows="12" id="textarea2"><?=ehtmlspecialchars(stripSlashes($r[smallpageallzz]))?></textarea></td>
            <td><textarea name="add[pageallzz]" cols="42" rows="12" id="textarea3"><?=ehtmlspecialchars(stripSlashes($r[pageallzz]))?></textarea></td>
          </tr>
        </table></td>
    </tr>
	<tr> 
      <td valign="top" bgcolor="#FFFFFF">&quot;上下页导航&quot;式正则设置:</td>
      <td bgcolor="#FFFFFF"> <table width="100%%" border="0" cellspacing="1" cellpadding="2">
          <tr> 
            <td width="50%" height="23"><strong>分页区域正则(<font color="#FF0000">[!--smallpagezz--]</font>)</strong></td>
            <td><strong>分页链接正则(<font color="#FF0000">[!--pagezz--]</font>)</strong></td>
          </tr>
          <tr> 
            <td><textarea name="add[smallpagezz]" cols="42" rows="12" id="add[smallpagezz]"><?=ehtmlspecialchars(stripSlashes($r[smallpagezz]))?></textarea></td>
            <td><textarea name="add[pagezz]" cols="42" rows="12" id="add[pagezz]"><?=ehtmlspecialchars(stripSlashes($r[pagezz]))?></textarea></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置">      </td>
    </tr>
  </table>
  <br>
  <table width="100%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td><strong>注意事项：<font color="#FF0000"><br>
        </font></strong>1.*:表示不限制内容。行与行之间的间隔最好用*格开<br>
        2.增加节点后，最好先“预览”。<br>
        3.对于特殊字符请在前面加上“\\”，当然直接将特殊字符改为“*”最合适了。特殊字符如下：<br>
        ),(,{,}，[,]，\，?<br>
        4.同一信息链接系统不会重复采集。</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>