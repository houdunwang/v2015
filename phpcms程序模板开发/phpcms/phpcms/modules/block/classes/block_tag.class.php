<?php 
defined('IN_PHPCMS') or exit('No permission resources.'); 
class block_tag {
	
	private $db;
	
	public function __construct() {
		$this->db = pc_base::load_model('block_model');
	}
	
	/**
	 * PC标签中调用数据
	 * @param array $data 配置数据
	 */
	public function pc_tag($data) {
		$siteid = isset($data['siteid']) && intval($data['siteid']) ? intval($data['siteid']) : get_siteid();
		$r = $this->db->select(array('pos'=>$data['pos'], 'siteid'=>$siteid));
		$str = '';
		if (!empty($r) && is_array($r)) foreach ($r as $v) {
			if (defined('IN_ADMIN') && !defined('HTML')) $str .= '<div id="block_id_'.$v['id'].'" class="admin_block" blockid="'.$v['id'].'">';
			if ($v['type'] == '2') {
				extract($v, EXTR_OVERWRITE);
				$data = string2array($data);
				if (!defined('HTML'))  {
					ob_start();
					include $this->template_url($id);
					$str .= ob_get_contents();
					ob_clean();
				} else {
					include $this->template_url($id);
				}
				
			} else {
				$str .= $v['data'];
			}
			if (defined('IN_ADMIN')  && !defined('HTML')) $str .= '</div>';
		}
		return $str;
	}
	
	/**
	 * 生成模板返回路径
	 * @param integer $id 碎片ID号
	 * @param string $template 风格
	 */
	public function template_url($id, $template = '') {
		$filepath = CACHE_PATH.'caches_template'.DIRECTORY_SEPARATOR.'block'.DIRECTORY_SEPARATOR.$id.'.php';
		$dir = dirname($filepath);
		if ($template) {
			if(!is_dir($dir)) {
				mkdir($dir, 0777, true);
		    }
		    $tpl = pc_base::load_sys_class('template_cache');
			$str = $tpl->template_parse(new_stripslashes($template));
			@file_put_contents($filepath, $str);
		} else {
			if (!file_exists($filepath)) {
				if(!is_dir($dir)) {
					mkdir($dir, 0777, true);
			    }
			    $tpl = pc_base::load_sys_class('template_cache');
				$str = $this->db->get_one(array('id'=>$id), 'template');
				$str = $tpl->template_parse($str['template']);
				@file_put_contents($filepath, $str);
			}
		}
		return $filepath;
	}
}
?>