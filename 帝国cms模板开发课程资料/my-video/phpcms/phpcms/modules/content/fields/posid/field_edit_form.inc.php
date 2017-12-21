<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="200">每个位置宽度</td>
      <td><input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="5" class="input-text"> px
	  </td>
    </tr>
    <tr> 
      <td>默认选中项</td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="20" class="input-text"> 多个之间用半角逗号隔开
	  </td>
    </tr>
</table>