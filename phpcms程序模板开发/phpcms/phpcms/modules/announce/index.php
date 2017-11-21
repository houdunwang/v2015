<?php 
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	function __construct() {
		$this->db = pc_base::load_model('announce_model');
	}
	
	public function init() {
		
	}
	
	/**
	 * 展示公告
	 */
	public function show() {
		if(!isset($_GET['aid'])) {
			showmessage(L('illegal_operation'));
		}
		$_GET['aid'] = intval($_GET['aid']);
		$where = '';
		$where .= "`aid`='".$_GET['aid']."'";
		$where .= " AND `passed`='1' AND (`endtime` >= '".date('Y-m-d')."' or `endtime`='0000-00-00')";
		$r = $this->db->get_one($where);
		if($r['aid']) {
			$this->db->update(array('hits'=>'+=1'), array('aid'=>$r['aid']));
			$template = $r['show_template'] ? $r['show_template'] : 'show';
			extract($r);
			$SEO = seo(get_siteid(), '', $title);
			include template('announce', $template, $r['style']);
		} else {
			showmessage(L('no_exists'));	
		}
	}
}
?>