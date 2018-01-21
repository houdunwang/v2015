<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<div class="pad-lr-10">
<div class="table-list">

<table width="100%" cellspacing="0">
        <thead>
            <tr>
			<th align="left" width="200px"><?php echo L('filedname')?></th>
			<th align="left" ><?php echo L('value')?></th>
            </tr>
        </thead>
    <tbody>
<?php
	foreach($member_fieldinfo as $k=>$v) {
?>
    <tr>
		<td align="left" width="200px"><?php echo $k?></td>
		<td align="left"><?php echo $v?></td>
    </tr>
<?php
	}
?>
 </tbody>
</table>

<div class="btn">
<input type="button" class="dialog" name="dosubmit" id="dosubmit" value="<?php echo L('goback')?>" onclick="window.top.art.dialog({id:'modelinfo'}).close();"/>
</div> 
</div>
</div>
</body>
</html>