<?php 
defined('IN_ADMIN') or exit('No permission resources.'); 
$show_header = $show_validator = $show_scroll = 1; 
include $this->admin_tpl('header','admin');
?>
<br />
<div class="pad-lr-10">
<div id="searchid" style="display:">
<form name="searchform" action="" method="get" >
<input type="hidden" value="special" name="m">
<input type="hidden" value="special" name="c">
<input type="hidden" value="import" name="a">
<input type="hidden" value="<?php echo $_GET['specialid']?>" name="specialid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 			<?php echo $model_form?>&nbsp;&nbsp; <?php echo L('keyword')?>：<input type='text' name="key" id="key" value="<?php echo $_GET['key'];?>" size="25"> <div class="bk10"></div>
<span id="catids"></span>&nbsp;&nbsp; 
				<?php echo L('input_time')?>：
				<?php $start_f = $_GET['start_time'] ? $_GET['start_time'] : format::date(SYS_TIME-2592000);$end_f = $_GET['end_time'] ? $_GET['end_time'] : format::date(SYS_TIME+86400);?>
				<?php echo form::date('start_time')?> - <?php echo form::date('end_time')?>
				 <input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<div class="table-list">
<form name="myform" id="myform" action="?m=special&c=special&a=import&specialid=<?php echo $_GET['specialid']?>&modelid=<?php echo $_GET['modelid']?>" method="post">
    <table width="100%">
        <thead>
            <tr>
			<th width="40"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="43"><?php echo L('listorder')?></th>
			<th><?php echo L('content_title')?></th>
            </tr>
        </thead>
<tbody>
    <?php if(is_array($data)) { foreach ($data as $r) {?>
        <tr>
		<td align="center" width="40"><input type="checkbox" class="inputcheckbox " name='ids[]' value="<?php echo $r['id'];?>"></td>
        <td align='center' width='43'><input name='listorders[<?php echo $r['id'];?>]' type='text' size='3' value='<?php echo $r['listorder'];?>' class='input-text-c'></td>
		<td><?php echo $r['title'];?></td>
	</tr>
     <?php } }?>
</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label> <?php echo form::select($types, '', 'name="typeid" id="typeid"', L('please_choose_type'))?><span id="msg_id"></span> <input type="submit" name="dosubmit" id="dosubmit" class="button" value="<?php echo L('import')?>" /> </div>
    <div id="pages"><?php echo $pages;?></div>
</form>
</div>
</div>
</body>
</html>
<script type="text/javascript">
	function select_categorys(modelid, id) {
		if(modelid) {
			$.get('', {m: 'special', c: 'special', a: 'public_categorys_list', modelid: modelid, catid: id, pc_hash: pc_hash }, function(data){
				if(data) {
					$('#catids').html(data);
				} else $('#catids').html('');
			});
		}
	}
	select_categorys(<?php echo $_GET['modelid']?>, <?php echo $_GET['catid']?>);
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
		$("#typeid").formValidator({tipid:"msg_id",onshow:"<?php echo L('please_choose_type')?>",oncorrect:"<?php echo L('true')?>"}).inputValidator({min:1,onerror:"<?php echo L('please_choose_type')?>"});	
	});
	$("#myform").submit(function (){
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')=='checked') str = 1;
		});
		if(str==0) {
			alert('<?php echo L('choose_news')?>');
			return false;
		}
		return true;
	});
</script>