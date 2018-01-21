<?php
defined('IN_PHPCMS') or exit('No permission resources.');

//定义在后台
define('IN_ADMIN',true);
class role_op {	
	public function __construct() {
		$this->db = pc_base::load_model('admin_role_model');
		$this->priv_db = pc_base::load_model('admin_role_priv_model');
	}
	/**
	 * 获取角色中文名称
	 * @param int $roleid 角色ID
	 */
	public function get_rolename($roleid) {
		$roleid = intval($roleid);
		$search_field = '`roleid`,`rolename`';
		$info = $this->db->get_one(array('roleid'=>$roleid),$search_field);
		return $info;
	}
		
	/**
	 * 检查角色名称重复
	 * @param $name 角色组名称
	 */
	public function checkname($name) {
		$info = $this->db->get_one(array('rolename'=>$name),'roleid');
		if($info[roleid]){
			return true;
		}
		return false;
	}
	
	/**
	 * 获取菜单表信息
	 * @param int $menuid 菜单ID
	 * @param int $menu_info 菜单数据
	 */
	public function get_menuinfo($menuid,$menu_info) {
		$menuid = intval($menuid);
		unset($menu_info[$menuid][id]);
		return $menu_info[$menuid];
	}
	
	/**
	 *  检查指定菜单是否有权限
	 * @param array $data menu表中数组
	 * @param int $roleid 需要检查的角色ID
	 */
	public function is_checked($data,$roleid,$siteid,$priv_data) {
		$priv_arr = array('m','c','a','data');
		if($data['m'] == '') return false;
		foreach($data as $key=>$value){
			if(!in_array($key,$priv_arr)) unset($data[$key]);
		}
		$data['roleid'] = $roleid;
		$data['siteid'] = $siteid;
		$info = in_array($data, $priv_data);
		if($info){
			return true;
		} else {
			return false;
		}
		
	}
	/**
	 * 是否为设置状态
	 */
	public function is_setting($siteid,$roleid) {
		$siteid = intval($siteid);
		$roleid = intval($roleid);
		$sqls = "`siteid`='$siteid' AND `roleid` = '$roleid' AND `m` != ''";
		$result = $this->priv_db->get_one($sqls);
		return $result ? true : false;
	}
	/**
	 * 获取菜单深度
	 * @param $id
	 * @param $array
	 * @param $i
	 */
	public function get_level($id,$array=array(),$i=0) {
		foreach($array as $n=>$value){
			if($value['id'] == $id)
			{
				if($value['parentid']== '0') return $i;
				$i++;
				return $this->get_level($value['parentid'],$array,$i);
			}
		}
	}
}
?>