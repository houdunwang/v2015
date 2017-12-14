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

$sql=$empire->query("select bqname,bqsay,funname,bq,issys,bqgs from {$dbtbpre}enewsbq where isclose=0 order by myorder desc,bqid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>帝国网站管理系统标签说明</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script language="javascript">
window.resizeTo(760,600);
window.focus();
</script>
</head>
<body>
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr> 
      <td id='bqnav'></td>
    </tr>
  </table>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <tr> 
    <td colspan="2" class="header">信息标签调用操作类型</td>
  </tr>
  <tr> 
    <td width="50%" bgcolor="#FFFFFF"> <table width="100%" border="0">
        <tr> 
          <td width="12%" rowspan="6" bgcolor="dbeaf5"> <div align="center"><strong>按<br>
              栏<br>
              目<br>
              调<br>
              用</strong></div></td>
          <td width="16%" height="20"><div align="center"><strong>0</strong></div></td>
          <td width="72%">栏目最新信息 <font color="#666666">(栏目ID=栏目ID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>1</strong></div></td>
          <td>栏目点击排行 <font color="#666666">(栏目ID=栏目ID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>2</strong></div></td>
          <td>栏目推荐信息 <font color="#666666">(栏目ID=栏目ID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>9</strong></div></td>
          <td>栏目评论排行 <font color="#666666">(栏目ID=栏目ID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>12</strong></div></td>
          <td>栏目头条信息 <font color="#666666">(栏目ID=栏目ID)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>15</strong></div></td>
          <td>栏目下载排行 <font color="#666666">(栏目ID=栏目ID)</font></td>
        </tr>
      </table></td>
    <td bgcolor="#FFFFFF"> <table width="100%" border="0">
        <tr> 
          <td width="11%" rowspan="6" bgcolor="dbeaf5"> <div align="center"><strong>按<br>
              默<br>
              认<br>
              表<br>
              调<br>
              用</strong></div></td>
          <td width="16%" height="20"><div align="center"><strong>3</strong></div></td>
          <td width="73%">默认表最新信息 <font color="#666666">(栏目ID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>4</strong></div></td>
          <td>默认表点击排行 <font color="#666666">(栏目ID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>5</strong></div></td>
          <td>默认表推荐信息 <font color="#666666">(栏目ID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>10</strong></div></td>
          <td>默认表评论排行 <font color="#666666">(栏目ID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>13</strong></div></td>
          <td>默认表头条信息 <font color="#666666">(栏目ID=0)</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>16</strong></div></td>
          <td>默认表下载排行 <font color="#666666">(栏目ID=0)</font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="100%" border="0">
      <tr>
        <td width="12%" rowspan="6" bgcolor="dbeaf5"><div align="center"><strong>按<br>
          标<br>
          题<br>
          分<br>
          类<br>
          调<br>
          用</strong></div></td>
        <td width="16%" height="20"><div align="center"><strong>25</strong></div></td>
        <td width="72%">标题分类最新信息 <font color="#666666">(栏目ID=标题分类ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>26</strong></div></td>
        <td>标题分类点击排行 <font color="#666666">(栏目ID=标题分类ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>27</strong></div></td>
        <td>标题分类推荐信息 <font color="#666666">(栏目ID=标题分类ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>28</strong></div></td>
        <td>标题分类评论排行 <font color="#666666">(栏目ID=标题分类ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>29</strong></div></td>
        <td>标题分类头条信息 <font color="#666666">(栏目ID=标题分类ID)</font></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><strong>30</strong></div></td>
        <td>标题分类下载排行 <font color="#666666">(栏目ID=标题分类ID)</font></td>
      </tr>
    </table></td>
    <td bgcolor="#FFFFFF"> <table width="100%" border="0">
        <tr> 
          <td width="11%" rowspan="6" bgcolor="dbeaf5"> <div align="center"><strong>按<br>
              数<br>
              据<br>
              表<br>
              调<br>
              用</strong></div></td>
          <td width="16%" height="20"><div align="center"><strong>18</strong></div></td>
          <td width="73%">各表最新信息 <font color="#666666">(栏目ID='表名')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>19</strong></div></td>
          <td>各表点击排行<font color="#666666"> (栏目ID='表名')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>20</strong></div></td>
          <td>各表推荐信息 <font color="#666666">(栏目ID='表名')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>21</strong></div></td>
          <td>各表评论排行 <font color="#666666">(栏目ID='表名')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>22</strong></div></td>
          <td>各表头条信息 <font color="#666666">(栏目ID='表名')</font></td>
        </tr>
        <tr> 
          <td height="20"><div align="center"><strong>23</strong></div></td>
          <td>各表下载排行 <font color="#666666">(栏目ID='表名')</font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="100%" border="0">
      <tr>
        <td width="12%" rowspan="6" bgcolor="dbeaf5"><div align="center"><strong>按<br>
          S<br>
          Q<br>
          L<br>
          调<br>
          用</strong></div></td>
        <td width="15%" height="20" rowspan="2"><div align="center"><strong>24</strong></div></td>
        <td width="73%" height="20">按sql查询 <font color="#666666">(栏目ID='sql语句')</font></td>
      </tr>
      <tr>
        <td height="20"><font color="#666666">数据表前缀可用：“[!db.pre!]&quot;表示</font></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<br>
<?
$bqnav="";
while($r=$empire->fetch($sql))
{
	$bqnav.="<option value='".$r['bq']."'>".$r['bqname']."(".$r['bq'].")</option>";
	$r['bqsay']=str_replace('[!--ehash--]',$ecms_hashur['ehref'],$r['bqsay']);
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="<?=$r[bq]?>">
  <tr>
    <td class="header"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header">
          <td width="14%">标签名称：</td>
          <td width="86%"><b><?=$r[bqname]?>&nbsp;(<?=$r[bq]?>)</b></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td>
<input type=text name="text" size=80 value="<?=stripSlashes($r[bqgs])?>" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td>参数说明：</td>
        </tr>
        <tr> 
          <td><?=stripSlashes($r[bqsay])?></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<?
}
$bqnav="<select name='bq' id='bq' onchange=window.location='#'+this.options[this.selectedIndex].value><option value='' selected style='background:#99C4E3'>标签导航</option>".$bqnav."<option value='eloop'>灵动标签 (e:loop)</option><option value='eindexloop'>索引灵动标签 (e:indexloop)</option><option value='ShowMemberInfo'>会员信息调用函数</option><option value='ListMemberInfo'>会员列表调用函数</option><option value='spaceeloop'>会员空间信息调用函数</option><option value='wapeloop'>WAP信息调用函数</option><option value='echeckloginauth'>验证会员登录与返回登录信息函数</option><option value='echeckmembergroup'>验证会员访问权限函数</option><option value='resizeimg'>生成缩图函数</option><option value='egetzy'>转义字符函数</option><option value='enewshowmorepic'>显示图集函数(全面型)</option><option value='emoreplayer'>显示视频播放器JS函数</option></select>";
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="eloop">
  <tr>
    <td class="header"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header">
          <td width="14%">标签名称：</td>
          <td width="86%"><b>灵动标签&nbsp;(e:loop)</b></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td width="86%"><textarea name="text" cols="80" rows="4" style="width:100%">[e:loop={栏目ID,显示条数,操作类型,只显示有标题图片,附加SQL条件,显示排序}]
模板代码内容
[/e:loop]</textarea></td>
        </tr>
        <tr>
          <td>例子:</td>
          <td><textarea name="textarea" cols="80" rows="9" style="width:100%">&lt;table width="100%" border="0" cellspacing="1" cellpadding="3"&gt;
[e:loop={栏目ID,显示条数,操作类型,只显示有标题图片,附加SQL条件,显示排序}]
&lt;tr&gt;&lt;td&gt;
&lt;a href="&lt;?=$bqsr[titleurl]?&gt;" target="_blank"&gt;&lt;?=$bqr[title]?&gt;&lt;/a&gt;
(&lt;?=date('Y-m-d',$bqr[newstime])?&gt;)
&lt;/td&gt;&lt;/tr&gt;
[/e:loop]
&lt;/table&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td height="23"><strong>标签说明</strong></td>
        </tr>
        <tr> 
          <td height="23">灵动标签是无需做标签模板，且模板内容为PHP代码，因而更灵活，可以使用php所有处理函数。<font color="#666666">使用本标签，需开启模板支持程序代码(参数设置)。</font></td>
        </tr>
        <tr> 
          <td height="23"><strong>参数</strong></td>
        </tr>
        <tr> 
          <td><table cellspacing="1" cellpadding="3" width="100%" bgcolor="#dbeaf5" border="0">
              <tbody>
                <tr> 
                  <td width="23%"> 
                    <div align="center">参数</div></td>
                  <td>参数说明</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">栏目ID</div></td>
                  <td height="25">查看栏目ID点<a onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>');"><strong><u>这里</u></strong></a>，查看标题分类ID点<a onclick="window.open('../info/InfoType.php<?=$ecms_hashur['whehref']?>');"><strong><u>这里</u></strong></a>,当前ID='selfinfo'<br />
                    多个栏目ID与标题分类ID可用“,”逗号隔开，如：'1,2'</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">显示条数</div></td>
                  <td height="25">显示前几条记录</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">操作类型</div></td>
                  <td height="25">具体看操作类型说明</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">只显示有标题图片</div></td>
                  <td height="25">0为不限制，1为只显示有标题图片的信息</td>
                </tr>
				<tr bgcolor="#ffffff">
            		<td height="25">
            			<div align="center">附加SQL条件</div>
            		</td>
            		<td height="25">附加调用条件，如：&quot;title='帝国'&quot;</td>
        		</tr>
        		<tr bgcolor="#ffffff">
            		<td height="25">
            			<div align="center">显示排序</div>
            		</td>
            		<td height="25">可指定按相应的字段排序，如：&quot;id desc&quot;</td>
        		</tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td><strong>变量说明</strong></td>
        </tr>
        <tr>
          <td height="139">
<table cellspacing="1" cellpadding="3" width="100%" bgcolor="#dbeaf5" border="0">
              <tbody>
                <tr> 
                  <td height="25"><div align="center">数组或变量</div></td>
                  <td height="25">说明</td>
                </tr>
                <tr> 
                  <td width="23%" height="25" bgcolor="#ffffff"> <div align="center">$bqr</div></td>
                  <td height="25" bgcolor="#ffffff">$bqr[字段名]：显示字段的内容</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"> <div align="center">$bqsr</div></td>
                  <td height="25" bgcolor="#ffffff">$bqsr[titleurl]：标题链接<br>
                    $bqsr[classname]：栏目名称<br>
                    $bqsr[classurl]：栏目链接</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"><div align="center">$bqno</div></td>
                  <td height="25" bgcolor="#ffffff">$bqno：为调用序号</td>
                </tr>
                <tr>
                  <td height="25" bgcolor="#ffffff"><div align="center">$public_r</div></td>
                  <td height="25" bgcolor="#ffffff">$public_r[newsurl]：网站地址</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr> 
          <td><strong>常用函数介绍</strong></td>
        </tr>
        <tr> 
          <td>文字截取：<strong>esub(字符串,截取长度)</strong>，例子：esub($bqr[title],30)截取标题前30个字符<br>
            时间格式：<strong>date('格式字串',时间字段)</strong>，例子：date('Y-m-d',$bqr[newstime])时间显示格式为&quot;2008-10-01&quot;</td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="eindexloop">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">标签名称：</td>
          <td width="86%"><b>索引灵动标签&nbsp;(e:indexloop)</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td width="86%"><textarea name="textarea4" cols="80" rows="4" style="width:100%">[e:indexloop={索引分类ID,显示条数,操作类型,栏目ID,系统模型ID,附加SQL条件}]
模板代码内容
[/e:indexloop]</textarea></td>
        </tr>
        <tr> 
          <td>例子:</td>
          <td><textarea name="textarea4" cols="80" rows="9" style="width:100%">&lt;table width="100%" border="0" cellspacing="1" cellpadding="3"&gt;
[e:indexloop={索引分类ID,显示条数,操作类型,栏目ID,系统模型ID,附加SQL条件}]
&lt;tr&gt;&lt;td&gt;
&lt;a href="&lt;?=$bqsr[titleurl]?&gt;" target="_blank"&gt;&lt;?=$bqr[title]?&gt;&lt;/a&gt;
(&lt;?=date('Y-m-d',$bqr[newstime])?&gt;)
&lt;/td&gt;&lt;/tr&gt;
[/e:indexloop]
&lt;/table&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td height="23"><strong>标签说明</strong></td>
        </tr>
        <tr> 
          <td height="23">索引灵动标签使用方法基本同灵动标签，只是索引灵动标签是以信息ID和栏目ID来获取信息内容。<font color="#666666">使用本标签，需开启模板支持程序代码(参数设置)。</font></td>
        </tr>
        <tr> 
          <td height="23"><strong>参数</strong></td>
        </tr>
        <tr> 
          <td><table cellspacing="1" cellpadding="3" width="100%" bgcolor="#dbeaf5" border="0">
              <tbody>
                <tr> 
                  <td width="23%"> <div align="center">参数</div></td>
                  <td>参数说明</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">索引分类ID</div></td>
                  <td height="25">查看专题ID点<a onclick="window.open('../special/ListZt.php<?=$ecms_hashur['whehref']?>');"><strong><u>这里</u></strong></a>,查看TAGS的ID点<a onclick="window.open('../tags/ListTags.php<?=$ecms_hashur['whehref']?>');"><strong><u>这里</u></strong></a>，查看碎片ID点<a onclick="window.open('../sp/ListSp.php<?=$ecms_hashur['whehref']?>');"><strong><u>这里</u></strong></a>，当前专题ID='selfinfo'<br />
                    多个ID可用“,”逗号隔开，如：'1,2'</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">显示条数</div></td>
                  <td height="25">显示前几条记录</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">操作类型</div></td>
                  <td height="25"> 1、专题最新 <font color="#666666">(索引分类ID=专题ID)</font><br>
                    2、专题最早 <font color="#666666">(索引分类ID=专题ID)</font><br>
                    3、专题推荐 <font color="#666666">(索引分类ID=专题ID)</font><br>
                    4、专题子类最新 <font color="#666666">(索引分类ID=专题子类ID)</font><br>
                    5、专题子类最早 <font color="#666666">(索引分类ID=专题子类ID)</font><br>
                    6、专题子类推荐 <font color="#666666">(索引分类ID=专题子类ID)</font><br>
                    7、碎片最新 <font color="#666666">(索引分类ID=碎片ID)</font><br>
8、碎片最早 <font color="#666666">(索引分类ID=碎片ID)</font><br>
                    9、TAGS最新 <font color="#666666">(索引分类ID=TAGS的ID)</font><br>
                    10、TAGS最早 <font color="#666666">(索引分类ID=TAGS的ID)</font><br>
                    11、SQL调用 <font color="#666666">(索引分类ID='sql语句') [数据表前缀可用：“[!db.pre!]&quot;表示]</font></td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">栏目ID</div></td>
                  <td height="25">限制只调用某一个或多个栏目的信息<br>
                    多个ID可以用“,”号隔开，如：'1,2'</td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"><div align="center">系统模型ID</div></td>
                  <td height="25">限制只调用某一个或多个系统模型的信息<br>
                    多个ID可以用“,”号隔开，如：'1,2'<br>
                    <font color="#FF0000">此参数对碎片调用无效，碎片调用时请把本参数设置为空：''</font></td>
                </tr>
                <tr bgcolor="#ffffff"> 
                  <td height="25"> <div align="center">附加SQL条件</div></td>
                  <td height="25">附加调用条件，如：&quot;isgood=1&quot;</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr> 
          <td><strong>变量说明</strong></td>
        </tr>
        <tr> 
          <td height="139"> <table cellspacing="1" cellpadding="3" width="100%" bgcolor="#dbeaf5" border="0">
              <tbody>
                <tr> 
                  <td height="25"><div align="center">数组或变量</div></td>
                  <td height="25">说明</td>
                </tr>
                <tr>
                  <td height="25" bgcolor="#ffffff"><div align="center">$indexbqr</div></td>
                  <td height="25" bgcolor="#ffffff">$indexbqr[字段名]：显示索引表的字段内容，如专题子类ID：$indexbqr[cid]</td>
                </tr>
                <tr> 
                  <td width="23%" height="25" bgcolor="#ffffff"> <div align="center">$bqr</div></td>
                  <td height="25" bgcolor="#ffffff">$bqr[字段名]：显示信息表字段的内容，如标题：$bqr[title]</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"> <div align="center">$bqsr</div></td>
                  <td height="25" bgcolor="#ffffff">$bqsr[titleurl]：标题链接<br>
                    $bqsr[classname]：栏目名称<br>
                    $bqsr[classurl]：栏目链接</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"><div align="center">$bqno</div></td>
                  <td height="25" bgcolor="#ffffff">$bqno：为调用序号</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#ffffff"><div align="center">$public_r</div></td>
                  <td height="25" bgcolor="#ffffff">$public_r[newsurl]：网站地址</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr> 
          <td><strong>常用函数介绍</strong></td>
        </tr>
        <tr> 
          <td>文字截取：<strong>esub(字符串,截取长度)</strong>，例子：esub($bqr[title],30)截取标题前30个字符<br>
            时间格式：<strong>date('格式字串',时间字段)</strong>，例子：date('Y-m-d',$bqr[newstime])时间显示格式为&quot;2012-10-01&quot;</td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ShowMemberInfo">
  <tr>
    <td class="header"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header">
          <td width="14%">标签名称：</td>
          <td width="86%"><b>会员信息调用函数</b></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td>
<input type=text name="text" size=80 value="sys_ShowMemberInfo(用户ID,查询字段)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td>用户ID：设置要调用的会员信息的用户ID，在信息内容页下调用可以设置为0，表示调用信息发布者的资料。<br>
            查询字段：默认为查询所有会员字段，此参数一般不用设置，如果为了效率更高可以指定相应的字段。如：“u.userid,ui.company”(u为主表，ui为副表)。<br>
            <strong>使用教程：</strong><a href="http://bbs.phome.net/showthread-13-108558-0.html" target="_blank">http://bbs.phome.net/showthread-13-108558-0.html</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ListMemberInfo">
  <tr>
    <td class="header"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header">
          <td width="14%">标签名称：</td>
          <td width="86%"><b>会员列表调用函数</b></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td>
<input type=text name="text" size=80 value="sys_ListMemberInfo(调用条数,操作类型,会员组ID,用户ID,查询字段)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td>调用条数：调用前几条记录。<br>
            操作类型：0为按注册时间、1为按积分排行、2为按资金排行、3为按会员空间人气排行<br>
            会员组ID：指定要调用的会员组ID，不设置为不限，多个会员组用逗号隔开，如：'1,2'<br>
            用户ID：指定要调用的会员ID，不设置为不限，多个用户ID用逗号隔开，如：'25,27'<br>
            查询字段：默认为查询所有会员字段，此参数一般不用设置，如果为了效率更高可以指定相应的字段。如：“u.userid,ui.company”(u为主表，ui为副表)。<br>
            <strong>使用教程：</strong><a href="http://bbs.phome.net/showthread-13-108558-0.html" target="_blank">http://bbs.phome.net/showthread-13-108558-0.html</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="spaceeloop">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">标签名称：</td>
          <td width="86%"><b>会员空间信息调用函数</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <textarea name="textarea2" cols="80" rows="11" style="width:100%">&lt;?php
$spacesql=espace_eloop(栏目ID,显示条数,操作类型,只显示有标题图片,附加SQL条件,显示排序);
while($spacer=$empire->fetch($spacesql))
{
        $spacesr=espace_eloop_sp($spacer);
?&gt;
模板代码内容
&lt;?
}
?&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td> <strong>使用教程：</strong><a href="http://bbs.phome.net/showthread-13-109152-0.html" target="_blank">http://bbs.phome.net/showthread-13-109152-0.html</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="wapeloop">
  <tr>
    <td class="header"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr class="header">
        <td width="14%">标签名称：</td>
        <td width="86%"><b>WAP信息调用函数</b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="6%">格式:</td>
        <td><textarea name="textarea7" cols="80" rows="11" style="width:100%">&lt;?php
$wapsql=ewap_eloop(栏目ID,显示条数,操作类型,只显示有标题图片,附加SQL条件,显示排序);
while($wapr=$empire->fetch($wapsql))
{
        $wapsr=ewap_eloop_sp($wapr);
?&gt;
模板代码内容
&lt;?
}
?&gt;</textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td>本函数参数和灵动标签完全一样，设置的内容也是一样，支持灵动标签的所有操作类型：<br>
          “$wapr[字段名]”等同于灵动标签“$bqr[字段名]”变量。<br>
          “$wapsr”等同于灵动标签“$bqsr”变量。（$wapsr[titleurl]：标题链接、$wapsr[classname]：栏目名称、$wapsr[classurl]：栏目链接）</td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="echeckloginauth">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">标签名称：</td>
          <td width="86%"><b>Cookie验证会员登录与返回登录信息函数</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <input type=text name="text22" size=80 value="qCheckLoginAuthstr()" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <textarea name="textarea3" cols="80" rows="9" style="width:100%">&lt;?php
$user=qCheckLoginAuthstr();
if(!$user['islogin'])
{
echo"您还未登录";
exit();
}
?&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr> 
                <td>本函数返回带用户信息的数组：<br>
                数组项：islogin(0为未登录,1为已登录)、userid(用户ID)、username(用户名)、groupid(会员组ID)</td>
              </tr>
            </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="echeckmembergroup">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">标签名称：</td>
          <td width="86%"><b>验证会员访问权限函数</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <input type=text name="text22" size=80 value="sys_CheckMemberGroup(限制访问的会员组ID)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <textarea name="textarea3" cols="80" rows="9" style="width:100%">&lt;?php
$levelst=sys_CheckMemberGroup('1,4');
if($levelst<=0)
{
echo"您没有权限";
exit();
}
?&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr> 
                <td>本函数验证当前登录会员是否有访问权限函数：sys_CheckMemberGroup(限制访问的会员组ID)，限制多个会员组ID可用逗号隔开。<br>
                返回0则未登录，返回-1则为没权限，大于0为有权限。</td>
              </tr>
            </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="resizeimg">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">标签名称：</td>
          <td width="86%"><b>生成缩图函数</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <input type=text name="text2" size=80 value="sys_ResizeImg(原图片,缩图宽度,缩图高度,是否裁翦图片,目标文件名,目标目录名)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <textarea name="textarea2" cols="80" rows="5" style="width:100%">&lt;?php
$resizeimgurl=sys_ResizeImg($bqr[titlepic],170,120,1,'','');
echo"&lt;img src='$resizeimgurl'&gt;";
?&gt;</textarea></td>
        </tr>
      </table> 
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr> 
          <td>原图片：要生成缩图的源文件。<br>
            缩图宽度、缩图高度：生成缩图的规格。<br>
            是否裁翦图片：按比例缩图后超出部分是事采用裁翦方式。<br>
            目标文件名：此项可省略，如果设置目标文件名将覆盖此文件名，防止重复生成临时图片文件。<br>
            目标目录名：此项可省略，默认为：e/data/tmp/titlepic/</td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="egetzy">
  <tr> 
    <td class="header"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr class="header"> 
          <td width="14%">标签名称：</td>
          <td width="86%"><b>转义字符函数</b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <input type=text name="text22" size=80 value="egetzy(转义字符)" style="width:100%"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td width="6%">格式:</td>
          <td> <textarea name="textarea3" cols="80" rows="5" style="width:100%">&lt;?php
$zystr=egetzy('rn');
echo"$zystr";
?&gt;</textarea></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr> 
                <td>本函数方便用户在调用模板使用反斜扛转义：<br>
                  (1)、函数语法：egetzy(转义字符)<br>
            (2)、转义字符rn转为\r\n、n转为\n、r转为\r、t转为\t、syh转为\&quot;、dyh转为\'<br>
                  (3)、转义字符为数字，则转为对应数量的\，比如：2转为\\<br>
                  (4)、分割换行符例子：$er=explode(egetzy('rn'),$navinfor[downpath]); </td>
              </tr>
            </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="enewshowmorepic">
  <tr>
    <td class="header"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr class="header">
        <td width="14%">标签名称：</td>
        <td width="86%"><b><strong>显示图集函数(全面型)</strong></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="6%">格式:</td>
        <td><input type=text name="text222" size=80 value="sys_ModShowMorepic(导航小图宽度,导航小图高度,小图导航模板内容)" style="width:100%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="6%">例子:</td>
        <td><textarea name="textarea5" cols="80" rows="5" style="width:100%">&lt;?=sys_ModShowMorepic(120,80,'')?&gt;</textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td><strong>使用教程：</strong><a href="../../data/modadd/morepic/ReadMe.html" target="_blank">[点击这里查看]</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="emoreplayer">
  <tr>
    <td class="header"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr class="header">
        <td width="14%">标签名称：</td>
        <td width="86%"><b><strong>显示视频播放器JS函数</strong></b></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="6%">格式:</td>
        <td><textarea name="textarea6" cols="80" rows="5" style="width:100%">&lt;script src=&quot;/e/data/modadd/moreplayer/empirecmsplayer.js&quot;&gt;&lt;/script&gt;
&lt;script&gt;
EmpireCMSPlayVideo('播放器类型','视频地址','显示宽度','显示高度',是否自动播放,'帝国CMS网站目录地址');
&lt;/script&gt;</textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td><strong>使用教程：</strong><a href="../../data/modadd/moreplayer/ReadMe.html" target="_blank">[点击这里查看]</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<script>
document.getElementById("bqnav").innerHTML="<?=$bqnav?>";
</script>
</body>
</html>
<?
db_close();
$empire=null;
?>
