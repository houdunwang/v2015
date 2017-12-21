<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<form method="post" action="?m=search&c=search_admin&a=setting">
<div class="pad_10">

<div class="col-tab">
<ul class="tabBut cu-li">
            <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',2,1);"><?php echo L('basic_setting')?></li>
            <li id="tab_setting_2" onclick="SwapTab('setting','on','',2,2);"><?php echo L('sphinx_setting')?></li>
</ul>
<div id="div_setting_1" class="contentList pad-10">
<table width="100%"  class="table_form">
  <tr>
    <th width="200"><?php echo L('enable_search')?></th>
    <td class="y-bg">
    <input type='radio' name='setting[fulltextenble]' value='1' <?php if($fulltextenble == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[fulltextenble]' value='0' <?php if($fulltextenble == 0) {?>checked<?php }?>> <?php echo L('no')?></td>
  </tr> 
  <tr>
    <th width="200"><?php echo L('relationenble')?></th>
    <td class="y-bg">
    <input type='radio' name='setting[relationenble]' value='1' <?php if($relationenble == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[relationenble]' value='0' <?php if($relationenble == 0) {?>checked<?php }?>> <?php echo L('no')?>  <?php echo L('relationenble_note')?></td>
  </tr> 
  <tr>
    <th width="200"><?php echo L('suggestenable')?></th>
    <td class="y-bg">
    <input type='radio' name='setting[suggestenable]' value='1' <?php if($suggestenable == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[suggestenable]' value='0' <?php if($suggestenable == 0) {?>checked<?php }?>> <?php echo L('no')?>  <?php echo L('suggestenable_note')?></td>
	 
  </tr> 
</table>
</div>

<div id="div_setting_2" class="contentList pad-10 hidden">
	<table width="100%"  class="table_form">
  <tr>
    <th width="200"><?php echo L('sphinxenable')?></th>
    <td class="y-bg">
	<input type='radio' name='setting[sphinxenable]' value='1' <?php if($sphinxenable == 1) {?>checked<?php }?>> <?php echo L('yes')?>&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='radio' name='setting[sphinxenable]' value='0' <?php if($sphinxenable == 0) {?>checked<?php }?>> <?php echo L('no')?>
	  </td>
  </tr>
  <tr>
    <th><?php echo L('host')?></th>
    <td class="y-bg">
	  <input name="setting[sphinxhost]" id="sphinxhost" value="<?php echo $sphinxhost?>" type="text" class="input-text"></td>
  </tr> 
  <tr>
    <th><?php echo L('port')?></th>
    <td class="y-bg"><input name="setting[sphinxport]" id="sphinxport" value="<?php echo $sphinxport?>" type="text" class="input-text"></td>
  </tr>
  <tr>
    <th></th>
    <td class="y-bg"><input name="button" type="button" value="<?php echo L('test')?>" class="button" onclick="test_sphinx()"> <span id='testing'></span></td>
  </tr>
</table>
</div>
<div class="bk15"></div>
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
</div>
 
</form>
</body>
<script type="text/javascript"> 
 
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
 
function showsmtp(obj,hiddenid){
	hiddenid = hiddenid ? hiddenid : 'smtpcfg';
	var status = $(obj).val();
	if(status == 1) $("#"+hiddenid).show();
	else  $("#"+hiddenid).hide();
}
function test_sphinx() {
	$('#testing').html('<?php echo L('testing')?>');
    $.post('?m=search&c=search_admin&a=public_test_sphinx',{sphinxhost:$('#sphinxhost').val(),sphinxport:$('#sphinxport').val()}, function(data){
		message = '';
		if(data == 1) {
			message = '<?php echo L('testsuccess')?>';
		} else if(data == -1) {
			message = '<?php echo L('hostempty')?>';
		} else if(data == -2) {
			message = '<?php echo L('portempty')?>';
		} else {
			message = data;
		}
		$('#testing').html(message);
		//window.top.art.dialog({content:message,lock:true,width:'200',height:'50'},function(){});
	});
}
 
</script>

</html>