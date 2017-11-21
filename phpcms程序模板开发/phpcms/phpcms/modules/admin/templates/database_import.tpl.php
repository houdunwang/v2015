<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
		<?php echo L('select_pdo_op')?> <?php echo form::select($pdos,$pdoname,'name="pdo_select" onchange="show_tbl(this)"',L('select_pdo'))?>
		<input type="submit" value="<?php echo L('pdo_look')?>" class="button" name="dosubmit">
		</div>
		</td>
		</tr>
    </tbody>
</table>
<div class="table-list">
<form method="post" id="myform" name="myform" >
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%"  align="left"><input type="checkbox" value="" id="check_box" onclick="selectall('filenames[]');"></th>
            <th width="15%"><?php echo L('backup_file_name')?></th>
            <th width="15%"><?php echo L('backup_file_size')?></th>
            <th width="15%"><?php echo L('backup_file_time')?></th>
            <th width="15%"><?php echo L('backup_file_number')?></th>
            <th width="15%"><?php echo L('database_op')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td width="10%">
<input type="checkbox" name="filenames[]" value="<?php echo $info['filename']?>" id="sql_phpcms" boxid="sql_phpcms">
	</td>
	<td  width="15%" align="center"><?php echo $info['filename']?></td>
	<td width="15%" align="center"><?php echo $info['filesize']?></td>
	<td width="15%" align="center"><?php echo $info['maketime']?></td>
	<td width="15%" align="center"><?php echo $info['number']?></td>
	<td width="15%" align="center">
	<a href="javascript:confirmurl('?m=admin&c=database&pdoname=<?php echo $pdoname?>&a=import&pre=<?php echo $info['pre']?>&dosubmit=1', '<?php echo L('confirm_recovery')?>')"><?php echo L('backup_import')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> 
<input type="submit" class="button" name="dosubmit" value="<?php echo L('backup_del')?>" onclick="document.myform.action='?m=admin&c=database&a=delete&pdoname=<?php echo $pdoname?>';return confirm('<?php echo L('bakup_del_confirm')?>')"/>
</div>
</form>
</div>
</div>

</body>
</html>
<script type="text/javascript">
<!--
function show_tbl(obj) {
	var pdoname = $(obj).val();
	location.href='?m=admin&c=database&a=import&pdoname='+pdoname+'&menuid='+<?php echo $_GET['menuid']?>+'&pc_hash=<?php echo $_SESSION['pc_hash']?>';
}
//-->
</script>