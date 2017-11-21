<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
<form action="?m=wap&c=wap_admin&a=edit" method="post" id="myform">
<input type="hidden" value='<?php echo $siteid?>' name="siteid">
<fieldset>
	<legend><?php echo L('basic_config')?></legend>
	<table width="100%"  class="table_form">
    <tr>
    <th width="120"><?php echo L('wap_belong_site')?></th>
    <td class="y-bg"><?php echo $sitelist[$siteid]['name']?></td>
    </tr>	
    <tr>
    <th width="120"><?php echo L('wap_sitename')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="sitename" id="sitename" size="30" value="<?php echo $sitename?>"/></td>
    </tr>
    <tr>
    <th width="120"><?php echo L('wap_logo')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="logo" id="logo" size="30" value="<?php echo $logo?>"/></td>
    </tr>
    <tr>
    <th width="120"><?php echo L('wap_domain')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="domain" id="domain" size="30" value="<?php echo $domain?>"/></td>
    </tr> 
    </table> 
  </fieldset>
 <div class="bk10"></div>
 <fieldset>
	<legend><?php echo L('parameter_config')?></legend>  
	<table width="100%"  class="table_form">   
    <tr>
    <th width="120"><?php echo L('wap_listnum')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[listnum]" id="listnum" size="10" value="<?php echo $listnum?>"/> 条</td>
    </tr>
    <tr>
    <th width="120"><?php echo L('wap_thumb')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[thumb_w]" id="thumb_w" size="5" value="<?php echo $thumb_w?>"/>px　*　<input type="text" class="input-text" name="setting[thumb_h]" id="thumb_h" size="5" value="<?php echo $thumb_h?>"/>px</td>
    </tr>
    <tr>
    <th width="120"><?php echo L('wap_content_page')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[c_num]" id="c_num" size="10" value="<?php echo $c_num?>"/></td>
    </tr> 
    <tr>
    <th width="120"><?php echo L('wap_index_tpl')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[index_template]" id="index_template" size="20" value="<?php echo $index_template?>"/>.html</td>
    </tr> 
     <tr>
    <th width="120"><?php echo L('wap_cat_tpl')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[category_template]" id="category_template" size="20" value="<?php echo $category_template?>"/>.html</td>
    </tr>             
     <tr>
    <th width="120"><?php echo L('wap_list_tpl')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[list_template]" id="list_template" size="20" value="<?php echo $list_template?>"/>.html</td>
    </tr>             
     <tr>
    <th width="120"><?php echo L('wap_show_tpl')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[show_template]" id="show_template" size="20" value="<?php echo $show_template?>"/>.html</td>
    </tr>   
     <tr>
    <th width="120"><?php echo L('wap_hotword')?></th>
    <td class="y-bg">
 <textarea style="height: 100px; width: 200px;" id="options" cols="20" rows="2" name="setting[hotwords]"><?php echo $hotwords?></textarea>   <?php echo L('wap_hotword_desc')?>
</td>
    </tr>              
</table>

<div class="bk15"></div>
<input type="submit" id="dosubmit" name="dosubmit" class="dialog" value="<?php echo L('submit')?>" />
</fieldset>
</form>
</div>
</body>
</html>