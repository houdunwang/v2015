<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">编辑器样式：</td>
      <td><input type="radio" name="setting[toolbar]" value="basic" checked> 简洁型 <input type="radio" name="setting[toolbar]" value="full"> 标准型 </td>
    </tr>
	<tr> 
      <td>默认值：</td>
      <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:100px;width:250px;"></textarea></td>
    </tr>
	<tr> 
      <td>是否启用关联链接：</td>
      <td><input type="radio" name="setting[enablekeylink]" value="1"> 是 <input type="radio" name="setting[enablekeylink]" value="0" checked> 否  <input type="text" name="setting[replacenum]" value="1" size="4" class="input-text"> 替换次数 （留空则为替换全部）</td>
    </tr>
	<tr> 
      <td>关联链接方式：</td>
      <td><input type="radio" name="setting[link_mode]" value="1" <?php if($setting['link_mode']==1) echo 'checked';?>> 关键字链接 <input type="radio" name="setting[link_mode]" value="0" <?php if($setting['link_mode']==0) echo 'checked';?>> 网址链接  </td>
    </tr>
	<tr> 
      <td>是否保存远程图片：</td>
      <td><input type="radio" name="setting[enablesaveimage]" value="1"> 是 <input type="radio" name="setting[enablesaveimage]" value="0" checked> 否</td>
    </tr>
	<tr> 
      <td>编辑器默认高度：</td>
      <td><input type="text" name="setting[height]" value="200" size="4" class="input-text"> px</td>
    </tr>
</table>