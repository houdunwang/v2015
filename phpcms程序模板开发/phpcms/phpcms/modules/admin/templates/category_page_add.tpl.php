<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript"> 
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#catname").formValidator({onshow:"<?php echo L('input_catname');?>",onfocus:"<?php echo L('input_catname');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_catname');?>"});
		$("#catdir").formValidator({onshow:"<?php echo L('input_dirname');?>",onfocus:"<?php echo L('input_dirname');?>"}).regexValidator({regexp:"^([a-zA-Z0-9]|[_-]){0,30}$",onerror:"<?php echo L('enter_the_correct_catname');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_dirname');?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=category&a=public_check_catdir",datatype : "html",cached:false,getdata:{parentid:'parentid'},async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('catname_have_exists');?>",onwait : "<?php echo L('connecting');?>"});
	})
//-->
</script>

<form name="myform" id="myform" action="?m=admin&c=category&a=add" method="post">
<div class="pad-10">
<div class="col-tab">

<ul class="tabBut cu-li">
            <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',5,1);"><?php echo L('catgory_basic');?></li>
            <li id="tab_setting_2" onclick="SwapTab('setting','on','',5,2);"><?php echo L('catgory_createhtml');?></li>
            <li id="tab_setting_3" onclick="SwapTab('setting','on','',5,3);"><?php echo L('catgory_template');?></li>
            <li id="tab_setting_4" onclick="SwapTab('setting','on','',5,4);"><?php echo L('catgory_seo');?></li>
            <li id="tab_setting_5" onclick="SwapTab('setting','on','',5,5);"><?php echo L('catgory_private');?></li>
</ul>
<div id="div_setting_1" class="contentList pad-10">

<table width="100%" class="table_form ">
<tr>
     <th><?php echo L('add_category_types');?>：</th>
      <td>
	  <input type='radio' name='addtype' value='0' checked id="normal_addid"> <?php echo L('normal_add');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='addtype' value='1'  onclick="$('#catdir_tr').html(' ');$('#normal_add').html(' ');$('#normal_add').css('display','none');$('#batch_add').css('display','');$('#normal_addid').attr('disabled','true');this.disabled='true'"> <?php echo L('batch_add');?></td>
    </tr>
      <tr>
        <th width="200"><?php echo L('parent_category')?>：</th>
        <td>
		<?php echo form::select_category('category_content_'.$this->siteid,$parentid,'name="info[parentid]" id="parentid"',L('please_select_parent_category'),0,-1);?>
		</td>
      </tr>
     <tr>
        <th><?php echo L('catname')?>：</th>
        <td>
        <span id="normal_add"><input type="text" name="info[catname]" id="catname" class="input-text" value=""></span>
        <span id="batch_add" style="display:none"> 
        <table width="100%" class="sss"><tr><td width="310"><textarea name="batch_add" maxlength="255" style="width:300px;height:60px;"></textarea></td>
        <td align="left">
        <?php echo L('batch_add_tips');?>
 </td></tr></table>
        </span>
		</td>
      </tr>
	<tr id="catdir_tr">
        <th><?php echo L('catdir')?>：</th>
        <td><input type="text" name="info[catdir]" id="catdir" class="input-text" value=""></td>
      </tr>
	<tr>
        <th><?php echo L('catgory_img')?>：</th>
        <td><?php echo form::images('info[image]', 'image', $image, 'content');?></td>
      </tr>
	<tr>
        <th><?php echo L('description')?>：</th>
        <td>
		<textarea name="info[description]" maxlength="255" style="width:300px;height:60px;"><?php echo $description;?></textarea>
		</td>
      </tr>
<tr>
     <th><?php echo L('ismenu');?>：</th>
      <td>
	  <input type='radio' name='info[ismenu]' value='1' checked> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='info[ismenu]' value='0'  > <?php echo L('no');?></td>
    </tr>
</table>

</div>
<div id="div_setting_2" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
		<tr>
      <th width="200"><?php echo L('html_category');?>：</th>
      <td>
	  <input type='radio' name='setting[ishtml]' value='1' <?php if($setting['ishtml']) echo 'checked';?> onClick="$('#category_php_ruleid').css('display','none');$('#category_html_ruleid').css('display','')"> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0' <?php if(!$setting['ishtml']) echo 'checked';?>  onClick="$('#category_php_ruleid').css('display','');$('#category_html_ruleid').css('display','none')"> <?php echo L('no');?>
	  </td>
    </tr>
	
	<tr>
      <th><?php echo L('urlrule_url');?>：</th>
      <td><div id="category_php_ruleid" style="display:<?php if($setting['ishtml']) echo 'none';?>">
	<?php
		echo form::urlrule('content','category',0,$setting['category_ruleid'],'name="category_php_ruleid"');
	?>
	</div>
	<div id="category_html_ruleid" style="display:<?php if(!$setting['ishtml']) echo 'none';?>">
	<?php
		echo form::urlrule('content','category',1,$setting['category_ruleid'],'name="category_html_ruleid"');
	?>
	</div>
	</td>
    </tr>
