<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
class mood_admin extends admin {
	
	public function __construct() {
		parent::__construct();
	}
	
	//排行榜查看
	public function init() {
		$mood_program = getcache('mood_program', 'commons');
		$mood_program = isset($mood_program[$this->get_siteid()]) ? $mood_program[$this->get_siteid()] : array();
		$mood_db = pc_base::load_model('mood_model');
		$catid = isset($_GET['catid']) &&  intval($_GET['catid']) ? intval($_GET['catid']) : '';
		$datetype = isset($_GET['datetype']) &&  intval($_GET['datetype']) ? intval($_GET['datetype']) : 0;
		$order = isset($_GET['order']) &&  intval($_GET['order']) ? intval($_GET['order']) : 0;
		$sql = '';
		if ($catid) {
			$sql = "`catid` = '$catid' AND `siteid` = '".$this->get_siteid()."'";
			switch ($datetype) {
				case 1://今天
					$sql .= " AND `lastupdate` BETWEEN '".(strtotime(date('Y-m-d')." 00:00:00"))."' AND '".(strtotime(date('Y-m-d')." 23:59:59"))."'";
					break;
					
				case 2://昨天
					$sql .= " AND `lastupdate` BETWEEN '".(strtotime(date('Y-m-d')." 00:00:00")-86400)."' AND '".(strtotime(date('Y-m-d')." 23:59:59")-86400)."'";
					break;
					
				case 3://本周
					$week = date('w');
					if (empty($week)) $week = 7;
					$sql .= " AND `lastupdate` BETWEEN '".(strtotime(date('Y-m-d')." 23:59:59")-86400*$week)."' AND '".(strtotime(date('Y-m-d')." 23:59:59")+(86400*(7-$week)))."'";
					break;
				
				case 4://本月
					$day = date('t');
					$sql .= " AND `lastupdate` BETWEEN '".strtotime(date('Y-m-1')." 00:00:00")."' AND '".strtotime(date('Y-m-'.$day)." 23:59:59")."'";
					break;
					
				case 5://所有
					$sql .= " AND `lastupdate` <= '".SYS_TIME."'";
					break;
			}
			$sql_order = '';
			if ($order == '-1') {
				$sql_order = " `total` desc";
			} elseif ($order) {
				$sql_order = "`n$order` desc";
			}
			$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
			$data = $mood_db->listinfo($sql, $sql_order, $page);
			$content_db = pc_base::load_model('content_model'); 
			$contentid = '';
			foreach ($data as $v) {
				$contentid .= $contentid ? "','".$v['contentid'] : $v['contentid'];
			}
			$content_db->set_catid($catid);
			$content_data = $content_db->select("`id` IN ('$contentid')", 'id,url,title');
			foreach ($content_data as $k=>$v) {
				$content_data[$v['id']] = array('title'=>$v['title'], 'url'=>$v['url']);
				unset($content_data[$k]);
			}
			$pages = $mood_db->pages;
		}
		$order_list = array('-1'=>L('total'));
		foreach ($mood_program as $k=>$v) {
			$order_list[$k]=$v['name'];
		}
		pc_base::load_sys_class('form', '', 0);
		include $this->admin_tpl('mood_list');
	}
	
	//配置
	public function setting() {
		$mood_program = getcache('mood_program', 'commons');
		if (isset($_POST['dosubmit'])) {
			$use = isset($_POST['use']) ? $_POST['use'] : '';
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$pic = isset($_POST['pic']) ? $_POST['pic'] : '';
			$data = array();
			foreach ($name as $k=>$v) {
				$data[$k] = array('use'=>$use[$k], 'name'=>$v, 'pic'=>$pic[$k]);
			}
			$mood_program[$this->get_siteid()] = $data;
			setcache('mood_program', $mood_program, 'commons');
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$mood_program = isset($mood_program[$this->get_siteid()]) ? $mood_program[$this->get_siteid()] : array();
			include $this->admin_tpl('mood_setting');
		}
	}
}