<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = $show_validator = 1;
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		<?php if (is_array($html) && $html['validator']){ echo $html['validator']; unset($html['validator']); }?>
	})
//-->
</script>
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li<?php if ($_GET['order']==1 || !isset($_GET['order'])) {?> class="on"<?php }?>><a href="?m=content&c=push&a=init&classname=position_api&action=position_list&order=1&modelid=<?php echo $_GET['modelid']?>&catid=<?php echo $_GET['catid']?>&id=<?php echo $_GET['id']?>"><?php echo L('push_to_position');?></a></li>
<li<?php if ($_GET['order']==2) {?> class="on"<?php }?>><a href="?m=content&c=push&a=init&module=special&action=_push_special&order=2&modelid=<?php echo $_GET['modelid']?>&catid=<?php echo $_GET['catid']?>&id=<?php echo $_GET['id']?>"><?php echo L('push_to_special');?></a></li>
<li<?php if ($_GET['order']==3) {?> class="on"<?php }?>><a href="?m=content&c=push&a=init&module=content&classname=push_api&action=category_list&order=3&tpl=push_to_category&modelid=<?php echo $_GET['modelid']?>&catid=<?php echo $_GET['catid']?>&id=<?php echo $_GET['id']?>"><?php echo L('push_to_category');?></a></li>
</ul>
<div class='content' style="height:auto;">
<form action="?m=content&c=push&a=init&module=<?php echo $_GET['module']?>&action=<?php echo $_GET['action']?>" method="post" name="myform" id="myform"><input type="hidden" name="modelid" value="<?php echo $_GET['modelid']?>"><input type="hidden" name="catid" value="<?php echo $_GET['catid']?>">
<input type='hidden' name="id" value='<?php echo $_GET['id']?>'>
<table width="100%"  class="table_form">
  
  <?php 
  if (isset($html) && is_array($html)) {
  foreach ($html as $k => $v) { ?>
  	  <tr>
    <th width="80"><?php echo $v['name']?>：</th>
    <td class="y-bg"><?php echo creat_form($k, $v)?></td>
  </tr>
  <?php if ($v['ajax']['name']) {?>
  	  <tr>
  	  	<th width="80"><?php echo $v['ajax']['name']?>：</th>
  	  	<td class="y-bg" id="<?php echo $k?>_td"><input type="hidden" name="<?php echo $v['ajax']['id']?>" id="<?php echo $v['ajax']['id']?>"></td>
  	 </tr>
  <?php } ?>

  <?php } } else { echo $html; }?>
  </table>
<div class="bk15"></div>

<input type="hidden" name="return" value="<?php echo $return?>" />
<input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>
</div>
</div>
</body>
</html>