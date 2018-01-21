<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1; 
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php if(isset($big_menu)) echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';?>
    <?php echo admin::submenu($_GET['menuid'],$big_menu); ?><span>|</span><a href="javascript:window.top.art.dialog({id:'setting',iframe:'?m=poster&c=space&a=setting', title:'<?php echo L('module_setting')?>', width:'540', height:'320'}, function(){var d = window.top.art.dialog({id:'setting'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'setting'}).close()});void(0);"><em><?php echo L('module_setting')?></em></a>
    </div>
</div>
<div class="pad-lr-10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="50" align="center"><?php echo L('template_name')?></th>
			<th width="24%" align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($templates)){
	foreach($templates as $info){
?>   
	<tr>
	<td><?php if ($poster_template[$info]['name']) { echo $poster_template[$info]['name'].' ('.$info.')'; } else { echo $info; }?></td>
	<td align="center">
	<a href="javascript:<?php if ($poster_template[$info]['iscore']) {?>check<?php } else {?>edit<?php }?>('<?php echo addslashes(new_html_special_chars($info))?>', '<?php echo addslashes(new_html_special_chars($poster_template[$info]['name']))?>');void(0);"><?php if ($poster_template[$info]['iscore']) { echo L('check_template'); } else { echo '<font color="#009933">'.L('setting_template').'</font>'; }?></a> | <a href="?m=poster&c=space&a=public_tempate_del&id=<?php echo $info?>"><?php echo L('delete')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>  </div>
 <div id="pages"><?php echo $this->pages?></div>
</div>
<script type="text/javascript">
<!--
	function edit(id, name) {
		window.top.art.dialog({id:'testIframe'}).close();
		window.top.art.dialog({title:name, id:'testIframe', iframe:'?m=poster&c=space&a=public_tempate_setting&template='+id ,width:'540px',height:'360px'}, function(){var d = window.top.art.dialog({id:'testIframe'}).data.iframe;// 使用内置接口获取iframe对象
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'testIframe'}).close()});
	};

	function check(id, name) {
		window.top.art.dialog({id:'testIframe'}).close();
		window.top.art.dialog({title:name, id:'testIframe', iframe:'?m=poster&c=space&a=public_tempate_setting&template='+id ,width:'540px',height:'360px'})
	}

//-->
</script>
</body>
</html>