<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<div class="table-list">
<form method="post" name="myform" id="myform" action="?m=admin&c=database&a=export">
<input type="hidden" name="tabletype" value="db" id="phpcmstables">
<table width="100%" cellspacing="0">
<thead>
  	<tr>
    	<th class="tablerowhighlight" colspan=4><?php echo L('backup_setting')?></th>
  	</tr>
</thead>
  	<tr>
	    <td class="align_r"><?php echo L('sizelimit')?></td>
	    <td colspan=3><input type=text name="sizelimit" value="2048" size=5> K</td>
  	</tr>
   	<tr>
	    <td class="align_r"><?php echo L('sqlcompat')?></td>
	    <td colspan=3><input type="radio" name="sqlcompat" value="" checked> <?php echo L('default')?> &nbsp; <input type="radio" name="sqlcompat" value="MYSQL40"> MySQL 3.23/4.0.x &nbsp; <input type="radio" name="sqlcompat" value="MYSQL41"> MySQL 4.1.x/5.x &nbsp;</td>
  	</tr>
   	<tr>
	    <td class="align_r"><?php echo L('sqlcharset')?></td>
	    <td colspan=3><input type="radio" name="sqlcharset" value="" checked> <?php echo L('default')?>&nbsp; <input type="radio" name="sqlcharset" value="latin1"> LATIN1 &nbsp; <input type="radio" name="sqlcharset" value='utf8'> UTF-8</option></td>
  	</tr>
  	<tr>
	    <td class="align_r"><?php echo L('select_pdo')?></td>
	    <td colspan=3><?php echo form::select($pdos,$pdo_name,'name="pdo_select" onchange="show_tbl(this)"',L('select_pdo'))?></td>
  	</tr>
  	<tr>
	    <td></td>
	    <td colspan=3><input type="submit" name="dosubmit" value=" <?php echo L('backup_starting')?> " class="button"></td>
  	</tr>
</table>
    <table width="100%" cellspacing="0">
 <?php 
if(is_array($infos)){
?>   
	<thead><tr><th align="center" colspan="8"><strong><?php echo $pdo_name?> <?php echo L('pdo_name')?></strong></th></tr></thead>
    <thead>
       <tr>
           <th width="10%"><input type="checkbox" value="" id="check_box" onclick="selectall('tables[]');"> <a class="cu" href="javascript:void(0);" onclick="reselect()"><?php echo L('reselect')?></a></th>
           <th width="10%" ><?php echo L('database_tblname')?></th>
           <th width="10%"><?php echo L('database_type')?></th>
           <th width="10%"><?php echo L('database_char')?></th>
           <th width="15%"><?php echo L('database_records')?></th>
           <th width="15%"><?php echo L('database_size')?></th>
           <th width="15%"><?php echo L('database_block')?></th>
            <th width="15%"><?php echo L('database_op')?></th>
       </tr>
    </thead>
    <tbody>
	<?php foreach($infos['phpcmstables'] as $v){?>
	<tr>
	<td  width="5%" align="center"><input type="checkbox" name="tables[]" value="<?php echo $v['name']?>"/></td>
	<td  width="10%" align="center"><?php echo $v['name']?></td>
	<td  width="10%" align="center"><?php echo $v['engine']?></td>
	<td  width="10%" align="center"><?php echo $v['collation']?></td>
	<td  width="15%" align="center"><?php echo $v['rows']?></td>
	<td  width="15%" align="center"><?php echo $v['size']?></td>
	<td  width="15%" align="center"><?php echo $v['data_free']?></td>
	<td  width="15%" align="center"><a href="?m=admin&c=database&a=public_repair&operation=optimize&pdo_name=<?php echo $pdo_name?>&tables=<?php echo $v['name']?>"><?php echo L('database_optimize')?></a> | <a href="?m=admin&c=database&a=public_repair&operation=repair&pdo_name=<?php echo $pdo_name?>&tables=<?php echo $v['name']?>"><?php echo L('database_repair')?></a> | <a href="javascript:void(0);" onclick="showcreat('<?php echo $v['name']?>','<?php echo $pdo_name?>')"><?php echo L('database_showcreat')?></a></td>
	</tr>
	<?php } ?>
	</tbody>
<?php 
}
?>
</table>
 <?php 
if(is_array($infos)){
?>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label>
<input type="button" class="button" onclick="reselect()" value="<?php echo L('reselect')?>"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=admin&c=database&a=public_repair&operation=optimize&pdo_name=<?php echo $pdo_name?>'" value="<?php echo L('batch_optimize')?>"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=admin&c=database&a=public_repair&operation=repair&pdo_name=<?php echo $pdo_name?>'" value="<?php echo L('batch_repair')?>"/>
</div>
<?php 
}
?>
</form>
</div>
</div>
</form>
</body>
<script type="text/javascript">
<!--
function show_tbl(obj) {
	var pdoname = $(obj).val();
	location.href='?m=admin&c=database&a=export&pdoname='+pdoname+'&pc_hash=<?php echo $_SESSION['pc_hash']?>';
}
function showcreat(tblname, pdo_name) {
	window.top.art.dialog({title:tblname, id:'show', iframe:'?m=admin&c=database&a=public_repair&operation=showcreat&pdo_name='+pdo_name+'&tables=' +tblname,width:'500px',height:'350px'});
}
function reselect() {
	var chk = $("input[name=tables[]]");
	var length = chk.length;
	for(i=0;i < length;i++){
		if(chk.eq(i).attr("checked")) chk.eq(i).attr("checked",false);
		else chk.eq(i).attr("checked",true);
	}
}
//-->
</script>
</html>
