<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript">
$(function(){
$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});

$("#badword").formValidator({onshow:"<?php echo L("input").L('badword_name')?>",onfocus:"<?php echo L("input").L('badword_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('badword_name')?>"}).regexValidator({regexp:"notempty",datatype:"enum",param:'i',onerror:"<?php echo L('input_not_space')?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=badword&a=public_name&badid=<?php echo $badid;?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('badword_name').L('exists')?>",onwait : "<?php echo L('connecting')?>"}).defaultPassed();

$("#replaceword").formValidator({empty:true,onshow:"<?php echo L('badword_noreplace')?>",onfocus:"<?php echo L("input").L('badword_replacename')?>",oncorrect:"<?php echo L('format_right')?>",onempty:"<?php echo L('badword_notreplace')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('badword_replacename')?>"});

})
</script>

<div class="pad_10">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
<form action="?m=admin&c=badword&a=edit&badid=<?php echo $badid?>" method="post" name="myform" id="myform">
 	<tr> 
      <th width="20%"><?php echo L('badword_name')?></th>
      <td><input type="text" name="badword" id="badword" value="<?php echo $badword?>"></td>
    </tr>
    
    <tr> 
      <th width="20%"><?php echo L('badword_replacename')?></th>
      <td><input type="text" name="replaceword" id="replaceword" value="<?php echo $replaceword ?>" ></td>
    </tr>
    
    <tr> 
    <th width="20%"><?php echo L('badword_level')?></th>
    <td>
	<select size="1" id="info[level]" name="info[level]">
	<?php 
	if($level=='1'){
		$level1 = "selected";
	}else{
		$level2 = "selected";
	}
	?>
	<option <?php echo $level1;?> value="1"><?php echo L('badword_common')?></option>
	<option <?php echo $level2;?> value="2"><?php echo L('badword_dangerous')?></option> 
	
	</select>
	<?php echo L('badword_level_info')?>
	</td>
    </tr> 
	<input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('submit')?> " class="dialog"> 
	</form>
</table>
</div>
</body>
</html>