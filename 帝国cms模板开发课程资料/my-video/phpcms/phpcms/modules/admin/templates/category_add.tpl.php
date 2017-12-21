<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript"> 
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#modelid").formValidator({onshow:"<?php echo L('select_model');?>",onfocus:"<?php echo L('select_model');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('select_model');?>"});
		$("#catname").formValidator({onshow:"<?php echo L('input_catname');?>",onfocus:"<?php echo L('input_catname');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_catname');?>"});
		$("#catdir").formValidator({onshow:"<?php echo L('input_dirname');?>",onfocus:"<?php echo L('input_dirname');?>"}).regexValidator({regexp:"^([a-zA-Z0-9、-]|[_]){0,30}$",onerror:"<?php echo L('enter_the_correct_catname');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_dirname');?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=category&a=public_check_catdir",datatype : "html",cached:false,getdata:{parentid:'parentid'},async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('catname_have_exists');?>",onwait : "<?php echo L('connecting');?>"});
		$("#url").formValidator({onshow:" ",onfocus:"<?php echo L('domain_name_format');?>",tipcss:{width:'300px'},empty:true}).inputValidator({onerror:"<?php echo L('domain_name_format');?>"}).regexValidator({regexp:"http:\/\/(.+)\/$",onerror:"<?php echo L('domain_end_string');?>"});
		$("#template_list").formValidator({onshow:"<?php echo L('template_setting');?>",onfocus:"<?php echo L('template_setting');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('template_setting');?>"});
	})
//-->
</script>

<form name="myform" id="myform" action="?m=admin&c=category&a=add" method="post">
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',6,1);"><?php echo L('catgory_basic');?></li>
<li id="tab_setting_2" onclick="SwapTab('setting','on','',6,2);"><?php echo L('catgory_createhtml');?></li>
<li id="tab_setting_3" onclick="SwapTab('setting','on','',6,3);"><?php echo L('catgory_template');?></li>
<li id="tab_setting_4" onclick="SwapTab('setting','on','',6,4);"><?php echo L('catgory_seo');?></li>
<li id="tab_setting_5" onclick="SwapTab('setting','on','',6,5);"><?php echo L('catgory_private');?></li>
<li id="tab_setting_6" onclick="SwapTab('setting','on','',6,6);"><?php echo L('catgory_readpoint');?></li>
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
        <th width="200"><?php echo L('select_model')?>：</th>
        <td>
		 <?php
			$model_datas = array();
			foreach($models as $_k=>$_v) {
				if($_v['siteid']!=$this->siteid) continue;
				$model_datas[$_v['modelid']] = $_v['name'];
			}
			echo form::select($model_datas,$modelid,'name="info[modelid]" id="modelid" onchange="change_tpl(this.value)"',L('select_model'));
		?>
		</td>
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
      <th><?php echo L('workflow');?>：</th>
      <td>
	  <?php
		$workflows = getcache('workflow_'.$this->siteid,'commons');
		if($workflows) {
			$workflows_datas = array();
			foreach($workflows as $_k=>$_v) {
				$workflows_datas[$_v['workflowid']] = $_v['workname'];
			}
			echo form::select($workflows_datas,'','name="setting[workflowid]"',L('catgory_not_need_check'));
		} else {
			echo '<input type="hidden" name="setting[workflowid]" value="">';
			echo L('add_workflow_tips');
		}
	?>
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
	  <input type='radio' name='setting[ishtml]' value='1' <?php if($setting['ishtml']) echo 'checked';?> onClick="$('#category_php_ruleid').css('display','none');$('#category_html_ruleid').css('display','');$('#tr_domain').css('display','');"> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0' <?php if(!$setting['ishtml']) echo 'checked';?>  onClick="$('#category_php_ruleid').css('display','');$('#category_html_ruleid').css('display','none');$('#tr_domain').css('display','none');"> <?php echo L('no');?>
	  </td>
    </tr>
	<tr>
      <th><?php echo L('html_show');?>：</th>
      <td>
	  <input type='radio' name='setting[content_ishtml]' value='1' <?php if($setting['content_ishtml']) echo 'checked';?> onClick="$('#show_php_ruleid').css('display','none');$('#show_html_ruleid').css('display','')"> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[content_ishtml]' value='0' <?php if(!$setting['content_ishtml']) echo 'checked';?>  onClick="$('#show_php_ruleid').css('display','');$('#show_html_ruleid').css('display','none')"> <?php echo L('no');?>
	  </td>
    </tr>
	<tr>
      <th><?php echo L('category_urlrules');?>：</th>
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
	
	<tr>
      <th><?php echo L('show_urlrules');?>：</th>
      <td><div id="show_php_ruleid" style="display:<?php if($setting['content_ishtml']) echo 'none';?>">
	  <?php
		echo form::urlrule('content','show',0,$setting['category_ruleid'],'name="show_php_ruleid"');
	?>
	</div>
	<div id="show_html_ruleid" style="display:<?php if(!$setting['content_ishtml']) echo 'none';?>">
	  <?php	
		echo form::urlrule('content','show',1,$setting['category_ruleid'],'name="show_html_ruleid"');
	?>
	</div>
	</td>
    </tr>
