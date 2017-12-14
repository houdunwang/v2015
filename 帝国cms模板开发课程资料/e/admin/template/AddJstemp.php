<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
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
//验证权限
CheckLevel($logininid,$loginin,$classid,"template");
$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$urlgname=$gname."&nbsp;>&nbsp;";
$cid=ehtmlspecialchars($_GET['cid']);
$enews=ehtmlspecialchars($_GET['enews']);
$r[showdate]="[m-d]";
$url=$urlgname."<a href=ListJstemp.php?gid=$gid".$ecms_hashur['ehref'].">管理JS模板</a>&nbsp;>&nbsp;增加JS模板";
//复制
if($enews=="AddJstemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select * from ".GetDoTemptb("enewsjstemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListJstemp.php?gid=$gid".$ecms_hashur['ehref'].">管理JS模板</a>&nbsp;>&nbsp;复制JS模板: ".$r[tempname];
}
//修改
if($enews=="EditJstemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select * from ".GetDoTemptb("enewsjstemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListJstemp.php?gid=$gid".$ecms_hashur['ehref'].">管理JS模板</a>&nbsp;>&nbsp;修改JS模板: ".$r[tempname];
}
//系统模型
$msql=$empire->query("select mid,mname from {$dbtbpre}enewsmod where usemod=0 order by myorder,mid");
while($mr=$empire->fetch($msql))
{
	if($mr[mid]==$r[modid])
	{$select=" selected";}
	else
	{$select="";}
	$mod.="<option value=".$mr[mid].$select.">".$mr[mname]."</option>";
}
//分类
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsjstempclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$r[classid])
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>增加JS模板</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<SCRIPT lanuage="JScript">
<!--
function tempturnit(ss)
{
 if (ss.style.display=="") 
  ss.style.display="none";
 else
  ss.style.display=""; 
}
-->
</SCRIPT>
<script>
function ReTempBak(){
	self.location.reload();
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListJstemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">增加JS模板 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"> <input name="gid" type="hidden" id="gid" value="<?=$gid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">模板名称(*)</td>
      <td width="81%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>"> 
      </td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">所属系统模型(*)</td>
      <td height="25"><select name="modid" id="modid">
          <?=$mod?>
        </select> <input type="button" name="Submit6" value="管理系统模型" onclick="window.open('../db/ListTable.php<?=$ecms_hashur['whehref']?>');"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">所属分类</td>
      <td height="25"><select name="classid" id="classid">
          <option value="0">不隶属于任何类别</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="管理分类" onclick="window.open('JsTempClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">简介截取字数</td>
      <td height="25"><input name="subnews" type="text" id="subnews" value="<?=$r[subnews]?>" size="6">
        个字节<font color="#666666">(0为不截取)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">标题截取字数</td>
      <td height="25"><input name="subtitle" type="text" id="subtitle" value="<?=$r[subtitle]?>" size="6">
        个字节<font color="#666666">(0为不截取)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">时间显示格式</td>
      <td height="25"><input name="showdate" type="text" id="showdate" value="<?=$r[showdate]?>" size="20"> 
        <select name="select4" onchange="document.form1.showdate.value=this.value">
          <option value="Y-m-d H:i:s">选择</option>
          <option value="Y-m-d H:i:s">2005-01-27 11:04:27</option>
          <option value="Y-m-d">2005-01-27</option>
          <option value="m-d">01-27</option>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>模板内容</strong>(*)</td>
      <td height="25">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml&notfullpage=1<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="temptext" cols="90" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置">
        <?php
		if($enews=='EditJstemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=jstemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">显示模板变量说明</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield42" type="text" value="[!--id--]">
              :信息ID</td>
            <td width="34%"> <input name="textfield52" type="text" value="[!--titleurl--]">
              :标题链接</td>
            <td width="33%"> <input name="textfield62" type="text" value="[!--oldtitle--]">
              :标题ALT(不截取字符)</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield72" type="text" value="[!--classid--]">
              :栏目ID</td>
            <td><input name="textfield82" type="text" value="[!--class.name--]">
              :栏目名称(带链接)</td>
            <td><input name="textfield92" type="text" value="[!--this.classname--]">
              :栏目名称(不带链接)</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield10" type="text" value="[!--this.classlink--]">
              :栏目地址</td>
            <td><input name="textfield11" type="text" value="[!--news.url--]">
              :网站地址</td>
            <td><input name="textfield12" type="text" value="[!--no.num--]">
              :信息编号</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield13" type="text" value="[!--userid--]">
              :发布者ID</td>
            <td><input name="textfield14" type="text" value="[!--username--]">
              :发布者</td>
            <td><input name="textfield15" type="text" value="[!--userfen--]">
              :查看信息扣除点数</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield16" type="text" value="[!--onclick--]">
              :点击数</td>
            <td><input name="textfield17" type="text" value="[!--totaldown--]">
              :下载数</td>
            <td><input name="textfield18" type="text" value="[!--plnum--]">
              :评论数</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield19" type="text" value="[!--ttid--]">
              :标题分类ID</td>
            <td><input name="textfield192" type="text" value="[!--tt.name--]">
              :标题分类名称</td>
            <td><input name="textfield1922" type="text" value="[!--tt.url--]">
:标题分类地址</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>[!--字段名--]:数据表字段内容调用，点 
              <input type="button" name="Submit3" value="这里" onclick="window.open('ShowVar.php?<?=$ecms_hashur['ehref']?>&modid='+document.form1.modid.value,'','width=300,height=520,scrollbars=yes');">
              可查看</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">模板格式：</td>
      <td height="25">列表头[!--empirenews.listtemp--]列表内容[!--empirenews.listtemp--]列表尾</td>
    </tr>
  </table>
</body>
</html>
