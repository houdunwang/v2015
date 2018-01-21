<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">附件</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="4%">&nbsp;</td>
    <td width="8%">
<div align="center">ID</div></td>
    <td width="42%">
<div align="center">文件名</div></td>
    <td width="15%">
<div align="center">大小</div></td>
    <td width="21%">
<div align="center">上传时间</div></td>
    <td width="10%"><div align="center">选择</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
	$filesize=ChTheFilesize($r[filesize]);
	//取得文件类型
	$truefiletype=GetFiletype($r[filename]);
	$filetype=substr($truefiletype,1);
	//文件
	$fspath=ReturnFileSavePath($r[classid],$r[fpath]);
	$filepath=$r[path]?$r[path].'/':$r[path];
	$file=$fspath['fileurl'].$filepath.$r[filename];
	$buttonr=ToReturnDoFileButton($doing,$tranfrom,$field,$file,$r[filename],$r[fileid],$filesize,$truefiletype,$r[no],$type);
	$button=$buttonr['button'];
	$buttonurl=$buttonr['bturl'];
  ?>
  <tr> 
    <td bgcolor="#FFFFFF"><div align="center"> 
        <input type=checkbox name=fileid[] value="<?=$r[fileid]?>">
      </div></td>
    <td bgcolor="#FFFFFF"> <div align="center"> 
        <?=$r[fileid]?>
      </div></td>
    <td bgcolor="#FFFFFF" style='line-height:20px'>
	  <?=$r[no]?>
	  <a href='<?=$file?>' target=_blank><?=$r[filename]?></a></td>
    <td bgcolor="#FFFFFF"> <div align="right"> 
        <?=$filesize?>
      </div></td>
    <td bgcolor="#FFFFFF"> <div align="center"> 
        <?=date('Y-m-d H:i:s',$r[filetime])?>
      </div></td>
    <td bgcolor="#FFFFFF"> <div align="center"> 
        <?=$button?>
      </div></td>
  </tr>
  <?
  }
  ?>
  <tr> 
    <td bgcolor="#FFFFFF"><div align="center">
        <input type="checkbox" name="chkall" value="on" onclick="CheckAll(this.form)">
      </div></td>
    <td colspan="5" bgcolor="#FFFFFF">&nbsp;&nbsp; 
      <?=$returnpage?>
      &nbsp;&nbsp; <input type="submit" name="Submit34" value="删除选中" onclick="document.dofile.enews.value='TDelFile_all';">
    </td>
  </tr>
</table>