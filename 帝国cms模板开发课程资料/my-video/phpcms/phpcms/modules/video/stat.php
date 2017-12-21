<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

/**
 *  
 * 
 * 视频统计功能  
 * @author		wangguanqing
 * @copyright	CopyRight (c) 2006-2012 上海盛大网络发展有限公司
 * 
 */
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global', 'video'); 

class stat extends admin {
	
	public $db,$module_db;
	
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('video_store_model');
		$this->module_db = pc_base::load_model('module_model');
		$this->userid = $_SESSION['userid'];
		pc_base::load_app_class('ku6api', 'video', 0);
		pc_base::load_app_class('v', 'video', 0);
		$this->v =  new v($this->db);
		
		//获取短信平台配置信息
		$this->setting = getcache('video');
		if(empty($this->setting) && ROUTE_A!='setting') {
			showmessage(L('video_setting_not_succfull'), 'index.php?m=video&c=video&a=setting&meunid='.$_GET['meunid']);
		}
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
	}    
	
	/*默认显示整体趋势*/
	public function init() { 
		//未指定时间，显示当天的视频排行 
		$pagesize = 20;
		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : date("Y-m-d");
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date("Y-m-d",strtotime("+1 day")); 
		if(empty($start_time) &&  empty($end_time)){//默认浏览 
			$date = isset($_GET['type']) ? $_GET['type'] : 'today' ;
			switch($date){
			case 'today':
			$start_time = date("Y-m-d");
			$end_time = date("Y-m-d",strtotime("+1 day")); 
			break;  
			case 'yestoday':
			$start_time =  date("Y-m-d",strtotime("-1 day"));
			$end_time = date("Y-m-d"); 
			break;   
			case 'week':
			$start_time =  date("Y-m-d",strtotime("-1 week"));
			$end_time = date("Y-m-d"); 
			break;  
			case 'month':
			$start_time =  date("Y-m-d",strtotime("last month"));
			$end_time = date("Y-m-d"); 
			break;  
			default:
			$start_time = date("Y-m-d");
			$end_time = date("Y-m-d",strtotime("+1 day")); 
			}
		}else{
			if(empty($start_time) || empty($end_time)){
				showmessage('时间区间不能为空！请返回！',HTTP_REFERER);
			}
		}
		$return_data = $this->ku6api->get_stat_bydate($start_time,$end_time,$pagesize,$page);
		if($return_data['code']==200) {
			$infos = $return_data['data'];
			include $this->admin_tpl('video_stat_init'); 
		} else {
			header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
		}
	}
	
	/*
	* 搜索查看视频统计
	*/
	public function search_video_stat(){
		$type = isset($_POST['search_type']) ? $_POST['search_type'] : 2;//2代表默认为标题搜索
		$keyword = $_POST['keyword'];
		$return_data = $this->ku6api->get_video_bykeyword($type,$keyword); 
		$infos = $return_data['data'];  
		include $this->admin_tpl('video_stat_init'); 
	}
	
	/*
	* 查看视频统计走势
	*/
	public function show_video_stat(){
		$vid =  $_GET['vid'] ; 
		$return_data = $this->ku6api->show_video_stat($vid); 
		$return = $return_data['data']; 
		$nums  = count($return['x']);
		$i = $j = 1;
		foreach($return['x'] as $re){
			if($i<$nums){
				$x .= "'".$re."' ,";
			}else{
				$x .= "'".$re."'";
			} 
			
			$i++;
		}
		foreach($return['y'] as $re){
			if($j<$nums){
				$y .=  $re." ,";
			}else{
				$y .=  $re ;
			} 
			$j++;
		} 
		$show_header = 0;
		include $this->admin_tpl('show_video_stat'); 
	}
	
	/*
	*  视频流量总体趋势图  
	*/
	public function vv_trend(){
		$return_data = $this->ku6api->vv_trend($vid); 
		$return = $return_data['data'];   
		$show_header = 0;
		
		$new_data = array(); 
		$start = date("Y-m-d",strtotime('-20 day'));
		$end= date("Y-m-d");
		$days = ((strtotime( $end)-strtotime( $start ))/86400);
		for($i=1;$i<=$days;$i++){
			$new_data['x'][] = date("m-d",strtotime("$start  +$i   day"));
			$new_data['y'][] = $return[date("Y-m-d",strtotime("$start  +$i   day"))] ? $return[date("Y-m-d",strtotime("$start  +$i   day"))] : 0; 
		}  
		
		//生成字符串
		$nums  = count($new_data['x']);
		$i = $j = 1;
		foreach($new_data['x'] as $re){ 
			$x .= $i<$nums ? "'".$re."' ," : "'".$re."'";
			$i++;
		}
		foreach($new_data['y'] as $re){ 
			$y .= $j<$nums ? $re." ," : $re;
			$j++;
		}   
		include $this->admin_tpl('video_vv_trend'); 
	}
	
}

?>