<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<form name="myform" action="?m=member&c=member_verify&a=delete" method="post"  onsubmit="checkuid();return false;">
<div class="pad-lr-10">
<div class="table-list">

<table width="100%" cellspacing="0">
        <thead>
            <tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left"><?php echo L('username')?></th>
			<th align="left"><?php echo L('email')?></th>
			<th align="left"><?php echo L('regtime')?></th>
			<th align="left"><?php echo L('model_name')?></th>
			<th align="left"><?php echo L('verify_message')?></th>
			<th align="left"><?php echo L('verify_status')?></th>
            </tr>
        </thead>
    <tbody>
<?php
	foreach($memberlist as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['userid']?>" name="userid[]"></td>
		<td align="left"><?php echo $v['username']?></td>
		<td align="left"><?php echo $v['email']?></td>
		<td align="left" title="<?php echo $v['regip']?>"><?php echo format::date($v['regdate'], 1);?></td>
		<td align="left"><a href="javascript:member_verify(<?php echo $v['userid']?>, '<?php echo $v['modelid']?>', '')"><?php echo $member_model[$v['modelid']]['name']?><img src="<?php echo IMG_PATH?>admin_img/detail.png"></a></td>
		<td align="left"><?php echo $v['message']?></td>
		<td align="left"><?php $verify_status = array('5'=>L('nerver_pass'), '4'=>L('reject'), '3'=>L('delete'), '2'=>L('ignore'), '0'=>L('need_verify'), '1'=>L('pass')); echo $verify_status[$v['status']]?></td>
    </tr>
<?php
	}
?>
 </tbody>
</table>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label>
<input type="submit" class="button" name="dosubmit" value="<?php echo L('verify_pass')?>" onclick="document.myform.action='?m=member&c=member_verify&a=pass'"/>

<input type="submit" class="button" name="dosubmit" value="<?php echo L('reject')?>" onclick="document.myform.action='?m=member&c=member_verify&a=reject'"/>

<input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>');"/>

<input type="submit" class="button" name="dosubmit" value="<?php echo L('ignore')?>" onclick="document.myform.action='?m=member&c=member_verify&a=ignore'"/>

<?php echo L('verify_message')?>：<input type="text" name="message"><input type="checkbox" value=1 name="sendemail" checked/><?php echo L('sendemail')?>
</div> 
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</form>
<script type="text/javascript">
<!--

function checkuid() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('member')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}

function member_verify(userid, modelid, name) {
	window.top.art.dialog({id:'modelinfo'}).close();
	window.top.art.dialog({title:'<?php echo L('member_verify')?>',id:'modelinfo',iframe:'?m=member&c=member_verify&a=modelinfo&userid='+userid+'&modelid='+modelid,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'modelinfo'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'modelinfo'}).close()});
}
//-->
</script>
</body>
</html>