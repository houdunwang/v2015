<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class comment_table_model extends model {
	public $table_name;
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'comment';
		$this->table_name = 'comment_table';
		parent::__construct();
	}
	
	/**
	 * 修改表记录总数
	 * @param integer $tableid  表ID
	 * @param string $num 要修改的数值（如果要添加请使用+=，如果要减少请使用-=）
	 */
	public function edit_total($tableid, $num) {
		return $this->update(array('total'=>$num), array('tableid'=>$tableid));
	}
	
	/**
	 * 创建新的评论数据表
	 * @param integer $id 创建新的评论表
	 */
	public function creat_table($id = '') {
		if (empty($id)) {
			$id = $this->insert(array('creat_at'=>SYS_TIME), true);
		}
		if ($this->query("CREATE TABLE `".$this->db_tablepre."comment_data_".$id."` (`id` int(10) unsigned NOT NULL auto_increment,`commentid` char(30) NOT NULL default '',`siteid` smallint(5) NOT NULL default '0',`userid` int(10) unsigned default '0',`username` varchar(20) default NULL,`creat_at` int(10) default 0,`ip` varchar(15) default NULL,`status` tinyint(1) default '0',`content` text,`direction` tinyint(1) default '0',`support` mediumint(8) unsigned default '0',`reply` tinyint(1) NOT NULL default '0',PRIMARY KEY  (`id`),KEY `commentid` (`commentid`),KEY `direction` (`direction`), KEY `siteid` (`siteid`),KEY `support` (`support`)) ENGINE=MyISAM DEFAULT CHARSET=".$this->db_config[$this->db_setting]['charset'].";")) {
			return $id;
		} else {
			return false;
		}
	}
}
?>