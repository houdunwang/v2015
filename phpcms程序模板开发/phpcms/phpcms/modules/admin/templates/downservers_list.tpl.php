<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad-lr-10">
<form name="downform" action="?m=admin&c=downservers&a=init" method="post" >
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"><?php echo L('downserver_name')?>  <input type="text" value="<?php echo $sitename?>" class="input-text" name="info[sitename]">    <?php echo L('downserver_url')?>   <input type="text" value="<?php echo $siteurl?>" class="input-text" name="info[siteurl]" size="50">  <?php echo L('downserver_site');?> <?php echo form::select($sitelist,self::get_siteid(),'name="info[siteid]"',$default)?> <input type="submit" value="<?php echo L('add');?>" class="button" name="dosubmit">
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<form name="myform" action="?m=admin&c=downservers&a=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%"  align="left"><?php echo L('listorder');?></th>
            <th width="10%"  align="left">ID</th>
            <th width="20%"><?php echo L('downserver_name')?></th>
            <th width="35%"><?php echo L('downserver_url')?></th>
            <th width="15%"><?php echo L('downserver_site')?></th>
            <th width="15%"><?php echo L('posid_operation');?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td width="10%">
	<input name='listorders[<?php echo $info['id']?>]' type='text' size='2' value='<?php echo $info['listorder']?>' class="input-text-c">
	</td>	
	<td width="10%"><?php echo $info['id']?></td>
	<td  width="20%" align="center"><?php echo $info['sitename']?></td>
	<td width="35%" align="center"><?php echo $info['siteurl']?></td>
	<td width="15%" align="center"><?php echo $info['siteid'] ? $sitelist[$info['siteid']] : L('all_site')?></td>
	<td width="15%" align="center">
	<a href="javascript:edit(<?php echo $info['id']?>, '<?php echo new_addslashes($info['sitename'])?>')"><?php echo L('edit')?></a> | 
	<a href="javascript:confirmurl('?m=admin&c=downservers&a=delete&id=<?php echo $info['id']?>', '<?php echo L('downserver_del_cofirm')?>')"><?php echo L('delete')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
  
    <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</form>
 <div id="pages"> <?php echo $pages?></div>
</div>
</div>

</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>
<script type="text/javascript">
<!--
	function edit(id, name) {
	window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?m=admin&c=downservers&a=edit&id='+id ,width:'520px',height:'150px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->
</script>