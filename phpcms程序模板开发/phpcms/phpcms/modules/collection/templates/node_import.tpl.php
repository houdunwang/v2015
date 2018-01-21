<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script type="text/javascript">
$(document).ready(function() {
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'})}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('nodename')?>",onfocus:"<?php echo L('input').L('nodename')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('nodename')?>"}).ajaxValidator({type : "get",url : "",data :"m=collection&c=node&a=public_name",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('nodename').L('exists')?>",onwait : "<?php echo L('connecting')?>"});

});
</script>
<div class="pad-10">
<form name="myform" action="?m=collection&c=node&a=node_import" method="post" id="myform"  enctype="multipart/form-data">
<div class="common-form">
	<table width="100%" class="table_form">
		<tr>
			<td width="120"><?php echo L('collect_call')?>：</td> 
			<td>
			<input type="text" name="name" id="name"  class="input-text" value="" />
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('cfg')?>：</td> 
			<td>
			<input type="file" name="file"  class="input-text" value="" /> <br /><?php echo L('only_support_txt_file_upload')?>
			</td>
		</tr>
	</table>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="dialog">
</div>
</div>
</form>

</body>
</html>