<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#subject_title").formValidator({onshow:"<?php echo L("input").L('vote_title')?>",onfocus:"<?php echo L("input").L('vote_title')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('vote_title')?>"}).regexValidator({regexp:"notempty",datatype:"enum",param:'i',onerror:"<?php echo L('input_not_space')?>"}).ajaxValidator({type : "get",url : "",data :"m=vote&c=vote&a=public_name&subjectid=<?php echo $subjectid;?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('vote_title').L('exists')?>",onwait : "<?php echo L('connecting')?>"}).defaultPassed();
	$('#fromdate').formValidator({onshow:"<?php echo L('select').L('fromdate')?>",onfocus:"<?php echo L('select').L('fromdate')?>",oncorrect:"<?php echo L('time_is_ok');
		?>"}).inputValidator();
	$("#todate").formValidator({onshow:"<?php echo L('select').L('todate')?>",onfocus:"<?php echo L('select').L('todate')?>",oncorrect:"<?php echo L('time_is_ok');?>"}).inputValidator();
		
	});
//-->
</script>

<div class="pad_10">
<form action="?m=vote&c=vote&a=edit&subjectid=<?php echo $subjectid?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
<tr> 
      <th width="100"> <?php echo L('vote_title')?></th>
      <td>
      <input type="text" name="subject[subject]" id="subject_title" size="30" value="<?php echo $subject;?>">
      </td>
    </tr>
    
    <tr> 
    <th width="100"> <?php echo L('select_type')?> </th>
    <td>
	<select name="subject[ischeckbox]" id="" onchange="AdsType(this.value)">
			<option value="0" <?php if($ischeckbox == '0') {?> selected<?php }?>><?php echo L('radio');?></option>
			<option value="1" <?php if($ischeckbox == '1') {?> selected<?php }?>><?php echo L('checkbox');?></option>
	</select>
	</td>
    </tr>

	<tr id="SizeFormat" <?php if($ischeckbox == '0'){ ?>style="display:none"<?php }else{?>style="display:"<?php }?>>
	<th> </th>
	<td><label><?php echo L('minval');?></label>&nbsp;&nbsp;<input name="subject[minval]" class="input-text" type="text" size="5" value="<?php echo $minval;?>"> <?php echo L('item')?> &nbsp;&nbsp;&nbsp;&nbsp; <label><?php echo L('maxval');?></label>&nbsp;&nbsp;<input name="subject[maxval]" type="text" class="input-text" size="5" value="<?php echo $maxval?>"> <?php echo L('item')?></td>
	</tr>
    
    <tr> 
    <th width="100"> <?php echo L('vote_option')?>：</th>
    <td>
    <input type="button" id="addItem" value="<?php echo L('add_option')?>" class="button" onclick="add_option()">
    
    <div id="option_list_1">
    <?php
		  $i=0;
		  foreach($options as $optionid=>$option){
		  $i++;
	?>
           <div id="option<?php echo $option['optionid'];?>"><br>
           <input type="text" name="option[<?php echo $option['optionid']?>]" size="40" require="true" value="<?php echo $option['option'];?>"/>
           <?php if($i>2){?>
           <input type="button" value="<?php echo L('del')?>"  onclick="del_old(<?php echo $option['optionid'];?>)" class="button"/>
           <?php }?> 
           <font color="#FF0000"> *</font>
             
    </div>
    

	<?php }?>

	</div>
	
 	<div id="new_option"></div>
 	
	</td>
    </tr>
 
    
    <tr>
		<th><?php echo L('fromdate')?>：</th>
		<td><?php echo form::date('subject[fromdate]',$fromdate)?></td>
	</tr>
	<tr>
		<th><?php echo L('todate')?> ：</th>
		<td><?php echo form::date('subject[todate]',$todate)?></td>
	</tr>
    <tr>  
      <th> <?php echo L('vote_description')?> </th>
      <td><textarea name="subject[description]" id="description" cols="60" rows="6"><?php echo $description;?></textarea></td>
    </tr>
    
    
    <tr> 
		<th><?php echo L('allowview')?>：</th> 
		<td><input name="subject[allowview]" type="radio" value="1" <?php echo $allowview?'checked':''?>>&nbsp;<?php echo L('allow')?>&nbsp;&nbsp;<input name="subject[allowview]" type="radio" value="0" <?php echo $allowview?'':'checked'?>>&nbsp;<?php echo L('not_allow')?></td> 
	</tr>
	<tr> 
		<th><?php echo L('allowguest')?>：</th> 
		<td><input name="subject[allowguest]" type="radio" value="1" <?php echo $allowguest?'checked':''?>>&nbsp;<?php echo L('yes')?>&nbsp;&nbsp;<input name="subject[allowguest]" type="radio" value="0" <?php echo $allowguest?'':'checked'?>>&nbsp;<?php echo L('no')?></td> 
	</tr>
	<tr> 
		<th><?php echo L('credit')?>：</th> 
		<td><input type="text" name="subject[credit]" value="<?php echo $credit;?>" size='5' /></td> 
	</tr>
	<tr> 
		<th><?php echo L('interval')?>：</th> 
		<td><input type="text" name="subject[interval]" value="<?php echo $interval;?>" size='5' /> <?php echo L('more_ip')?>，<font color=red>0</font> <?php echo L('one_ip')?></td> 
	</tr>
	
	<tr>
		<th><?php echo L('vote_style')?>：</th>
		<td>
		<?php echo form::select($template_list, $info['default_style'], 'name="vote_subject[style]" id="style" onchange="load_file_list(this.value)"', L('please_select'))?>
		<script type="text/javascript">$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style=<?php echo $info['default_style']?>&module=vote&templates=vote_tp&id=<?php echo $template?>&name=vote_subject&pc_hash='+pc_hash, function(data){$('#show_template').html(data.vote_tp_template);});</script>
		</td>
	</tr>
	
	<tr>
		<th><?php echo L('template')?>：</th>
		<td id="show_template">
		<?php echo form::select_template('default', 'vote', $template, 'name="vote_subject[show_template]"', 'vote_tp');?>
		</td>
	</tr>
	
	<tr> 
		<th><?php echo L('enabled')?>：</th> 
		<td><input name="subject[enabled]" type="radio" value="1" <?php echo $enabled?'checked':''?>>&nbsp;<?php echo L('yes')?>&nbsp;&nbsp;<input name="subject[enabled]" type="radio" value="0" <?php echo $enabled?'':'checked'?>>&nbsp;<?php echo L('no')?></td> 
	</tr>
	<tr> 
		<th></th> 
		<td> 
		<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> "> 
		</td> 
	</tr>
	
