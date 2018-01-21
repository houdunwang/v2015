<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<table width="100%" cellspacing="0" class="table-list">
	<thead>
		<tr>
			<th width="15%" align="right"><?php echo L('selects')?></th>
			<th align="left"><?php echo L('values')?></th>
		</tr>
	</thead>
<tbody>
 <?php
if(is_array($forminfos_data)){
	foreach($forminfos_data as $key => $form){
?>   
	<tr>
		<td><?php echo $fields[$key]['name']?>:</td>
		<td><?php echo $form?></td>
		
		
		</tr>
<?php 
	}
}
?>
	</tbody>
</table>

</div>
</body>
</html>