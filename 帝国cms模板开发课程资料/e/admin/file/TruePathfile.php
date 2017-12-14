<?php
if(!defined('InEmpireCMS'))
{
	exit();
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include('TruePathfileFun.php');
}
if($enews=='TranTruePathFile')//上传固定目录文件
{
	$file=$_FILES['file']['tmp_name'];
    $file_name=$_FILES['file']['name'];
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
	TranTruePathFile($filepathr['filelevel'],$filepathr['filepath'],$file,$file_name,$file_type,$file_size,$_POST,$logininid,$loginin);
}
elseif($enews=='DelTruePathFile')//删除固定目录文件
{
	DelTruePathFile($filepathr['filelevel'],$filepathr['filepath'],$_POST['filename'],$logininid,$loginin);
}

//基目录
$actionurl=$filepath_r['actionurl'];
$filepath=$filepathr['filepath'];
$openpath=ECMS_PATH.$filepathr['filepath'];
if(!file_exists($openpath))
{
	exit();
}
$hand=@opendir($openpath);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理附件</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="34%"><?=$filepathr['url']?></td>
    <td width="66%"><div align="right" class="emenubutton"></div></td>
  </tr>
</table>
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <form action="<?=$actionurl?>" method="post" enctype="multipart/form-data" name="form2">
  <?=$ecms_hashur['form']?>
    <tr>
      <td>上传附件：
      <input type="file" name="file">
      <input type="submit" name="Submit2" value="上传">
      <input name="enews" type="hidden" id="enews" value="TranTruePathFile">
	  <?=$filepathr['addpostvar']?>
	  </td>
    </tr>
  </form>
  </table>
  <br>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td height="32">当前目录：<strong>/<?=$filepath?></strong></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="<?=$actionurl?>" onsubmit="return confirm('确认删除?');">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"> <div align="center">选择</div></td>
      <td height="25"><div align="center">文件名</div></td>
      <td><div align="center">大小</div></td>
      <td><div align="center">类型</div></td>
      <td><div align="center">修改时间</div></td>
    </tr>
    <?php
	$efileurl=$public_r['newsurl'].$filepath.'/';
	while($file=@readdir($hand))
	{
		if($file=="."||$file=="..")
		{
			continue;
		}
		$truefile=$file;
		$pathfile=$openpath."/".$file;
		if(is_dir($pathfile))//目录
		{
			$filelink="'#empirecms'";
			$filename=$file;
			$img="../../data/images/dir/folder.gif";
			$checkbox="";
			$target="";
			//发布时间
			$ftime=@filemtime($pathfile);
			$filetime=date("Y-m-d H:i:s",$ftime);
			$filesize='<目录>';
			$filetype='文件夹';
		}
		else//文件
		{
			$filelink=$efileurl.$truefile;
			$filename=$file;
			$ftype=GetFiletype($file);
			$checkbox="<input name='filename[]' type='checkbox' value='".$truefile."'>";
			$target=" target='_blank'";
			//发布时间
			$ftime=@filemtime($pathfile);
			$filetime=date("Y-m-d H:i:s",$ftime);
			//文件大小
			$fsize=@filesize($pathfile);
			$filesize=ChTheFilesize($fsize);
			$furl=$efileurl.$truefile;
		}
	 ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td width="6%" height="25"> 
        <div align="center"> 
          <?=$checkbox?>
        </div></td>
      <td width="47%" height="25"><a href=<?=$filelink?><?=$target?>> 
        <?=$filename?>
        </a></td>
      <td width="14%"> 
        <div align="right"> 
          <?=$filesize?>
        </div></td>
      <td width="10%"> 
        <div align="center"> 
          <?=$ftype?>
        </div></td>
      <td width="23%"> 
        <div align="center"> 
          <?=$filetime?>
        </div></td>
    </tr>
    <?
	}
	@closedir($hand);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> 
        <div align="center"> 
          <input type="checkbox" name="chkall" value="on" onclick="CheckAll(this.form)">
        </div></td>
      <td height="25" colspan="4"> 
        <input type="submit" name="Submit" value="删除文件"> 
        <input name="enews" type="hidden" id="enews" value="DelTruePathFile">
		<?=$filepathr['addpostvar']?>
        </td>
    </tr>
  </form>
</table>
</body>
</html>