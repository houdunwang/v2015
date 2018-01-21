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
CheckLevel($logininid,$loginin,$classid,"f");
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(empty($tid)||empty($tbname))
{
	printerror("ErrorUrl","history.go(-1)");
}
$enews=RepPostStr($_GET['enews'],1);
$r[iscj]=1;
$r[tobr]=0;
$r[dohtml]=1;
$r[myorder]=0;
$disabled='';
$tbdatafhidden='';
$savetxthidden='';
$fmvnum=1;
$fmvline=3;
$fmvmust=1;
$url="数据表:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListF.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">字段管理</a>&nbsp;>&nbsp;增加字段";
$postword='增加';
//修改字段
if($enews=="EditF")
{
	$fid=(int)$_GET['fid'];
	$url="数据表:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListF.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">字段管理</a>&nbsp;>&nbsp;修改字段";
	$postword='修改';
	$r=$empire->fetch1("select * from {$dbtbpre}enewsf where fid='$fid' and tid='$tid'");
	if(!$r[fid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//元素长度
	if($r[fform]=='textarea'||$r[fform]=='editor')
	{
		$fsr=explode(',',$r['fformsize']);
		$fformwidth=$fsr[0];
		$fformheight=$fsr[1];
	}
	//多值元素
	if($r[fform]=='morevaluefield')
	{
		$fmvr=explode(',',$r['fmvnum']);
		$fmvnum=$fmvr[0];
		$fmvline=$fmvr[1];
		$fmvmust=$fmvr[2];
	}
	$oftype="type".$r[ftype];
	$$oftype=" selected";
	$ofform="form".$r[fform];
	$$ofform=" selected";
	$disabled=' disabled';
	$tbdatafhidden='<input type="hidden" name="tbdataf" value="'.$r[tbdataf].'">';
	$savetxthidden='<input type="hidden" name="savetxt" value="'.$r[savetxt].'">';
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$postword?>字段</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ShowFieldFormSet(obj,val){
	if(val=='text'||val=='password'||val=='flash'||val=='file'||val=='date'||val=='color')
	{
		fsizediv.style.display="";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='img')
	{
		fsizediv.style.display="";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='editor')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='textarea'||val=='ubbeditor')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='select'||val=='radio'||val=='checkbox')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="";
		fmorevaluediv.style.display="none";
	}
	else if(val=='linkfield')
	{
		fsizediv.style.display="";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='linkfieldselect')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='morevaluefield')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="";
	}
}
</script>
</head>

