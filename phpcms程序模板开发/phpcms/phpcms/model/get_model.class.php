<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class get_model extends model {
	public $db_config, $db_setting;
	public function __construct($db_config = array(), $db_setting = '') {
		if (!$db_config) {
			$this->db_config = pc_base::load_config('database');
		} else {
			$this->db_config = $db_config;
		}
		if (!$db_setting) {
			$this->db_setting = 'default';
		} else {
			$this->db_setting = $db_setting;
		}
		
		parent::__construct();
		if ($db_setting && $db_config[$db_setting]['db_tablepre']) {
			$this->db_tablepre = $db_config[$db_setting]['db_tablepre'];
		}
	}
	
	public function sql_query($sql) {
		if (!empty($this->db_tablepre)) $sql = str_replace('phpcms_', $this->db_tablepre, $sql);
		return parent::query($sql);
	}
	
	public function fetch_next() {
		return $this->db->fetch_next();
	}
}
?>