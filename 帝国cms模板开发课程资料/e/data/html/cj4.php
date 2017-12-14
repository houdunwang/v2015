<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>作品名正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--title--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_title]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_title]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_title]" type="text" id="add[z_title]" value="<?=stripSlashes($r[z_title])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>发布时间正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--newstime--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_newstime]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_newstime]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_newstime]" type="text" id="add[z_newstime]" value="<?=stripSlashes($r[z_newstime])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>作品预览图正则：</strong><br>
      ( 
      <input name="textfield" type="text" id="textfield" value="[!--titlepic--]" size="20">
      )</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td>附件前缀 
        <input name="add[qz_titlepic]" type="text" id="add[qz_titlepic]" value="<?=stripSlashes($r[qz_titlepic])?>"> 
        <input name="add[save_titlepic]" type="checkbox" id="add[save_titlepic]" value=" checked"<?=$r[save_titlepic]?>>
        远程保存 </td>
    </tr>
    <tr> 
      <td><textarea name="add[zz_titlepic]" cols="60" rows="10" id="add[zz_titlepic]"><?=ehtmlspecialchars(stripSlashes($r[zz_titlepic]))?></textarea></td>
    </tr>
    <tr> 
      <td><input name="add[z_titlepic]" type="text" id="titlepic5" value="<?=stripSlashes($r[z_titlepic])?>">
        (如填写这里，这就是字段的值)</td>
    </tr>
  </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>作者正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--flashwriter--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_flashwriter]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_flashwriter]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_flashwriter]" type="text" id="add[z_flashwriter]" value="<?=stripSlashes($r[z_flashwriter])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>作者邮箱正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--email--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_email]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_email]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_email]" type="text" id="add[z_email]" value="<?=stripSlashes($r[z_email])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>作品评价正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--star--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_star]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_star]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_star]" type="text" id="add[z_star]" value="<?=stripSlashes($r[z_star])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>文件大小正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--filesize--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_filesize]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_filesize]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_filesize]" type="text" id="add[z_filesize]" value="<?=stripSlashes($r[z_filesize])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>Flash地址正则：</strong><br>
      ( 
      <input name="textfield" type="text" id="textfield" value="[!--flashurl--]" size="20">
      )</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td>附件前缀 
        <input name="add[qz_flashurl]" type="text" id="add[qz_flashurl]" value="<?=stripSlashes($r[qz_flashurl])?>"> 
        <input name="add[save_flashurl]" type="checkbox" id="add[save_flashurl]" value=" checked"<?=$r[save_flashurl]?>>
        远程保存 </td>
    </tr>
    <tr> 
      <td><textarea name="add[zz_flashurl]" cols="60" rows="10" id="add[zz_flashurl]"><?=ehtmlspecialchars(stripSlashes($r[zz_flashurl]))?></textarea></td>
    </tr>
    <tr> 
      <td><input name="add[z_flashurl]" type="text" id="flashurl5" value="<?=stripSlashes($r[z_flashurl])?>">
        (如填写这里，这就是字段的值)</td>
    </tr>
  </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>Flash宽度正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--width--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_width]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_width]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_width]" type="text" id="add[z_width]" value="<?=stripSlashes($r[z_width])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>Flash高度正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--height--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_height]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_height]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_height]" type="text" id="add[z_height]" value="<?=stripSlashes($r[z_height])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>

  <tr bgcolor="#FFFFFF"> 
    <td height="22" valign="top"><strong>作品简介正则：</strong><br>
      (<input name="textfield" type="text" id="textfield" value="[!--flashsay--]" size="20">)</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr> 
          <td><textarea name="add[zz_flashsay]" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[zz_flashsay]))?></textarea></td>
        </tr>
        <tr> 
          <td><input name="add[z_flashsay]" type="text" id="add[z_flashsay]" value="<?=stripSlashes($r[z_flashsay])?>">
            (如填写这里，将为字段的值)</td>
        </tr>
      </table></td>
  </tr>
