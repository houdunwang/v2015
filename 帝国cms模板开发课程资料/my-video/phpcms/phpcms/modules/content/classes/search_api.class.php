<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 全站搜索内容入库接口
 */
class search_api extends admin {
	private $siteid,$categorys,$db;
	public function __construct() {
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$this->db = pc_base::load_model('content_model');
	}
	public function set_model($modelid) {
		$this->modelid = $modelid;
		$this->db->set_model($modelid);
	}
	/**
	 * 全文索引API
	 * @param $pagesize 每页条数
	 * @param $page 当前页
	 */
	public function fulltext_api($pagesize = 100, $page = 1) {
		$system_keys = $model_keys = array();
		$fulltext_array = getcache('model_field_'.$this->modelid,'model');
		foreach($fulltext_array AS $key=>$value) {
			if($value['issystem'] && $value['isfulltext']) {
				$system_keys[] = $key;
			}
		}
		if(empty($system_keys)) return '';
		$system_keys = 'id,inputtime,'.implode(',',$system_keys);
		$offset = $pagesize*($page-1);
		$result = $this->db->select('',$system_keys,"$offset, $pagesize");

		//模型从表字段
		foreach($fulltext_array AS $key=>$value) {
			if(!$value['issystem'] && $value['isfulltext']) {
				$model_keys[] = $key;
			}
		}
		if(empty($model_keys)) return '';
		$model_keys = 'id,'.implode(',',$model_keys);
		
		$this->db->table_name = $this->db->table_name.'_data';
		$result_data = $this->db->select('',$model_keys,"$offset, $pagesize",'','','id');
		//处理结果
		foreach($result as $r) {
			$fulltextcontent = '';
			foreach($r as $field=>$_r) {
				if($field=='id') continue;
				$fulltextcontent .= strip_tags($_r).' ';
			}
			if(!empty($result_data[$r['id']])) {
				foreach($result_data[$r['id']] as $_r) {
					if($field=='id') continue;
					$fulltextcontent .= strip_tags($_r).' ';
				}
			}
			$temp['fulltextcontent'] = str_replace("'",'',$fulltextcontent);
			$temp['title'] = addslashes($r['title']);
			$temp['adddate'] = $r['inputtime'];
			$data[$r['id']] = $temp;
		}
		return $data;
	}
	/**
	 * 计算总数
	 * @param $modelid
	 */
	public function total($modelid) {
		$this->modelid = $modelid;
		$this->db->set_model($modelid);
		return $this->db->count();
	}
}