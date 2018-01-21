<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('member_manage');
include $this->admin_tpl('header');
?>
<div class="subnav">
	<h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('member_manage')?></h2>
	<div class="content-menu ib-a blue line-x">
    <div class="rt">
			<form action="index.php" method="get" name="form_member_search">
				<?php echo L('regtime')?>：
				<?php echo form::date('start_time', $start_time)?>
				<?php echo form::date('end_time', $end_time)?>
				<select name="type">
					<option value='1' <?php if(isset($_GET['type']) && $_GET['type']==1){?>selected<?php }?>><?php echo L('username')?></option>
					<option value='2' <?php if(isset($_GET['type']) && $_GET['type']==2){?>selected<?php }?>><?php echo L('uid')?></option>
					<option value='3' <?php if(isset($_GET['type']) && $_GET['type']==3){?>selected<?php }?>><?php echo L('email')?></option>
					<option value='4' <?php if(isset($_GET['type']) && $_GET['type']==4){?>selected<?php }?>><?php echo L('regip')?></option>
				</select>
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
				<input type="hidden" name="m" value="admin" />
				<input type="hidden" name="c" value="member" />
				<input type="hidden" name="a" value="manage" />
			</form>
	</div>
		<a href="?m=admin&c=member&a=manage" class="on">
		<em><?php echo L('member_manage')?></em></a>
		<span>|</span>
		<a href="?m=admin&c=member&a=add">
		<em><?php echo L('member_add')?></em></a>
	</div>
</div>
<div class="pad-lr-10">
<form action="?m=admin&c=member&a=delete" method="post" name="form_member_manage">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
	            <th align="left" width="40"><input type="checkbox" value="" id="check_box" onclick="selectall('uid[]');"></th>
				<th align="left" width="60"><?php echo L('uid')?></th>
	            <th align="left"><?php echo L('username')?></th>
	            <th align="left"><?php echo L('email')?></th>
	            <th align="left"><?php echo L('application')?></th>
	            <th align="left"><?php echo L('type')?></th>
				<th align="left"><?php echo L('regip')?></th>
	            <th align="left"><?php echo L('regtime')?></th>
	            <th align="left"><?php echo L('lastlogintime')?></th>
	            <th align="left"><?php echo L('operation')?></th>
            </tr>
        </thead>
    <tbody>
<?php
foreach($memberlist as $k=>$v) {
?>
	<tr>
		<td align="left" width="40"><input type="checkbox" value="<?php echo $v['uid']?>" name="uid[]"></td>
		<td align="left" width="60"><?php echo $v['uid']?></td>
		<td align="left"><?php if($v['avatar']) {?><img src="<?php echo ps_getavatar($v['uid']);?>" height=18 width=18><?php }?><?php echo $v['username']?></td>
		<td align="left"><?php echo $v['email']?></td>
		<td align="left"><?php echo $v['appname']?></td>
		<td align="left"><?php echo $v['type']?></td>
		<td align="left"><?php echo $v['regip']?></td>
		<td align="left"><?php echo format::date($v['regdate'], 1);?></td>
		<td align="left"><?php echo format::date($v['lastdate'], 1);?></td>
		<td align="left"><a href="?m=admin&c=member&a=edit&uid=<?php echo $v['uid']?>">[<?php echo L('edit')?>]</a></td>
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
    <?php echo $pages?>
    </div>
</form>
</div>
</body>
</html>
