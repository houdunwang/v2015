<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-lr-10">
<form name="myform2" action="?m=wap&c=wap_admin&a=type_manage&siteid=<?php echo $siteid?>" method="post">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> <?php echo L('listorder')?> <input type="text" value="0" class="input-text" name="info[listorder]" size="5">  <?php echo L('wap_type_name')?>  <input type="text" value="" class="input-text" name="info[typename]">   <?php echo L('wap_bound_type')?>   <?php echo form::select_category('category_content_'.$siteid,$parentid,'name="info[cat]"',L('wap_type_bound'),0,0,0,$siteid);?><input type="submit" value="<?php echo L('wap_toptype_add')?>" class="button" name="dosubmit">
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<div class="table-list">
<form name="myform" action="" method="post" >
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="5%"><input type="checkbox" onclick="selectall('ids[]');" id="check_box" value=""></th>
            <th width="10%"  align="center"><?php echo L('listorder')?></th>
            <th width="10%" align='center'>TYPEID</th>
            <th width="40%" align="left"><?php echo L('wap_type_name')?></th>
            <th width="20%"><?php echo L('wap_bound_type')?></th>
            </tr>
        </thead>
    <tbody>  
<?php echo $wap_type?>
    </tbody>
    </table>

    <div class="btn">
    <input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" 
     onclick="document.myform.action='?m=wap&c=wap_admin&a=type_edit&siteid=<?php echo $siteid?>';"/>
    <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete');?>" onclick="document.myform.action='?m=wap&c=wap_admin&a=type_delete&dosubmit=1';return confirm_delete()"/>
    </div> 
</form>
 </div>
</div>
</div>
</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>
<script type="text/javascript">
	function add_tr(obj,parentid,siteid) {
		$(obj).parent().parent().after('<tr><td width="5%" align="center"></td><td width="10%" align="center"><input type="text" class="input-text" value="0" size="3" name="addorder['+parentid+']"></td><td width="10%" align="center"></td><td width="" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─ <input type="text" value="" class="input-text" name="addtype['+parentid+'][]" size="10" ></td><td width="20%" align="center" id="td_'+parentid+'"></td></tr>');
		$("#td_"+parentid).load('?m=wap&c=wap_admin&a=public_show_cat_ajx&parentid='+parentid+'&siteid='+siteid);
	};
	function confirm_delete(){
		if(confirm('<?php echo L('confirm_delete');?>')) $('#myform').submit();
	}	
</script>