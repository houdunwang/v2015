<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
pc_base::load_sys_class('format','',0);
pc_base::load_app_func('global','sms');
class sms extends admin {

	function __construct() {
		parent::__construct();
		$this->log_db = pc_base::load_model('sms_report_model');
		$this->module_db = pc_base::load_model('module_model');
		$this->member_db = pc_base::load_model('member_model');
		
		//获取短信平台配置信息
		$siteid = get_siteid();
		$this->sms_setting_arr = getcache('sms');
		if(!empty($this->sms_setting_arr[$siteid])) {
			$this->sms_setting = $this->sms_setting_arr[$siteid];
		} else {
			$this->sms_setting = array('userid'=>'', 'productid'=>'', 'sms_key'=>'');
		}
		
		//初始化smsapi
		pc_base::load_app_class('smsapi', '', 0);
		$this->smsapi = new smsapi($this->sms_setting['userid'], $this->sms_setting['productid'], $this->sms_setting['sms_key']);
	}
	
	public function init() {	
		$show_pc_hash = 1;
		//短信套餐列表
		$smsprice_arr = $this->smsapi->get_price();

		//字符转换
		if(CHARSET != 'utf-8') {
			if(is_array($smsprice_arr)) {
				foreach ($smsprice_arr as $k=>$v) {
					$smsprice_arr[$k]['name'] = iconv('utf-8', CHARSET, $smsprice_arr[$k]['name']);
					$smsprice_arr[$k]['description'] = iconv('utf-8', CHARSET, $smsprice_arr[$k]['description']);
				}
			}
		}
		
		//短信剩余条数
		$smsinfo_arr = $this->smsapi->get_smsinfo();

		include $this->admin_tpl('index');
	}
	
	/**
	 * 
	 * 短信充值记录
	 */
	public function sms_buy_history() {
		$payinfo_arr = $this->smsapi->get_buyhistory();	
		//字符转换
		if(CHARSET != 'utf-8') {
			if(is_array($payinfo_arr)) foreach ($payinfo_arr as $k=>$v) {
				$payinfo_arr[$k]['name'] = iconv('utf-8', CHARSET, $payinfo_arr[$k]['name']);
				$payinfo_arr[$k]['description'] = iconv('utf-8', CHARSET, $payinfo_arr[$k]['description']);
			}
		}
		include $this->admin_tpl('sms_buy_history');

	}
	
	/**
	 * 
	 * 短信消费记录
	 */
	public function sms_pay_history() {
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$paylist_apiarr = $this->smsapi->get_payhistory($page);
		
		$paylist_arr = !empty($paylist_apiarr['datas']) ? $paylist_apiarr['datas'] : array();
		$payhistoryinfo_total = !empty($paylist_apiarr['total']) ? $paylist_apiarr['total'] : 0;

		$pages = pages($payhistoryinfo_total, $page, 20);

		include $this->admin_tpl('sms_pay_history');
	}	
	
	public function sms_setting() {
		$siteid = get_siteid();
		if(isset($_POST['dosubmit'])) {
			$this->sms_setting_arr[$siteid] = $_POST['setting'];
			$setting = array2string($this->sms_setting);
			setcache('sms', $this->sms_setting_arr);
			$this->module_db->update(array('setting'=>$setting),array('module'=>'sms'));
			showmessage(L('operation_success'),HTTP_REFERER);			
		} else {
			$show_pc_hash = '';
			include $this->admin_tpl('sms_setting');
		}
	}
	
	public function sms_api() {

		
		include $this->admin_tpl('sms_api');
	}
	
