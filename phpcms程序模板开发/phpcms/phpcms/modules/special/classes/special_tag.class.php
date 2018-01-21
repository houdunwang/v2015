<?php
/**
 * special_tag.class.php 专题标签调用类
 * @author 
 *
 */
class special_tag {
	private $db, $c;
	
	public function __construct() {
		$this->db = pc_base::load_model('special_model');
		$this->c = pc_base::load_model('special_content_model');
	}
	
	/**
	 * lists调用方法
	 * @param array $data 标签配置传递过来的配置数组，根据配置生成sql
	 */
	public function lists($data) {
		$siteid = $data['siteid'] ? intval($data['siteid']) : get_siteid();
		$where .= "`siteid`='".$siteid."'";
		if ($data['elite']) $where .= " AND `elite`='1'";
		if ($data['thumb']) $where .= " AND `thumb`!=''"; 
		if ($data['disable']) {
			$where .= " AND `disabled`='".$data['disable']."'";
		}else{
			$where .= " AND `disabled`='0'";//默认显示，正常显示的专题。
		}
		$listorder = array('`id` ASC', '`id` DESC', '`listorder` ASC, `id` DESC', '`listorder` DESC, `id` DESC');
		return $this->db->select($where, '*', $data['limit'], $listorder[$data['listorder']]);
	}
	
	/**
	 * 视频专题列表 video_lists
	 * @param array $data 标签配置传递过来的配置数组，根据配置生成sql
	 */
	public function video_lists($data) {
		$siteid = $data['siteid'] ? intval($data['siteid']) : get_siteid();
		$where .= "`siteid`='".$siteid."'";
		if ($data['elite']) $where .= " AND `elite`='1'";
		if ($data['thumb']) $where .= " AND `thumb`!=''"; 
		if ($data['disable']) {
			$where .= " AND `disabled`='".$data['disable']."'";
		}else{
			$where .= " AND `disabled`='0'";//默认显示，正常显示的专题。
		}
		$where .=" AND `isvideo`='1'";
		$listorder = array('`id` ASC', '`id` DESC', '`listorder` ASC, `id` DESC', '`listorder` DESC, `id` DESC');
		return $this->db->select($where, '*', $data['limit'], $listorder[$data['listorder']]);
	}
	
	/**
	 * 标签中计算分页的方法
	 * @param array $data 标签配置数组，根据数组计算出分页
	 */
	public function count($data) {
		$where = '1';
		if($data['action'] == 'lists') {
			$where = '1';
			if ($data['siteid']) $where .= " AND `siteid`='".$data['siteid']."'";
			if ($data['elite']) $where .= " AND `elite`='1'";
			if ($data['thumb']) $where .= " AND `thumb`!=''"; 
			$r = $this->db->get_one($where, 'COUNT(id) AS total');
		} elseif ($data['action'] == 'content_list') {
			if ($data['specialid']) $where .= " AND `specialid`='".$data['specialid']."'";
			if ($data['typeid']) $where .= " AND `typeid`='".$data['typeid']."'";
			if ($data['thumb']) $where .= " AND `thumb`!=''";
			$r = $this->c->get_one($where, 'COUNT(id) AS total');
		} elseif ($data['action'] == 'hits') {
			$hitsid = 'special-c';
			if ($data['specialid']) $hitsid .= $data['specialid'].'-';
			else $hitsid .= '%-';
			$hitsid = $hitsid .= '%';
			$hits_db = pc_base::load_model('hits_model');
			$sql = "hitsid LIKE '$hitsid'";
			$r = $hits_db->get_one($sql, 'COUNT(*) AS total');
		}elseif($data['action'] == 'video_lists') {
			$where = '1';
			if ($data['siteid']) $where .= " AND `siteid`='".$data['siteid']."'";
			if ($data['elite']) $where .= " AND `elite`='1'";
			if ($data['thumb']) $where .= " AND `thumb`!=''"; 
			$where .=" AND `isvideo`='1'";
			$r = $this->db->get_one($where, 'COUNT(id) AS total');
		}
		return $r['total'];
	}
	
	/**
	 * 点击排行调用方法
	 * @param array $data 标签配置数组
	 */
	public function hits($data) {
		$hitsid = 'special-c-';
		if ($data['specialid']) $hitsid .= $data['specialid'].'-';
		else $hitsid .= '%-';
		$hitsid = $hitsid .= '%';
		$this->hits_db = pc_base::load_model('hits_model');
		$sql = "hitsid LIKE '$hitsid'";
		$listorders = array('views DESC', 'yesterdayviews DESC', 'dayviews DESC', 'weekviews DESC', 'monthviews DESC');
		$result = $this->hits_db->select($sql, '*', $data['limit'], $listorders[$data['listorder']]);
		foreach ($result as $key => $r) {
			$ids = explode('-', $r['hitsid']);
			$id = $ids[3];
			$re = $this->c->get_one(array('id'=>$id));
			$result[$key]['title'] = $re['title'];
			$result[$key]['url'] = $re['url'];
		}
		return $result;
	}
	
