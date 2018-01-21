<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<link href="<?php echo CSS_PATH?>appcenter.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.switchable.min.js"></script>
<div class="pad_10">
<div class="wx980">
<div class="infoba" id="ibar">
 
</div>
<div class="row1">
  <div id="mboxs" class="mbox">
    <div>
		<?php if(is_array($focus_data)) foreach ($focus_data as $f) {?>
        <a <?php if($f[islink]) {?>href="<?php echo $f['url']?>" target="_blank"<?php } else {?> href="?m=admin&c=plugin&a=appcenter_detail&id=<?php echo $f['appid']?>"<?php } ?>><img src="<?php echo $f['thumb']?>"/></a>
		<?php } ?>

    </div>
  </div>
  <div id="tagers" class="sbox"></div>
</div>
  <div class="rr2">
    <div class="row2">
      <div class="l jj"></div>
      <ul class="r cola li20" id="ul0s">
      	  <?php if(is_array($recommed_data['list'])) foreach ($recommed_data['list'] as $r) {?>
        <li>
          <div><a href="?m=admin&c=plugin&a=appcenter_detail&id=<?php echo $r['id']?>" title="test" rel="<?php echo $r['id']?>"><img src="<?php echo $r['thumb'] ? $r['thumb'] : IMG_PATH.'zz_bg.jpg'?>" width="55" height="55" /></a><a href="?m=admin&c=plugin&a=appcenter_detail&id=<?php echo $r['id']?>" title="test" class="mgt6"><?php echo $r['appname']?></a></div>
        </li>
         <?php }?>
        <li style="width:100%; height:0; font-size:0; overflow:hidden;"></li>
      </ul>
      <div style="clear:both;"></div>
    </div>
  </div>
  <div class="row3"> <a href="javascript:;"  class="ac"><?php echo L('plugin_app_all','','plugin')?><span class="sja"></span></a></div>
  <div class="rr3 cr">
    <div class="row4">
      <ul class="col col4 fy" id="ul1s">
	     <?php if(is_array($data['list'])) foreach ($data['list'] as $r) {?>
        <li>
          <div><a href="?m=admin&c=plugin&a=appcenter_detail&id=<?php echo $r['id']?>" title="<?php echo $r['appname']?>" rel="<?php echo $r['id']?>"><img src="<?php echo $r['thumb'] ? $r['thumb'] : IMG_PATH.'zz_bg.jpg'?>" width="55" height="55" /></a>
            <h5><?php echo str_cut($r['appname'],16,'')?></h5>
            <span><?php echo $r['isfree'] ? L('plugin_free','','plugin') : L('plugin_not_free','','plugin')?></span><br />
           </div>
        </li>
		<?php }?>
      </ul>
    </div>
  </div>
  <div id="pages"><?php echo $pages?></div>
</div>
<script type="text/javascript">
	$(document).ready(function(e) {
        $("#ul0s > li div").bind("mouseenter",function(e){
			var id = $(this).children('a').attr('rel');
			get_ajx_detail(id);
			var zj = $(this).offset();$("#ul0s").append($("#ibar"));$("#ibar").addClass("xs").css({"left":zj.left+92,"top":zj.top-150});$("#ibar").mouseleave(function(){$(this).removeClass("xs");});
			});
		$("#ul1s > li div").bind("mouseenter",function(e){
			var id = $(this).children('a').attr('rel');
			get_ajx_detail(id);
			var zj = $(this).offset();$("#ul1s").append($("#ibar"));$("#ibar").addClass("xs").css({"left":zj.left+92,"top":zj.top-150});$("#ibar").mouseleave(function(){$(this).removeClass("xs");});
			});
		$('#tagers').switchable('#mboxs > div > a', {effect: 'scroll',speed: .2,vertical: true}).autoplay(6).carousel().mousewheel();

    });
	function get_ajx_detail(id) {
		$.getJSON('?m=admin&c=plugin&a=public_appcenter_ajx_detail&jsoncallback=?&id='+id+'&pc_hash='+pc_hash,function(a){
			var isfree = a.isfree == 1 ? '<?php echo L('plugin_free','','plugin')?>' : '<?php echo L('plugin_not_free','','plugin')?>'
			$("#ibar").html('<div class="lsj"></div><div class="cr r1"> <img src="'+a.thumb+'" width="55" height="55" /></a><h5>'+a.appname+'</h5><span class="grayt">'+isfree+'</span></div><p class="nr">'+a.description+'</p><div class="r2"><div class="jx l"><span class="xx3"></span></div><span class="l">(3)</span><div class="zz"><?php echo L('plugin_author','','plugin')?>：'+a.username+'</div></div>');
		});	
	}



</script>
</div>
</body>
</html>