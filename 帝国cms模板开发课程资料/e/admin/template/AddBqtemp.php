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
$mid=ehtmlspecialchars($_GET['mid']);
$cid=ehtmlspecialchars($_GET['cid']);
$enews=ehtmlspecialchars($_GET['enews']);
$r[subnews]=0;
$r[rownum]=1;
$r[showdate]="Y-m-d H:i:s";
$url=$urlgname."<a href=ListBqtemp.php?gid=$gid".$ecms_hashur['ehref'].">管理标签模板</a>&nbsp;>&nbsp;增加标签模板";
$autorownum=" checked";
//复制
if($enews=="AddBqtemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select * from ".GetDoTemptb("enewsbqtemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListBqtemp.php?gid=$gid".$ecms_hashur['ehref'].">管理标签模板</a>&nbsp;>&nbsp;复制标签模板：".$r[tempname];
}
//修改
if($enews=="EditBqtemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select * from ".GetDoTemptb("enewsbqtemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListBqtemp.php?gid=$gid".$ecms_hashur['ehref'].">管理标签模板</a>&nbsp;>&nbsp;修改标签模板：".$r[tempname];
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
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsbqtempclass order by classid");
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
<title>管理标签模板</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ReturnHtml(html)
{
document.form1.temptext.value=html;
}
</script>
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
    <td>位置：<?=$url?></td>
  </tr>
</table>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListBqtemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="3">增加标签模板 
        <input type=hidden name=enews value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"> <input name="mid" type="hidden" id="mid" value="<?=$mid?>"> 
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="22%" height="25">模板名(*)</td>
      <td height="25" colspan="2"><input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>" size="36"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">所属系统模型(*)</td>
      <td height="25" colspan="2"><select name="modid" id="modid">
          <?=$mod?>
        </select> <input type="button" name="Submit6" value="管理系统模型" onclick="window.open('../db/ListTable.php<?=$ecms_hashur['whehref']?>');"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">所属分类</td>
      <td height="25" colspan="2"><select name="classid" id="classid">
          <option value="0">不隶属于任何分类</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="管理分类" onclick="window.open('BqtempClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">简介截取字数</td>
      <td height="25" colspan="2"><input name="subnews" type="text" id="subnews" value="<?=$r[subnews]?>" size="6">
        个字节<font color="#666666">(0为不截取)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">每次显示</td>
      <td height="25" colspan="2"><input name="rownum" type="text" id="rownum" value="<?=$r[rownum]?>" size="6">
        条记录<font color="#666666">( 
        <input name="autorownum" type="checkbox" id="autorownum" value="1"<?=$autorownum?>>
        自动识别)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">时间显示格式</td>
      <td colspan="2"> <input name="showdate" type="text" id="showdate" value="<?=$r[showdate]?>" size="20"> 
        <select name="select4" onchange="document.form1.showdate.value=this.value">
          <option value="Y-m-d H:i:s">选择</option>
          <option value="Y-m-d H:i:s">2005-01-27 11:04:27</option>
          <option value="Y-m-d">2005-01-27</option>
          <option value="m-d">01-27</option>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>页面模板内容</strong>(*)</td>
      <td colspan="2">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?<?=$ecms_hashur['ehref']?>&getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml&notfullpage=1','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3" valign="top"><div align="center"> 
          <textarea name="temptext" cols="90" rows="18" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"><strong>列表内容模板(list.var) </strong>(*)</td>
      <td width="64%" height="25">请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.listvar.value);document.form1.listvar.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?<?=$ecms_hashur['ehref']?>&getvar=opener.document.form1.listvar.value&returnvar=opener.document.form1.listvar.value&fun=ReturnHtml&notfullpage=1','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</td>
      <td width="14%"><div align="right">
          <input name="docode" type="checkbox" id="docode" value="1"<?=$r[docode]==1?' checked':''?>><a title="list.var使用程序代码">使用程序代码</a></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3" valign="top"> <div align="center"> 
          <textarea name="listvar" cols="90" rows="12" id="listvar" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[listvar]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25" colspan="2"><input type="submit" name="Submit" value="保存模板"> 
        &nbsp; <input type="reset" name="Submit2" value="重置">
        <?php
		if($enews=='EditBqtemp')
		{
		?>
		&nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=bqtemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>]
		<?php
		}
		?>
		</td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">显示模板变量说明</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="3"><strong>(1)、页面模板内容支持的变量</strong><br> <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield" type="text" value="[!--the.classname--]">
              :栏目名称</td>
            <td width="34%"> <input name="textfield2" type="text" value="[!--the.classid--]">
              :栏目ID</td>
            <td width="33%"> <input name="textfield3" type="text" value="[!--the.classurl--]">
              :栏目链接</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25" colspan="3"><strong>内容变量： &lt;!--list.var编号--&gt; 
              (如：&lt;!--list.var1--&gt;,&lt;!--list.var2--&gt;)</strong></td>
          </tr>
        </table>
        <br> <strong>(2)、列表内容模板(list.var)支持的变量</strong><br> <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield4" type="text" value="[!--id--]">
              :信息ID</td>
            <td width="34%"> <input name="textfield5" type="text" value="[!--titleurl--]">
              :标题链接</td>
            <td width="33%"> <input name="textfield6" type="text" value="[!--oldtitle--]">
              :标题ALT(不截取字符)</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield7" type="text" value="[!--classid--]">
              :栏目ID</td>
            <td><input name="textfield8" type="text" value="[!--class.name--]">
              :栏目名称(带链接)</td>
            <td><input name="textfield9" type="text" value="[!--this.classname--]">
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
      <td height="80">增加说明</td>
      <td height="80" colspan="2"><strong>页面模板内容：</strong>列表头[!--empirenews.listtemp--]列表内容[!--empirenews.listtemp--]列表尾<br>
        页面模板格式举列：&lt;table&gt;[!--empirenews.listtemp--]&lt;tr&gt;&lt;td&gt;&lt;!--list.var1--&gt;&lt;/td&gt;&lt;td&gt;&lt;!--list.var2--&gt;&lt;/td&gt;&lt;/tr&gt;[!--empirenews.listtemp--]&lt;/table&gt;<font color="#FF0000">(每次显示2条记录)</font><br> 
        <strong>列表内容模板：</strong>即”页面模板内容”中”&lt;!--list.var*--&gt;”标签显示的内容．</td>
    </tr>
  </table>
</body>
</html>
