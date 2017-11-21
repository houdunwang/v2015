<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = true;
$show_scroll = true;
include $this->admin_tpl('header');
?>
<body scroll="no">
<div style="padding:6px 3px">
    <div class="col-2 col-left mr6" style="width:140px">
      <h6><img src="<?php echo IMG_PATH?>icon/sitemap-application-blue.png" width="16" height="16" /> <?php echo L('site_select');?></h6>
          <ul class="content role-memu" id="site_list">
          <?php foreach($sites_list as $n=>$r) {?>
            <li><a href="?m=admin&c=role&a=setting_cat_priv&siteid=<?php echo $r['siteid']?>&roleid=<?php echo $roleid?>&op=1" target="role"><span><img src="<?php echo IMG_PATH?>icon/gear_disable.png" width="16" height="16" /><?php echo L('sys_setting');?></span><em><?php echo $r['name']?></em></a></li>
           <?php } ?>
      </ul>
    </div>
    <div class="col-2 col-auto">
        <div class="content" style="padding:1px">
        <iframe name="role" id="role" src="?m=admin&c=role&a=role_priv&pc_hash=<?php echo $_SESSION['pc_hash']?>" frameborder="false" scrolling="auto" style="overflow-x:hidden;border:none" width="100%" height="483" allowtransparency="true"></iframe>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
	$("#site_list li").click(
		function(){$(this).addClass("on").siblings().removeClass('on')}
		);
</script>