</table> 
</form>
</div>
</body>
</html>
<script language="javascript" type="text/javascript">
function AdsType(adstype) {
	$('#SizeFormat').css('display', 'none');
	if(adstype=='0') {
		
	} else if(adstype=='1') {
		$('#SizeFormat').css('display', '');
	}
}
$('#AlignBox').click( function (){
	if($('#AlignBox').attr('checked')) {
		$('#PaddingLeft').attr('disabled', true);
		$('#PaddingTop').attr('disabled', true);
	} else {
		$('#PaddingLeft').attr('disabled', false);
		$('#PaddingTop').attr('disabled', false);
	}
}); 
</script>
               
<script language="javascript">
var i = 1;
function add_option() {
	//var i = 1;
	var htmloptions = '';
	htmloptions += '<div id='+i+'><span ><br><input type="text" name="newoption[]" size="40" msg="<?php echo L('must_input')?>" value="" class="input-text"/><input type="button" value="<?php echo L('del')?>"  onclick="del('+i+')" class="button"/></span><font color="#FF0000"> *</font><br> </div>';
	$(htmloptions).appendTo('#new_option'); 
	var htmloptions = '';
	i = i+1;
}
function del(o){
 $("div [id=\'"+o+"\']").remove();	
}
function del_old2(o){
	 $("div [id=\'"+o+"\']").remove();	
}

function del_old(id) {
	$.get('?m=vote&c=vote&a=del_option&optionid='+id+'&pc_hash='+pc_hash,null,function (msg) { 
	if (msg==1) { 
	$("div [id=\'option"+id+"\']").remove(); 
	} else {
	alert(msg); 
	} 
	}); 
} 

function load_file_list(id) {
	$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&module=vote&templates=vote_tp&name=subject&pc_hash='+pc_hash, function(data){$('#show_template').html(data.vote_tp_template);});
}

</script>