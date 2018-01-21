<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class member_model_model extends model {
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'model';
		parent::__construct();
	}
		
	public function drop_table($tablename) {
		$tablename = $this->db_tablepre.$tablename;
		$tablearr = $this->db->list_tables();
		if(in_array($tablename, $tablearr)) {
			return $this->db->query("DROP TABLE $tablename");
		} else {
			return false;
		}
	}
	
	public function create_table($tablename) {
		$tablename = $this->db_tablepre.$tablename;
		$tablearr = $this->db->list_tables();
		if(!in_array($tablename, $tablearr)) {
			return $this->db->query("CREATE TABLE $tablename (`userid` int(10) unsigned NOT NULL,  UNIQUE KEY `userid` (`userid`)) DEFAULT CHARSET=".CHARSET);
		} else {
			return false;
		}
	}

	/**
	 * 修改member表会员模型
	 * @param unknown_type $tablename
	 */
	public function change_member_modelid($from_modelid, $to_modelid) {
		$tablename = $this->db_tablepre.'member';
		$this->db->update(array('modelid'=>$to_modelid), $tablename, "modelid='$from_modelid'");
	}
}
?>