<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<form name="myform" action="?m=admin&c=position&a=public_item" method="post">
<input type="hidden" value="<?php echo $posid?>" name="posid">
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%"  align="left"><input type="checkbox" value="" id="check_box" onclick="selectall('items[]');"></th>
            <th width="10%"  align="left"><?php echo L('listorder');?></th>
            <th width="10%"  align="left">ID</th>
            <th width=""  align="left"><?php echo L('title');?></th>
            <th width="15%"><?php echo L('catname');?></th>
            <th width="15%"><?php echo L('inputtime')?></th>
            <th width="15%"><?php echo L('posid_operation');?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td width="10%">
	<input type="checkbox" name="items[]" value="<?php echo $info['id'],'-',$info['modelid']?>" id="items" boxid="items">
	</td>	
	<td width="10%">
	<input name='listorders[<?php echo $info['catid'],'-',$info['id']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c">
	</td>	
	<td width="10%"  align="left"><?php echo $info['id']?></td>
	<td width=""  align="left"><?php echo $info['title']?> <?php if($info['thumb']!='') {echo '<img src="'.IMG_PATH.'icon/small_img.gif">'; }?></td>
	<td  width="15%" align="center"><?php echo $info['catname']?></td>
	<td width="15%" align="center"><?php echo date('Y-m-d H:i:s',$info['inputtime'])?></td>
	<td width="15%" align="center"><a href="<?php echo $info['url']?>" target="_blank"><?php echo L('posid_item_view')?></a> | <a onclick="javascript:openwinx('?m=content&c=content&a=edit&catid=<?php echo $info['catid']?>&id=<?php echo $info['id']?>','')" href="javascript:;"><?php echo L('posid_item_edit');?></a> | <a href="javascript:item_manage(<?php echo $info['id']?>,<?php echo $info['posid']?>, <?php echo $info['modelid']?>,'<?php echo $info['title']?>')"><?php echo L('posid_item_manage')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="button" class="button" value="<?php echo L('listorder')?>" onclick="myform.action='?m=admin&c=position&a=public_item_listorder';myform.submit();"/> <input type="submit" class="button" name="dosubmit" value="<?php echo L('posid_item_remove')?>" /> </div></div>

 <div id="pages"> <?php echo $pages?></div>
</div>
</div>
</form>
</body>
</html>
<script type="text/javascript">
	function item_manage(id,posid, modelid, name) {
	window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?m=admin&c=position&a=public_item_manage&id='+id+'&posid='+posid+'&modelid='+modelid ,width:'550px',height:'430px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
</script>