<body onload="ShowFieldFormSet(document.addfform,'<?=$r[fform]?$r[fform]:'text'?>')">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="addfform" method="post" action="../ecmsmod.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr> 
      <td height="25" colspan="2" class="header"> 
        <?=$postword?>
        数据表( 
        <?=$dbtbpre?>
        ecms_ 
        <?=$tbname?>
        )字段 
        <input name="fid" type="hidden" id="fid" value="<?=$fid?>"> <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="oldfform" type="hidden" id="oldfform" value="<?=$r[fform]?>"> 
        <input name="oldf" type="hidden" id="oldf" value="<?=$r[f]?>"> <input name="tbname" type="hidden" id="tbname" value="<?=$tbname?>"> 
        <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> <input name="oldfvalue" type="hidden" id="oldfvalue" value="<?=ehtmlspecialchars(stripSlashes($r[fvalue]))?>"> 
        <input name="oldsavetxt" type="hidden" id="oldsavetxt" value="<?=$r[savetxt]?>"> 
        <input name="oldlinkfieldval" type="hidden" id="oldlinkfieldval" value="<?=$r[linkfieldval]?>"> 
        <input name="oldfformsize" type="hidden" id="oldfformsize" value="<?=$r[fformsize]?>"> 
		<?=$ecms_hashur['form']?>
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">基本设置</td>
    </tr>
    <tr> 
      <td width="25%" height="25" bgcolor="#FFFFFF">字段名</td>
      <td width="75%" height="25" bgcolor="#FFFFFF"> <input name="f" type="text" id="f" value="<?=$r[f]?>">
        <font color="#666666">(由英文与数字组成，且不能以数字开头。比如：&quot;title&quot;)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">字段标识</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="fname" type="text" id="fname" value="<?=$r[fname]?>"> 
        <font color="#666666">(比如：&quot;标题&quot;)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">字段类型</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="ftype" id="select">
          <option value="VARCHAR"<?=$typeVARCHAR?>>字符型0-255字节(VARCHAR)</option>
		  <option value="CHAR"<?=$typeCHAR?>>定长字符型0-255字节(CHAR)</option>
          <option value="TEXT"<?=$typeTEXT?>>小型字符型(TEXT)</option>
          <option value="MEDIUMTEXT"<?=$typeMEDIUMTEXT?>>中型字符型(MEDIUMTEXT)</option>
          <option value="LONGTEXT"<?=$typeLONGTEXT?>>大型字符型(LONGTEXT)</option>
          <option value="TINYINT"<?=$typeTINYINT?>>小数值型(TINYINT)</option>
          <option value="SMALLINT"<?=$typeSMALLINT?>>中数值型(SMALLINT)</option>
          <option value="INT"<?=$typeINT?>>大数值型(INT)</option>
          <option value="BIGINT"<?=$typeBIGINT?>>超大数值型(BIGINT)</option>
          <option value="FLOAT"<?=$typeFLOAT?>>数值浮点型(FLOAT)</option>
          <option value="DOUBLE"<?=$typeDOUBLE?>>数值双精度型(DOUBLE)</option>
          <option value="DATE"<?=$typeDATE?>>日期型(DATE)</option>
          <option value="DATETIME"<?=$typeDATETIME?>>日期时间型(DATETIME)</option>
        </select>
        长度 
        <input name="flen" type="text" id="flen" value="<?=$r[flen]?>" size="6"> 
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">存放表</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="tbdataf" value="0"<?=$r[tbdataf]==0?' checked':''?><?=$disabled?>>
        主表 
        <input type="radio" name="tbdataf" value="1"<?=$r[tbdataf]==1?' checked':''?><?=$disabled?>>
        副表<?=$tbdatafhidden?><font color="#666666"> (设置后不能修改)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">特殊属性</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">加索引</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="iskey" value="1"<?=$r[iskey]==1?' checked':''?>>
        是 
        <input type="radio" name="iskey" value="0"<?=$r[iskey]==0?' checked':''?>>
        否 
        <input name="oldiskey" type="hidden" id="oldiskey" value="<?=$r[iskey]?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">值唯一</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="isonly" value="1"<?=$r[isonly]==1?' checked':''?>>
        是 
        <input type="radio" name="isonly" value="0"<?=$r[isonly]==0?' checked':''?>>
        否 
        <input name="oldisonly" type="hidden" id="oldisonly" value="<?=$r[isonly]?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">采集项</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="iscj" type="radio" value="1"<?=$r[iscj]==1?' checked':''?>>
        是 
        <input name="iscj" type="radio" value="0"<?=$r[iscj]==0?' checked':''?>>
        否 
        <input name="oldiscj" type="hidden" id="oldiscj" value="<?=$r[iscj]?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">分页字段</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="ispage" value="1"<?=$r[ispage]==1?' checked':''?>>
        是 
        <input type="radio" name="ispage" value="0"<?=$r[ispage]==0?' checked':''?>>
        否<font color="#666666">(表只可设置一个字段)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">简介字段</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="issmalltext" value="1"<?=$r[issmalltext]==1?' checked':''?>>
        是 
        <input type="radio" name="issmalltext" value="0"<?=$r[issmalltext]==0?' checked':''?>>
        否<font color="#666666">(模板里设置截取简介字数的字段)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">内容存文本</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="savetxt" value="1"<?=$r[savetxt]==1?' checked':''?><?=$disabled?>>
        是 
        <input type="radio" name="savetxt" value="0"<?=$r[savetxt]==0?' checked':''?><?=$disabled?>>
        否<?=$savetxthidden?><font color="#666666">(设置后不能修改,表只可设置一个字段)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">前台内容显示</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="tobr" type="checkbox" id="tobr" value="1"<?=$r[tobr]==1?' checked':''?>>
        将回车替换成换行符, 
        <input name="dohtml" type="checkbox" id="dohtml" value="1"<?=$r[dohtml]==1?' checked':''?>>
        支持html代码</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">后台增加信息处理函数</td>
      <td height="25" bgcolor="#FFFFFF"><input name="adddofun" type="text" id="adddofun" value="<?=$r[adddofun]?>">
        <font color="#666666">(一般不设置，格式“函数名##参数”参数可不设置)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">后台修改信息处理函数</td>
      <td height="25" bgcolor="#FFFFFF"><input name="editdofun" type="text" id="editdofun" value="<?=$r[editdofun]?>">
        <font color="#666666">(一般不设置，格式“函数名##参数”参数可不设置)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">前台增加信息处理函数</td>
      <td height="25" bgcolor="#FFFFFF"><input name="qadddofun" type="text" id="qadddofun" value="<?=$r[qadddofun]?>">
        <font color="#666666">(一般不设置，格式“函数名##参数”参数可不设置)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">前台修改信息处理函数</td>
      <td height="25" bgcolor="#FFFFFF"><input name="qeditdofun" type="text" id="qeditdofun" value="<?=$r[qeditdofun]?>">
        <font color="#666666">(一般不设置，格式“函数名##参数”参数可不设置)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">显示顺序</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>"> 
        <font color="#666666">(数字越小越前面)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">表单显示设置</td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">输入表单显示元素</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="fform" id="fform" onchange="ShowFieldFormSet(document.addfform,this.options[this.selectedIndex].value)">
          <option value="text"<?=$formtext?>>单行文本框(text)</option>
          <option value="password"<?=$formpassword?>>密码框(password)</option>
          <option value="select"<?=$formselect?>>下拉框(select)</option>
          <option value="radio"<?=$formradio?>>单选框(radio)</option>
          <option value="checkbox"<?=$formcheckbox?>>复选框(checkbox)</option>
          <option value="textarea"<?=$formtextarea?>>多行文本框(textarea)</option>
          <option value="editor"<?=$formeditor?>>编辑器(editor)</option>
          <option value="img"<?=$formimg?>>图片(img)</option>
          <option value="flash"<?=$formflash?>>FLASH文件(flash)</option>
          <option value="file"<?=$formfile?>>文件(file)</option>
          <option value="date"<?=$formdate?>>日期(date)</option>
          <option value="color"<?=$formcolor?>>颜色(color)</option>
		  <option value="morevaluefield"<?=$formmorevaluefield?>>多值字段(morevaluefield)</option>
          <option value="linkfield"<?=$formlinkfield?>>选择外表关联字段(linkfield)</option>
          <option value="linkfieldselect"<?=$formlinkfieldselect?>>下拉外表关联字段(linkfieldselect)</option>
        </select> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">选项</td>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr id="fsizediv"> 
            <td height="23"><strong>元素长度</strong><br> <input name="fformsize" type="text" id="fformsize" value="<?=$r[fformsize]?>"> 
              <font color="#666666">(空为按默认)</font></td>
          </tr>
          <tr id="fwidthdiv"> 
            <td height="23"><strong>元素大小</strong><br>
              宽度 
              <input name="fformwidth" type="text" id="fformwidth" value="<?=$fformwidth?>" size="6">
              ×高度 
              <input name="fformheight" type="text" id="fformheight" value="<?=$fformheight?>" size="6"> 
              <font color="#666666">(空为按默认)</font></td>
          </tr>
          <tr id="flinkfielddiv"> 
            <td height="23"><strong>选择模型字段设置</strong><br>
              数据表名 
              <input name="linkfieldtb" type="text" id="linkfieldtb" value="<?=$r[linkfieldtb]?>"> 
              <br>
              值字段名 
              <input name="linkfieldval" type="text" id="linkfieldval" value="<?=$r[linkfieldval]?>"> 
              <input name="samedata" type="checkbox" id="samedata" value="1"<?=$r[samedata]==1?' checked':''?>>
              数据同步<br>
              显示字段 
              <input name="linkfieldshow" type="text" id="linkfieldshow" value="<?=$r[linkfieldshow]?>"> 
            </td>
          </tr>
          <tr id="feditordiv"> 
            <td height="23"><strong>编辑器样式</strong><br> <input type="radio" name="editorys" value="0"<?=$r[editorys]==0?' checked':''?>>
              标准型 
              <input type="radio" name="editorys" value="1"<?=$r[editorys]==1?' checked':''?>>
              简洁型</td>
          </tr>
		  <tr id="fmorevaluediv"> 
            <td height="23"><strong>多值字段元素格式</strong><br>
              设置列数 
              <input name="fmvnum" type="text" id="fmvnum" value="<?=$fmvnum?>" size="6">
              ，默认行数 
              <input name="fmvline" type="text" id="fmvline" value="<?=$fmvline?>" size="6">
              ，第
              <input name="fmvmust" type="text" id="fmvmust" value="<?=$fmvmust?>" size="6">
              列必填</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><p>初始值<br>
          <font color="#666666"><span id="defvaldiv">(多个值用&quot;回车&quot;格开；<br>
          “下拉/单选/复选”格式用：值==名称；<br>
          当值等于名称时，名称可省略；<br>
          默认选项后面加：:default)</span></font></p></td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="fvalue" cols="65" rows="8" id="fvalue" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes(str_replace("|","\r\n",$r[fvalue])))?></textarea></td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#FFFFFF">输入表单替换html代码<br> <font color="#666666">(增加字段时请留空)</font></td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="fhtml" cols="65" rows="10" id="fhtml" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[fhtml]))?></textarea></td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#FFFFFF">投稿表单替换html代码<br> <font color="#666666">(增加字段时请留空)</font></td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="qfhtml" cols="65" rows="10" id="qfhtml" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[qfhtml]))?></textarea></td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#FFFFFF">注释</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="fzs" cols="65" rows="6" id="fzs" style="WIDTH: 100%"><?=stripSlashes($r[fzs])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="提交"> 
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td height="25"><font color="#666666">说明：主表字段越少效率越高，不在列表调用字段建议将字段存在副表。</font></td>
    </tr>
  </table>
</form>
</body>
</html>
