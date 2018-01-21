<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = $show_validator = 1;
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		<?php if (is_array($html) && $html['validator']){ echo $html['validator']; unset($html['validator']); }?>
	})
//-->
</script>
<div class="pad-10">
<div class="col-tab">

<ul class="tabBut cu-li">
<li<?php if ($_GET['order']==1 || !isset($_GET['order'])) {?> class="on"<?php }?>><a href="?m=content&c=push&a=init&classname=position_api&action=position_list&order=1&modelid=<?php echo $_GET['modelid']?>&catid=<?php echo $_GET['catid']?>&id=<?php echo $_GET['id']?>"><?php echo L('push_to_position');?></a></li>
<li<?php if ($_GET['order']==2) {?> class="on"<?php }?>><a href="?m=content&c=push&a=init&module=special&action=_push_special&order=2&modelid=<?php echo $_GET['modelid']?>&catid=<?php echo $_GET['catid']?>&id=<?php echo $_GET['id']?>"><?php echo L('push_to_special');?></a></li>
<li<?php if ($_GET['order']==3) {?> class="on"<?php }?>><a href="?m=content&c=push&a=init&module=content&classname=push_api&action=category_list&order=3&tpl=push_to_category&modelid=<?php echo $_GET['modelid']?>&catid=<?php echo $_GET['catid']?>&id=<?php echo $_GET['id']?>"><?php echo L('push_to_category');?></a></li>
</ul>

<div class='content' style="height:auto;">
<form action="?m=content&c=push&a=init&module=<?php echo $_GET['module']?>&action=<?php echo $_GET['action']?>" method="post" name="myform" id="myform"><input type="hidden" name="modelid" value="<?php echo $_GET['modelid']?>"><input type="hidden" name="catid" value="<?php echo $_GET['catid']?>">
<input type='hidden' name="id" value='<?php echo $_GET['id']?>'>
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="public_relationlist" name="a">
<input type="hidden" value="<?php echo $modelid;?>" name="modelid">
<?php
$sitelist = getcache('sitelist','commons');
$siteid = $this->siteid;
	foreach($sitelist as $_k=>$_v) {
		$checked = $_k==$siteid ? 'checked' : '';
		echo "<label class='ib' style='width:128px;padding:5px;'><input type='radio' name='select_siteid' $checked onclick='change_siteid($_k)'> " .$_v['name']."</label>";

	}
?>
<input type="hidden" value="<?php echo $siteid;?>" name="siteid" id="siteid">
</div>
</div>
    <div style="width:500px; padding:2px; border:1px solid #d8d8d8; float:left; margin-top:10px; margin-right:10px">
    <table width="100%" cellspacing="0" class="table-list" >
            <thead>
                <tr>
                <th width="100"><?php echo L('catid');?></th>
                <th ><?php echo L('catname');?></th>
                <th width="150" ><?php echo L('select_model_name');?></th>
                </tr>
            </thead>
        <tbody id="load_catgory">
        <?php echo $categorys;?>
        </tbody>
        </table>
    </div>

    <div style="overflow:hidden;_float:left;margin-top:10px;*margin-top:0;_margin-top:0">
    <fieldset>
        <legend><?php echo L('category_checked');?></legend>
    <ul class='list-dot-othors' id='catname'>
    <input type='hidden' name='ids' value="" id="relation"></ul>
    </fieldset>
    </div>
</div>
<style type="text/css">
.line_ff9966,.line_ff9966:hover td{background-color:#FF9966}
.line_fbffe4,.line_fbffe4:hover td {background-color:#fbffe4}
.list-dot-othors li{float:none; width:auto}
</style>

<div class="bk15"></div>

<input type="hidden" name="return" value="<?php echo $return?>" />
<input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</form>

<SCRIPT LANGUAGE="JavaScript">
<!--
	function select_list(obj,title,id) {
		var relation_ids = $('#relation').val();
		var sid = 'v'+id;
		$(obj).attr('class','line_fbffe4');
		var str = "<li id='"+sid+"'>·<span>"+title+"</span><a href='javascript:;' class='close' onclick=\"remove_id('"+sid+"')\"></a></li>";
		$('#catname').append(str);
		if(relation_ids =='' ) {
			$('#relation').val(id);
		} else {
			relation_ids = relation_ids+'|'+id;
			$('#relation').val(relation_ids);
		}
}

function change_siteid(siteid) {
		$("#load_catgory").load("?m=content&c=content&a=public_getsite_categorys&siteid="+siteid);
		$("#siteid").val(siteid);
}
//移除ID
function remove_id(id) {
	$('#'+id).remove();
}
change_siteid(<?php echo $siteid;?>);
//-->
</SCRIPT>