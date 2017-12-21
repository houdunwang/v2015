<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<style type="text/css">
<!--
.showMsg{border: 1px solid #1e64c8; zoom:1; width:450px; height:172px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px}
.showMsg h5{background-image: url(<?php echo IMG_PATH?>msg_img/msg.png);background-repeat: no-repeat; color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .content{ margin-top:50px; font-size:14px; height:64px; position:relative}
#search_div{ position:absolute; top:23px; border:1px solid #dfdfdf; text-align:left; padding:1px; left:89px;*left:88px; width:263px;*width:260px; background-color:#FFF; display:none; font-size:12px}
#search_div li{ line-height:24px;}
#search_div li a{  padding-left:6px;display:block}
#search_div li a:hover{ background-color:#e2eaff}
-->
</style>
<div class="showMsg" style="text-align:center">
	<h5><?php echo L('quick_into');?></h5>
    <div class="content">
	<input type="text" size="41" id="cat_search" value="<?php echo L('search_category');?>" onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;">
    <ul id="search_div"></ul>
	</div>
</div>
<script type="text/javascript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=content&c=content&a=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}
$(document).ready(function(){
	setInterval(closeParent,5000);
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
$().ready(
function(){
	$('#cat_search').keyup(
		function(){
			var value = $("#cat_search").val();
			if (value.length > 0){
				$.getJSON('?m=admin&c=category&a=public_ajax_search', {catname: value}, function(data){
					if (data != null) {
						var str = '';
						$.each(data, function(i,n){
							if(n.type=='0') {
								str += '<li><a href="?m=content&c=content&a=init&menuid=822&catid='+n.catid+'&pc_hash='+pc_hash+'">'+n.catname+'</a></li>';
							} else {
								str += '<li><a href="?m=content&c=content&a=add&menuid=822&catid='+n.catid+'&pc_hash='+pc_hash+'">'+n.catname+'</a></li>';
							}
						});
						$('#search_div').html(str);
						$('#search_div').show();
					} else {
						$('#search_div').hide();
					}
				});
			} else {
				$('#search_div').hide();
			}
		}
	);
}
)

//-->
</script>
</body>
</html>