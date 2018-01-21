<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#workname").formValidator({onshow:"<?php echo L("input").L('workflow_name')?>",onfocus:"<?php echo L("input").L('workflow_name')?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('workflow_name')?>"});
	})
//-->
</script>
<div class="pad-lr-10">
<form action="?m=content&c=workflow&a=edit" method="post" id="myform">
	<table width="100%"  class="table_form">
  <tr>
    <th width="150"><?php echo L('workflow_name')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="info[workname]" id="workname" size="30" value="<?php echo $workname;?>"/></td>
  </tr>
    <tr>
    <th><?php echo L('description')?>：</th>
    <td class="y-bg"><textarea name="info[description]" maxlength="255" style="width:300px;height:60px;"><?php echo $description;?></textarea></td>
  </tr>
	<tr>
    <th><?php echo L('steps')?>：</th>
    <td class="y-bg">
	<select name="info[steps]" onchange="select_steps(this.value)">
	<option value='1' <?php if($steps==1) echo 'selected';?>><?php echo L('steps_1');?></option>
	<option value='2' <?php if($steps==2) echo 'selected';?>><?php echo L('steps_2');?></option>
	<option value='3' <?php if($steps==3) echo 'selected';?>><?php echo L('steps_3');?></option>
	<option value='4' <?php if($steps==4) echo 'selected';?>><?php echo L('steps_4');?></option>
	</select></td>
  </tr>
   <tr id="step1">
    <th><?php echo L('steps_1');?> <?php echo L('admin_users')?>：</th>
    <td class="y-bg">
	<?php echo form::checkbox($admin_data,$checkadmin1,'name="checkadmin1[]"','',120);?>
	</td>
  </tr>
   <tr id="step2" style="display:<?php if($steps<2) echo 'none';?>">
    <th><?php echo L('steps_2');?> <?php echo L('admin_users')?>：</th>
    <td class="y-bg">
		<?php echo form::checkbox($admin_data,$checkadmin2,'name="checkadmin2[]"','',120);?>
	</td>
  </tr>
   <tr id="step3" style="display:<?php if($steps<3) echo 'none';?>">
    <th><?php echo L('steps_3');?> <?php echo L('admin_users')?>：</th>
    <td class="y-bg">
		<?php echo form::checkbox($admin_data,$checkadmin3,'name="checkadmin3[]"','',120);?>
	</td>
  </tr>
   <tr id="step4" style="display:<?php if($steps<4) echo 'none';?>">
    <th><?php echo L('steps_4');?> <?php echo L('admin_users')?>：</th>
    <td class="y-bg">
		<?php echo form::checkbox($admin_data,$checkadmin4,'name="checkadmin4[]"','',120);?>
	</td>
  </tr>
  <tr>
    <th><B><?php echo L('nocheck_users')?></B>：</th>
    <td class="y-bg">
		<?php echo form::checkbox($admin_data,$nocheck_users,'name="nocheck_users[]"','',120);?>
	</td>
  </tr>
  <tr>
    <th><?php echo L('checkstatus_flag')?>：</th>
    <td class="y-bg">
		<input type="radio" name="info[flag]" value="1" <?php if($flag) echo 'checked';?>> 是 
		<input type="radio" name="info[flag]" value="0" <?php if(!$flag) echo 'checked';?>> 否
	</td>
  </tr>
</table>

<div class="bk15"></div>
<input type="hidden" name="workflowid" value="<?php echo $workflowid?>"/>
<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="1" />
</form>
</div>
</body>
</html>
<SCRIPT LANGUAGE="JavaScript">
<!--
function select_steps(stepsid) {
	for(i=4;i>1;i--) {
		if(stepsid>=i) {
			$('#step'+i).css('display','');
		} else {
			$('#step'+i).css('display','none');
		}
	}
}
//-->
</SCRIPT>
