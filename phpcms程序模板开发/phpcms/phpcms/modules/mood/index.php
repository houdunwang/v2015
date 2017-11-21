<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	private $setting, $catid, $contentid, $siteid, $mood_id;
	public function __construct() {
		$this->setting = getcache('mood_program', 'commons');
		
		
		$this->mood_id = isset($_GET['id']) ? $_GET['id'] : '';
		if(!preg_match("/^[a-z0-9_\-]+$/i",$this->mood_id)) showmessage((L('illegal_parameters')));
		if (empty($this->mood_id)) {
			showmessage(L('id_cannot_be_empty'));
		}
		list($this->catid, $this->contentid, $this->siteid) = id_decode($this->mood_id);
		
		$this->setting = isset($this->setting[$this->siteid]) ? $this->setting[$this->siteid] : array();
		
		foreach ($this->setting as $k=>$v) {
			if (empty($v['use'])) unset($this->setting[$k]);
		}
		
		define('SITEID', $this->siteid);
	}
	
	//显示心情
	public function init() {
		$mood_id =& $this->mood_id;
		$setting =& $this->setting;
		$mood_db = pc_base::load_model('mood_model');
		$data = $mood_db->get_one(array('catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid));
		foreach ($setting as $k=>$v) {
			$setting[$k]['fields'] = 'n'.$k;
			if (!isset($data[$setting[$k]['fields']])) $data[$setting[$k]['fields']] = 0;
			if (isset($data['total']) && !empty($data['total'])) {
				$setting[$k]['per'] = ceil(($data[$setting[$k]['fields']]/$data['total']) * 60);
			} else {
				$setting[$k]['per'] = 0;
			}
		}
		ob_start();
		include template('mood', 'index');
		$html = ob_get_contents();
		ob_clean();
		echo format_js($html);
	}
	
	//提交选中
	public function post() {
		if (isset($_GET['callback']) && !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $_GET['callback']))  unset($_GET['callback']);
		$mood_id =& $this->mood_id;
		$setting =& $this->setting;
		$cookies = param::get_cookie('mood_id');
		$cookie = explode(',', $cookies);
		if (in_array($this->mood_id, $cookie)) {
			$this->_show_result(0, L('expressed'));
		} else {
			$mood_db = pc_base::load_model('mood_model');
			$key = isset($_GET['k']) && intval($_GET['k']) ? intval($_GET['k']) : '';
			if (!in_array($key, array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)))
				$this->_show_result(0, L('illegal_parameters'));
			$fields = 'n'.$key;
			if ($data = $mood_db->get_one(array('catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid))) {
				$mood_db->update(array('total'=>'+=1', $fields=>'+=1', 'lastupdate'=>SYS_TIME), array('id'=>$data['id']));
				$data['total']++;
				$data[$fields]++;
			} else {
				$mood_db->insert(array('total'=>'1', $fields=>'1', 'catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid,'
				lastupdate'=>SYS_TIME));
				$data['total'] = 1;
				$data[$fields] = 1;
			}
			param::set_cookie('mood_id', $cookies.','.$mood_id);
			foreach ($setting as $k=>$v) {
				$setting[$k]['fields'] = 'n'.$k;
				if (!isset($data[$setting[$k]['fields']])) $data[$setting[$k]['fields']] = 0;
				if (isset($data['total']) && !empty($data['total'])) {
					$setting[$k]['per'] = ceil(($data[$setting[$k]['fields']]/$data['total']) * 60);
				} else {
					$setting[$k]['per'] = 0;
				}
			}
			ob_start();
			include template('mood', 'index');
			$html = ob_get_contents();
			ob_clean();
			$this->_show_result(1,$html);
		}
	}
	
	//显示AJAX结果
	protected function _show_result($status = 0, $msg = '') {
		if(CHARSET != 'utf-8') {
			$msg = iconv(CHARSET, 'utf-8', $msg);
		}
		exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>$status, 'data'=>$msg)).')');
	}
}