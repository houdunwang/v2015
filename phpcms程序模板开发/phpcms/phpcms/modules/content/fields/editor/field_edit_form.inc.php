<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="225">编辑器样式：</td>
      <td><input type="radio" name="setting[toolbar]" value="basic" <?php if($setting['toolbar']=='basic') echo 'checked';?>>简洁型 <input type="radio" name="setting[toolbar]" value="full" <?php if($setting['toolbar']=='full') echo 'checked';?>> 标准型 </td>
    </tr>
	<tr> 
      <td>默认值：</td>
      <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:100px;width:250px;"><?php echo $setting['defaultvalue'];?></textarea></td>
    </tr>
	<tr> 
      <td>是否启用关联链接：</td>
      <td><input type="radio" name="setting[enablekeylink]" value="1" <?php if($setting['enablekeylink']==1) echo 'checked';?>> 是 <input type="radio" name="setting[enablekeylink]" value="0" <?php if($setting['enablekeylink']==0) echo 'checked';?>> 否  <input type="text" name="setting[replacenum]" value="<?php echo $setting['replacenum'];?>" size="4" class="input-text"> 替换次数 （留空则为替换全部）</td>
    </tr>
	<tr> 
      <td>关联链接方式：</td>
      <td><input type="radio" name="setting[link_mode]" value="1" <?php if($setting['link_mode']==1) echo 'checked';?>> 关键字链接 <input type="radio" name="setting[link_mode]" value="0" <?php if($setting['link_mode']==0) echo 'checked';?>> 网址链接  </td>
    </tr>
	<tr> 
      <td>是否保存远程图片：</td>
      <td><input type="radio" name="setting[enablesaveimage]" value="1" <?php if($setting['enablesaveimage']==1) echo 'checked';?>> 是 <input type="radio" name="setting[enablesaveimage]" value="0"  <?php if($setting['enablesaveimage']==0) echo 'checked';?>> 否</td>
    </tr>
	<tr> 
      <td>编辑器默认高度：</td>
      <td><input type="text" name="setting[height]" value="<?php echo $setting['height'];?>" size="4" class="input-text"> px</td>
    </tr>
	<tr> 
      <td>禁止显示编辑器下方的分页符与子标题：</td>
      <td><input type="radio" name="setting[disabled_page]" value="1" <?php if($setting['disabled_page']==1) echo 'checked';?>> 禁止 <input type="radio" name="setting[disabled_page]" value="0" <?php if($setting['disabled_page']==0) echo 'checked';?>> 显示</td>
    </tr>
</table>