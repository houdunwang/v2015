<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('formguide');?>--<?php if ($formid) echo $r['name']; else echo L('public')?><?php echo L('field_manage');?></h2>
<div class="content-menu ib-a blue line-x"><a class="add fb" href="?m=formguide&c=formguide_field&a=add&formid=<?php echo $formid?>&menuid=<?php echo $_GET['menuid']?>"><em><?php echo L('add_field');?></em></a>
　<a class="on" href="?m=formguide&c=formguide_field&a=init&formid=<?php echo $formid?>"><em><?php echo L('manage_field');?></em></a><?php if ($formid) {?><span>|</span><a href="?m=formguide&c=formguide&a=public_preview&formid=<?php echo $formid?>&menuid=<?php echo $_GET['menuid']?>"><em><?php echo L('priview_modelfield');?></em></a><?php }?>
</div></div>
<div class="pad-lr-10">
<form name="myform" action="?m=formguide&c=formguide_field&a=listorder&formid=<?php echo $formid?>" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
			 <th width="70"><?php echo L('listorder')?></th>
            <th width="90"><?php echo L('fieldname')?></th>
			<th width="100"><?php echo L('cnames');?></th>
			<th width="100"><?php echo L('type');?></th>
			<th width="50"><?php echo L('system');?></th> 
            <th width="50"><?php echo L('must_input');?></th>
            <th width="50"><?php echo L('search');?></th>
            <th width="50"><?php echo L('listorder');?></th>
            <th width="50"><?php echo L('contribute');?></th>
			<th ><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody class="td-line">
	<?php
	foreach($datas as $r) {
		$tablename = L($r['tablename']);
	?>
    <tr>
		<td align='center' width='70'><input name='listorders[<?php echo $r['fieldid'] ? $r['fieldid'] : $r['field']?>]' type='text' size='3' value='<?php echo $r['listorder']?>' class='input-text-c'></td>
		<td width='90'><?php echo $r['field']?></td>
		<td width="100"><?php echo $r['name']?></td>
		<td width="100" align='center'><?php echo $r['formtype']?></td>
		<td width="50" align='center'><?php echo $r['issystem'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td width="50" align='center'><?php echo $r['minlength'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td width="50" align='center'><?php echo $r['issearch'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td width="50" align='center'><?php echo $r['isorder'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td width="50" align='center'><?php echo $r['isadd'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align='center'> <a href="?m=formguide&c=formguide_field&a=edit&formid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&field=<?php echo $r['field']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('edit');?></a> | 
		<?php if ($formid) { if(!in_array($r['field'],$forbid_fields)) { ?>
		<a href="?m=formguide&c=formguide_field&a=disabled&disabled=<?php echo $r['disabled'];?>&modelid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&fieldid=<?php echo $r['fieldid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo $r['disabled'] ? L('field_enabled') : L('field_disabled');?></a>
		<?php } else { ?><font color="#BEBEBE"> <?php echo L('field_disabled');?> </font><?php } ?>|<?php } ?> 
		<a href="javascript:confirmurl('?m=formguide&c=formguide_field&a=delete&formid=<?php echo $r['modelid']?>&fieldid=<?php echo $r['fieldid']?>&field=<?php echo $r['field']?>&menuid=<?php echo $_GET['menuid']?>','<?php echo L('confirm',array('message'=>$r['name']))?>')"><?php echo L('delete')?></a>  </td>
	</tr>
	<?php } ?>
    </tbody>
    </table>
   <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder');?>" /></div></div>
</form>
</div>
</body>
</html>