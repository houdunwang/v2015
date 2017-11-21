<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10"> 
<form name="searchform" action="?m=admin&c=log&a=search_log&menuid=<?php echo $_GET['menuid'];?>" method="get" >
<input type="hidden" value="admin" name="m">
<input type="hidden" value="log" name="c">
<input type="hidden" value="search_log" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"><?php echo L('module')?>: <?php echo form::select($module_arr,'','name="search[module]"',$default)?> <?php echo L('username')?>  <input type="text" value="phpcms" class="input-text" name="search[username]" size='10'>  <?php echo L('times')?>  <?php echo form::date('search[start_time]','','1')?> <?php echo L('to')?>   <?php echo form::date('search[end_time]','','1')?>    <input type="submit" value="<?php echo L('determine_search')?>" class="button" name="dosubmit"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" name="del_log_4" value="<?php echo L('removed_data')?>" onclick="location='?m=admin&c=log&a=delete&week=4&menuid=<?php echo $_GET['menuid'];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>'"  />
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<form name="myform" id="myform" action="?m=admin&c=log&a=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
 <table width="100%" cellspacing="0">
        <thead>
            <tr>
             <th width="80"><?php echo L('username')?></th>
            <th ><?php echo L('module')?></th>
            <th ><?php echo L('file')?></th>
             <th width="120"><?php echo L('time')?></th>
             <th width="120">IP</th>
            </tr>
        </thead>
    <tbody>
 <?php
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr> 
        <td align="center"><?php echo $info['username']?></td>
        <td align="center"><?php echo $info['module']?></td>
        <td align="left" title="<?php echo $info['querystring']?>"><?php echo str_cut($info['querystring'], 40);?></td>
         <td align="center"><?php echo $info['time'];//echo $info['lastusetime'] ? date('Y-m-d H:i', $info['lastusetime']):''?></td>
         <td align="center"><?php echo $info['ip']?>　</td> 
    </tr>
<?php
	}
}
?></tbody>
 </table>
 <div class="btn"> 
</div> 
<div id="pages"><?php echo $pages?></div>

</div>
</form>
</div>
</body>
</html>
<script type="text/javascript"> 
function checkuid() {
	var ids='';
	$("input[name='logid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('select_operations')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
</script>
 