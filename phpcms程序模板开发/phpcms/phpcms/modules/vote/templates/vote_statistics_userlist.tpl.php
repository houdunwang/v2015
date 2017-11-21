<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<div class="col-tab">
        <ul class="tabBut cu-li">
            <li class="on"><a href="?m=vote&c=vote&a=statistics_userlist&subjectid=<?php echo $subjectid;?>"><?php echo L('user_list')?></a></li>
            <li><a href="?m=vote&c=vote&a=statistics&subjectid=<?php echo $subjectid;?>"><?php echo L('vote_result')?></a></li>
        </ul>
            <div class="content pad-10" style="height:auto">
<form name="myform" action="?m=vote&c=vote&a=delete_statistics" method="post">
<div class="table-list">

<br>	
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th><?php echo L('username')?></th>
			<th width="155" align="center"><?php echo L('up_vote_time')?></th>
			<th width="14%" align="center"><?php echo L('ip')?></th>
 		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td><?php if($info['username']=="")echo L('guest');else echo $info['username']?></td>
		<td align="center" width="155"><?php echo date("Y-m-d h-i",$info['time']);?></td>
		<td align="center" width="14%"><?php echo $info['ip'];?></td>
 		</tr>
	<?php
	}
}
?>
</tbody>
</table>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
</div>
</div>
</body>
</html>

<script type="text/javascript">
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edit',iframe:'?m=vote&c=vote&a=edit&subjectid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
</script>
