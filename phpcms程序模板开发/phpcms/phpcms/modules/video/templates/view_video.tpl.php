<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
	echo player_code('video_player',$r['channelid'],$r['vid'],450,350);
?>