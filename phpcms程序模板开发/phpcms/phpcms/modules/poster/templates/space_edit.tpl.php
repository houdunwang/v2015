<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<form method="post" action="?m=poster&c=space&a=edit&spaceid=<?php echo $_GET['spaceid']?>" name="myform" id="myform">
<table class="table_form" width="100%" cellspacing="0">
<tbody>
	<tr>
		<th width="80"><strong><?php echo L('boardtype')?>：</strong></th>
		<td><input name="space[name]" class="input-text" id="name" type="text" value="<?php echo new_html_special_chars($info['name'])?>" size="25"></td>
	</tr>
	<tr>
		<th><strong><?php echo L('ads_type')?>：</strong></th>
		<td><?php echo form::select($TYPES, $info['type'], 'name="space[type]" id="type" onchange="AdsType(this.value)"')?>&nbsp;&nbsp;<span id="ScrollSpan" style="padding-left:30px;display:none;"><label><input type="checkbox" id="ScrollBox" name="setting[scroll]"<?php if($setting['scroll']) {?> checked<?php }?> value='1'/> <?php echo L('rolling')?></label></span>
      <span id="AlignSpan" style="padding-left:30px;display:none;"><label><input type="checkbox" <?php if($setting['align']) {?> checked<?php }?> id="AlignBox" name="setting[align]" value='1'/> <?php echo L('lightbox')?></label></span></td>
	</tr>
	<tr id="trPosition" style="display:none;">
    	<th align="right"  valign="top"><strong><?php echo L('position')?>：</strong></th>
        <td valign="top" colspan="2">
        <?php echo L('left_margin')?>：<input name='setting[paddleft]' id='PaddingLeft' type='text' size='5' value='<?php echo $setting['paddleft']?>' class="input-text"> px&nbsp;&nbsp;
        <?php echo L('top_margin')?>：<input name='setting[paddtop]' id='PaddingTop' type='text' size='5' value='<?php echo $setting['paddtop']?>' class="input-text" /> px</div>
        </td>
    </tr>
	<tr id="SizeFormat">
		<th><strong><?php echo L('size_format')?>：</strong></th>
		<td><label><?php echo L('plate_width')?></label><input name="space[width]" id="s_width" class="input-text" type="text" value="<?php echo $info['width']?>" size="10"> px &nbsp;&nbsp;&nbsp;&nbsp; <label><?php echo L('plate_height')?></label><input name="space[height]" id="h_height" type="text" class="input-text" value="<?php echo $info['height']?>" size="10"> px<div id="w_hTip"></div></td>
	</tr>
	<tr>
		<th><strong><?php echo L('description')?>：</strong></th>
		<td><textarea name="space[description]" id="description" class="input-textarea" cols="45" rows="4"><?php echo $info['description']?></textarea></td>
	</tr></tbody>
	</table>

<div class="bk15"></div>
<input type="hidden" name="old_type" value="<?php echo $info['type']?>">
<input type="submit" name="dosubmit" id="dosubmit" class='dialog' value="2"/></form>
</body>
</html>
<script language="javascript" type="text/javascript">
function AdsType(adstype) {
	$('input[type=checkbox]').attr('checked', false);
	$('#ScrollSpan').css('display', 'none');
	$('#AlignSpan').css('display', 'none');
	$('#trPosition').css('display', 'none');
	$('#SizeFormat').css('display', '');
	$('#PaddingLeft').attr('disabled', false);
	$('#PaddingTop').attr('disabled', false);
	<?php 
			if (is_array($poster_template) && !empty($poster_template)) {
				$n = 0;
				foreach ($poster_template as $key => $p) {
					if ($n==0) {
						echo 'if (adstype==\''.$key.'\') {';
					} else {
						echo '} else if (adstype==\''.$key.'\') {';
					}
					if ($p['align']) {
						if ($p['align']=='align') {
							echo '$(\'#AlignSpan\').css(\'display\', \'\');';
							if ($setting['align']) {
								echo '$(\'#AlignBox\').attr(\'checked\', \'true\');';
								echo '$(\'#PaddingLeft\').attr(\'disabled\', true);';
								echo '$(\'#PaddingTop\').attr(\'disabled\', true);';
							}
						} elseif ($p['align']=='scroll') {
							echo '$(\'#ScrollSpan\').css(\'display\', \'\');';
							if ($setting['scroll']) {
								echo '$(\'#ScrollBox\').attr(\'checked\', \'true\');';
							}
						}
					}
					if ($p['padding']) {
						echo '$(\'#trPosition\').css(\'display\', \'\');';
					}
					if (!isset($p['size']) || !$p['size']) {
						echo '$(\'#SizeFormat\').css(\'display\', \'none\');';
					}
					$n++;
				}
			}
			echo '}';
		?>
}
$('#AlignBox').click( function (){
	if($('#AlignBox').attr('checked')) {
		$('#PaddingLeft').attr('disabled', true);
		$('#PaddingTop').attr('disabled', true);
	} else {
		$('#PaddingLeft').attr('disabled', false);
		$('#PaddingTop').attr('disabled', false);
	}
});
AdsType($('#type').val());
$(document).ready(function(){
	 $.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
	$("#name").formValidator({onshow:"<?php echo L('please_input_space_name')?>",onfocus:"<?php echo L('spacename_three_length')?>",oncorrect:"<?php echo L('correct')?>"}).inputValidator({min:6,onerror:"<?php echo L('spacename_illegality')?>"}).ajaxValidator({type:"get",url:"",data:"m=poster&c=space&a=public_check_space&spaceid=<?php echo $_GET['spaceid']?>",datatype:"html",cached:false,async:'true',success : function(data) {
            if( data == "1" )
			{
                return true;
			}
            else
			{
                return false;
			}
		},
		error: function(){alert("<?php echo L('server_busy')?>");},
		onerror : "<?php echo L('space_exist')?>",
		onwait : "<?php echo L('checking')?>"
	}).defaultPassed();
	$('#type').formValidator({onshow:"<?php echo L('choose_space_type')?>",onfocus:"<?php echo L('choose_space_type')?>",oncorrect:"<?php echo L('correct')?>"}).inputValidator();
	$('#s_width').formValidator({tipid:"w_hTip",onshow:"<?php echo L('input_width_height')?>",onfocus:"<?php echo L('three_numeric')?>",oncorrect:"<?php echo L('correct')?>"}).inputValidator().defaultPassed();
})
</script>