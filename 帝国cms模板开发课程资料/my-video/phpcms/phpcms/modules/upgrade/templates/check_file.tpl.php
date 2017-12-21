<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<div class="table-list">

<div class="explain-col">
<?php echo L('check_file_notice');?>
</div>
<div class="bk15"></div>

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left"><?php echo L('modifyedfile')?></th>
			<th align="left"><?php echo L('lostfile')?></th>
			<th align="left"><?php echo L('unknowfile')?></th>
		</tr>
	</thead>
<tbody>
    <tr>
		<td align="left"><?php echo count($diff);?></td>
		<td align="left"><?php echo count($lostfile);?></td>
		<td align="left"><?php echo count($unknowfile);?></td>
    </tr>

</tbody>
</table>
<div class="bk15"></div>
<?php if(!empty($diff)) {?>
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left"><?php echo L('modifyedfile')?></th>
			<th align="left"><?php echo L('lastmodifytime')?></th>
			<th align="left"><?php echo L('filesize')?></th>
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($diff as $k=>$v) {
?>
    <tr>
		<td align="left"><?php echo base64_decode($k)?></td>
		<td align="left"><?php echo date("Y-m-d H:i:s", filemtime(base64_decode($k)))?></td>
		<td align="left"><?php echo sizecount(filesize(base64_decode($k)))?></td>
		<td align="left"><a href="javascript:void(0)" onclick="view('<?php echo base64_decode($k)?>')"><?php echo L('view')?></a> <a href="<?php echo APP_PATH,base64_decode($k);?>" target="_blank"><?php echo L('access')?></a></td>
    </tr>
<?php
	}
?>
</tbody>
</table>
<div class="bk15"></div>
<?php }?>

<?php if(!empty($unknowfile)) {?>
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left"><?php echo L('unknowfile')?></th>
			<th align="left"><?php echo L('lastmodifytime')?></th>
			<th align="left"><?php echo L('filesize')?></th>
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($unknowfile as $k=>$v) {
?>
    <tr>
		<td align="left"><?php echo base64_decode($v)?></td>
		<td align="left"><?php echo date("Y-m-d H:i:s", filectime(base64_decode($v)))?></td>
		<td align="left"><?php echo sizecount(filesize(base64_decode($v)))?></td>
		<td align="left"><a href="javascript:void(0)" onclick="view('<?php echo base64_decode($v)?>')"><?php echo L('view')?></a> <a href="<?php echo APP_PATH,base64_decode($v);?>" target="_blank"><?php echo L('access')?></a></td>
    </tr>
<?php
	}
?>
</tbody>
</table>
<div class="bk15"></div>
<?php }?>

<?php if(!empty($lostfile)) {?>
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left"><?php echo L('lostfile')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($lostfile as $k) {
?>
    <tr>
		<td align="left"><?php echo base64_decode($k)?></td>
    </tr>
<?php
	}
?>
</tbody>
</table>
<?php }?>

</div>
</div>
<script type="text/javascript">
<!--
function view(url) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('view_code')?>',id:'edit',iframe:'?m=scan&c=index&a=public_view&url='+url,width:'700',height:'500'});
}
//-->
</script>
</body>
</html>