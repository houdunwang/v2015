<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>地图接口选择</td>
      <td>
	  <input type="radio" name="setting[maptype]" value="2" <?php if($setting['maptype']==2) echo 'checked';?>> 百度地图
	  <input type="radio" name="setting[maptype]" value="1" <?php if($setting['maptype']==1) echo 'checked';?> disabled> MAPABC
	  </td>
    </tr>	
	<tr> 
      <td>地图API Key </td>
      <td><input type="text" name="setting[api_key]" value="<?php echo $setting['api_key'];?>" size="30" class="input-text"></td>
    </tr>	
	<tr> 
      <td>默认城市</td>
      <td><input type="text" name="setting[defaultcity]" value="<?php echo $setting['defaultcity'];?>" size="30" class="input-text"></td>
    </tr>
	<tr> 
      <td width="100">热门城市</td>
      <td>
	  <textarea style="height:100px;width:100px;" id="options" cols="20" rows="2" name="setting[hotcitys]"><?php echo $setting['hotcitys'];?></textarea> 多个城市请使用半角逗号分隔</td>
    </tr>	
	<tr> 
      <td>地图尺寸 </td>
      <td>
	  宽度: <input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="10" class="input-text">px 
	  高度: <input type="text" name="setting[height]" value="<?php echo $setting['height'];?>" size="10" class="input-text">px
	  </td>
    </tr>		
</table>