<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="200">默认选择的会员组</td>
      <td><input type="text" name="setting[groupids]" value="<?php echo $setting['groupids'];?>" size="20" class="input-text"> 填写会员组ID，多个用 “|” 分开</td>
    </tr>
</table>