<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'attachment');
?>
<div class="pad-lr-10">
<div class="explain-col">
<?php echo L('attachment_address_replace_msg')?>
</div>
<form action="index.php?m=attachment&c=address&a=update&pc_hash=<?php echo $_SESSION['pc_hash'];?>" method="post" onsubmit="return confirm('<?php echo L('form_submit_confirm');?>')">
<table width="100%"  class="table_form">
  <tr>
    <th width="100"><?php echo L('old_attachment_address')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="old_attachment_path" id="old_attachment_path" size="40" value="<?php echo pc_base::load_config('system', 'upload_url')?>" /> <?php echo L('old_attachment_address_msg')?></td>
  </tr>
  <tr>
    <th><?php echo L('new_attachment_address')?>：</th>
    <td class="y-bg"><input type="text" class="input-text" name="new_attachment_path" id="new_attachment_path" size="40" value="" /></td>
  </tr>
   <tr>
    <th></th>
    <td class="y-bg"><input type="submit" value="<?php echo L('submit')?>" class="button"></td>
  </tr>
</table>
</form>
</div>
</body>
</html>
<script type="text/javascript">
<!--
//-->
</script>