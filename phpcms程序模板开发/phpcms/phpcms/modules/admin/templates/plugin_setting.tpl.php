<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<form action="?m=admin&c=plugin&a=config" method="post" id="myform">
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
	 		<?php foreach($plugin_menus as $_num => $menu) {?>
            <li <?php if($menu['status']) {?>class="on"<?php }?> <?php if($menu['extend']) {?>onclick="loadfile('<?php echo$menu['url'] ?>')"<?php }?> ><?php echo $menu['name']?></li>
            <?php }?>
</ul>
<div id="tab-content">
<div class="contentList pad-10">
<h3><?php echo $name?></h3>
<?php echo $description?><br/>
</div>
<?php if($form) {?>
<div class="contentList pad-10 hidden">
	<table width="100%"  class="table_form">
<?php echo $form?>
</table>
<div class="bk15"></div>
<input name="pluginid" type="hidden" value="<?php echo $pluginid?>">
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
</div>
<?php }?>
<?php if(is_array($mods)) { foreach ($mods as $m) {?>
<div class="contentList pad-10 hidden" id="<?php echo $m?>">

</div>
<?php } }?>
</div>
</div>
</div>
</form>
</body>
<script type="text/javascript">
function SwapTab(name,title,content,Sub,cur){
	  $(name+' '+title).click(function(){
		  $(this).addClass(cur).siblings().removeClass(cur);
		  $(content+" > "+Sub).eq($(name+' '+title).index(this)).show().siblings().hide();
	  });
	}
function loadfile(data) {
	$("#"+data).load('?m=admin&c=plugin&a=config&pluginid=<?php echo $pluginid?>&module='+data
	+'&pc_hash=<?php echo $_SESSION['pc_hash']?>');
}
new SwapTab(".tabBut","li","#tab-content",".contentList","on");//排行TAB	
</script>
</html>