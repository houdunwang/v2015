<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>允许上传的文件类型</td>
      <td><input type="text" name="setting[upload_allowext]" value="<?php echo $setting['upload_allowext'];?>" size="40" class="input-text"></td>
    </tr>
	<tr> 
      <td>是否从已上传中选择</td>
      <td><input type="radio" name="setting[isselectimage]" value="1" <?php if($setting['isselectimage']) echo 'checked';?>> 是 <input type="radio" name="setting[isselectimage]" value="0" <?php if(!$setting['isselectimage']) echo 'checked';?>> 否</td>
    </tr>
	<tr> 
      <td>允许同时上传的个数</td>
      <td><input type="text" name="setting[upload_number]" value="<?php echo $setting['upload_number'];?>" size=3></td>
    </tr>
	<tr>
	<td>文件链接方式</td>
	<td>
      	<input name="setting[downloadlink]" value="0" type="radio" <?php if(!$setting['downloadlink']) echo 'checked';?>>
        链接到真实软件地址 
        <input name="setting[downloadlink]" value="1" type="radio" <?php if($setting['downloadlink']) echo 'checked';?>>
        链接到跳转页面
      
	</td>
	</tr>
	<tr>
	<td>文件下载方式</td>
	<td>
      	<input name="setting[downloadtype]" value="0" type="radio" <?php if(!$setting['downloadtype']) echo 'checked';?>>
        链接文件地址 
        <input name="setting[downloadtype]" value="1" type="radio" <?php if($setting['downloadtype']) echo 'checked';?>>
        通过PHP读取
      
	</td>
	</tr>	
</table>