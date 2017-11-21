<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header');
?>
<div class="pad-10">
<form action="?m=admin&c=module&a=install" method="post" id="myform">
<div>
	<table width="100%"  class="table_form">
  <tr>
    <th width="80"><?php echo L('modulename')?>：</th>
    <td class="y-bg"><?php echo $modulename?></td>
  </tr>
  <tr>
    <th width="80"><?php echo L('introduce')?>：</th>
    <td class="y-bg"><?php echo $introduce?></td>
  </tr>
  <tr>
    <th width="80"><?php echo L('moduleauthor')?>：</th>
    <td class="y-bg"><?php echo $author?></td>
  </tr>
  <tr>
    <th width="80">E-mail：</th>
    <td class="y-bg"><?php echo $authoremail?></td>
 </tr>
 <tr>
    <th width="80"><?php echo L('homepage')?>：</th>
    <td class="y-bg"><?php echo $authorsite?></td>
 </tr>
</table>
</div>
<div class="bk15"></div><input type="hidden" name="module" value="<?php echo $_GET['module']?>">
    <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</div>
</div>
</form>
</body>
</html>