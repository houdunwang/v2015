<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_func('global', 'video');

class player extends admin {
	public function __construct() {
		parent::__construct();
		$this->userid = $_SESSION['userid'];
		pc_base::load_app_class('ku6api', 'video', 0);

		$this->setting = getcache('video');
		if(empty($this->setting['sn']) || empty($this->setting['skey'])) {
			header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
		}
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
		if(!$this->ku6api->testapi()) {
			header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
		}
	}
	
	/**
	 * 
	 * 视频列表
	 */
	public function init() {
		$infos = $this->player_list(1);
		include $this->admin_tpl('player_list');		
	}
	
	/**
	 * function edit
	 * 修改播放器属性
	 */
	public function edit() {
		if (isset($_POST['dosubmit'])) {
			if(in_array($_POST['field'],array('default','auto','replay','share','show_elite','ssv'))) {
				if(preg_match('/([a-z0-9_\-\.])/i',$_POST['style'])) {
					if ($return = $this->ku6api->player_edit($_POST['field'],$_POST['style'])) {
						echo $return['data'][$_POST['field']];
						$this->player_list();
					}
				}
			}		
		}
	}

	private function player_list($return_data = 0) {
		$infos = $this->ku6api->player_list();
		$infos = $infos['data'];
		
		$player_caches = array();
		foreach($infos as $info) {
			if($info['default']==1) {
				$player_caches[$info['channelid']]['default'] = $info['style'];
			}
			$player_caches[$info['channelid']]['STY-'.$info['style']] = $info;
		}
		setcache('player',$player_caches,'video');
		if($return_data) return $infos;
		/*
		1=>array(
			'default'=> 'idZwHK_aOJ7E-oGT',
			'STY-idZwHK_aOJ7E-oGT'=> array('auto'=>1),
			'STY-7i8TjPi7A3o.'=> array(),
		  ),
		 */
	}
}

?>