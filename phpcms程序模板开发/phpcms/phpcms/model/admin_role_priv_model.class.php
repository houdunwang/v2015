<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class admin_role_priv_model extends model {
	public $table_name = '';
	function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'admin_role_priv';
		parent::__construct();
	}
}
?>