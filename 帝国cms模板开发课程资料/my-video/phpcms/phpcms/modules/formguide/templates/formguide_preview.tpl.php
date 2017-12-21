<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="{JS_PATH}dialog.js"></script>

<link href="<?php echo CSS_PATH?>table_form.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>dialog.css" rel="stylesheet" type="text/css" />
<div class="subnav">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo $f_info['name']?>--<?php echo L('form_preview')?></h2>  
<div class="content-menu ib-a blue line-x">
　 <?php if(isset($big_menu)) echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';?><a class="on" href="?m=formguide&c=formguide&a=init"><em><?php echo L('return_list')?></em></a></div>
</div>
<div class="pad-10">
<table class="table_form" width="100%" cellspacing="0">
<tbody>
	<?php
if(is_array($forminfos_data)) {
 foreach($forminfos_data as $field=>$info) {
	 if($info['isomnipotent']) continue;
	 if($info['formtype']=='omnipotent') {
		foreach($forminfos_data as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
	}
 ?>
	<tr>
      <th width="80"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?>
	  </th>
      <td><?php echo $info['form']?>  <?php echo $info['tips']?></td>
    </tr>
<?php
} }
?>
	</tbody>
</table>
<input type="submit" class="button" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> ">&nbsp;<input type="reset" class="button" value=" <?php echo L('clear')?> ">
</div>
</body>
</html>