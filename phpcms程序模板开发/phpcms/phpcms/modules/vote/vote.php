<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class vote extends admin {
	private $db2, $db;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('vote', 'commons'));
		$this->db = pc_base::load_model('vote_subject_model');
		$this->db2 = pc_base::load_model('vote_option_model');
	}

	public function init() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo(array('siteid'=>$this->get_siteid()),'subjectid DESC',$page, '14');
		$pages = $this->db->pages;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=vote&c=vote&a=add\', title:\''.L('vote_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('vote_add'));
		include $this->admin_tpl('vote_list'); 
 	}

	/*
	 *判断标题重复和验证 
	 */
	public function public_name() {
		$subject_title = isset($_GET['subject_title']) && trim($_GET['subject_title']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['subject_title'])) : trim($_GET['subject_title'])) : exit('0');
		$subjectid = isset($_GET['subjectid']) && intval($_GET['subjectid']) ? intval($_GET['subjectid']) : '';
		$data = array();
		if ($subjectid) {
			$data = $this->db->get_one(array('subjectid'=>$subjectid), 'subject');
			if (!empty($data) && $data['subject'] == $subject_title) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('subject'=>$subject_title), 'subjectid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/*
	 *判断结束时间是否比当前时间小  
	 */
	public function checkdate() {
		$nowdate = date('Y-m-d',SYS_TIME);
		$todate = $_GET['todate'];
		if($todate > $nowdate){
			exit('1');
		}else {
			exit('0');
		}
	}
	
	/**
	 * 添加投票
	 */
	public function add() {
		//读取配置文件
		$data = array();
		$data = $this->M;
		$siteid = $this->get_siteid();//当前站点
		if(isset($_POST['dosubmit'])) {
			$_POST['subject']['addtime'] = SYS_TIME;
			$_POST['subject']['siteid'] = $this->get_siteid();
			if(empty($_POST['subject']['subject'])) {
				showmessage(L('vote_title_noempty'),'?m=vote&c=vote&a=add');
			}
 			//记录选项条数 optionnumber 
			$_POST['subject']['optionnumber'] = count($_POST['option']);
			$_POST['subject']['template'] = $_POST['vote_subject']['vote_tp_template'];
			
 			$post_data = trim_script($_POST);
			$subjectid = $this->db->insert($post_data['subject'],true);
			if(!$subjectid) return FALSE; //返回投票ID值, 以备下面添加对应选项用,不存在返回错误
			//添加选项操作
			$this->db2->add_options($post_data['option'],$subjectid,$this->get_siteid());
			//生成JS文件
			$this->update_votejs($subjectid);
			if(isset($_POST['from_api'])&& $_POST['from_api']) {
				showmessage(L('operation_success'),'?m=vote&c=vote&a=add','100', '',"window.top.$('#voteid').val('".$subjectid."');window.top.art.dialog({id:'addvote'}).close();");
			} else {
				showmessage(L('operation_success'),'?m=vote&c=vote','','add');
 			}
		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			@extract($data[$siteid]);
			//模版
			pc_base::load_app_func('global', 'admin');
			$siteid = $this->get_siteid();
			$template_list = template_list($siteid, 0);
			$site = pc_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			include $this->admin_tpl('vote_add');
		}

	}

	/**
	 * 编辑投票
	 */
	public function edit() {

		if(isset($_POST['dosubmit'])){
			//验证数据正确性
				$subjectid = intval($_GET['subjectid']);
				if($subjectid < 1) return false;
				if(!is_array($_POST['subject']) || empty($_POST['subject'])) return false;
				if((!$_POST['subject']['subject']) || empty($_POST['subject']['subject'])) return false;
				$post_data = trim_script($_POST);
 				$this->db2->update_options($post_data['option']);//先更新已有 投票选项,再添加新增加投票选项
				if(is_array($_POST['newoption'])&&!empty($_POST['newoption'])){
					$siteid = $this->get_siteid();//新加选项站点ID
					$this->db2->add_options($post_data['newoption'],$subjectid,$siteid);
				}
				//模版 
				$_POST['subject']['template'] = $_POST['vote_subject']['vote_tp_template'];
				
				$_POST['subject']['optionnumber'] = count($_POST['option'])+count($_POST['newoption']);
	 			$this->db->update($post_data['subject'],array('subjectid'=>$subjectid));//更新投票选项总数
				$this->update_votejs($subjectid);//生成JS文件
				showmessage(L('operation_success'),'?m=vote&c=vote&a=edit','', 'edit');
			}else{
				$show_validator = $show_scroll = $show_header = true;
				pc_base::load_sys_class('form', '', 0);
				
				//解出投票内容
				$info = $this->db->get_one(array('subjectid'=>$_GET['subjectid']));
				if(!$info) showmessage(L('operation_success'));
				extract($info);
					
				//解出投票选项
				$this->db2 = pc_base::load_model('vote_option_model');
				$options = $this->db2->get_options($_GET['subjectid']);
				
				//模版
				pc_base::load_app_func('global', 'admin');
				$siteid = $this->get_siteid();
				$template_list = template_list($siteid, 0);
				$site = pc_base::load_app_class('sites','admin');
				$info = $site->get_by_id($siteid);
				foreach ($template_list as $k=>$v) {
					$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
					unset($template_list[$k]);
				}
	
				include $this->admin_tpl('vote_edit');
		}

	}

	/**
	 * 删除投票 
	 * @param	intval	$sid	投票的ID，递归删除
	 */
	public function delete() {
		if((!isset($_GET['subjectid']) || empty($_GET['subjectid'])) && (!isset($_POST['subjectid']) || empty($_POST['subjectid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
				
			if(is_array($_POST['subjectid'])){
				foreach($_POST['subjectid'] as $subjectid_arr) {
					//删除对应投票的选项
					$this->db2 = pc_base::load_model('vote_option_model');
					$this->db2->del_options($subjectid_arr);
					$this->db->delete(array('subjectid'=>$subjectid_arr));
				}
				showmessage(L('operation_success'),'?m=vote&c=vote');
			}else{
				$subjectid = intval($_GET['subjectid']);
				if($subjectid < 1) return false;
				//删除对应投票的选项
				$this->db2 = pc_base::load_model('vote_option_model');
				$this->db2->del_options($subjectid);

				//删除投票
				$this->db->delete(array('subjectid'=>$subjectid));
				$result = $this->db->delete(array('subjectid'=>$subjectid));
				if($result)
				{
					showmessage(L('operation_success'),'?m=vote&c=vote');
				}else {
					showmessage(L("operation_failure"),'?m=vote&c=vote');
				}
			}
				
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
	/**
	 * 说明:删除对应投票选项
	 * @param  $optionid
	 */
	public function del_option() {
		$result = $this->db2->del_option($_GET['optionid']);
		if($result) {
			echo 1;
		} else {
			echo 0;
		}
	} 
	
	
	/**
	 * 投票模块配置
	 */
	public function setting() {
		//读取配置文件
		$data = array();
 		$siteid = $this->get_siteid();//当前站点 
		//更新模型数据库,重设setting 数据. 
		$m_db = pc_base::load_model('module_model');
		$data = $m_db->select(array('module'=>'vote'));
		$setting = string2array($data[0]['setting']);
		$now_seting = $setting[$siteid]; 
 		if(isset($_POST['dosubmit'])) {
			//多站点存储配置文件
			$siteid = $this->get_siteid();//当前站点
			$setting[$siteid] = $_POST['setting'];
  			setcache('vote', $setting, 'commons');  
			//更新模型数据库,重设setting 数据. 
 			$set = array2string($setting);
			$m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
			showmessage(L('setting_updates_successful'), '?m=vote&c=vote&a=init');
		} else {
			@extract($now_seting);
			pc_base::load_sys_class('form', '', 0);
			//模版
			pc_base::load_app_func('global', 'admin');
			$siteid = $this->get_siteid();
			$template_list = template_list($siteid, 0);
			$site = pc_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			include $this->admin_tpl('setting');
		}
	}


	/**
	 * 检查表单数据
	 * @param	Array	$data	表单传递过来的数组
	 * @return Array	检查后的数组
	 */
	private function check($data = array()) {
		if($data['name'] == '') showmessage(L('name_plates_not_empty'));
		if(!isset($data['width']) || $data['width']==0) {
			showmessage(L('plate_width_not_empty'), HTTP_REFERER);
		} else {
			$data['width'] = intval($data['width']);
		}
		if(!isset($data['height']) || $data['height']==0) {
			showmessage(L('plate_height_not_empty'), HTTP_REFERER);
		} else {
			$data['height'] = intval($data['height']);
		}
		return $data;
	}
		
	/**
	 * 投票结果统计
	 */
	public function statistics() {
			$subjectid = intval($_GET['subjectid']);
			if(!$subjectid){
				showmessage(L('illegal_operation'));
			}
			$show_validator = $show_scroll = $show_header = true;
 			//获取投票信息
			$sdb = pc_base::load_model('vote_data_model'); //加载投票统计的数据模型
        	$infos = $sdb->select("subjectid = $subjectid",'data');	
          	//新建一数组用来存新组合数据
        	$total = 0;
        	$vote_data =array();
			$vote_data['total'] = 0 ;//所有投票选项总数
			$vote_data['votes'] = 0 ;//投票人数
			//循环每个会员的投票记录
			foreach($infos as $subjectid_arr) {
					extract($subjectid_arr);
 					$arr = string2array($data);
 					foreach($arr as $key => $values){
 						$vote_data[$key]+=1;
					}
  					$total += array_sum($arr);
					$vote_data['votes']++ ;
			}
 			$vote_data['total'] = $total ;
 			//取投票选项
			$options = $this->db2->get_options($subjectid);	
			include $this->admin_tpl('vote_statistics');	
	}
	
	/**
	 * 投票会员统计
	 */
	public function statistics_userlist() {
			$subjectid = $_GET['subjectid'];
			if(empty($subjectid)) return false;
 			$show_validator = $show_scroll = $show_header = true;
			$where = array ("subjectid" => $subjectid);
			$sdb = pc_base::load_model('vote_data_model'); //调用统计的数据模型
 			$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
			$infos = $sdb->listinfo($where,'time DESC',$page,'7');
			$pages = $sdb->pages;
			include $this->admin_tpl('vote_statistics_userlist');
	}
	
	/**
	 * 说明:生成JS投票代码
	 * @param $subjectid 投票ID
	 */
	function update_votejs($subjectid){
 			if(!isset($subjectid)||intval($subjectid) < 1) return false;
			//解出投票内容
			$info = $this->db->get_subject($subjectid);
			if(!$info) showmessage(L('not_vote'));
			extract($info);
 			//解出投票选项
			$options = $this->db2->get_options($subjectid);
 			ob_start();
 			include template('vote', $template);
			$voteform = ob_get_contents();
			ob_clean() ;
	        @file_put_contents(CACHE_PATH.'vote_js/vote_'.$subjectid.'.js', $this->format_js($voteform));
	        
	}
	
	/**
	 * 更新js
	 */
	public function create_js() {
 		$infos = $this->db->select(array('siteid'=>$this->get_siteid()), '*');
		if(is_array($infos)){
			foreach($infos as $subjectid_arr) {
				$this->update_votejs($subjectid_arr['subjectid']);
			}
		}
		showmessage(L('operation_success'),'?m=vote&c=vote');
	}
	
	/**
	 * 说明:对字符串进行处理
	 * @param $string 待处理的字符串
	 * @param $isjs 是否生成JS代码
	 */
	function format_js($string, $isjs = 1){
		$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}
	
	/**
	 * 投票调用代码
	 * 
	 */ 
 	public function public_call() {
 		$_GET['subjectid'] = intval($_GET['subjectid']);
		if(!$_GET['subjectid']) showmessage(L('illegal_action'), HTTP_REFERER, '', 'call');
		$r = $this->db->get_one(array('subjectid'=>$_GET['subjectid']));
		include $this->admin_tpl('vote_call');
	}
	/**
	 * 信息选择投票接口
	 */
	public function public_get_votelist() {
		$infos = $this->db->listinfo(array('siteid'=>$this->get_siteid()),'subjectid DESC',$page,'10');
		$target = isset($_GET['target']) ? $_GET['target'] : '';
		include $this->admin_tpl('get_votelist');
	}
	
}
?>