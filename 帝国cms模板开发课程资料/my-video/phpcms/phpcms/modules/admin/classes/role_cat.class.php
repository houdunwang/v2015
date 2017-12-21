<?php
defined('IN_PHPCMS') or exit('No permission resources.');

class role_cat {
	//数据库连接
	static $db;
	
	private static function _connect() {
		self::$db = pc_base::load_model('category_priv_model');
	}
	
	/**
	 * 获取角色配置权限
	 * @param integer $roleid  角色ID
	 * @param integer $siteid  站点ID
	 */
	public static function get_roleid($roleid, $siteid) {
		if (empty(self::$db)) {
			self::_connect();
		}
		if ($data = self::$db->select("`roleid` = '$roleid' AND `is_admin` = '1' AND `siteid` IN ('$siteid') ")) {
			$priv = array();
			foreach ($data as $k=>$v) {
				$priv[$v['catid']][$v['action']] = true;
			}
			return $priv;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取站点栏目列表
	 * @param integer $siteid  站点ID
	 * @return array()         返回为数组
	 */
	public static function get_category($siteid) {
		$category = getcache('category_content_'.$siteid, 'commons');
		foreach ($category as $k=>$v) {
			if (!in_array($v['type'], array(0,1))) unset($category[$k]); 
		}
		return $category;
	}
	
	/**
	 * 更新数据库信息 
	 * @param integer $roleid   角色ID
	 * @param integer $siteid   站点ID
	 * @param array $data       需要更新的数据
	 */
	public static function updata_priv($roleid, $siteid, $data) {
		if (empty(self::$db)) {
			self::_connect();
		}
		//删除该角色当前的权限
		self::$db->delete(array('roleid'=>$roleid, 'siteid'=>$siteid, 'is_admin'=>1));
		foreach ($data as $k=>$v) {
			if (is_array($v) && !empty($v[0])) {
				foreach ($v as $key=>$val) {
					self::$db->insert(array('siteid'=>$siteid, 'catid'=>$k, 'is_admin'=>1, 'roleid'=>$roleid, 'action'=>$val));
				}
			}
		}
	}
}