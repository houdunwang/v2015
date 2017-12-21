<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class sitemodel_field_model extends model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'model_field';
		parent::__construct();
	}
	/**
	 * 删除字段
	 * 
	 */
	public function drop_field($tablename,$field) {
		$this->table_name = $this->db_tablepre.$tablename;
		$fields = $this->get_fields();
		if(in_array($field, array_keys($fields))) {
			return $this->db->query("ALTER TABLE `$this->table_name` DROP `$field`;");
		} else {
			return false;
		}
	}
	
	/**
	 * 改变数据表
	 */
	public function change_table($tablename = '') {
		if (!$tablename) return false;
		
		$this->table_name = $this->db_tablepre.$tablename;
		return true;
	}
}
?>