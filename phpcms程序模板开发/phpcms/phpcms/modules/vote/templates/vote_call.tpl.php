<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = $show_validator = $show_scroll = 1; 
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<h2 class="title-1 f14 lh28">(<?php echo $r['subject'];?>)<?php echo L('vote_call')?></h2>
<div class="bk10"></div>
<div class="explain-col">
<strong><?php echo L('vote_call_info')?>：</strong><br />
<?php echo L('vote_call_infos')?>
</div>
<div class="bk10"></div>
 
<fieldset>
	<legend><?php echo L('vote_call_1')?></legend>
    <?php echo L('vote_phpcall')?><br />
<input name="jscode1" id="jscode1" value='<script language="javascript" src="<?php echo APP_PATH;?>index.php?m=vote&c=index&a=show&action=js&subjectid=<?php echo $r['subjectid']?>&type=3"></script>' style="width:410px"> <input type="button" onclick="$('#jscode1').select();document.execCommand('Copy');" value="<?php echo L('copy_code')?>" class="button" style="width:114px">
</fieldset>
<div class="bk10"></div>
<fieldset>
	<legend><?php echo L('vote_call_2')?></legend>
    <?php echo L('vote_phpcall')?><br />
<input name="jscode2" id="jscode2" value='<script language="javascript" src="<?php echo APP_PATH;?>index.php?m=vote&c=index&a=show&action=js&subjectid=<?php echo $r['subjectid']?>&type=2"></script>' style="width:410px">
 <input type="button" onclick="$('#jscode2').select();document.execCommand('Copy');" value="<?php echo L('copy_code')?>" class="button" style="width:114px">
</fieldset> 
<div class="bk10"></div>
<fieldset>
	<legend><?php echo L('vote_jscall')?></legend>
    <?php echo L('vote_jscall_info')?><br />
<input name="jscode2" id="jscode3" value='<script language="javascript" src="<?php echo APP_PATH;?>caches/vote_js/vote_<?php echo $r['subjectid']?>.js"></script>' style="width:410px">
 <input type="button" onclick="$('#jscode3').select();document.execCommand('Copy');" value="<?php echo L('copy_code')?>" class="button" style="width:114px">
</fieldset> 
  

</div>
</body>
</html>