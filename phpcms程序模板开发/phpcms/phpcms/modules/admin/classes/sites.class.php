<?php
/**
 * 站点对外接口
 * @author chenzhouyu
 *
 */
class sites {
	//数据库连接
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('site_model');
	}
	
	/**
	 * 获取站点列表
	 * @param string $roleid 角色ID 留空为获取所有站点列表
	 */
	public function get_list($roleid='') {
		$roleid = intval($roleid);
		if(empty($roleid)) {
			if ($data = getcache('sitelist', 'commons')) {
				return $data;
			} else {
				$this->set_cache();
				return $this->db->select();
			}			
		} else {
			$site_arr = $this->get_role_siteid($roleid);
			$sql = "`siteid` in($site_arr)";
			return $this->db->select($sql);
		}

	}
	
	/**
	 * 按ID获取站点信息
	 * @param integer $siteid 站点ID号
	 */
	public function get_by_id($siteid) {
		return siteinfo($siteid);
	}
	
	/**
	 * 设置站点缓存
	 */
	public function set_cache() {
		$list = $this->db->select();
		$data = array();
		foreach ($list as $key=>$val) {
			$data[$val['siteid']] = $val;
			$data[$val['siteid']]['url'] = $val['domain'] ? $val['domain'] : pc_base::load_config('system', 'web_path').$val['dirname'].'/';
		}
		setcache('sitelist', $data, 'commons');
	}
	
	/**
	 * PC标签中调用站点列表
	 */
	public function pc_tag_list() {
		$list = $this->db->select('', 'siteid,name');
		$sitelist = array(''=>L('please_select_a_site', '', 'admin'));
		foreach ($list as $k=>$v) {
			$sitelist[$v['siteid']] = $v['name'];
		}
		return $sitelist;
	}
	
	/**
	 * 按角色ID获取站点列表
	 * @param string $roleid 角色ID
	 */	
	
	public function get_role_siteid($roleid) {
		$roleid = intval($roleid);
		if($roleid == 1) {
			$sitelists = $this->get_list();
			foreach($sitelists as $v) {
				$sitelist[] = $v['siteid'];
			}
		} else {
			$sitelist = getcache('role_siteid', 'commons');
			$sitelist = $sitelist[$roleid];
		}
		if(is_array($sitelist)) 
		{
			$siteid = implode(',',array_unique($sitelist));
			return $siteid;			
		} else {
			showmessage(L('no_site_permissions'),'?m=admin&c=index&a=login');
		}
	}
}