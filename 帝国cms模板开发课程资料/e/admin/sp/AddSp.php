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
CheckLevel($logininid,$loginin,$classid,"sp");
$enews=ehtmlspecialchars($_GET['enews']);
$postword='增加碎片';
$noteditword='<font color="#666666">(设置后不可修改)</font>';
$disabled='';
$sptypehidden='';
$r[maxnum]=0;
$url="<a href=ListSp.php".$ecms_hashur['whehref'].">管理碎片</a> &gt; 增加碎片";
$fcid=(int)$_GET['fcid'];
$fclassid=(int)$_GET['fclassid'];
$fsptype=(int)$_GET['fsptype'];
$r['spfile']='html/sp/'.time().'.html';
$spid=(int)$_GET['spid'];
if($enews=='EditSp')
{
	$filepass=$spid;
}
else
{
	$filepass=ReturnTranFilepass();
}
//复制
if($enews=="AddSp"&&$_GET['docopy'])
{
	$r=$empire->fetch1("select * from {$dbtbpre}enewssp where spid='$spid'");
	$url="<a href=ListSp.php".$ecms_hashur['whehref'].">管理碎片</a> &gt; 复制碎片：<b>".$r[spname]."</b>";
	$username=substr($r[username],1,-1);
}
//修改
if($enews=="EditSp")
{
	$r=$empire->fetch1("select * from {$dbtbpre}enewssp where spid='$spid'");
	$postword='修改碎片';
	$noteditword='';
	$disabled=' disabled';
	$sptypehidden='<input type="hidden" name="sptype" value="'.$r[sptype].'">';
	$url="<a href=ListSp.php".$ecms_hashur['whehref'].">管理碎片</a> &gt; 修改碎片：<b>".$r[spname]."</b>";
	$username=substr($r[username],1,-1);
}
//标签模板
$bqtemp='';
$bqtempsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsbqtemp")." order by tempid");
while($bqtempr=$empire->fetch($bqtempsql))
{
	$select="";
	if($r[tempid]==$bqtempr[tempid])
	{
		$select=" selected";
	}
	$bqtemp.="<option value='".$bqtempr[tempid]."'".$select.">".$bqtempr[tempname]."</option>";
}
//栏目
$options=ShowClass_AddClass("",$r[classid],0,"|-",0,0);
//分类
$scstr='';
$scsql=$empire->query("select classid,classname from {$dbtbpre}enewsspclass order by classid");
while($scr=$empire->fetch($scsql))
{
	$select="";
	if($scr[classid]==$r[cid])
	{
		$select=" selected";
	}
	$scstr.="<option value='".$scr[classid]."'".$select.">".$scr[classname]."</option>";
}
//用户组
$group='';
$groupsql=$empire->query("select groupid,groupname from {$dbtbpre}enewsgroup order by groupid");
while($groupr=$empire->fetch($groupsql))
{
	$select='';
	if(strstr($r[groupid],','.$groupr[groupid].','))
	{
		$select=' selected';
	}
	$group.="<option value='".$groupr[groupid]."'".$select.">".$groupr[groupname]."</option>";
}
//部门
$userclass='';
$ucsql=$empire->query("select classid,classname from {$dbtbpre}enewsuserclass order by classid");
while($ucr=$empire->fetch($ucsql))
{
	$select='';
	if(strstr($r[userclass],','.$ucr[classid].','))
	{
		$select=' selected';
	}
	$userclass.="<option value='".$ucr[classid]."'".$select.">".$ucr[classname]."</option>";
}
//当前使用的模板组
$thegid=GetDoTempGid();
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>碎片</title>
<script>
function selectalls(doselect,formvar)
{  
	 var bool=doselect==1?true:false;
	 var selectform=document.getElementById(formvar);
	 for(var i=0;i<selectform.length;i++)
	 { 
		  selectform.all[i].selected=bool;
	 } 
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListSp.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="spid" type="hidden" id="spid" value="<?=$spid?>"> 
        <input name="fcid" type="hidden" id="fcid" value="<?=$fcid?>"> <input name="fclassid" type="hidden" id="fclassid" value="<?=$fclassid?>"> 
        <input name="fsptype" type="hidden" id="fsptype" value="<?=$fsptype?>">
		<input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">碎片类型：</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="sptype" id="sptype"<?=$disabled?>>
          <option value="1"<?=$r[sptype]==1?' selected':''?>>静态信息碎片</option>
          <option value="2"<?=$r[sptype]==2?' selected':''?>>动态信息碎片</option>
          <option value="3"<?=$r[sptype]==3?' selected':''?>>代码碎片</option>
        </select> 
        <?=$noteditword?>
        <?=$sptypehidden?>
      </td>
    </tr>
    <tr> 
      <td width="18%" height="25" bgcolor="#FFFFFF">碎片名称:</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"> <input name="spname" type="text" id="spname" value="<?=$r[spname]?>" size="42"> 
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">碎片变量名：</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="varname" type="text" id="varname" value="<?=$r[varname]?>" size="42"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">所属分类：</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="cid" id="cid">
          <option value="0">不隶属于任何类别</option>
          <?=$scstr?>
        </select> <input type="button" name="Submit6222322" value="管理分类" onclick="window.open('ListSpClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">隶属信息栏目：</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="classid" id="classid">
          <option value="0">隶属于所有栏目</option>
          <?=$options?>
        </select> <input type="button" name="Submit622232" value="管理栏目" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>');"> 
        <font color="#666666">(选择父栏目，将应用于子栏目)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">最大信息数量：</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="maxnum" type="text" id="spname3" value="<?=$r[maxnum]?>" size="42"> 
        <font color="#666666">(0为不限)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">使用标签模板：</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="tempid" id="tempid">
          <?=$bqtemp?>
        </select> <input type="button" name="Submit6222323" value="管理标签模板" onclick="window.open('../template/ListBqtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">是否生成碎片文件：</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="refile" value="0"<?=$r[refile]==0?' checked':''?>>
        不生成 
        <input type="radio" name="refile" value="1"<?=$r[refile]==1?' checked':''?>>
        生成</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">生成碎片文件名：</td>
      <td height="25" bgcolor="#FFFFFF">/ 
        <input name="spfile" type="text" id="spfile" value="<?=$r[spfile]?>" size="42">
        <input name="oldspfile" type="hidden" id="oldspfile" value="<?=$r[spfile]?>"> </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">生成碎片文件内容设置：</td>
      <td height="25" bgcolor="#FFFFFF">显示信息数量：
        <input name="spfileline" type="text" id="spfileline" value="<?=$r[spfileline]?>" size="6">
        ，标题截取字数：
        <input name="spfilesub" type="text" id="spfilesub" value="<?=$r[spfilesub]?>" size="6"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">碎片效果图：</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="sppic" type="text" id="sppic" value="<?=$r[sppic]?>" size="42"> 
        <a onclick="window.open('../ecmseditor/FileMain.php?<?=$ecms_hashur['ehref']?>&modtype=7&type=1&classid=&doing=2&field=sppic&filepass=<?=$filepass?>&sinfo=1','','width=700,height=550,scrollbars=yes');" title="选择已上传的图片"><img src="../../data/images/changeimg.gif" alt="选择/上传图片" width="22" height="22" border="0" align="absbottom"></a></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">碎片描述：</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="spsay" cols="60" rows="5" id="varname3"><?=ehtmlspecialchars($r[spsay])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">可越权限推送：</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="cladd" value="0"<?=$r[cladd]==0?' checked':''?>>
        是 
        <input type="radio" name="cladd" value="1"<?=$r[cladd]==1?' checked':''?>>
        否 <font color="#666666">(不在权限设置范围内的用户也能推送信息)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">是否开启：</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="isclose" value="0"<?=$r[isclose]==0?' checked':''?>>
        是 
        <input type="radio" name="isclose" value="1"<?=$r[isclose]==1?' checked':''?>>
        否</td>
    </tr>
    <tr> 
      <td height="25" colspan="2">权限设置</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">用户组：</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="groupid[]" size="5" multiple id="groupidselect" style="width:180">
          <?=$group?>
        </select>
        [<a href="#empirecms" onclick="selectalls(0,'groupidselect')">全部取消</a>]</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">部门：</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="userclass[]" size="5" multiple id="userclassselect" style="width:180">
          <?=$userclass?>
        </select>
        [<a href="#empirecms" onclick="selectalls(0,'userclassselect')">全部取消</a>]</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">用户：</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="username" type="text" id="username" value="<?=$username?>" size="42"> 
        <font color="#666666"> 
        <input type="button" name="Submit3" value="选择" onclick="window.open('../ChangeUser.php?field=username&form=form1<?=$ecms_hashur['ehref']?>','','width=300,height=520,scrollbars=yes');">
        (多个用户用“,”逗号隔开)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="提交"> 
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
