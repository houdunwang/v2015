<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<style type="text/css">
.table-list td b{color:#666}
.tpl_style{background-color:#FBFAE3}

</style>
<form name="myform" action="?m=admin&c=category&a=batch_edit" method="post">
<div class="pad_10">
<div class="explain-col">
<?php echo L('category_batch_tips');?></a>
</div>
<div class="bk10"></div>
<div id="table-lists" class="table-list" >
    <table height="auto" cellspacing="0" >
        <thead >
		<?php
		foreach($batch_array as $catid=>$cat) {
			$batch_array[$catid]['setting'] = string2array($cat['setting']);
			echo "<th width='260' align='left' ><strong>{$cat[catname]} （catid: <font color='red'>{$catid}</font>）</strong></th>";
		}
		?>
        </thead>
    <tbody>
     <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('catname')?>：</b><br><input type='text' name='info[<?php echo $catid;?>][catname]' id='catname' class='input-text' value='<?php echo $cat['catname']?>' style='width:250px'></td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('catdir')?>：</b><br><input type='text' name='info[<?php echo $catid;?>][catdir]' id='catname' class='input-text' value='<?php echo $cat['catdir']?>' style='width:250px'></td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('catgory_img')?>：</b><br><?php echo form::images('info['.$catid.'][image]', 'image'.$catid, $cat['image'], 'content','',23);?></td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('description')?>：</b><br><textarea name="info[<?php echo $catid;?>][description]" maxlength="255" style="width:240px;height:40px;"><?php echo $cat['description'];?></textarea></td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td class="tpl_style"><b><?php echo L('available_styles')?>：</b><br>
		<?php echo form::select($template_list, $cat['setting']['template_list'], 'name="setting['.$catid.'][template_list]" id="template_list" onchange="load_file_list(this.value,'.$catid.')"', L('please_select'))?> 
		</td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td class="tpl_style"><b><?php echo L('category_index_tpl')?>：</b><br>
		<div id="category_template<?php echo $catid;?>">
		<?php echo form::select_template($cat['setting']['template_list'], 'content',$cat['setting']['category_template'],'name="setting['.$catid.'][category_template]" style="width:250px"','category');?>
		</div>
		</td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td class="tpl_style"><b><?php echo L('category_list_tpl')?>：</b><br>
		<div id="list_template<?php echo $catid;?>">
		<?php echo form::select_template($cat['setting']['template_list'], 'content',$cat['setting']['list_template'],'name="setting['.$catid.'][list_template]" style="width:250px"','list');?>
		</div>
		</td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td class="tpl_style"><b><?php echo L('content_tpl')?>：</b><br>
		<div id="show_template<?php echo $catid;?>">
		<?php echo form::select_template($cat['setting']['template_list'], 'content',$cat['setting']['show_template'],'name="setting['.$catid.'][show_template]" style="width:250px"','show');?>
		</div>
		</td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('workflow')?>：</b><br><?php echo form::select($workflows_datas,$cat['setting']['workflowid'],'name="setting['.$catid.'][workflowid]"',L('catgory_not_need_check'));?></td>
	<?php
		}
	?>
	 </tr>
	<tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('ismenu')?>：</b><br>
		<input boxid="ismenu" type='radio' name='info[<?php echo $catid;?>][ismenu]' value='1' <?php if($cat['ismenu']) echo 'checked';?> onclick="change_radio(event,'ismenu',1)"> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
		<input boxid="ismenu" type='radio' name='info[<?php echo $catid;?>][ismenu]' value='0' <?php if(!$cat['ismenu']) echo 'checked';?> onclick="change_radio(event,'ismenu',0)"> <?php echo L('no');?>
	  </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('html_category')?>：</b><br>
		<input boxid="ishtml" catid="<?php echo $catid;?>" type='radio' name='setting[<?php echo $catid;?>][ishtml]' value='1' <?php if($cat['setting']['ishtml']) echo 'checked';?> onClick="change_radio(event,'ishtml',1,'category');urlrule('category',1,<?php echo $catid;?>)"> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input boxid="ishtml"  catid="<?php echo $catid;?>" type='radio' name='setting[<?php echo $catid;?>][ishtml]' value='0' <?php if(!$cat['setting']['ishtml']) echo 'checked';?>  onClick="change_radio(event,'ishtml',0,'category');urlrule('category',0,<?php echo $catid;?>)"> <?php echo L('no');?>
	  </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('html_show')?>：</b><br>
		<input boxid="content_ishtml" catid="<?php echo $catid;?>" type='radio' name='setting[<?php echo $catid;?>][content_ishtml]' value='1' <?php if($cat['setting']['content_ishtml']) echo 'checked';?> onClick="change_radio(event,'content_ishtml',1,'show');urlrule('show',1,<?php echo $catid;?>)"> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input boxid="content_ishtml" catid="<?php echo $catid;?>" type='radio' name='setting[<?php echo $catid;?>][content_ishtml]' value='0' <?php if(!$cat['setting']['content_ishtml']) echo 'checked';?>  onClick="change_radio(event,'content_ishtml',0,'show');urlrule('show',0,<?php echo $catid;?>)"> <?php echo L('no');?>
	  </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('category_urlrules')?>：</b><br>
		<div id="category_php_ruleid<?php echo $catid;?>" style="display:<?php if($cat['setting']['ishtml']) echo 'none';?>">
	<?php
		echo form::urlrule('content','category',0,$cat['setting']['category_ruleid'],'name="category_php_ruleid['.$catid.']" style="width:250px;"');
	?>
	</div>
	<div id="category_html_ruleid<?php echo $catid;?>" style="display:<?php if(!$cat['setting']['ishtml']) echo 'none';?>">
	<?php
		echo form::urlrule('content','category',1,$cat['setting']['category_ruleid'],'name="category_html_ruleid['.$catid.']" style="width:250px;"');
	?>
	</div>
	  </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('show_urlrules')?>：</b><br>
		<div id="show_php_ruleid<?php echo $catid;?>" style="display:<?php if($cat['setting']['content_ishtml']) echo 'none';?>">
	  <?php
		echo form::urlrule('content','show',0,$cat['setting']['show_ruleid'],'name="show_php_ruleid['.$catid.']" style="width:250px;"');
	?>
	</div>
	<div id="show_html_ruleid<?php echo $catid;?>" style="display:<?php if(!$cat['setting']['content_ishtml']) echo 'none';?>">
	  <?php	
		echo form::urlrule('content','show',1,$cat['setting']['show_ruleid'],'name="show_html_ruleid['.$catid.']" style="width:250px;"');
	?>
	</div>
	  </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('create_to_rootdir')?>：</b><br>
		<input boxid="create_to_html_root" onclick="change_radio(event,'create_to_html_root',1)" type='radio' name='setting[<?php echo $catid;?>][create_to_html_root]' value='1' <?php if($cat['setting']['create_to_html_root']) echo 'checked';?> > <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input boxid="create_to_html_root" onclick="change_radio(event,'create_to_html_root',0)" type='radio' name='setting[<?php echo $catid;?>][create_to_html_root]' value='0' <?php if(!$cat['setting']['create_to_html_root']) echo 'checked';?> > <?php echo L('no');?>
	  </td>
	<?php
		}
	?>
	 </tr>
	 
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('meta_title')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][meta_title]' type='text' value='<?php echo $cat['setting']['meta_title'];?>' style='width:250px'>
		  </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('meta_keywords')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][meta_keywords]' type='text' value='<?php echo $cat['setting']['meta_keywords'];?>' style='width:250px'>
		  </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('meta_description')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][meta_description]' type='text' value='<?php echo $cat['setting']['meta_description'];?>' style='width:250px'>
		  </td>
	<?php
		}
	?>
	 </tr>
	<tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('contribute_add_point')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][presentpoint]' type='text' value='<?php echo $cat['setting']['presentpoint'];?>' style='width:100px' maxlength='60'>
		 <?php echo L('point');?> </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('default_readpoint')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][defaultchargepoint]' type='text' value='<?php echo $cat['setting']['defaultchargepoint'];?>' style='width:100px' maxlength='60'>
		<select name="setting[<?php echo $catid;?>][paytype]"><option value="0" <?php if(!$cat['setting']['paytype']) echo 'selected';?>><?php echo L('readpoint');?></option><option value="1" <?php if($cat['setting']['paytype']) echo 'selected';?>><?php echo L('money');?></option></select>   </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('repeatchargedays')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][repeatchargedays]' type='text' value='<?php echo $cat['setting']['repeatchargedays'];?>' style='width:100px' maxlength='60'><?php echo L('repeat_tips');?>
		  </td>
	<?php
		}
	?>
	 </tr>
    </tbody>
    </table>
    <div class="btn">
	<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
	<input type="hidden" name="type" value="<?php echo $type;?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" /></div>
	<BR><BR>
