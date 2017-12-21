<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('credit_change');
include $this->admin_tpl('header');
?>
<div class="subnav">
	<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('credit_manage')?></h2>
	<div class="content-menu ib-a blue line-x">
		<a href="?m=admin&c=credit&a=manage" class="on">
		<em><?php echo L('credit_manage')?></em></a>
		<span>|</span>
		<a href="?m=admin&c=credit&a=add">
		<em><?php echo L('credit_add')?></em></a>
	</div>
</div>

<form action="?m=admin&c=credit&a=delete" method="post" name="form_member_manage">
<div class="table-list pad-lr-10">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
	            <th width="40"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
				<th align="left"><?php echo L('id')?></th>
	            <th align="left"><?php echo L('change_pos')?></th>
	            <th align="left"><?php echo L('change_rate')?></th>
				<th align="left"></th>
            </tr>
        </thead>
    <tbody>
<?php
foreach($creditlist as $k=>$v) {
?>
	<tr>
		<td align="center"><input type="checkbox" value="<?php echo $k?>" name="id[]"></td>
		<td align="left"><?php echo $k?></td>
		<td align="left"><?php echo $applist[$v['fromid']]['name']?>[<?php echo $v['fromname']?>]-><?php echo $applist[$v['toid']]['name']?>[<?php echo $v['toname']?>]</td>
		<td align="left"><?php echo $v['fromrate']?>:<?php echo $v['torate']?></td>
		<td align="left"></td>
	</tr>
<?php
}
?>   </tbody>
    </table>
    <div class="btn">
	<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label>
	<input type="submit" class="button" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
	</div>
    <div id="pages">
    </div>
</div>
</form>

</body>
</html>
