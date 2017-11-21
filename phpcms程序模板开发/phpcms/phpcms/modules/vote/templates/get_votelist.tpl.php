<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th><?php echo L('title')?></th>
			<th width="14%" align="center"><?php echo L('startdate')?></th>
			<th width="14%" align="center"><?php echo L('enddate')?></th>
			<th width='20%' align="center"><?php echo L('inputtime')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr onclick="return_id(<?php echo $info['subjectid'];?>, '<?php echo addslashes($info['subject'])?>')" style="cursor:hand" title="<?php echo L('check_select')?>">
		<td><?php if($target=='dialog') {?><input type='radio' id="voteid_<?php echo $info['subjectid']?>" name="subjectid"><?php } echo $info['subject']?></td>
		<td ><?php echo $info['fromdate'];?></td>
		<td ><?php echo $info['todate'];?></td>
		<td ><?php echo date("Y-m-d h-i",$info['addtime']);?></td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
<input type="hidden" name="msg_id" id="msg_id">
<div id="pages"><?php echo $this->pages?></div>
</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function return_id(voteid, title) {
	<?php if ($target=='dialog') {?>
	$('#voteid_'+voteid).attr('checked', 'true');
	$('#msg_id').val('vote|'+voteid+'|'+title);
	<?php }?>
	window.top.$('#voteid').val(voteid);<?php if(!$target) {?>window.top.art.dialog({id:'selectid'}).close(); <?php }?>
}
//-->
</SCRIPT>
</body>
</html>
