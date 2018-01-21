<?php 
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	function __construct() {
		$this->db = pc_base::load_model('poster_model');
		$this->s_db = pc_base::load_model('poster_stat_model');
	}
	
	public function init() {
		
	}
	
	/**
	 * 统计广告点击次数
	 * 
	 */
	public function poster_click() {
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$r = $this->db->get_one(array('id'=>$id));
		if (!is_array($r) && empty($r)) return false;
		$ip_area = pc_base::load_sys_class('ip_area');
		$ip = ip();
		$area = $ip_area->get($ip);
		$username = param::get_cookie('username') ? param::get_cookie('username') : '';
		if($id) {
			$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
			$this->s_db->insert(array('siteid'=>$siteid, 'pid'=>$id, 'username'=>$username, 'area'=>$area, 'ip'=>$ip, 'referer'=>safe_replace(HTTP_REFERER), 'clicktime'=>SYS_TIME, 'type'=> 1));
		}
		$this->db->update(array('clicks'=>'+=1'), array('id'=>$id));
		$setting = string2array($r['setting']);
		if (count($setting)==1) {
			$url = $setting['1']['linkurl'];
		} else {
			$url = isset($_GET['url']) ? $_GET['url'] : $setting['1']['linkurl'];
		}
		header('Location: '.$url);
	}
	
	/**
	 * php方式展示广告
	 */
	public function show_poster() {
		if(!$_GET['id']) exit();
		$id = intval($_GET['id']);
		$sdb = pc_base::load_model('poster_space_model');
		$now = SYS_TIME;
		$siteid = get_siteid();
		$r = $sdb->get_one(array('siteid'=>$siteid, 'spaceid'=>$id));
		if(!$r) exit();
		if($r['setting']) $r['setting'] = string2array($r['setting']);
		$poster_template = getcache('poster_template_'.$siteid, 'commons');
		if ($poster_template[$r['type']]['option']) {
			$where = "`spaceid`='".$id."' AND `disabled`=0 AND `startdate`<='".$now."' AND (`enddate`>='".$now."' OR `enddate`=0) ";
			$pinfo = $this->db->select($where, '*', '', '`listorder` ASC, `id` DESC');
			if (is_array($pinfo) && !empty($pinfo)) {
				foreach ($pinfo as $k => $rs) {
					if ($rs['setting']) {
						$rs['setting'] = string2array($rs['setting']);
						$pinfo[$k] = $rs;
					} else {
						unset($pinfo[$k]);
					}
				}
				extract($r);
			} else {
				return true;
			}
		} else {
			$where = " `spaceid`='".$id."' AND `disabled`=0 AND `startdate`<='".$now."' AND (`enddate`>='".$now."' OR `enddate`=0)";
			$pinfo = $this->db->get_one($where, '*', '`listorder` ASC, `id` DESC');
			if (is_array($pinfo) && $pinfo['setting']) {
				$pinfo['setting'] = string2array($pinfo['setting']);
			}
			extract($r);
			if (!is_array($pinfo) || empty($pinfo)) return true;
			extract($pinfo, EXTR_PREFIX_SAME , 'p');
		}
		include template('poster', $type);
	}
	
	/**
	 * js传值，统计展示次数
	 */
	public function show() {
		$siteid = $_GET['siteid'] ? intval($_GET['siteid']) : get_siteid();
		$spaceid = $_GET['spaceid'] ? intval($_GET['spaceid']) : 0;
		$id = $_GET['id'] ? intval($_GET['id']) : 0;
		if (!$spaceid || !$id) {
			exit(0);
		} else {
			$this->show_stat($siteid, $spaceid, $id);
		}
	}
	
	/**
	 * 统计广告展示次数
	 * @param intval $siteid 站点ID
	 * @param intval $spaceid 广告版位ID
	 * @param intval $id 广告ID
	 * @return boolen 
	 */
	protected function show_stat($siteid = 0, $spaceid = 0, $id = 0) {
		$M = new_html_special_chars(getcache('poster', 'commons'));
		if(isset($M[$siteid]['enablehits']) && $M[$siteid]['enablehits']==0) return true; 
		//$siteid = intval($siteid);
		$spaceid = intval($spaceid);
		$id = intval($id);
		if(!$id) return false;
		if(!$siteid || !$spaceid) {
			$r = $this->db->get_one(array('id'=>$id), 'siteid, spaceid');
			$siteid = $r['id'];
			$spaceid = $r['spaceid'];
		}
		$ip = ip();
		$ip_area = pc_base::load_sys_class('ip_area');
		$area = $ip_area->get($ip);
		$username = param::get_cookie('username') ? param::get_cookie('username') : '';
		$this->db->update(array('hits'=>'+=1'), array('id'=>$id));
		$this->s_db->insert(array('pid'=>$id, 'siteid'=>$siteid, 'spaceid'=>$spaceid, 'username'=>$username, 'area'=>$area, 'ip'=>$ip, 'referer'=>safe_replace(HTTP_REFERER), 'clicktime'=>SYS_TIME, 'type'=>0));
		return true;
	}
}
?>