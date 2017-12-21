<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="subnav">
  <h1 class="title-2 line-x"><?php echo $node['name']?> - <?php echo L('content_list')?></h1>
</div>

<div class="pad-lr-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li <?php if(empty($status)) echo 'class="on" '?>id="tab_1"><a href="?m=collection&c=node&a=publist&nodeid=<?php echo $nodeid?>"><?php echo L('all')?></a></li>
<li <?php if($status==1) echo 'class="on" '?>id="tab_1"><a href="?m=collection&c=node&a=publist&nodeid=<?php echo $nodeid?>&status=1"><?php echo L('if_bsnap_then')?></a></li>
<li <?php if($status==2) echo 'class="on" '?> id="tab_2"><a href="?m=collection&c=node&a=publist&nodeid=<?php echo $nodeid?>&status=2"><?php echo L('spidered')?></a></li>
<li <?php if($status==3) echo 'class="on" '?> id="tab_3"><a href="?m=collection&c=node&a=publist&nodeid=<?php echo $nodeid?>&status=3"><?php echo L('imported')?></a></li>
</ul>
<div class="content pad-10" id="show_div_1" style="height:auto">
<form name="myform" id="myform" action="" method="get">
<div id="form_">
<input type="hidden" name="m" value="collection" />
<input type="hidden" name="c" value="node" />
<input type="hidden" name="a" value="content_del" />
</div>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th align="left"><?php echo L('status')?></th>
			<th align="left"><?php echo L('title')?></th>
			<th align="left"><?php echo L('url')?></th>
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($data) && !empty($data))foreach($data as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['id']?>" name="id[]"></td>
		<td align="left"><?php if ($v['status'] == '0') {echo L('if_bsnap_then');} elseif ($v['status'] == 1) {echo L('spidered');} elseif ($v['status'] == 2) {echo L('imported');} ?></td>
		<td align="left"><?php echo $v['title']?></td>
		<td align="left"><?php echo $v['url']?></td>
		<td align="left"><a href="javascript:void(0)" onclick="$('#tab_<?php echo $v['id']?>').toggle()"><?php echo L('view')?></a></td>
    </tr>
      <tr id="tab_<?php echo $v['id']?>" style="display:none">
		<td align="left" colspan="5"><textarea style="width:98%;height:300px;"><?php echo new_html_special_chars(print_r(string2array($v['data']),true))?></textarea></td>
    </tr>
<?php
	}

?>
</tbody>
</table>

<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="re_url('m=collection&c=node&a=content_del&nodeid=<?php echo $nodeid?>');return check_checkbox(1);"/> 
<input type="submit" class="button" name="dosubmit"  onclick="re_url('m=collection&c=node&a=content_del&nodeid=<?php echo $nodeid?>&history=1');return check_checkbox(1);" value="<?php echo L('also_delete_the_historical')?>"/> 
<input type="submit" class="button" name="dosubmit" onclick="re_url('m=collection&c=node&a=import&nodeid=<?php echo $nodeid?>');return check_checkbox();" value="<?php echo L('import_selected')?>"/>
<input type="submit" class="button" name="dosubmit"  onclick="re_url('m=collection&c=node&a=import&type=all&nodeid=<?php echo $nodeid?>')" value="<?php echo L('import_all')?>"/>
</div>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
</div>
<script type="text/javascript">
<!--
function re_url(url) {
	var urls = url.split('&');
	var num = urls.length;
	var str = '';
	for (var i=0;i<num;i++){
		var a = urls[i].split('=');
		str +='<input type="hidden" name="'+a[0]+'" value="'+a[1]+'" />';
	}
	$('#form_').html(str);
}

function check_checkbox(obj) {
	var checked = 0;
	$("input[type='checkbox'][name='id[]']").each(function (i,n){if (this.checked) {
		checked = 1;
	}});
	if (checked != 0) {
		if (obj) {
			if (confirm('<?php echo L('sure_delete')?>')) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	} else {
		alert('<?php echo L('select_article')?>');
		return false;
	}
}
window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>