<?php
/**
 * search_api.class.php 专题执行接口类
 * 
 */
defined('IN_PHPCMS') or exit('No permission resources.');

class search_api {
	private $db, $c;
	
	public function __construct() {
		$this->db = pc_base::load_model('special_content_model');
		$this->c = pc_base::load_model('special_c_data_model');
	}
	
	/**
	 * 获取内容接口
	 * @param intval $pagesize 每页个数
	 * @param intval $page 当前页数
	 */
	public function fulltext_api($pagesize = 100, $page = 1) {
		$result = $r = $data = $tem = array();
		$offset = ($page-1)*$pagesize;
		$result = $this->db->select(array('isdata'=>1), '`id`, `title`, `inputtime`', $offset.','.$pagesize, '`id` ASC');
		foreach ($result as $r) {
			$d = $this->c->get_one(array('id'=>$r['id']), '`content`');
			$tem['title'] = addslashes($r['title']);
			$tem['fulltextcontent'] = $d['content'];
			$tem['adddate'] = $r['inputtime'];
			$data[$r['id']] = $tem;
		}
		return $data;
	}
	
	/**
	 * 计算总数接口
	 */
	public function total() {
		$r = $this->db->get_one(array('isdata'=>1), 'COUNT(*) AS num');
		return $r['num'];
	}
	
	/**
	 * 获取专题下内容数据
	 * @param string/intval $ids 多个id用“,”分开
	 */
	public function get_search_data($ids) {
		$where = to_sqls($ids, '', 'id');
		$data = $this->db->select($where, '`id`, `title`, `thumb`, `description`, `url`, `inputtime`', '', '', '', 'id');
		return $data;
	}
	
}