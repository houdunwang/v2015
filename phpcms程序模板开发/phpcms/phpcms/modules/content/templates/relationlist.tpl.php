<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="public_relationlist" name="a">
<input type="hidden" value="<?php echo $modelid;?>" name="modelid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="center">
		<div class="explain-col">
				<select name="field">
					<option value='title' <?php if($_GET['field']=='title') echo 'selected';?>><?php echo L('title');?></option>
					<option value='keywords' <?php if($_GET['field']=='keywords') echo 'selected';?> ><?php echo L('keywords');?></option>
					<option value='description' <?php if($_GET['field']=='description') echo 'selected';?>><?php echo L('description');?></option>
					<option value='id' <?php if($_GET['field']=='id') echo 'selected';?>>ID</option>
				</select>
				<?php echo form::select_category('',$catid,'name="catid"',L('please_select_category'),$modelid,0,1);?>
				<input name="keywords" type="text" value="<?php echo stripslashes($_GET['keywords'])?>" style="width:330px;" class="input-text" />
				<input type="submit" name="dosubmit" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th ><?php echo L('title');?></th>
			<th width="100"><?php echo L('belong_category');?></th>
            <th width="100"><?php echo L('addtime');?></th>
            </tr>
        </thead>
    <tbody>
	<?php foreach($infos as $r) { ?>
	<tr onclick="select_list(this,'<?php echo safe_replace($r['title']);?>',<?php echo $r['id'];?>)" class="cu" title="<?php echo L('click_to_select');?>">
		<td align='left' ><?php echo $r['title'];?></td>
		<td align='center'><?php echo $this->categorys[$r['catid']]['catname'];?></td>
		<td align='center'><?php echo format::date($r['inputtime']);?></td>
	</tr>
	 <?php }?>
	    </tbody>
    </table>
   <div id="pages"><?php echo $pages;?></div>
</div>
</div>
<style type="text/css">
 .line_ff9966,.line_ff9966:hover td{
	background-color:#FF9966;
}
 .line_fbffe4,.line_fbffe4:hover td {
	background-color:#fbffe4;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function select_list(obj,title,id) {
		var relation_ids = window.top.$('#relation').val();
		var sid = 'v<?php echo $modelid;?>'+id;
		if($(obj).attr('class')=='line_ff9966' || $(obj).attr('class')==null) {
			$(obj).attr('class','line_fbffe4');
			window.top.$('#'+sid).remove();
			if(relation_ids !='' ) {
				var r_arr = relation_ids.split('|');
				var newrelation_ids = '';
				$.each(r_arr, function(i, n){
					if(n!=id) {
						if(i==0) {
							newrelation_ids = n;
						} else {
						 newrelation_ids = newrelation_ids+'|'+n;
						}
					}
				});
				window.top.$('#relation').val(newrelation_ids);
			}
		} else {
			$(obj).attr('class','line_ff9966');
			var str = "<li id='"+sid+"'>·<span>"+title+"</span><a href='javascript:;' class='close' onclick=\"remove_relation('"+sid+"',"+id+")\"></a></li>";
			window.top.$('#relation_text').append(str);
			if(relation_ids =='' ) {
				window.top.$('#relation').val(id);
			} else {
				relation_ids = relation_ids+'|'+id;
				window.top.$('#relation').val(relation_ids);
			}
		}
}
//-->
</SCRIPT>
</body>
</html>