<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

/**
 * 
 * ------------------------------------------
 * video import class
 * ------------------------------------------
 * 
 * 导入KU6视频
 *  
 * @copyright	CopyRight (c) 2006-2012 上海盛大网络发展有限公司
 * 
 */
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global', 'video'); 
pc_base::load_sys_class('push_factory', '', 0);

class import extends admin {
	
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
	
	/**
	* 执行视频导入 
	*/
	public function doimport(){
		$importdata = $_POST['importdata'];
		$select_category = intval($_POST['select_category']);//栏目ID
		$is_category = intval($_POST['is_category']);//是否导入栏目
 		$siteid = get_siteid();
		$ids = $_POST['ids'];
		$datas = array();
 		if(is_array($ids)){
 			foreach ($_POST['importdata'] as $vv) {//重组勾选数据
				if(in_array($vv['vid'], $ids)) {
					$datas[] = $vv;
				}
			}
			
			$video_store_db = pc_base::load_model('video_store_model');
			$content_model = pc_base::load_model('content_model');
			$content_model->set_catid($select_category);
			$CATEGORYS = getcache('category_content_'.$siteid,'commons');
			$modelid = $CATEGORYS[$select_category]['modelid'];// 所选视频栏目对应的modelid
			$model_field = pc_base::load_model('sitemodel_field_model');
			$r = $model_field->get_one(array('modelid'=>$modelid, 'formtype'=>'video'), 'field');
			$fieldname = $r['field'];//查出视频字段
			
			//导入推荐位使用
			$this->push = push_factory::get_instance()->get_api('admin');
  			//循环勾选数据，进行请求ku6vms入库接口进行入库，成功后插入本系统对应栏目，并自动进行video_content对应关系 
			$new_s = array();
 			foreach ($datas as $data) {
  				$data['cid'] = $select_category;
				$data['import'] = 1;
				$data['channelid'] = 1;
				$return_data = array();
  				$return_data = $this->ku6api->vms_add($data);//插入VMS,返回能播放使用的vid
				//$new_s[] = $return_data;
   				$vid = $return_data['vid'];
				if(!$vid){
					showmessage('导入VMS系统时，发生错误！',HTTP_REFERER);
				}
  				//入本机视频库
				
				$video_data = array();
				$video_data['title'] = str_cut($data['title'],80,false);
				$video_data['vid'] = $vid;
				$video_data['keywords'] = str_cut($data['tag'],36);
				$video_data['description'] = str_cut($data['desc'],200);
				$video_data['status'] = $data['status'];
				$video_data['addtime'] = $data['uploadtime'] ? substr($data['uploadtime'],0,10) : SYS_TIME;
				$video_data['picpath'] = safe_replace( format_url($data['picpath']) );
 				$video_data['timelen'] = intval($data['timelen']);
				$video_data['size'] = intval($data['size']); 
				$video_data['channelid'] = 1; 
				
				$videoid = $video_store_db->insert($video_data, true);//插入视频库
 				
				if($is_category==1){//视频直接发布到指定栏目
					//组合POST数据
					//根据模型id，得到视频字段名
					$content_data = array();
					
					$content_data[$fieldname] = 1;
					$content_data['catid'] = $select_category;
					$content_data['title'] = str_cut($data['title'],80,' '); 
					$content_data['content'] = $data['desc']; 
					$content_data['description'] = str_cut($data['desc'],198,' '); 
					$content_data['keywords'] = str_cut($data['tag'],38,' ');
					$content_data = array_filter($content_data,'rtrim');
					$content_data['thumb'] = $data['picpath']; 
					$content_data['status'] = 99;  
					//组合POST数据,入库时会自动对应关系 
					$_POST[$fieldname.'_video'][1] = array('videoid'=>$videoid, 'listorder'=>1); 
					//调接口，插入数据库
					$cid = $content_model->add_content($content_data); 
					
					//入推荐位
					$position = $_POST['sub']['posid'];
					if($position){
						$info = array();//组成提交信息数据
						$pos_content_data = $content_data;
						$pos_content_data['id'] = $cid;
						$pos_content_data['inputtime'] = SYS_TIME;
						$pos_content_data['updatetime'] = SYS_TIME;
						$info[$cid]= $pos_content_data;//信息数据
						
						$pos_array = array();//推荐位ID，要求是数组下面使用
						$pos_array[] = $position;
						
						$post_array = '';//position 所用
						$post_array['modelid'] = $modelid;
						$post_array['catid'] = $select_category;
						$post_array['id'] = $cid; 
						$post_array['posid'] = $pos_array;
						$post_array['dosubmit'] = '提交';
						$post_array['pc_hash'] = $_GET['pc_hash'];
						 
						$this->push->position_list($info, $post_array);//调用admin position_list()方法
					}
					
					//更新点击次数 
					if ($data['viewcount']) {
						$views = intval($data['viewcount']);
						$hitsid = 'c-'.$modelid.'-'.$cid;
						$count = pc_base::load_model('hits_model');
						$count->update(array('views'=>$views), array('hitsid'=>$hitsid));
					} 
				}
				 
  			}
			$page = intval($_POST['page']) + 1;
			if($_POST['fenlei'] || $_POST['keyword']){
				$forward = "?m=video&c=video&a=import_ku6video&menuid=".$_POST['menuid']."&fenlei=".$_POST['fenlei']."&srctype=".$_POST['srctype']."&videotime=".$_POST['videotime']."&keyword=".$_POST['keyword']."&dosubmit=%CB%D1%CB%&page=".$page;
			}else{
				$forward = "?m=video&c=video&a=import_ku6video&menuid=".$_POST['menuid'];
			}
			
     		showmessage('KU6视频导入成功，正在返回！',$forward);
		}else{
 			showmessage('请选择要导入的视频！',HTTP_REFERER);
		}
	} 
	
	/**
	* 获取站点栏目数据
	*/
	 
	/**
	 * 
	 * 视频列表
	 */
	public function init() {
		$where = '1';
		$page = $_GET['page'];
		$pagesize = 20;
		if (isset($_GET['type'])) {
			if ($_GET['type']==1) {
				$where .= ' AND `videoid`=\''.$_GET['q'].'\'';
			} else {
				$where .= " AND `title` LIKE '%".$_GET['q']."%'";
			}
		}
		if (isset($_GET['start_time'])) {
			$where .= ' AND `addtime`>=\''.strtotime($_GET['start_time']).'\'';
		}
		if (isset($_GET['end_time'])) {
			$where .= ' AND `addtime`<=\''.strtotime($_GET['end_time']).'\'';
		}
		if (isset($_GET['status'])) {
			$status = intval($_GET['status']);
			$where .= ' AND `status`=\''.$status.'\'';
		}
		$infos = $this->db->listinfo($where, 'videoid DESC', $page, $pagesize);
		$pages = $this->db->pages;
		include $this->admin_tpl('video_list');		
	}   
}

?>