</table>
</div>
<div id="div_setting_3" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
<tr>
  <th width="200"><?php echo L('available_styles');?>：</th>
        <td>
		<?php echo form::select($template_list, $setting['template_list'], 'name="setting[template_list]" id="template_list" onchange="load_file_list(this.value)"', L('please_select'))?> 
		</td>
</tr>
		<tr>
        <th width="200"><?php echo L('page_templates')?>：</th>
        <td  id="page_template">
		</td>
      </tr>
</table>
</div>
<div id="div_setting_4" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
	<tr>
      <th width="200"><?php echo L('meta_title');?></th>
      <td><input name='setting[meta_title]' type='text' id='meta_title' value='<?php echo $setting['meta_title'];?>' size='60' maxlength='60'></td>
    </tr>
    <tr>
      <th ><?php echo L('meta_keywords');?></th>
      <td><textarea name='setting[meta_keywords]' id='meta_keywords' style="width:90%;height:40px"><?php echo $setting['meta_keywords'];?></textarea></td>
    </tr>
    <tr>
      <th ><strong><?php echo L('meta_description');?></th>
      <td><textarea name='setting[meta_description]' id='meta_description' style="width:90%;height:50px"><?php echo $setting['meta_description'];?></textarea></td>
    </tr>
</table>
</div>
<div id="div_setting_5" class="contentList pad-10 hidden">
<table width="100%" >
		<tr>
        <th width="200"><?php echo L('role_private')?>：</th>
        <td>
			<table width="100%" class="table-list">
			  <thead>
				<tr>
				  <th align="left" width="200"><?php echo L('role_name');?></th><th><?php echo L('edit');?></th>
			  </tr>
			    </thead>
				 <tbody>
				<?php
				$roles = getcache('role','commons');
				foreach($roles as $roleid=> $rolrname) {
				$disabled = $roleid==1 ? 'disabled' : '';
				?>
		  		<tr>
				  <td><?php echo $rolrname?></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="init,<?php echo $roleid;?>" ></td>
			  </tr>
			  <?php }?>
	
			 </tbody>
			</table>
		</td>

      </tr>
		<tr><td colspan=2><hr style="border:1px dotted #F2F2F2;"></td>
		</tr>

	  <tr>
        <th width="200"><?php echo L('group_private')?>：</th>
        <td>
			<table width="100%" class="table-list">
			  <thead>
				<tr>
				  <th align="left" width="200"><?php echo L('group_name');?></th><th><?php echo L('allow_vistor');?></th>
			  </tr>
			    </thead>
				 <tbody>
			<?php
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
			if($_value['groupid']==1) continue;
			?>
		  		<tr>
				  <td><?php echo $_value['name'];?></td>
				  <td align="center"><input type="checkbox" name="priv_groupid[]" value="visit,<?php echo $_value['groupid'];?>" ></td>
			  </tr>
			<?php }?>
			 </tbody>
			</table>
		</td>
      </tr>
</table>
</div>

 <div class="bk15"></div>
	<input name="catid" type="hidden" value="<?php echo $catid;?>">
	<input name="type" type="hidden" value="<?php echo $type;?>">
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">

</form>
</div>

</div>
<!--table_form_off-->
</div>

<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
	function SwapTab(name,cls_show,cls_hide,cnt,cur){
		for(i=1;i<=cnt;i++){
			if(i==cur){
				 $('#div_'+name+'_'+i).show();
				 $('#tab_'+name+'_'+i).attr('class',cls_show);
			}else{
				 $('#div_'+name+'_'+i).hide();
				 $('#tab_'+name+'_'+i).attr('class',cls_hide);
			}
		}
	}
	function load_file_list(id) {
		if(id=='') return false;
		$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&catid=<?php echo $parentid?>&type=1', function(data){$('#page_template').html(data.page_template);});
	}
	<?php if(isset($setting['template_list']) && !empty($setting['template_list'])) echo "load_file_list('".$setting['template_list']."')"?>
//-->
</script>