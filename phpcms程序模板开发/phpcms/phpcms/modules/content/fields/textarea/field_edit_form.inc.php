<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">文本域宽度</td>
      <td><input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="10" class="input-text" > %</td>
    </tr>
	<tr> 
      <td>文本域高度</td>
      <td><input type="text" name="setting[height]" value="<?php echo $setting['height'];?>" size="10" class="input-text"> px</td>
    </tr>
	<tr> 
      <td>默认值</td>
      <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:60px;width:250px;" ><?php echo new_html_special_chars($setting['defaultvalue']);?></textarea></td>
    </tr>
	<tr> 
      <td>是否允许Html</td>
      <td><input type="radio" name="setting[enablehtml]" value="1" <?php if($setting['enablehtml']==1) {?>checked<?php }?>> 是 <input type="radio" name="setting[enablehtml]" value="0" <?php if($setting['enablehtml']==0) {?>checked<?php }?>> 否</td>
    </tr>
</table>