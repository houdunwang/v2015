<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<form method="post" action="?m=formguide&c=formguide&a=edit&formid=<?php echo $_GET['formid']?>" name="myform" id="myform">
<table class="table_form" width="100%" cellspacing="0">
<tbody>
	<tr>
		<th width="150"><strong><?php echo L('name')?>：</strong></th>
		<td><input name="info[name]" id="name" class="input-text" type="text" value="<?php echo new_html_special_chars($data['name'])?>" size="30" ></td>
	</tr>
	<tr>
		<th><strong><?php echo L('tablename')?>：</strong></th>
		<td><input name="info[tablename]" id="tablename" class="input-text" type="text" value="<?php echo $data['tablename']?>" readonly size="25" ></td>
	</tr>
	<tr>
		<th><strong><?php echo L('introduction')?>：</strong></th>
		<td><textarea name="info[description]" id="description" rows="6" cols="50"><?php echo $data['description']?></textarea></td>
	</tr>
	<tr>
		<th><strong><?php echo L('time_limit')?>：</strong></th>
		<td><input type="radio" name="setting[enabletime]" value="1" <?php if ($data['setting']['enabletime']) {?>checked<?php }?>> <?php echo L('enable')?> <input type="radio" name="setting[enabletime]" value="0" <?php if ($data['setting']['enabletime']==0) {?>checked<?php }?>> <?php echo L('unenable')?></td>
	</tr>
	<tr id="time_start" style="<?php if ($data['setting']['enabletime']==0) {?>display:none;<?php }?>">
  		<th><strong><?php echo L('start_time')?>：</strong></th>
        <td><?php echo form::date('setting[starttime]', $data['setting']['starttime']?date('Y-m-d', $data['setting']['starttime']):0)?></td>
	</tr>
	<tr id="time_end" style="<?php if ($data['setting']['enabletime']==0) {?>display:none;<?php }?>">
		<th><strong><?php echo L('end_time')?>：</strong></th>
		<td><?php echo form::date('setting[endtime]', $data['setting']['endtime']?date('Y-m-d', $data['setting']['endtime']):0)?></td>
	</tr>
	<tr>
		<th><strong><?php echo L('allowed_send_mail')?>：</strong></th>
		<td><input name="setting[sendmail]" type="radio" value="1" <?php if ($data['setting']['sendmail']) {?>checked<?php }?>>&nbsp;<?php echo L('yes')?>&nbsp;&nbsp;<input name="setting[sendmail]" type="radio" value="0" <?php if ($data['setting']['sendmail']==0) {?>checked<?php }?>>&nbsp;<?php echo L('no')?></td>
	</tr>
	<tr id="mailaddress" style="<?php if ($data['setting']['sendmail']==0) {?>display:none;<?php }?>">
		<th><strong><?php echo L('e-mail_address')?>：</strong></th>
		<td><input type="text" name="setting[mails]" id="mails" class="input-text" value="<?php echo $data['setting']['mails']?>" size="50"> <?php echo L('multiple_with_commas')?></td>
	</tr>
	<tr>
		<th><strong><?php echo L('allows_more_ip')?>：</strong></th>
		<td><input type='radio' name='setting[allowmultisubmit]' value='1' <?php if($data['setting']['allowmultisubmit'] == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[allowmultisubmit]' value='0' <?php if($data['setting']['allowmultisubmit'] == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>
	<tr>
		<th><strong><?php echo L('allowunreg')?>：</strong></th>
		<td><input type='radio' name='setting[allowunreg]' value='1' <?php if($data['setting']['allowunreg'] == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[allowunreg]' value='0' <?php if($data['setting']['allowunreg'] == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
	</tr>
	<tr>
		<th><strong><?php echo L('optional_style')?>：</strong></th>
		<td>
		<?php echo form::select($template_list, $data['default_style'], 'name="info[default_style]" id="style" onchange="load_file_list(this.value)"', L('please_select'))?> 
		</td>
	</tr>
	<tr>
		<th><strong><?php echo L('template_selection')?>：</strong></th>
		<td id="show_template"><script type="text/javascript">$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style=<?php echo $data['default_style']?>&id=<?php echo $data['show_template']?>&module=formguide&templates=show&name=info&pc_hash='+pc_hash, function(data){$('#show_template').html(data.show_template);});</script></td>
	</tr>
	<tr>
		<th><strong>js调用使用的模板：</strong></th>
		<td id="show_js_template"><script type="text/javascript">$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style=<?php echo $data['default_style']?>&id=<?php echo $data['js_template']?>&module=formguide&templates=show_js&name=info&pc_hash='+pc_hash, function(data){$('#show_js_template').html(data.show_js_template);});</script></td>
	</tr>
	</tbody>
</table>
<input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="dialog">&nbsp;<input type="reset" class="dialog" value=" <?php echo L('clear')?> ">
</form>
</div>
</body>
</html>
<script type="text/javascript">
function load_file_list(id) {
	if (id=='') return false;
	$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&module=formguide&templates=show|show_js&name=info&pc_hash='+pc_hash, function(data){$('#show_template').html(data.show_template);$('#show_js_template').html(data.show_js_template);});
}

$(document).ready(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
	$('#name').formValidator({onshow:"<?php echo L('input_form_title')?>",onfocus:"<?php echo L('title_min_3_chars')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('title_cannot_empty')?>"}).defaultPassed();
	$('#tablename').formValidator({onshow:"<?php echo L('please_input_tallename')?>", onfocus:"<?php echo L('standard')?>", oncorrect:"<?php echo L('right')?>"}).regexValidator({regexp:"^[a-zA-Z]{1}([a-zA-Z0-9]|[_]){0,19}$",onerror:"<?php echo L('tablename_was_wrong');?>"}).inputValidator({min:1,onerror:"<?php echo L('tablename_no_empty')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data : "m=formguide&c=formguide&a=public_checktable&formid=<?php echo $_GET['formid']?>",
		datatype : "html",
		cached:false,
		getdata:{issystem:'issystem'},
		async:'false',
		success : function(data){	
            if( data == "1" ){
                return true;
			} else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('tablename_existed')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	}).defaultPassed();
	$('#starttime').formValidator({onshow:"<?php echo L('select_stardate')?>",onfocus:"<?php echo L('select_stardate')?>",oncorrect:"<?php echo L('right_all')?>"}).defaultPassed();
	$('#endtime').formValidator({onshow:"<?php echo L('select_downdate')?>",onfocus:"<?php echo L('select_downdate')?>",oncorrect:"<?php echo L('right_all')?>"}).defaultPassed();
	$('#style').formValidator({onshow:"<?php echo L('select_style')?>",onfocus:"<?php echo L('select_style')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('select_style')?>"}).defaultPassed();
});
$("input:radio[name='setting[enabletime]']").click(function (){
	if($("input:radio[name='setting[enabletime]'][checked]").val()==0) {
		$("#time_start").hide();
		$("#time_end").hide();
	} else if($("input:radio[name='setting[enabletime]'][checked]").val()==1) {
		$("#time_start").show();
		$("#time_end").show();
	}
});
$("input:radio[name='setting[sendmail]']").click(function (){
	if($("input:radio[name='setting[sendmail]'][checked]").val()==0) {
		$("#mailaddress").hide();
	} else if($("input:radio[name='setting[sendmail]'][checked]").val()==1) {
		$("#mailaddress").show();
	}
});
</script>