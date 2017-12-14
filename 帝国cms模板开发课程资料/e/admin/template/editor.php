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

$getvar=ehtmlspecialchars($_GET['getvar']);
$returnvar=ehtmlspecialchars($_GET['returnvar']);
$fun=ehtmlspecialchars($_GET['fun']);
$notfullpage=ehtmlspecialchars($_GET['notfullpage']);
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>在线编辑模板</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/fckeditor/fckeditor.js"></script>
<script>
function GetContents()
{
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance('pagetext') ;

	// Get the editor contents in XHTML.
	return oEditor.GetXHTML( true );		// "true" means you want it formatted.
}
function SaveTemp(){
var isok=confirm('确认要保存?');
if(isok)
{
<?=$returnvar?>=GetContents();
window.close();
}
return false;
}
</script>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <form name="edittemp" method="post" action="../enews.php" onsubmit="return SaveTemp()">
  <?=$ecms_hashur['eform']?>
    <tr class="header"> 
      <td width="82%">在线编辑模板<font color="#FF0000">(本地如果有装dreamweaver，推荐用dreamweaver编辑)</font></td>
      <td width="18%"> 
        <div align="right"> 
          <select name="notfullpage" onchange="self.location.href='editor.php?<?=$ecms_hashur['ehref']?>&getvar=<?=$getvar?>&returnvar=<?=$returnvar?>&fun=<?=$fun?>&notfullpage='+this.options[this.selectedIndex].value;">
            <option value='0'<?=$notfullpage==0?' selected':''?>>编辑整体页面(带body)</option>
            <option value='1'<?=$notfullpage==1?' selected':''?>>编辑局部内容(不带body)</option>
          </select>
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="button" name="Submit" value=" 保存内容 " onclick="return SaveTemp()">
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"><div align="center"> 
          <script type="text/javascript">
<!--
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// oFCKeditor.BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
var sBasePath = '../ecmseditor/fckeditor/' ;

var oFCKeditor = new FCKeditor( 'pagetext' ) ;
oFCKeditor.BasePath	= sBasePath ;
<?php
if(empty($notfullpage))
{
?>
oFCKeditor.Config['FullPage'] = true ;
<?php
}
?>
oFCKeditor.Height	= 480 ;
oFCKeditor.Value	= <?=$getvar?> ;
oFCKeditor.Create() ;
//-->
			</script>
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="button" name="Submit2" value=" 保存内容 " onclick="return SaveTemp()">
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"> &nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=500,scrollbars=yes,resizable=yes');">查看模板标签语法</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看JS调用地址</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看公共模板变量</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">查看标签模板</a>]</td>
    </tr>
  </form>
</table>
</body>
</html>
