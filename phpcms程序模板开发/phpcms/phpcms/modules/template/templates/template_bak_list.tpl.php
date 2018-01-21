<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="bk15"></div>
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th><?php echo L('time')?></th>
		<th><?php echo L('who')?></th>
		<th width="150"><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
?>
<tr>
<td align="center"><?php echo format::date($v['creat_at'], 1)?></td>
<td align="center"><?php echo $v['username']?></td>
<td align="center"><a href="?m=template&c=template_bak&a=restore&id=<?php echo $v['id']?>&style=<?php echo $this->style?>&dir=<?php echo $this->dir?>&filename=<?php echo $this->filename?>" onclick="return confirm('<?php echo L('are_you_sure_you_want_to_restore')?>')"><?php echo L('restore')?></a> | <a href="?m=template&c=template_bak&a=del&id=<?php echo $v['id']?>&style=<?php echo $this->style?>&dir=<?php echo $this->dir?>&filename=<?php echo $this->filename?>" onclick="return confirm('<?php echo L('confirm', array('message'=>format::date($v['creat_at'], 1)))?>')"><?php echo L('delete')?></a></td>
</tr>
<?php 
	endforeach;
endif;
?>
</tbody>
</table>
</from>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
</body>
</html>