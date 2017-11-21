<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<div id="main_frameid" class="pad-10 display" style="_margin-right:-12px;_width:98.9%;">
<script type="text/javascript">
$(function(){if ($.browser.msie && parseInt($.browser.version) < 7) $('#browserVersionAlert').show();}); 
</script>
<div class="explain-col mb10" style="display:none" id="browserVersionAlert">
<?php echo L('ie8_tip')?></div>
<div class="col-2 lf mr10" style="width:48%">
	<h6><?php echo L('personal_information')?></h6>
	<div class="content">
	<?php echo L('main_hello')?><?php echo $admin_username?><br />
	<?php echo L('main_role')?><?php echo $rolename?> <br />
	<div class="bk20 hr"><hr /></div>
	<?php echo L('main_last_logintime')?><?php echo date('Y-m-d H:i:s',$logintime)?><br />
	<?php echo L('main_last_loginip')?><?php echo $loginip?> <br />
	</div>
</div>
<div class="col-2 col-auto">
	<h6><?php echo L('main_safety_tips')?></h6>
	<div class="content" style="color:#ff0000;">
<?php if($pc_writeable) {?>	
<?php echo L('main_safety_permissions')?><br />
<?php } ?>
<?php if(pc_base::load_config('system','debug')) {?>
<?php echo L('main_safety_debug')?><br />
<?php } ?>
<?php if(!pc_base::load_config('system','errorlog')) {?>
<?php echo L('main_safety_errlog')?><br />
<?php } ?>
	<div class="bk20 hr"><hr /></div>	
<?php if(pc_base::load_config('system','execution_sql')) {?>	
<?php echo L('main_safety_sql')?> <br />
<?php } ?>
<?php if($logsize_warning) {?>	
<?php echo L('main_safety_log',array('size'=>$common_cache['errorlog_size'].'MB'))?>
 <br />
<?php } ?>
<?php 
$tpl_edit = pc_base::load_config('system','tpl_edit');
if($tpl_edit=='1') {?>
<?php echo L('main_safety_tpledit')?><br />
<?php } ?>
	</div>
</div>
<div class="bk10"></div>
<div class="col-2 lf mr10" style="width:48%">
<?php
$ccache = getcache('category_content_1','commons');

if(module_exists('member') && is_array($ccache)) { ?>
	<h6><?php echo L('main_shortcut')?></h6>
	<div class="content" id="admin_panel">
	<?php foreach($adminpanel as $v) {?>
		<span>
			[<a target="right" href="<?php echo $v['url'].'&menuid='.$v['menuid'];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>"><?php echo L($v['name'])?></a>]   
		</span>
	<?php }?>
	</div>
<?php } else { ?>
	<h6>Update Caches</h6>
	<div class="content" id="update_tips" style="height:90px; overflow:auto;"><ul id="file" class="sbul">
<div class="pad-10">
<form action="?m=admin&c=cache_all&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>" target="cache_if" method="post" id="myform" name="myform">
  <input type="hidden" name="dosubmit" value="1">
</form>
<iframe id="cache_if" name="cache_if" class="ifm" width="0" height="0"></iframe>
</div>
<script type="text/javascript">
document.myform.submit();
function addtext(data) {
	$('#file').append(data);
	document.getElementById('update_tips').scrollTop = document.getElementById('update_tips').scrollHeight;
}
</script>
	</div>
<?php }?>
</div>
<div class="col-2 col-auto">
	<h6><?php echo L('main_sysinfo')?></h6>
	<div class="content">
	<?php echo L('main_version')?>Phpcms <?php echo PC_VERSION?>  Release <?php echo PC_RELEASE?> [<a href="http://download.phpcms.cn/v9/" target="_blank"><?php echo L('main_latest_version')?></a>]<br />
	<?php echo L('main_os')?><?php echo $sysinfo['os']?> <br />
	<?php echo L('main_web_server')?><?php echo $sysinfo['web_server']?> <br />
	<?php echo L('main_sql_version')?><?php echo $sysinfo['mysqlv']?><br />
	<?php echo L('main_upload_limit')?><?php echo $sysinfo['fileupload']?><br />	
	</div>
</div>
<div class="bk10"></div>
<div class="col-2 lf mr10" style="width:48%">
	<h6><?php echo L('main_product_team')?></h6>
	<div class="content">
	<?php echo L('main_copyright')?><?php echo $product_copyright?><br />
	<?php echo L('main_product_dev')?><?php echo $programmer;?><br />
	<?php echo L('main_product_ui')?><?php echo $designer;?><br />
	<?php echo L('main_product_site')?><a href="http://www.phpcms.cn/" target="_blank">http://www.phpcms.cn/</a> <br />
	<?php echo L('main_product_bbs')?><a href="http://bbs.phpcms.cn/" target="_blank">http://bbs.phpcms.cn/</a> <br />
	<?php echo L('main_product_qq')?>7634000 <br />
	<?php echo L('main_product_sales')?>1561683312
	</div>
</div>

<div class="col-2 col-auto">
	<h6><?php echo L('main_license')?></h6>
	<div class="content">
	<?php echo L('main_version')?>Phpcms <?php echo PC_VERSION?>  Release <?php echo PC_RELEASE?> [<a href="http://buy.phpcms.cn" target="_blank"><?php echo L('main_support')?></a>]<br />
	<?php echo L('main_license_type')?><span id="phpcms_license"></span> <br />
	<?php echo L('main_serial_number')?><span id="phpcms_sn"></span> <br />
	</div>
</div>
    <div class="bk10"></div>
</div>
</body></html>