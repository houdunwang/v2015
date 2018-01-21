<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">编辑器样式：</td>
      <td><input type="radio" name="setting[toolbar]" value="basic" <?php if($setting['toolbar']=='basic') echo 'checked';?>> <?php echo $setting['toolbar'];?>简洁型 <input type="radio" name="setting[toolbar]" value="full" <?php if($setting['toolbar']=='full') echo 'checked';?>> 标准型 </td>
    </tr>
	<tr> 
      <td>默认值：</td>
      <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:100px;width:250px;"><?php echo $setting['defaultvalue'];?></textarea></td>
    </tr>
</table>