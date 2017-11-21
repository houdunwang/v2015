<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class sitemodel_model extends model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'model';
		parent::__construct();
		$this->charset = $this->db_config[$this->db_setting]['charset'];
	}

	public function sql_execute($sql) {
		$sqls = $this->sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					$this->db->query($sql);
				}
			}
		} else {
			$this->db->query($sqls);
		}
		return true;
	}

	public function sql_split($sql) {
		global $db;
		if($this->db->version() > '4.1' && $this->charset) {
			$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$this->charset,$sql);
		}
		if($this->db_tablepre != "phpcms_") $sql = str_replace("phpcms_", $this->db_tablepre, $sql);
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach($queriesarray as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			$queries = array_filter($queries);
			foreach($queries as $query) {
				$str1 = substr($query, 0, 1);
				if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
			}
			$num++;
		}
		return($ret);
	}

	/**
	 * 删除表
	 * 
	 */
	public function drop_table($tablename) {
		$tablename = $this->db_tablepre.$tablename;
		$tablearr = $this->db->list_tables();
		if(in_array($tablename, $tablearr)) {
			return $this->db->query("DROP TABLE $tablename");
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