<tr>
      <th><?php echo L('create_to_rootdir');?>：</th>
      <td>
	  <input type='radio' name='setting[create_to_html_root]' value='1' <?php if($setting['create_to_html_root']) echo 'checked';?> > <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[create_to_html_root]' value='0' <?php if(!$setting['create_to_html_root']) echo 'checked';?> > <?php echo L('no');?>
	  （<?php echo L('create_to_rootdir_tips');?>）</td>
    </tr>
    <tr id="tr_domain" style="display:<?php if(!$setting['ishtml']) echo 'none';?>">
        <th><?php echo L('domain')?>：</th>
        <td><input type="text" name="info[url]" id="url" class="input-text" size="50" value=""></td>
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
        <th width="200"><?php echo L('category_index_tpl')?>：</th>
        <td  id="category_template">
		</td>
      </tr>
	  <tr>
        <th width="200"><?php echo L('category_list_tpl')?>：</th>
        <td  id="list_template">
		</td>
      </tr>
	  <tr>
        <th width="200"><?php echo L('content_tpl')?>：</th>
        <td  id="show_template">
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
				  <th align="left"><?php echo L('role_name');?></th><th><?php echo L('view');?></th><th><?php echo L('add');?></th><th><?php echo L('edit');?></th><th><?php echo L('delete');?></th><th><?php echo L('listorder');?></th><th><?php echo L('push');?></th><th><?php echo L('move');?></th>
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
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="add,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="edit,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="delete,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="listorder,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="push,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="move,<?php echo $roleid;?>" ></td>
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
				  <th align="left"><?php echo L('group_name');?></th><th><?php echo L('allow_vistor');?></th><th><?php echo L('allow_contribute');?></th>
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
				  <td align="center"><input type="checkbox" name="priv_groupid[]" value="add,<?php echo $_value['groupid'];?>" ></td>
			  </tr>
			<?php }?>
			 </tbody>
			</table>
		</td>
      </tr>
</table>
</div>
<div id="div_setting_6" class="contentList pad-10 hidden">
<table width="100%" class="table_form">
<tr>
      <th width="200"><?php echo L('contribute_add_point');?></th>
      <td><input name='setting[presentpoint]' type='text' value='1' size='5' maxlength='5' style='text-align:center'> <?php echo L('contribute_add_point_tips');?></td>
</tr>
<tr>
      <th ><?php echo L('default_readpoint');?></th>
      <td><input name='setting[defaultchargepoint]' type='text' value='0' size='4' maxlength='4' style='text-align:center'> <select name="setting[paytype]"><option value="0"><?php echo L('readpoint');?></option><option value="1"><?php echo L('money');?></option></select> <?php echo L('readpoint_tips');?></td>
    </tr>
    <tr>
      <th><?php echo L('repeatchargedays');?></th>
      <td>
	    <input name='setting[repeatchargedays]' type='text' value='1' size='4' maxlength='4' style='text-align:center'> <?php echo L('repeat_tips');?>&nbsp;&nbsp;
        <font color="red"><?php echo L('repeat_tips2');?></font></td>
    </tr>
</table>   
</div>
 <div class="bk15"></div>
	<input name="catid" type="hidden" value="<?php echo $catid;?>">
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
	function change_tpl(modelid) {
		if(modelid) {
			$.getJSON('?m=admin&c=category&a=public_change_tpl&modelid='+modelid, function(data){$('#template_list').val(data.template_list);$('#category_template').html(data.category_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
		}
	}
	function load_file_list(id) {
		if(id=='') return false;
		$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&catid=<?php echo $parentid?>', function(data){$('#category_template').html(data.category_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
	}
	<?php if($modelid) echo "change_tpl($modelid)";?>
//-->
</script>