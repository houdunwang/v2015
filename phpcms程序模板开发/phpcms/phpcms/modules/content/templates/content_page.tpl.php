<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div id="closeParentTime" style="display:none"></div>
<SCRIPT LANGUAGE="JavaScript">
<!--
if(window.top.$("#current_pos").data('clicknum')==1) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=content&c=content&a=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}
$(document).ready(function(){
	setInterval(closeParent,3000);
});
function closeParent() {
	if($('#closeParentTime').html() == '') {
		window.top.$(".left_menu").addClass("left_menu_on");
		window.top.$("#openClose").addClass("close");
		window.top.$("html").addClass("on");
		$('#closeParentTime').html('1');
		window.top.$("#openClose").data('clicknum',1);
	}
}
//-->
</SCRIPT>
<div class="pad-lr-10">
<div class="pad-10">
<div class="content-menu ib-a blue line-x"><a href="javascript:;" class=on><em><?php echo L('page_manage');?></em></a><span>|</span> <a href="<?php if(strpos($category['url'],'http://')===false) echo siteurl($this->siteid);echo $category['url'];?>" target="_blank"><em><?php echo L('click_vistor');?></em></a> <span>|</span> <a href="?m=block&c=block_admin&a=public_visualization&catid=<?php echo $catid;?>&type=page"><em><?php echo L('visualization_edit');?></em></a> 
</div>
</div>

<form name="myform" action="?m=content&c=content&a=add" method="post" enctype="multipart/form-data">
<div class="pad_10">
<div style='overflow-y:auto;overflow-x:hidden' class='scrolltable'>
<table width="100%" cellspacing="0" class="table_form contentWrap">
<tr>
	 <th width="80"> <?php echo L('title');?>	  </th>
      <td><input type="text" style="width:400px;" name="info[title]" id="title" value="<?php echo $title?>" style="color:<?php echo $style;?>" class="measure-input " onBlur="$.post('api.php?op=get_keywords&number=3&sid='+Math.random()*5, {data:$('#title').val()}, function(data){if(data && $('#keywords').val()=='') $('#keywords').val(data); })"/>
		<input type="hidden" name="style_color" id="style_color" value="<?php echo $style_color;?>">
		<input type="hidden" name="style_font_weight" id="style_font_weight" value="<?php echo $style_font_weight;?>">
		<img src="statics/images/icon/colour.png" width="15" height="16" onclick="colorpicker('title_colorpanel','set_title_color');" style="cursor:hand"/> 
		<img src="statics/images/icon/bold.png" width="10" height="10" onclick="input_font_bold()" style="cursor:hand"/> <span id="title_colorpanel" style="position:absolute; z-index:200" class="colorpanel"></span>  </td>
    </tr>
<tr>
      <th width="80"> <?php echo L('keywords');?>	  </th>
      <td><input type="text" name="info[keywords]" id="keywords" value="<?php echo $keywords?>" size="50">  <?php echo L('explode_keywords');?></td>
    </tr>

<tr>
 <th width="80"> <?php echo L('content');?>	  </th>
<td>
<textarea name="info[content]" id="content"><?php echo $content?></textarea>
<?php echo form::editor('content','full','','','',1,1)?>
</td></tr>
</table>
</div>
<div class="bk10"></div>
<div class="btn">
<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
<input type="hidden" name="edit" value="<?php echo $title ? 1 : 0;?>" />
<input type="submit" class="button" name="dosubmit" value="<?php echo L('submit');?>" />
</div> 
  </div>

</form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
</body>
</html>