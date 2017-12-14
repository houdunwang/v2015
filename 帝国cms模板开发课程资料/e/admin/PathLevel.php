<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
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
db_close();
$empire=null;
//返回目录权限结果
function ReturnPathLevelResult($path){
	$testfile=$path."/test.test";
	$fp=@fopen($testfile,"wb");
	if($fp)
	{
		@fclose($fp);
		@unlink($testfile);
		return 1;
	}
	else
	{
		return 0;
	}
}
//返回文件权限结果
function ReturnFileLevelResult($filename){
	return is_writable($filename);
}
//检测目录权限
function CheckFileMod($filename,$smallfile=""){
	$succ="√";
	$error="<font color=red>×</font>";
	if(!file_exists($filename)||($smallfile&&!file_exists($smallfile)))
	{
		return $error;
	}
	if(is_dir($filename))//目录
	{
		if(!ReturnPathLevelResult($filename))
		{
			return $error;
		}
		//子目录
		if($smallfile)
		{
			if(is_dir($smallfile))
			{
				if(!ReturnPathLevelResult($smallfile))
				{
					return $error;
				}
			}
			else//文件
			{
				if(!ReturnFileLevelResult($smallfile))
				{
					return $error;
				}
			}
		}
	}
	else//文件
	{
		if(!ReturnFileLevelResult($filename))
		{
			return $error;
		}
		if($smallfile)
		{
			if(!ReturnFileLevelResult($smallfile))
			{
				return $error;
			}
		}
	}
	return $succ;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>帝国网站管理系统</title>

<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="">
    <tr class="header"> 
      <td height="25"> <div align="center">目录权限检测</div></td>
    </tr>
    <tr> 
      <td height="100" bgcolor="#FFFFFF"> <div align="center"> 
          <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
            <tr> 
              <td height="23"><strong>提示信息</strong></td>
            </tr>
            <tr> 
              <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                  <tr> 
                    <td height="25"> <li>将下面目录权限设为0777, 除了红色目录外，是目录全部要把权限应用于子目录与文件。<br>
                      </li></td>
                  </tr>
                </table></td>
            </tr>
          </table>
          <br>
          <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
            <tr> 
              <td width="34%" height="23"> <div align="center"><strong>目录文件名称</strong></div></td>
              <td width="42%"> <div align="center"><strong>说明</strong></div></td>
              <td width="24%"> <div align="center"><strong>权限检查</strong></div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left"><font color="#FF0000"><strong>/</strong></font></div></td>
              <td> <div align="center"><font color="#FF0000">系统根目录(不要应用于子目录)</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/d</div></td>
              <td> <div align="center"><font color="#666666">附件目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../d","../../d/txt");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/s</div></td>
              <td> <div align="center"><font color="#666666">专题存放目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../s");?>
                </div></td>
            </tr>
			<tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/t</div></td>
              <td> <div align="center"><font color="#666666">标题分类存放目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../t");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/search</div></td>
              <td> <div align="center"><font color="#666666">搜索表单</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../search","../../search/test.txt");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/index.html</div></td>
              <td> <div align="center"><font color="#666666">网站首页</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../index.html");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/html</div></td>
              <td> <div align="center"><font color="#666666">默认可选的HTML存放目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../html");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/admin/ebak/bdata</td>
              <td> <div align="center"><font color="#666666">备份数据存放目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("ebak/bdata");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/admin/ebak/zip</td>
              <td> <div align="center"><font color="#666666">备份数据压缩存放目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("ebak/zip");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/e/config/config.php</div></td>
              <td> <div align="center"><font color="#666666">数据库等参数配置文件</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../config/config.php");?>
                </div></td>
            </tr>
            
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/e/data</div></td>
              <td> <div align="center"><font color="#666666">部分配置文件存放目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../data","../data/tmp");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/install</td>
              <td> <div align="center"><font color="#666666">安装目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../install");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/member/iframe/index.php</td>
              <td><div align="center"><font color="#666666">登陆状态显示</font></div></td>
              <td><div align="center"> 
                  <?=CheckFileMod("../member/iframe/index.php");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/member/login/loginjs.php</td>
              <td><div align="center"><font color="#666666">JS登陆状态显示</font></div></td>
              <td><div align="center"> 
                  <?=CheckFileMod("../member/login/loginjs.php");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/pl/more/index.php</td>
              <td> <div align="center"><font color="#666666">评论JS调用文件</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../pl/more/index.php");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/sch/index.php</td>
              <td><div align="center"><font color="#666666">全站搜索文件</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../sch/index.php");?>
                </div></td>
            </tr>
			<tr bgcolor="#FFFFFF"> 
              <td height="25">/e/template</td>
              <td> <div align="center"><font color="#666666">动态页面的模板目录</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../template");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/tool/feedback/temp</td>
              <td><div align="center"><font color="#666666">信息反馈</font></div></td>
              <td><div align="center"> 
                  <?=CheckFileMod("../tool/feedback/temp","../tool/feedback/temp/test.txt");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/tool/gbook/index.php</td>
              <td><div align="center"><font color="#666666">留言板</font></div></td>
              <td><div align="center"> 
                  <?=CheckFileMod("../tool/gbook/index.php");?>
                </div></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr class="header"> 
      <td><div align="center"> 
          &nbsp;&nbsp; &nbsp;&nbsp; </div></td>
    </tr>
  </form>
</table>
</body>
</html>