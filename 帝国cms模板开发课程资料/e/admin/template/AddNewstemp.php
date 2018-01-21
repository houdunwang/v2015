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
$r[showdate]="Y-m-d H:i:s";
$url=$urlgname."<a href=ListNewstemp.php?gid=$gid".$ecms_hashur['ehref'].">管理内容模板</a>&nbsp;>&nbsp;增加内容模板";
//复制
if($enews=="AddNewstemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempname,temptext,modid,showdate,classid from ".GetDoTemptb("enewsnewstemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListNewstemp.php?gid=$gid".$ecms_hashur['ehref'].">管理内容模板</a>&nbsp;>&nbsp;复制内容模板：".$r[tempname];
}
//修改
if($enews=="EditNewstemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempname,temptext,modid,showdate,classid from ".GetDoTemptb("enewsnewstemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListNewstemp.php?gid=$gid".$ecms_hashur['ehref'].">管理内容模板</a>&nbsp;>&nbsp;修改内容模板：".$r[tempname];
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
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsnewstempclass order by classid");
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
<title>管理内容模板</title>
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
  <form name="form1" method="post" action="ListNewstemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">增加模板 
        <input type=hidden name=enews value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"> <input name="mid" type="hidden" id="mid" value="<?=$mid?>"> 
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">模板名(*)</td>
      <td width="69%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>" size="30"> 
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
          <option value="0">不隶属于任何分类</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="管理分类" onclick="window.open('NewstempClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">时间显示格式：</td>
      <td> <input name="showdate" type="text" id="showdate" value="<?=$r[showdate]?>" size="20"> 
        <select name="select4" onchange="document.form1.showdate.value=this.value">
          <option value="Y-m-d H:i:s">选择</option>
          <option value="Y-m-d H:i:s">2005-01-27 11:04:27</option>
          <option value="Y-m-d">2005-01-27</option>
          <option value="m-d">01-27</option>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>模板内容</strong>(*)</td>
      <td> 请将模板内容<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" valign="top"> <div align="center">
          <textarea name="temptext" cols="90" rows="27" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="保存模板">&nbsp;
        <input type="reset" name="Submit2" value="重置">
        <?php
		if($enews=='EditNewstemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=newstemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"> &nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">显示模板变量说明</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=500,scrollbars=yes,resizable=yes');">查看模板标签语法</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看JS调用地址</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看公共模板变量</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看标签模板</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"><strong>模板变量说明：</strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="34%" height="25"> <input name="textfield18" type="text" value="[!--pagetitle--]">
              :页面标题</td>
            <td width="33%"><input name="textfield72" type="text" value="[!--pagekey--]">
              :页面关键字 </td>
            <td width="33%"><input name="textfield73" type="text" value="[!--pagedes--]">
              :页面描述 </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield19" type="text" value="[!--newsnav--]">
              :导航条</td>
            <td><input name="textfield92" type="text" value="[!--class.menu--]">
              :一级栏目导航</td>
            <td><input name="textfield20" type="text" value="[!--page.stats--]">
              :统计访问</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <input name="textfield21" type="text" value="[!--id--]">
              :信息ID</td>
            <td><input name="textfield22" type="text" value="[!--titleurl--]">
              :标题链接</td>
            <td><input name="textfield23" type="text" value="[!--keyboard--]">
              :关键字</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield24" type="text" value="[!--classid--]">
              :栏目ID</td>
            <td><input name="textfield25" type="text" value="[!--class.name--]">
              :栏目名称</td>
            <td><input name="textfield26" type="text" value="[!--self.classid--]">
              :本栏目ID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield30" type="text" value="[!--bclass.id--]">
              :父栏目ID<br></td>
            <td><input name="textfield31" type="text" value="[!--bclass.name--]">
              :父栏目名称</td>
            <td><input name="textfield32" type="text" value="[!--other.link--]">
              :相关链接</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield19222" type="text" value="[!--p.title--]">
              :分页标题</td>
            <td><input name="textfield34" type="text" value="[!--news.url--]">
              :网站地址</td>
            <td><input name="textfield35" type="text" value="[!--no.num--]">
              :信息编号</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield36" type="text" value="[!--userid--]">
              :发布者ID</td>
            <td><input name="textfield37" type="text" value="[!--username--]">
              :发布者</td>
            <td><input name="textfield38" type="text" value="[!--linkusername--]">
              :带链接的用户名</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield39" type="text" value="[!--userfen--]">
              :查看信息扣除点数</td>
            <td><input name="textfield40" type="text" value="[!--pinfopfen--]">
              :平均评分</td>
            <td><input name="textfield41" type="text" value="[!--infopfennum--]">
              :评分人数</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield42" type="text" value="[!--onclick--]">
              :点击数</td>
            <td><input name="textfield43" type="text" value="[!--totaldown--]">
              :下载数</td>
            <td><input name="textfield44" type="text" value="[!--plnum--]">
              :评论数</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield45" type="text" value="[!--page.url--]">
              :分页导航</td>
            <td><input name="textfield46" type="text" value="[!--title.select--]">
              :标题式分页导航</td>
            <td><input name="textfield47" type="text" value="[!--next.page--]">
              :内容下一页链接</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield48" type="text" value="[!--info.next--]">
              :下一篇</td>
            <td><input name="textfield49" type="text" value="[!--info.pre--]">
              :上一篇</td>
            <td><input name="textfield50" type="text" value="[!--info.vote--]">
              :信息投票</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield192" type="text" value="[!--ttid--]">
              :标题分类ID</td>
            <td><input name="textfield1922" type="text" value="[!--tt.name--]">
              :标题分类名称</td>
            <td><input name="textfield19223" type="text" value="[!--tt.url--]">
:标题分类地址</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield252" type="text" value="[!--class.url--]">
:栏目页面地址</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield51" type="text" value="[!--hotnews--]">
              :热门信息JS调用(默认表)<br> <input name="textfield52" type="text" value="[!--self.hotnews--]">
              :本栏目热门信息JS调用</td>
            <td><input name="textfield53" type="text" value="[!--newnews--]">
              :最新信息JS调用(默认表)<br> <input name="textfield54" type="text" value="[!--self.newnews--]">
              :本栏目最新信息JS调用 </td>
            <td><input name="textfield55" type="text" value="[!--goodnews--]">
              :推荐信息JS调用(默认表)<br> <input name="textfield56" type="text" value="[!--self.goodnews--]">
              :本栏目推荐信息JS调用</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield57" type="text" value="[!--hotplnews--]">
              :评论热门信息JS调用(默认表)<br> <input name="textfield58" type="text" value="[!--self.hotplnews--]">
              :本栏目评论热门信息JS调用</td>
            <td><input name="textfield59" type="text" value="[!--firstnews--]">
              :头条信息JS调用(默认表)<br> <input name="textfield60" type="text" value="[!--self.firstnews--]">
              :本栏目头条信息JS调用</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>[!--字段名--]:数据表字段内容调用，点 
              <input type="button" name="Submit3" value="这里" onclick="window.open('ShowVar.php?<?=$ecms_hashur['ehref']?>&modid='+document.form1.modid.value,'','width=300,height=520,scrollbars=yes');">
              可查看</strong></td>
            <td><strong>支持公共模板变量</strong></td>
            <td><strong>支持所有模板标签</strong></td>
          </tr>
        </table>
        <br> <strong>其它JS调用及地址说明 </strong> <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="17%" height="25">实时显示点击数(不统计)</td>
            <td width="83%"><input name="textfield61" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">实时显示点击数(显示+统计)</td>
            <td><input name="textfield62" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;addclick=1&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">实时显示下载数</td>
            <td><input name="textfield63" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=1&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">实时显示评论数</td>
            <td><input name="textfield64" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=2&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">实时显示平均评分数</td>
            <td><input name="textfield65" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=3&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">实时显示评分人数</td>
            <td><input name="textfield66" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=4&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">实时显示顶数</td>
            <td><input name="textfield67" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=5&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">实时显示踩数</td>
            <td><input name="textfield672" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=6&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25">实时显示专题评论数</td>
            <td><input name="textfield6723" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=专题ID&amp;down=7&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td rowspan="2">上面多变量同时显示<br>
              (变量1为显示,0为不显示) </td>
            <td height="25"><input name="textfield6722" type="text" value="&lt;script src=[!--news.url--]e/public/ViewClick/ViewMore.php?classid=[!--classid--]&amp;id=[!--id--]&amp;onclick=1&amp;down=1&amp;plnum=1&amp;pfen=0&amp;pfennum=0&amp;diggtop=0&amp;diggdown=0&amp;addclick=0&gt;&lt;/script&gt;" size="85"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">显示内容地方要加id=&quot;变量showdiv&quot;，比如点击数：&lt;span id=&quot;onclickshowdiv&quot;&gt;0&lt;/span&gt;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">购物车地址</td>
            <td><input name="textfield68" type="text" style="WIDTH: 100%" value="[!--news.url--]e/ShopSys/buycar/?classid=[!--classid--]&amp;id=[!--id--]"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25">评论JS调用</td>
            <td><input name="textfield682" type="text" style="WIDTH: 100%" value="&lt;script src=&quot;[!--news.url--]e/pl/more/?classid=[!--classid--]&amp;id=[!--id--]&amp;num=10&quot;&gt;&lt;/script&gt;"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</body>
</html>
