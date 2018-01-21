<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_class('messagequeue', 'admin' , 0);

class credit extends admin {

	private $db;
	/**
	 * 析构函数
	 */
	public function __construct() {	
		parent::__construct();
		$this->db = pc_base::load_model('settings_model');
	}
	
	/**
	 * 首页
	 */
	public function manage() {
		$applist = getcache('applist');
		$creditlist = getcache('creditlist');
		if(empty($creditlist)) $creditlist = array();
		
		include $this->admin_tpl('credit_list');
	}
	
	/**
	 * 首页
	 */
	public function delete() {
		$id = isset($_POST['id']) ? $_POST['id'] : showmessage(L('illegal_parameters'), HTTP_REFERER);

		$creditlist = getcache('creditlist');
		foreach($id as $v) {
			unset($creditlist[$v]);
		}
		
		$this->db->insert(array('name'=>'creditrate', 'data'=>array2string($creditlist)), 1, 1);
		setcache('creditlist', $creditlist);
		showmessage(L('operation_success'), HTTP_REFERER);

	}
	
	/**
	 * 添加规则
	 */
	public function add() {
		if (isset($_POST['dosubmit'])) {
			$ruledata['fromid'] = isset($_POST['fromid']) ? intval($_POST['fromid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$ruledata['toid'] = isset($_POST['toid']) ? intval($_POST['toid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$ruledata['fromrate'] = isset($_POST['fromrate']) ? intval($_POST['fromrate']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$ruledata['torate'] = isset($_POST['torate']) ? intval($_POST['torate']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
			if(empty($_POST['from']) || empty($_POST['to'])) {
				showmessage(L('illegal_parameters'), HTTP_REFERER);
			}
			$fromarr = explode('_', $_POST['from']);
			$toarr = explode('_', $_POST['to']);
			$ruledata['from'] = isset($fromarr[0]) ? $fromarr[0] : '';
			$ruledata['fromname'] = isset($fromarr[1]) ? $fromarr[1] : '';
			$ruledata['fromunit'] = isset($fromarr[2]) ? $fromarr[2] : '';
			$ruledata['to'] = isset($toarr[0]) ? $toarr[0] : '';
			$ruledata['toname'] = isset($toarr[1]) ? $toarr[1] : '';
			$ruledata['tounit'] = isset($toarr[2]) ? $toarr[2] : '';
			
			$creditlistarr = $this->db->get_one(array('name'=>'creditrate'));
			
			$creditlist = string2array($creditlistarr['data']);
			$creditlist[] = $ruledata;
			$noticedata['creditlist'] = $creditlist;
			//加入消息队列
			messagequeue::add('credit_update', $noticedata);
			
			setcache('creditlist', $creditlist);
			$this->db->insert(array('name'=>'creditrate', 'data'=>array2string($creditlist)), 1, 1);
			showmessage(L('operation_success'), HTTP_REFERER);
		}
		$applist = getcache('applist');
		include $this->admin_tpl('credit_add');
	}
	
	/**
	 * 获取应用积分列表
	 */
	public function creditlist() {
		$appid = isset($_GET['appid']) ? $_GET['appid'] : exit('0');
		$applist = getcache('applist');
		$url = isset($applist[$appid]) ? $applist[$appid]['url'].$applist[$appid]['apifilename'] : exit('0');

		$data['action'] = 'credit_list';
		
		$res = ps_send($url.'&appid='.$appid, $data, $applist[$appid]['authkey']);
		if(!empty($res)) {		
			$creditlist = string2array($res);
			$str = '';
			foreach($creditlist as $k=>$v) {
				$str .="<option value=".$k.'_'.$v[0].'_'.$v[1].">".$v[0]."(".$v[1].")</option>";
			}
			echo $str;exit;
		} else {
			exit('0');
		}

	}
	
}
?>