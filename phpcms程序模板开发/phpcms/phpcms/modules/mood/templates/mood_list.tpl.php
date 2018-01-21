<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="mood" name="m">
<input type="hidden" value="mood_admin" name="c">
<input type="hidden" value="init" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 		<?php echo L('category')?>：<?php echo form::select_category('', $catid, 'name="catid"', L('please_select'), '', 0, 1)?> 
 		<?php echo L('time')?>：<?php echo form::select(array('1'=>L('today'), '2'=>L('yesterday'), '3'=>L('this_week'), '4'=>L('this_month'), '5'=>L('all')), $datetype, 'name="datetype"')?> 
 		<?php echo L('sort')?>：<?php echo form::select($order_list, $order, 'name="order"')?> 
				<input type="submit" name="search" class="button" value="<?php echo L('view')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>


<div class="table-list">
<?php if ($catid) :?>
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left" width="300"><?php echo L('title')?></th>
			<th align="left"><?php echo L('total')?></th>
			<?php foreach ($mood_program as $k=>$v) {
				echo  '<th align="left">'.$v['name'].'</th>';
			}?>
			
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($data) && !empty($data))foreach($data as $k=>$v) {
?>
    <tr>
		<td align="left"><a href="<?php echo $content_data[$v['contentid']]['url']?>" target="_blank"><?php echo $content_data[$v['contentid']]['title']?></a></td>
		<td align="left" <?php if ($order == -1) echo 'class="on"';?>><?php echo  $v['total']?></td>
		<?php foreach ($mood_program as $k=>$b) {
				$d = 'n'.$k;
				echo  '<td align="left" '.($order==$k ? 'class="on"' : '').'>'.$v[$d].'</td>';
			}?>
		
    </tr>
<?php
	}

?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>
<?php endif;?>
</div>
</div>

</body>
</html>