	public function sms_sent() {
		if(!$this->sms_setting['sms_enable']) showmessage(L('please_open_sms_platform_status'));
		if(empty($this->smsapi->userid)) {
			showmessage(L('need_band'), 'index.php?m=sms&c=sms&a=sms_setting&menuid='.$_GET[menuid].'&pc_hash='.$_SESSION['pc_hash']);
		}
		//检查短信余额
		if($this->sms_setting['sms_key']) {
			$smsinfo = $this->smsapi->get_smsinfo();
		}

		if(isset($_POST['dosubmit'])) {
			//组合短信参数内容
			$content = '';
			if(is_array($_POST['msg']) && !empty($_POST['msg'])){
				foreach ($_POST['msg'] as $val) { 
					$val = stripcslashes($val);
					if($content==''){
						$content.="$val";
					}else{
						$content.="||$val";
					}
				}
			}
			$mobile = explode("\r\n", trim($_POST['mobile'],"\r\n"));
			$mobile = array_unique($mobile);
			$tplid = intval($_POST['tplid']);
			//过滤非手机号码
			foreach ($mobile as $k=>$v) {
				if(!preg_match('/^1([0-9]{9})/',$v)) {
					unset($mobile[$k]);
				}
			}
			
			//短信余额不足
			if($smsinfo['surplus'] < count($mobile)) {
				showmessage(L('need_more_surplus'));
			}
			
			//发送短信
			$return = $this->smsapi->send_sms($mobile, $content, $_POST['sendtime'], CHARSET,'',$tplid);
			
			showmessage($return, HTTP_REFERER,6000);
		} else {
			$smsinfo_arr = $this->smsapi->get_smsinfo();
			if(!empty($smsinfo_arr['allow_send_ip']) &&!in_array($_SERVER["SERVER_ADDR"],$smsinfo_arr['allow_send_ip'])) {
				showmessage(L('this_server_does_not_allow_send_sms'));
			}
			$start_time = date('Y-m-d', SYS_TIME-date('t', SYS_TIME)*86400);
			$end_time = date('Y-m-d', SYS_TIME);
			$grouplist = getcache('grouplist', 'member');
			foreach($grouplist as $k=>$v) {
				$grouplist[$k] = $v['name'];
			}
			
			//会员所属模型		
			$modellistarr = getcache('member_model', 'commons');
			foreach ($modellistarr as $k=>$v) {
				$modellist[$k] = $v['name'];
			}
			//显示群发
			$show_qf_url = $this->smsapi->show_qf_url();
			
			include $this->admin_tpl('sms_sent');
		}
	}
	
	/*
	* 获取短信模版,ajax处理
	*/
	public function public_get_tpl(){
		$sceneid = intval($_GET['sceneid']);
		if(!$sceneid){exit(0);}
		//获取服务器场景，组成表单单选项
		$tpl_arr = $this->smsapi->get_tpl($sceneid);
		if(!empty($tpl_arr)){
			exit($tpl_arr);
		}else{
			exit(0);
		}
 	}
	/*
	* 显示短信内容,ajax处理
	*/
	public function public_show_tpl(){
		$tplid = intval($_GET['tplid']);
		if(!$tplid){exit(0);}
		//获取模版内容
		$tpl_arr = $this->smsapi->show_tpl($tplid);
		if(!empty($tpl_arr)){
			exit($tpl_arr);
		}else{
			exit(0);
		}
 	}

	public function exportmobile() {
		$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
		$end_time = isset($_POST['end_time']) ? $_POST['end_time'] : date('Y-m-d', SYS_TIME);
		$where_start_time = strtotime($start_time) ? strtotime($start_time) : 0;
		$where_end_time = strtotime($end_time) + 86400;
		$groupid = isset($_POST['groupid']) && !empty($_POST['groupid']) ? $_POST['groupid'] : '';
		$modelid = isset($_POST['modelid']) && !empty($_POST['modelid']) ? $_POST['modelid'] : 10;

		//开始时间大于结束时间，置换变量
		if($where_start_time > $where_end_time) {
			$tmp = $where_start_time;
			$where_start_time = $where_end_time;
			$where_end_time = $tmp;
			$tmptime = $start_time;
			
			$start_time = $end_time;
			$end_time = $tmptime;
			unset($tmp, $tmptime);
		}
		
		$where = '';
		if($groupid) {
			$where .= "`groupid` = '$groupid' AND ";
		}
		
		if($modelid) {
			$where .= "`modelid` = '$modelid' AND ";
		}
		
		$where .= "`regdate` BETWEEN '$where_start_time' AND '$where_end_time'";

		//根据条件读取会员主表
		$total = $this->member_db->count($where);
		$str = '';
		$perpage = 10;
		for($i=0;$i<=floor($total/$perpage);$i++) {
			$start = $i*$perpage;
			$data = $this->member_db->select($where, 'userid', "$start, $perpage");
			$userid_arr = array();
			foreach ($data as $v) {
				$userid_arr[] = $v['userid']; 
			}
			$uids = to_sqls($userid_arr, '', 'userid');
			//读取模型表中手机号码字段
			$this->member_db->set_model($modelid);
			$data = $this->member_db->select($uids);
			foreach ($data as $v) {
				if(!empty($v['mobile'])) {
					$str .= $v['mobile']."\r\n";
				}
			}
			
			$this->member_db->set_model();
		}
		header("Content-type:application/octet-stream"); 
		header("Content-Disposition: attachment; filename=mobile.txt"); 
		echo $str;	
	}
	
}










