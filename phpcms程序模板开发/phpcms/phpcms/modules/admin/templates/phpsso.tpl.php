<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
		<div id="leftMain">
		<h3 class="f14">phpsso<?php echo L('manage')?></h3>
		<ul>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=member&a=manage&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=member&a=manage')?>" target="right"><?php echo L('member_manage')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=applications&a=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=applications&a=init')?>" target="right"><?php echo L('application')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=messagequeue&a=manage&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=messagequeue&a=manage')?>" target="right"><?php echo L('communication')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=credit&a=manage&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=credit&a=manage')?>" target="right"><?php echo L('redeem')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=administrator&a=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=administrator&a=init')?>" target="right"><?php echo L('administrator')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=system&a=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=system&a=init')?>" target="right"><?php echo L('system_setting')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=cache&a=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=cache&a=init')?>" target="right"><?php echo L('update_phpsso_cache')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=password&a=init&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=password&a=init')?>" target="right"><?php echo L('change_password')?></a>
		</li>
		<li class="sub_menu">
		<a style="outline: medium none;" hidefocus="true" href="<?php echo $setting['phpsso_api_url']?>/index.php?m=admin&c=login&a=logout&forward=<?php echo urlencode($setting['phpsso_api_url'].'/index.php?m=admin&c=member&a=manage')?>" target="right"><?php echo L('exit')?>phpsso</a>
		</li>
		</ul>
		</div>
		<script  type="text/javascript">
			$("#leftMain li").click(function() {
				var i =$(this).index() + 1;
				$("#leftMain li").removeClass();
				$("#leftMain li:nth-child("+i+")").addClass("on fb blue");
			});
		</script>