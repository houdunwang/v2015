<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
$page_title = L('index');$show_scroll = 1;
include $this->admin_tpl('header');
?>
<div class="pad-lr-10">
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('phpsso')?></h2>
<table width="100%"  class="table_form">
	<tr>
		<th width="100"><?php echo L('version_info')?>：</th>
		<td>v1.0</td>
	</tr>
	<tr>
		<th><?php echo L('application_info')?>：</th>
		<td><?php echo $appnum?></td>
	</tr>
	<tr>
		<th><?php echo L('member_info')?>：</th>
		<td>
		<?php echo L('total')?><?php echo $total_member?>&nbsp;&nbsp;
		<?php echo L('member_today')?><?php echo $today_member?></td>
	</tr>
	<tr>
		<th><?php echo L('queue_info')?>：</th>
		<td><?php echo $total_messagequeue?></td>
	</tr>
</table>
<div class="bk15"></div>
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('system_info')?></h2>
<table width="100%"  class="table_form">
	<tr>
		<th width="100"><?php echo L('server_info')?>：</th>
		<td><?php echo PHP_OS.' '.$_SERVER['SERVER_SOFTWARE'];?></td>
	</tr>
	<tr>
		<th><?php echo L('host_info')?>：</th>
		<td><?php echo $_SERVER['SERVER_NAME'].'('.$_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'].')'?> </td>
	</tr>
	<tr>
		<th><?php echo L('php_info')?>：</th>
		<td>get_magic_quotes_gpc():<?php echo get_magic_quotes_gpc() ? 'On' : 'Off';?></td>
	</tr>
	<tr>
		<th><?php echo L('mysql_info')?>：</th>
		<td><?php echo L('mysql_version')?>：<?php echo $mysql_version?>、
			<?php echo L('table_size')?>：<?php echo $mysql_table_size?>、
			<?php echo L('index_size')?>：<?php echo $mysql_table_index_size?>
		</td>
	</tr>
	
</table>
<div class="bk15"></div>
  <h2 class="title-1 line-x f14 fb blue lh28"><?php echo L('service_info')?></h2>
<table width="100%"  class="table_form">
	<tr>
		<th width="100"><?php echo L('development_team')?>：</th>
		<td><?php echo L('phpcms_chenzhouyu')?>、<?php echo L('phpcms_wangtiecheng')?></td>
	</tr>
	<tr>
		<th><?php echo L('design_team')?>：</th>
		<td><?php echo L('phpcms_dongfeilong')?></td>
	</tr>
</table>
</div>
</body>
</html>
