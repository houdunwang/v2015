<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>回复留言</title>
<link href="../../data/images/qcss.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="regbook" method="post" action="index.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class=header> 
      <td height="25" colspan="2">回复/修改留言
        <input name="enews" type="hidden" id="enews" value="ReMemberGbook">
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>">
        </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">留言发表者:</td>
      <td width="80%" height="25"> 
        <?=$r['uname']?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">留言内容:</td>
      <td height="25" style='word-break:break-all'> 
        <?=nl2br($r[gbtext])?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">发布时间:</td>
      <td height="25">
        <?=$r[addtime]?>&nbsp;
        (IP:
        <?=$r[ip]?>)
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>回复内容:</strong></td>
      <td height="25"><textarea name="retext" cols="60" rows="9" id="retext"><?=$r[retext]?></textarea> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交">
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center">[ <a href="javascript:window.close();">关 
          闭</a> ]</div></td>
    </tr>
  </table>
</form>
</body>
</html>