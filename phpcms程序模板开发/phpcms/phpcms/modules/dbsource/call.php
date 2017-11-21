<?php 
defined('IN_PHPCMS') or exit('No permission resources.'); 
class call  {
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('datacall_model');
	}
	
	public function get() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : exit();
		if ($data = $this->db->get_one(array('id'=>$id))) {
			if (!$str = tpl_cache('dbsource_'.$id,$data['cache'])) {
				if ($data['type'] == 1) { //自定义SQL调用
					$get_db = pc_base::load_model("get_model");
					$sql = $data['data'].(!empty($data['num']) ? " LIMIT $data[num]" : '');
					$r= $get_db->query($sql);
					while(($s = $get_db->fetch_next()) != false) {
						$str[] = $s;
					}
				} else {
					$filepath = PC_PATH.'modules'.DIRECTORY_SEPARATOR.$data['module'].DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$data['module'].'_tag.class.php';
					if (file_exists($filepath)) {
						$pc_tag = pc_base::load_app_class($data['module'].'_tag', $data['module']); 
						if (!method_exists($pc_tag, $data['action'])) {
							exit();
						}
						$sql = string2array($data['data']);
						$sql['action'] = $data['action'];
						$sql['limit'] = $data['num'];
						unset($data['num']);
						$str  = $pc_tag->{$data['action']}($sql);
						
					} else {
						exit();
					}
				}
				if ($data['cache']) setcache('dbsource_'.$id, $str, 'tpl_data');
			}
			echo $this->_format($data['id'], $str, $data['dis_type']);
		}
	}
	
	private function _format($id, $data, $type) {
		switch($type) {
			case '1'://json
				if (CHARSET == 'gbk') {
					$data = array_iconv($data, 'gbk', 'utf-8');
				}
				return json_encode($data);
				break;
				
			case '2'://xml
				$xml = pc_base::load_sys_class('xml');
				return $xml->xml_serialize($data);
				break;
				
			case '3'://js
				pc_base::load_app_func('global');
				ob_start();
				include template_url($id);
				$html = ob_get_contents();
				ob_clean();
				return format_js($html); 
				break;
		}
	}
}
?>