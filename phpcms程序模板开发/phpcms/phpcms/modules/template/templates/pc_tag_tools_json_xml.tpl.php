<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
<form action="?m=template&c=file&a=edit_pc_tag&style=<?php echo $this->style?>&dir=<?php echo $dir?>&file=<?php echo urlencode($file)?>&op=<?php echo $op?>&tag_md5=<?php echo $_GET['tag_md5']?>" method="post" id="myform">
	<table width="100%"  class="table_form">
	  <tr>
    <th width="80"><?php echo L("toolbox_type")?>：</th>
    <td class="y-bg"><?php echo $op?></td>
  </tr>
    <tr>
    <th width="80"><?php echo L("data_address")?>：</th>
    <td class="y-bg"><input type="text" name="url" id="url" size="30" value="<?php echo $_GET['url']?>" /></td>
  </tr>
     <tr>
    <th width="80"><?php echo L("check")?>：</th>
    <td class="y-bg"><input type="text" name="return" id="return" size="30" value="<?php echo $_GET['return']?>" /> </td>
  </tr>
   <tr>
    <th width="80"><?php echo L("buffer_time")?>：</th>
    <td class="y-bg"><input type="text" name="cache" id="cache" size="30" value="<?php echo $_GET['cache']?>" /> <?php echo L("unit_second")?></td>
  </tr>
</table>
<div class="bk15"></div>
<input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />

</form>
</div>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#url").formValidator({onshow:"<?php echo L("input").L("data_address")?>",onfocus:"<?php echo L("input").L("data_address")?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L("data_address")?>"}).regexValidator({regexp:"^http:\/\/(.*)",param:'i',onerror:"<?php echo L('data_address_reg_sg')?>"});
		$("#cache").formValidator({onshow:"<?php echo L("input").L('buffer_time')?>",onfocus:"<?php echo L("input").L('buffer_time')?>"}).regexValidator({regexp:"num1",datatype:'enum',param:'i',onerror:"<?php echo L('cache_time_can_only_be_positive')?>"});
	})
//-->
</script>
</body>
</html>