	/**
	 * 内容列表调用方法
	 * @param array $data 标签配置数组
	 */
	public function content_list($data) {
		$where = '1';
		if ($data['specialid']) $where .= " AND `specialid`='".$data['specialid']."'";
		if ($data['typeid']) $where .= " AND `typeid`='".$data['typeid']."'";
		if ($data['thumb']) $where .= " AND `thumb`!=''";
		$listorder = array('`id` ASC', '`id` DESC', '`listorder` ASC', '`listorder` DESC');
		$result = $this->c->select($where, '*', $data['limit'], $listorder[$data['listorder']]);
		if (is_array($result)) {
			foreach($result as $k => $r) {
				if ($r['curl']) {
					$content_arr = explode('|', $r['curl']);
					$r['url'] = go($content_arr['1'], $content_arr['0']);
				}
				$res[$k] = $r;
			}
		} else {
			$res = array();
		}
		return $res;
	}
	
	/**
	 * 获取专题分类方法
	 * @param intval $specialid 专题ID
	 * @param string $value 默认选中值
	 * @param intval $id onchange影响HTML的ID
	 * 
	 */
	public function get_type($specialid = 0, $value = '', $id = '') {
		$type_db = pc_base::load_model('type_model');
		$data = $arr = array();
		$data = $type_db->select(array('module'=>'special', 'parentid'=>$specialid));
		pc_base::load_sys_class('form', '', 0);
		foreach($data as $r) {
			$arr[$r['typeid']] = $r['name'];
		}
		$html = $id ? ' id="typeid" onchange="$(\'#'.$id.'\').val(this.value);"' : 'name="typeid", id="typeid"';
		return form::select($arr, $value, $html, L('please_select'));
	}
	
	/**
	 * 标签生成方法
	 */
	public function pc_tag() {
		//获取站点
		$sites = pc_base::load_app_class('sites','admin');
		$sitelist = $sites->pc_tag_list();
		
		$result = getcache('special', 'commons');
		if(is_array($result)) {
			$specials = array(L('please_select'));
			foreach($result as $r) {
				if($r['siteid']!=get_siteid()) continue;
				$specials[$r['id']] = $r['title'];
			}
		}
		return array(
			'action'=>array('lists'=>L('special_list', '', 'special'), 'content_list'=>L('content_list', '', 'special'), 'hits'=>L('hits_order','','special')),
			'lists'=>array(
				'siteid'=>array('name'=>L('site_id','','comment'), 'htmltype'=>'input_select', 'data'=>$sitelist),
				'elite'=>array('name'=>L('iselite', '', 'special'), 'htmltype'=>'radio', 'defaultvalue'=>'0', 'data'=>array(L('no'), L('yes'))),
				'thumb'=>array('name'=>L('get_thumb', '', 'special'), 'htmltype'=>'radio','defaultvalue'=>'0','data'=>array(L('no'), L('yes'))),
				'listorder'=>array('name'=>L('order_type', '', 'special'), 'htmltype'=>'select', 'defaultvalue'=>'3', 'data'=>array(L('id_asc', '', 'special'), L('id_desc', '','special'), L('order_asc','','special'), L('order_desc', '','special'))),
			),
			'content_list'=>array(
				'specialid'=>array('name'=>L('special_id','','special'),'htmltype'=>'input_select', 'data'=>$specials, 'ajax'=>array('name'=>L('for_type','','special'), 'action'=>'get_type', 'id'=>'typeid')),
				'thumb'=>array('name'=>L('content_thumb','','special'),'htmltype'=>'radio','defaultvalue'=>'0','data'=>array(L('no'), L('yes'))),
				'listorder'=>array('name'=>L('order_type', '', 'special'), 'htmltype'=>'select', 'defaultvalue'=>'3', 'data'=>array(L('id_asc', '', 'special'), L('id_desc', '','special'), L('order_asc','','special'), L('order_desc', '','special'))),
			),
			'hits' => array(
				'specialid' => array('name'=>L('special_id','','special'), 'htmltype'=>'input_select', 'data'=>$specials),
				'listorder' => array('name' => L('order_type', '', 'special'), 'htmltype' => 'select', 'data'=>array(L('total','','special'), L('yesterday', '','special'), L('today','','special'), L('week','','special'), L('month','','special'))),
			),
		);
	}
}
?>