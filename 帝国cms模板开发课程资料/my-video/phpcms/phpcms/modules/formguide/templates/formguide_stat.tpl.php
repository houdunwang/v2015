<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
 <?php 
if(is_array($result)){
	foreach($result as $v){
?>
<table width="100%" cellspacing="0" class="table-list">
	<thead>
		<tr>
			<th align="left"><strong><?php echo $fields[$v['field']]['name']?></strong></th>
			<th width="10%" align="center"><?php echo L('stat_num')?></th>
			<th width='30%' align="center"><?php echo L('thumb_shi')?></th>
		</tr>
	</thead>
<tbody>
<?php
$i = 1;
$setting = string2array($v['setting']);
$setting = $setting['options'];
$options = explode("\n",$setting);
if(is_array($options)){
	foreach($options AS $_k=>$_v){
		$_key = $_kv = $_v;
		if (strpos($_v,'|')!==false) {
			$xs = explode('|',$_v);
			$_key =$xs[0];
			$_kv =$xs[1];
		}
?>
	<tr>
		<td> <?php echo intval($_k+1).' 、 '.$_key;?> </td>
		<td align="center"><?php
						$number = 0;
						foreach ($datas AS $__k=>$__v) {
							if(trim($__v[$v['field']])==trim($_kv))  $number++;
						}
						echo $number;
						?></td>
		<td align="center">
		<?php if($total==0){
		$per=0;
	}else{
		$per=intval($number/$total*100);
	}?>
		<div class="vote_bar">
        	<div style="width:<?=$per?>%"><span><?php echo $per;?> %</span> </div>
        </div>
		</td>
		</tr>
<?php
	$i++;
	}
}
?>
	</tbody>
</table>
<div class="bk10"></div>
<?php 
	}
}
?>
<div class="bk10"></div>
</div>
</body>
</html>








