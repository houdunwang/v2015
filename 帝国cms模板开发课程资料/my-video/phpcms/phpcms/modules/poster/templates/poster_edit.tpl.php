<?php 
defined('IN_ADMIN') or exit('No permission resources.');
//$show_header = $show_validator = $show_scroll = 1; 
$show_dialog = $show_header = 1; 
include $this->admin_tpl('header', 'admin');
$thisExt = isset($this->M['ext'])?$this->M['ext']:'';
$authkey = upload_key('1,'.$thisExt.',1');
?> 
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js" charset="UTF-8"></script>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php if(isset($big_menu)) echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';?>
    <?php echo admin::submenu($_GET['menuid'],$big_menu); ?><span>|</span><a href="javascript:window.top.art.dialog({id:'setting',iframe:'?m=poster&c=space&a=setting', title:'<?php echo L('module_setting')?>', width:'540', height:'320'}, function(){var d = window.top.art.dialog({id:'setting'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'setting'}).close()});void(0);"><em><?php echo L('module_setting')?></em></a>
    </div>
</div>

<form method="post" action="?m=poster&c=poster&a=edit&id=<?php echo $_GET['id']?>&spaceid=<?php echo $info['spaceid']?>" id="myform">
<table class="table_form" width="100%" cellspacing="0">
<tbody>
	<tr>
		<th width="100"><?php echo L('poster_title')?>：</th>
		<td><input name="poster[name]" id="name" value="<?php echo $info['name']?>" class="input-text" type="text" size="25"></td>
	</tr>
	<tr>
		<th><?php echo L('for_postion')?>：</th>
		<td><b style="color:#F60;"><?php echo $sinfo['name']?></b>&nbsp;[<?php echo $TYPES[$sinfo['type']]?>]</td>
	</tr>
	<tr>
    	<th align="right"  valign="top"><?php echo L('poster_type')?>：</th>
        <td valign="top" colspan="2"><?php echo form::select($setting['type'], trim($info['type']), 'name="poster[type]" id="type" onchange="AdsType(this.value)"', $default);?>
        </td>
    </tr>
	<tr>
		<th><?php echo L('line_time')?>：</th>
		<td><?php echo form::date('poster[startdate]', date('Y-m-d H:i:s', $info['startdate']), 1)?></td>
	</tr>
	<tr>
		<th><?php echo L('down_time')?>：</th>
		<td><?php echo form::date('poster[enddate]', date('Y-m-d H:i:s', $info['enddate']), 1)?></td>
	</tr>
	</tbody>
	</table><?php if(array_key_exists('images', $setting['type'])) {?><div class="pad-10" id="imagesdiv" style="display:<?php if($info['type']=='flash') {?>none;<?php }?>">
	<fieldset>
	<legend><?php echo L('photo_setting')?></legend>
	<?php if($setting['num']>1) { for($i=1; $i<=$setting['num']; $i++) {?>
	<table width="100%"  class="table_form">
	<tbody>
  <tr>
    <th width="80"><?php echo L('linkurl')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[images][<?php echo $i;?>][linkurl]" id="linkurl<?php echo $i;?>" size="30" value="<?php echo $info['setting'][$i]['linkurl']?>" /></td>
    <td rowspan="2"><a href="javascript:flashupload('imgurl<?php echo $i;?>_images', '<?php echo L('upload_photo')?>','imgurl<?php echo $i;?>',preview,'1,<?php echo $thisExt?>,1','poster', '', '<?php echo $authkey?>');void(0);"><img src="<?php echo $info['setting'][$i]['imageurl']?>" id="imgurl<?php echo $i;?>_s" width="105" height="88" onerror="this.src='<?php echo IMG_PATH;?>nopic.gif'"></a><input type="hidden" id="imgurl<?php echo $i;?>" name="setting[images][<?php echo $i;?>][imageurl]" value="<?php echo $info['setting'][$i]['imageurl']?>"></td>
  </tr>
  <tr>
    <th><?php echo L('alt')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[images][<?php echo $i;?>][alt]" id="alt<?php echo $i;?>" value="<?php echo $info['setting'][$i]['alt']?>" size="30" /></td>
  </tr>
</table>
<?php } } else {?>
<table width="100%"  class="table_form">
	<tbody>
  <tr>
    <th width="80"><?php echo L('linkurl')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[images][1][linkurl]" id="linkurl3" size="30" value="<?php echo $info['setting'][1]['linkurl']?>" /></td>
    <td rowspan="2"><a href="javascript:flashupload('imgurl_images', '<?php echo L('upload_photo')?>','imgurl',preview,'1,<?php echo $thisExt?>,1','poster', '', '<?php echo $authkey?>');void(0);"><img src="<?php echo $info['setting'][1]['imageurl']?>" id="imgurl_s" width="105" height="88" onerror="this.src='<?php echo IMG_PATH;?>nopic.gif'"></a><input type="hidden" id="imgurl" name="setting[images][1][imageurl]" value="<?php echo $info['setting'][1]['imageurl']?>"></td>
  </tr>
  <tr>
    <th><?php echo L('alt')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[images][1][alt]" value="<?php echo $info['setting'][1]['alt']?>" id="alt3" size="30" /></td>
  </tr>
  </tbody>
</table>
<?php } ?>
</fieldset></div><?php } if(array_key_exists('flash', $setting['type'])) {?>
<div class="pad-10" id="flashdiv" style="display:<?php if($info['type']=='images') {?>none<?php }?>;">
	<fieldset>
	<legend><?php echo L('flash_setting')?></legend>
	<?php if($setting['num']>1) { for($i=1; $i<=$setting['num']; $i++) {?>
	<table width="100%"  class="table_form">
	<tbody>
  <tr>
    <th width="80"><?php echo L('flash_url')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[flash][<?php echo $i;?>][flashurl]" value="<?php echo $info['setting'][$i]['flashurl']?>" id="flashurl<?php echo $i;?>" size="40" /></td>
    <td class="y-bg"><input type="button" class="button" onclick="javascript:flashupload('flashurl<?php echo $i;?>_images', '<?php echo L('flash_upload')?>','flashurl<?php echo $i;?>',submit_attachment,'1,<?php echo $thisExt?>,1','poster', '', '<?php echo $authkey?>')" value="<?php echo L('flash_upload')?>"></td>
  </tr>
  </tbody>
</table>
<?php } } else {?>
<table width="100%"  class="table_form">
	<tbody>
  <tr>
    <th width="80"><?php echo L('flash_url')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[flash][1][flashurl]" id="flashurl" size="40" value="<?php echo $info['setting'][1]['flashurl']?>" /></td>
    <td class="y-bg"><input type="button" class="button" onclick="javascript:flashupload('flashurl_images', '<?php echo L('flash_upload')?>','flashurl',submit_attachment,'1,<?php echo $thisExt?>,1','poster', '', '<?php echo $authkey?>')" value="<?php echo L('flash_upload')?>"></td>
  </tr>
  </tbody>
</table>
<?php } ?>
</fieldset></div><?php } if(array_key_exists('text', $setting['type'])) {?><div class="pad-10" id="textdiv" style="display:">
	<fieldset>
	<legend><?php if ($sinfo['type']=='code') { echo L('code_setting'); } else { echo L('word_link'); } ?></legend>
	<table width="100%"  class="table_form">
	<tbody>
	<?php if($sinfo['type']=='code') {?>
  <tr>
    <th width="80"><?php echo L('code_content')?>：</th>
    <td class="y-bg"><textarea name="setting[text][code]" id="code" cols="55" rows="6"><?php echo $info['setting']['code']?></textarea></td>
  </tr>
  <?php } else {?>
  <tr>
    <th width="80"><?php echo L('word_content')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[text][1][title]" value="<?php echo $info['setting'][1]['title']?>" id="title" size="30" /></td>
  </tr>
  <tr>
    <th><?php echo L('linkurl')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[text][1][linkurl]" id="link" size="30" value="<?php echo $info['setting'][1]['linkurl']?>"  /></td>
  </tr><?php }?>
  </tbody>
</table>
</fieldset></div><?php }?>
<div class="bk15" style="margin-left:10px; line-height:30px;"><input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="button">&nbsp;<input type="reset" value=" <?php echo L('goback')?> " class="button" onclick="history.go(-1)"></div>

	
</form>
</body>
</html>
<script type="text/javascript">
function AdsType(type) {
	$('#imagesdiv').css('display', 'none');
	$('#flashdiv').css('display', 'none');
	$('#'+type+'div').css('display', '');
}
$(document).ready(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
	$('#name').formValidator({onshow:"<?php echo L('please_input_name')?>",onfocus:"<?php echo L('name_three_length')?>",oncorrect:"<?php echo L('correct')?>"}).inputValidator({min:6,onerror:"<?php echo L('adsname_no_empty')?>"}).ajaxValidator({type:"get",url:"",data:"m=poster&c=poster&a=public_check_poster",datatype:"html",cached:false,async:'true',success : function(data) {
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
	onerror : "<?php echo L('ads_exist')?>",
	onwait : "<?php echo L('checking')?>"
}).defaultPassed();
	$('#type').formValidator({onshow:"<?php echo L('choose_ads_type')?>",onfocus:"<?php echo L('type_selected')?>",oncorrect:"<?php echo L('correct')?>"}).inputValidator({min:1,onerror: "<?php echo L('choose_ads_type')?>"});
	$('#startdate').formValidator({onshow:"<?php echo L('online_time')?>",onfocus:"<?php echo L('online_time')?>",oncorrect:"<?php echo L('correct')?>"}).functionValidator({fun:isDateTime});
	$('#enddate').formValidator({onshow:"<?php echo L('one_month_no_select')?>",onfocus:"<?php echo L('down_time')?>",oncorrect:"<?php echo L('correct')?>"}).inputValidator();
	<?php if(array_key_exists('text', $setting['type'])) {?>
	<?php if($sinfo['type']=='text') {?>
	$('#title').formValidator({onshow:'<?php echo L('link_content')?>',onfoucs:'<?php echo L('link_content')?>',oncorrect:'<?php echo L('correct')?>'}).inputValidator({min:1,onerror:'<?php echo L('no_link_content')?>'});
	<?php } elseif($sinfo['type']=='code') {?>
	$('#code').formValidator({onshow:"<?php echo L('input_code')?>",onfocus:"<?php echo L('input_code')?>",oncorrect:"<?php echo L('correct')?>"}).inputValidator({min:1,onerror:'<?php echo L('input_code')?>'});
	<?php } }?>
});
 function preview(uploadid,returnid){
		var d = window.top.art.dialog({id:uploadid}).data.iframe;
		var in_content = d.$("#att-status").html().substring(1);
		$('#'+returnid).val(in_content);
		$('#'+returnid+'_s').attr('src', in_content);
}
</script>
<script type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>