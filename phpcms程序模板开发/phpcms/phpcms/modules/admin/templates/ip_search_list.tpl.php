<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form name="searchform" action="?m=admin&c=ipbanned&a=search_ip&menuid=<?php echo $_GET['menuid'];?>" method="get" >
<input type="hidden" value="admin" name="m">
<input type="hidden" value="ipbanned" name="c">
<input type="hidden" value="search_ip" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col">IP:  <input type="text" value="" class="input-text" name="search[ip]">    <input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit">
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<form name="myform" id="myform" action="?m=admin&c=ipbanned&a=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
 <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('ipbannedid[]');"></th>
             <th width="30%">IP</th>
            <th ><?php echo L('deblocking_time')?></th> 
             <th width="120"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr>
    <td align="center">
	<input type="checkbox" name="ipbannedid[]" value="<?php echo $info['ipbannedid']?>">
	</td> 
        <td width="30%" align="left"><span  class="<?php echo $info['style']?>"><?php echo $info['ip']?></span> </td>
        <td align="center"><?php echo date('Y-m-d H:i', $info['expires']);?></td>
         <td align="center"><a href="javascript:confirmurl('?m=admin&c=ipbanned&a=delete&ipbannedid=<?php echo $info['ipbannedid']?>', "<?php echo L('confirm_del_ip')?>")"><?php echo L('delete')?></a> </td>
    </tr>
<?php
	}
}
?></tbody>
 </table>
 <div class="btn">
 <a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', true)"><?php echo L('selected_all')?></a>/<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', false)"><?php echo L('cancel')?></a>

<input type="submit" name="submit" class="button" value="<?php echo L('remove_all_selected')?>"  onClick="return confirm('<?php echo L('confirm', array('message' => L('selected')))?>')" /> 

</div> 
<div id="pages"><?php echo $pages?></div>

</div>

</form></div>
</body>
</html>
<script type="text/javascript">
function checkuid() {
	var ids='';
	$("input[name='ipbannedid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:"<?php echo L('before_select_operation')?>",lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
</script>
 