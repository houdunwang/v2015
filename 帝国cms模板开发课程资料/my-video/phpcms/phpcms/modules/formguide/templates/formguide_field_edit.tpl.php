<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = $show_dialog = 1;
include $this->admin_tpl('header','admin');?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform"});
	$("#field").formValidator({onshow:"<?php echo L('input').L('fieldname')?>",onfocus:"<?php echo L('fieldname').L('between_1_to_20')?>"}).regexValidator({regexp:"^[a-zA-Z]{1}([a-zA-Z0-9]|[_]){0,19}$",onerror:"<?php echo L('fieldname_was_wrong');?>"}).inputValidator({min:1,max:20,onerror:"<?php echo L('fieldname').L('between_1_to_20')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data : "m=formguide&c=formguide_field&a=public_checkfield&formid=<?php echo $formid?>&oldfield=<?php echo $field;?>",
		datatype : "html",
		cached:false,
		getdata:{issystem:'issystem'},
		async:'true',
		success : function(data){	
            if( data == "1" )
			{
                return true;
			}
            else
			{
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('fieldname').L('already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	}).defaultPassed();
	$("#formtype").formValidator({onshow:"<?php echo L('select_fieldtype');?>",onfocus:"<?php echo L('select_fieldtype');?>",oncorrect:"<?php echo L('input_right');?>",defaultvalue:""}).inputValidator({min:1,onerror: "<?php echo L('select_fieldtype');?>"});
	$("#name").formValidator({onshow:"<?php echo L('input_nickname');?>",onfocus:"<?php echo L('nickname_empty');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_nickname');?>"});
})

//-->
</script>
<div class="pad_10">
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('model_manage');?>--<?php echo $m_r['name'].L('field_manage');?></h2>
<div class="content-menu ib-a blue line-x">
<a href="javascript:;" class="on"><em><?php echo L('edit_field');?></em></a><span>|</span><a href="?m=formguide&c=formguide_field&a=init&formid=<?php echo $formid?>&menuid=<?php echo $_GET['menuid']?>"><em><?php echo L('manage_field');?></em></a><span>|</span></div>
  <div class="bk10"></div>
</div>
<form name="myform" id="myform" action="?m=formguide&c=formguide_field&a=edit" method="post">
<div class="common-form">
<table width="100%" class="table_form">
	<tr> 
      <th><strong><?php echo L('field_type');?></strong><br /></th>
      <td>
<input type="hidden" name="info[formtype]" value="<?php echo $formtype;?>">
<?php echo form::select($fields,$formtype,'name="info[formtype]" id="formtype" onchange="javascript:field_setting(this.value);" disabled',L('select_fieldtype'));?>
	  </td>
    </tr>
	<tr> 
      <th width="25%"><font color="red">*</font> <strong><?php echo L('fieldname');?></strong><br />
	  <?php echo L('fieldname_tips');?>
	  </th>
      <td><input type="text" name="info[field]" id="field" size="20" class="input-text" value="<?php echo $field?>" <?php if(in_array($field,$forbid_delete)) echo 'readonly';?>></td>
    </tr>
	<tr> 
      <th><font color="red">*</font> <strong><?php echo L('field_nickname');?></strong><br /><?php echo L('nickname_tips');?></th>
      <td><input type="text" name="info[name]" id="name" size="30" class="input-text" value="<?php echo $name?>"></td>
    </tr>
	<tr> 
      <th><strong><?php echo L('field_tip');?></strong><br /><?php echo L('field_tips');?></th>
      <td><textarea name="info[tips]" rows="2" cols="20" id="tips" style="height:40px; width:80%"><?php echo new_html_special_chars($tips);?></textarea></td>
    </tr>

	<tr> 
      <th><strong><?php echo L('relation_parm');?></strong><br /><?php echo L('relation_parm_tips');?></th>
      <td><?php echo $form_data;?></td>
    </tr>
	<?php if(in_array($formtype,$att_css_js)) { ?>
	<tr> 
      <th><strong><?php echo L('form_attr');?></strong><br /><?php echo L('form_attr_tips');?></th>
      <td><input type="text" name="info[formattribute]" size="50" class="input-text" value="<?php echo new_html_special_chars($formattribute);?>"></td>
    </tr>
	<tr> 
      <th><strong><?php echo L('form_css_name');?></strong><br /><?php echo L('form_css_name_tips');?></th>
      <td><input type="text" name="info[css]" size="10" class="input-text" value="<?php echo new_html_special_chars($css);?>"></td>
    </tr>
	<?php } ?>
	<tr> 
      <th><strong><?php echo L('string_size');?></strong><br /><?php echo L('string_size_tips');?></th>
      <td><?php echo L('minlength');?>：<input type="text" name="info[minlength]" id="field_minlength" value="<?php echo $minlength;?>" size="5" class="input-text"><?php echo L('maxlength');?>：<input type="text" name="info[maxlength]" id="field_maxlength" value="<?php echo $maxlength;?>" size="5" class="input-text"></td>
    </tr>
	<tr> 
      <th><strong><?php echo L('data_preg');?></strong><br /><?php echo L('data_preg_tips');?></th>
      <td><input type="text" name="info[pattern]" id="pattern" value="<?php echo $pattern;?>" size="40" class="input-text"> 
<select name="pattern_select" onchange="javascript:$('#pattern').val(this.value)">
<option value=""><?php echo L('often_preg');?></option>
<option value="/^[0-9.-]+$/"><?php echo L('figure');?></option>
<option value="/^[0-9-]+$/"><?php echo L('integer');?></option>
<option value="/^[a-z]+$/i"><?php echo L('letter');?></option>
<option value="/^[0-9a-z]+$/i"><?php echo L('integer_letter');?></option>
<option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
<option value="/^[0-9]{5,20}$/">QQ</option>
<option value="/^http:\/\//"><?php echo L('hyperlink');?></option>
<option value="/^(1)[0-9]{10}$/"><?php echo L('mobile_number');?></option>
<option value="/^[0-9-]{6,13}$/"><?php echo L('tel_number');?></option>
<option value="/^[0-9]{6}$/"><?php echo L('zip');?></option>
</select>
	  </td>
    </tr>
	<tr> 
      <th><strong><?php echo L('data_passed_msg');?></strong></th>
      <td><input type="text" name="info[errortips]" value="<?php echo new_html_special_chars($errortips);?>" size="50" class="input-text"></td>
    </tr>
	
	<tr> 
      <th><strong><?php echo L('disabled_groups_field');?></strong></th>
      <td><?php echo form::checkbox($grouplist,$unsetgroupids,'name="unsetgroupids[]" id="unsetgroupids"',0,'100');?></td>
    </tr>
</table>

    <div class="bk15"></div>
    <input name="info[modelid]" type="hidden" value="<?php echo $formid?>">
    <input name="fieldid" type="hidden" value="<?php echo $fieldid?>">
    <input name="oldfield" type="hidden" value="<?php echo $field?>">
    <div class="btn"><input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button"></div>
	</form>

</div>
</body>
</html>