</div>
</div>
</div>
</form>
 
<script language="JavaScript">
<!--
$(document).keydown(function(event) {
	   if(event.keyCode==37) {
		   window.scrollBy(-100,0);
	   } else if(event.keyCode==39) {
		  window.scrollBy(100,0);
	   }
	});

function change_radio(oEvent,boxid,value,type) {
	altKey = oEvent.altKey;
	if(altKey) {
		var obj = $("input[boxid="+boxid+"][value="+value+"]");
		obj.attr('checked',true);
		if(type){
			obj.each(function(){	
				urlrule(type,value,$(this).attr('catid'));			
			})
		}
	}	
}

window.top.$('#display_center_id').css('display','none');
function urlrule(type,html,catid) {
	if(type=='category') {
		if(html) {
			$('#category_php_ruleid'+catid).css('display','none');$('#category_html_ruleid'+catid).css('display','');
		} else {
			$('#category_php_ruleid'+catid).css('display','');$('#category_html_ruleid'+catid).css('display','none');;
		}
	} else {
		if(html) {
			$('#show_php_ruleid'+catid).css('display','none');$('#show_html_ruleid'+catid).css('display','');
		} else {
			$('#show_php_ruleid'+catid).css('display','');$('#show_html_ruleid'+catid).css('display','none');;
		}
	}	
}
function load_file_list(id,catid) {
	if(id=='') return false;
	$.getJSON('?m=admin&c=category&a=public_tpl_file_list&batch_str=1&style='+id+'&catid='+catid, function(data){
	if(data==null) return false;
	$('#category_template'+catid).html(data.category_template);$('#list_template'+catid).html(data.list_template);$('#show_template'+catid).html(data.show_template);});
}
//-->
</script>
</body>
</html>
