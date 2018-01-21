<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

/**
 * 
 * ------------------------------------------
 * video video class
 * ------------------------------------------
 * 
 * 视频库管理扩展下的视频管理控制器  控制视频添加、修改、删除及从ku6导入视频等
 * 用户在配置好ku6vms账户后才能使用该模块。
 * 在此扩展下对视频的所有操作通过接口同步到ku6vms下面
 * 
 * @package 	PHPCMS V9.1.16
 * @author		chenxuewang
 * @copyright	CopyRight (c) 2006-2012 上海盛大网络发展有限公司
 * 
 */
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global', 'video');


class video extends admin {
	
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
		
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
	}
	
	/**
	 * 
	 * 视频列表
	 */
	public function init() {
		$where = '';
		$page = $_GET['page'];
		$pagesize = 20;
		if($_GET['q']){
			if (isset($_GET['type'])) {
				if ($_GET['type']==1) {
					$where .= ' `videoid`=\''.$_GET['q'].'\'';
				} else {
					$where .= " `title` LIKE '%".$_GET['q']."%'";
				}
			}
 		}
 		
		if (isset($_GET['start_addtime']) && !empty($_GET['start_addtime'])) {
 			$where .= !empty($where) ? ' AND `addtime`>=\''.strtotime($_GET['start_addtime']).'\'' : ' `addtime`>=\''.strtotime($_GET['start_addtime']).'\'';
		}
		if (!empty($_GET['end_addtime'])) {
			$where .= !empty($where) ? ' AND `addtime`<=\''.strtotime($_GET['end_addtime']).'\'' : ' `addtime`<=\''.strtotime($_GET['end_addtime']).'\'';
 		} 
		$userupload = intval($_GET['userupload']);
		if ($userupload) {
			$where .= ' AND `userupload`=1';
		}
 		$infos = $this->db->listinfo($where, 'videoid DESC', $page, $pagesize);
		$pages = $this->db->pages;
		include $this->admin_tpl('video_list');		
	}
	
	/**
	 * 
	 * 视频添加方法
	 */
	public function add() {
		if ($_POST['dosubmit']) {
			//首先处理，提交过来的数据
			$data['vid'] = safe_replace($_POST['vid']);
			if (!$data['vid']) showmessage(L('failed_you_video_uploading'), 'index.php?m=video&c=video&a=add');
			$data['title'] = isset($_POST['title']) && trim($_POST['title']) ? trim($_POST['title']) : showmessage(L('video_title_not_empty'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			$data['description'] = trim($_POST['description']);
			$data['keywords'] = trim(strip_tags($_POST['keywords']));
			$data['channelid'] = intval($_POST['channelid']);
			//其次向vms post数据，并取得返回值
			$get_data = $this->ku6api->vms_add($data);
			if (!$get_data) {
				showmessage($this->ku6api->error_msg);
			}
			$data['vid'] = $get_data['vid'];
			$data['addtime'] = SYS_TIME;
			
			$data['userupload'] = intval($_POST['userupload']);
			$videoid = $this->v->add($data);
			if ($videoid) {
				showmessage(L('operation_success'), 'index.php?m=video&c=video&a=init&meunid='.$_GET['meunid']);
			} else {
				showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			}
		} else {
			if((empty($this->setting['sn']) || empty($this->setting['skey'])) && ROUTE_A!='open') {
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
			}
			if(!$this->ku6api->testapi()) {
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
			}
			$flash_info = $this->ku6api->flashuploadparam();
			$show_validator = true;
			include $this->admin_tpl('video_add');
		}
	}
	
	/**
	 * function edit
	 * 视频编辑控制器
	 */
	public function edit() {
		$vid = intval($_GET['vid']);
		if (!$vid) showmessage(L('illegal_parameters'));
		if (isset($_POST['dosubmit'])) {
			//首先处理，提交过来的数据
			$data['vid'] = $_POST['vid'];
			if (!$data['vid']) showmessage(L('failed_you_video_uploading'), 'index.php?m=video&c=video&a=add');
			$data['title'] = isset($_POST['title']) && trim($_POST['title']) ? trim($_POST['title']) : showmessage(L('video_title_not_empty'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			$data['description'] = trim($_POST['description']);
			$data['keywords'] = trim(strip_tags($_POST['keywords']));
			//其次向vms post数据，并取得返回值
			if ($this->ku6api->vms_edit($data)) {
				$return = $this->v->edit($data, $vid);
				if ($return) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=init');
				else showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=edit&vid='.$vid.'&menuid='.$_GET['menuid']);
			} else {
				showmessage($this->ku6api->error_msg, 'index.php?m=video&c=video&a=edit&vid='.$vid.'&menuid='.$_GET['menuid']);
			}
		} else {
			$show_validator = true;
			$info = $this->db->get_one(array('videoid'=>$vid));
			include $this->admin_tpl('video_edit');
		}
	}
	
	/**
	 * function delete
	 * 删除视频控制器
	 */
	public function delete() {
		$vid = $_GET['vid'];
		$r = $this->db->get_one(array('videoid'=>$vid), 'vid');
		if (!$r) showmessage(L('video_not_exist_or_deleted'));
		if (!$this->ku6api->delete_v($r['vid'])) showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=init&meunid='.$_GET['meunid']);
		$this->v->del_video($vid);	
		showmessage(L('success_next_update_content'), 'index.php?m=video&c=video&a=public_update_content&vid='.$vid.'&meunid='.$_GET['meunid']);
	}

	/**
	 * function delete_all
	 * 批量删除视频
	 * @删除视频时，注意同时删除视频库内容对应关系表中的相关数据，因为操作时间限制，无法同时更新相关的内容。删除完成时需要提醒用户
	 */
	public function delete_all() {
		if (isset($_GET['dosubmit'])) {
			$ids = $_POST['ids'];
			if (is_array($ids)) {
				$video_content_db = pc_base::load_model('video_content_model');
				foreach ($ids as $videoid) {
					$videoid = intval($videoid);
					$r = $this->db->get_one(array('videoid'=>$videoid), 'vid');
					if (!$this->ku6api->delete_v($r['vid'])) continue;
					$this->v->del_video($videoid);
					$video_content_db->delete(array('videoid'=>$videoid));
				}
			}
			showmessage(L('succfull_create_index'));
		}
	}
	
	/**
	 * Function UPDATE_CONTENT
	 * 更新与此视频关联的内容模型
	 * @param int $vid 视频库videoid字段
	 */
	public function public_update_content() {
		$videoid = intval($_GET['vid']);
		$video_content_db = pc_base::load_model('video_content_model');
		$meunid = intval($_GET['meunid']);
		$pagesize = 10;
		$result = $video_content_db->select(array('videoid'=>$videoid), '*', $pagesize);
		if (!$result || empty($result)) {
			showmessage(L('update_complete'), 'index.php?m=video&c=video&a=init&meunid='.$meunid);
		}
		//加载更新html类
		$html = pc_base::load_app_class('html', 'content');
		$content_db = pc_base::load_model('content_model');
		$url = pc_base::load_app_class('url', 'content');
		foreach ($result as $rs) {
			$modelid = intval($rs['modelid']);
			$contentid = intval($rs['contentid']);
			$video_content_db->delete(array('videoid'=>$videoid, 'contentid'=>$contentid, 'modelid'=>$modelid));
			$content_db->set_model($modelid);
			$table_name = $content_db->table_name;
			$r1 = $content_db->get_one(array('id'=>$contentid));
			if ($this->ishtml($r1['catid'])) {
				$content_db->table_name = $table_name.'_data';
				$r2 = $content_db->get_one(array('id'=>$contentid));
				$r = array_merge($r1, $r2);unset($r1, $r2);
				if($r['upgrade']) {
					$urls[1] = $r['url'];
				} else {
					$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
				}
				$html->show($urls[1], $r, 0, 'edit');
			} else {
				continue;
			}
		}
		showmessage(L('part_update_complete'), 'index.php?m=video&c=video&a=public_update_content&vid='.$videoid.'&meunid='.$meunid);
	}
	
	/**
	 * Function ISHTML
	 * 判断内容是否需要生成静态
	 * @param int $catid 栏目id
	 */
	private function ishtml($catid = 0) {
		static $ishtml, $catid_siteid;
		if (!$ishtml[$catid]) {
			if (!$catid_siteid) {
				$catid_siteid = getcache('category_content', 'commons');
			} else {
				$siteid = $catid_siteid[$catid];
			}
			$siteid = $catid_siteid[$catid];
			$categorys = getcache('category_content_'.$siteid, 'commons');
			$ishtml[$catid] = $categorys[$catid]['content_ishtml'];
		}
		return $ishtml[$catid];
	}
	
	/**
	 * 
	 * 配置视频参数。包括身份识别码、加密密钥、调用方案编号等信息
	 */
	public function setting() {
		if(isset($_POST['dosubmit'])) {
			$setting = array2string($_POST['setting']);
			setcache('video', $_POST['setting']);
			$this->ku6api->ku6api_skey = $_POST['setting']['skey'];
			$this->ku6api->ku6api_sn = $_POST['setting']['sn'];
			$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
			if(!$this->ku6api->testapi()) {
				showmessage(L('vms_sn_skey_error'),'?m=video&c=video&a=open');
			}
			showmessage(L('operation_success'),'?m=video&c=video&a=open');
		} else {
			$show_pc_hash = '';
			$v_model_categorys = $this->ku6api->get_categorys(true, $this->setting['catid']);
			$category_list = '<select name="setting[catid]" id="catid"><option value="0">'.L('please_choose_catid').'</option>'.$v_model_categorys.'</select>';
			include $this->admin_tpl('video_open');
		}
	}
	
	//获取SKEY ,SN 写入缓存
	public function set_video_setting(){
		$array['skey'] = $_GET['skey'];
		$array['sn'] = $_GET['sn'];
		if(empty($_GET['skey']) || empty($_GET['sn'])){
			showmessage(L('操作失败！正在返回！'),'?m=admin');
		}
		$setting = array2string($array);
		setcache('video', $array);
		$this->ku6api->ku6api_skey = $_GET['skey'];
		$this->ku6api->ku6api_sn = $_GET['sn'];
		$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
		showmessage(L('operation_success'),'?m=admin');
	}
	
	/**
	 * function get_pos 获取推荐位
	 * 根据栏目获取推荐位id，并生成form的select形式
	 */
	public function public_get_pos () {
		$catid = intval($_GET['catid']);
		if (!$catid) exit(0);
		$position = getcache('position','commons');
		if(empty($position)) exit;
		$category = pc_base::load_model('category_model');
		$info = $category->get_one(array('catid'=>$catid), 'modelid, arrchildid');
		if (!$info) exit(0);
		$modelid = $info['modelid'];
		$array = array();
		foreach($position as $_key=>$_value) {
			if($_value['modelid'] && ($_value['modelid'] !=  $modelid) || ($_value['catid'] && strpos(','.$info['arrchildid'].',',','.$catid.',')===false)) continue;
			$array[$_key] = $_value['name'];
		}
		$data = form::select($array, '', 'name="sub[posid]"', L('please_select'));
		exit($data);
	}
	
	/**
	 * Function subscribe_list 获取订阅列表
	 * 获取订阅列表
	 */
	public function subscribe_list() {
		if (isset($_GET['dosubmit'])) {
			if (is_array($_GET['sub']) && !empty($_GET['sub'])) {
				$sub = $_GET['sub'];
				if (!$sub['channelid'] || !$sub['catid']) showmessage(L('please_choose_catid_and_channel'));
				$sub['catid'] = intval($sub['catid']);
				$sub['posid'] = intval($sub['posid']);
				$result = $this->ku6api->subscribe($sub);
				if ($result['check'] == 6) showmessage(L('subscribe_for_default')); 
				if ($result['code'] == 200) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list');
				else showmessage(L('subscribe_set_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
			} else {
				showmessage(L('please_choose_catid_and_channel'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
			}
		} else {
			$type = isset($_GET['type']) ? intval($_GET['type']) : 1;
			if((empty($this->setting['sn']) || empty($this->setting['skey'])) && ROUTE_A!='open') {
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
			}
			if(!$this->ku6api->testapi()) {
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
			}
			//获取用户订阅信息
			$v_model_categorys = $this->ku6api->get_categorys(true);
			$category_list = '<select name="sub[catid]" id="catid" onchange="select_pos(this)"><option value="0">'.L('please_choose_catid').'</option>'.$v_model_categorys.'</select>';
			$siteid = get_siteid();
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$ku6_channels = $this->ku6api->get_subscribetype();
			$subscribes = $this->ku6api->get_subscribe();
			$usersubscribes = $this->ku6api->get_usersubscribe();
			$position = getcache('position','commons');
			
			include $this->admin_tpl('subscribe_list');
		}
	}
	
	/**
	 * Function Sub_DEl 删除订阅
	 * 用户删除订阅方法
	 */
	public function sub_del() {
		$id = intval($_GET['id']);
		if (!$id) showmessage(L('illegal_parameters'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		if ($this->ku6api->sub_del($id)) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		else showmessage(L('delete_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
	}
	
	/**
	 * Function sub_del 删除订阅用户
	 * 删除订阅用户方法
	 */
	public function user_sub_del() {
		$id = intval($_GET['id']);
		$type = intval($_GET['type']);
		if (!$id) showmessage(L('illegal_parameters'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		if ($this->ku6api->user_sub_del($id)) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid'].'&type='.$type);
		else showmessage(L('delete_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid'].'&type='.$type);
	}	
	
	/**
	 * Function video2content 视频库中视频
	 * 用户选择在视频中选择已上传的视频加入到视频字段或编辑器中
	 */
	public function video2content () {
		$page = max(intval($_GET['page']), 1);
		$pagesize = isset($_GET['pagesize']) ? intval($_GET['pagesize']) : 8;
		$where = '`status` = 21';
		if (isset($_GET['name']) && !empty($_GET['name'])) {
			$title = safe_replace($_GET['name']);
			$where .= " AND `title` LIKE '%$title%'";
		}
		if (isset($_GET['starttime']) && !empty($_GET['starttime'])) {
			$addtime = strtotime($_GET['starttime']);
			$where .= " AND `addtime`>='$addtime'";
		}
		if (isset($_GET['endtime']) && !empty($_GET['endtime'])) {
			$endtime = strtotime($_GET['endtime']);
			$where .= " AND `addtime` <= '$endtime'";
		}
		if ($_GET['userupload']) {
			$userupload = intval($_GET['userupload']);
			$where .= " AND `userupload`=1";
		}
		$show_header = 1;
		$infos = $this->db->listinfo($where, '`videoid` DESC', $page, $pagesize, '', 5);
		$pages = $this->db->pages;
		include $this->admin_tpl('album_list');
	}
	
	/**
	 * 设置swfupload上传的json格式cookie
	 */
	public function swfupload_json() {
		$arr['id'] = $_GET['id'];
		$arr['src'] = trim($_GET['src']);
		$arr['title'] = urlencode($_GET['title']);
		$json_str = json_encode($arr);
		$att_arr_exist = param::get_cookie('att_json');
		$att_arr_exist_tmp = explode('||', $att_arr_exist);
		if(is_array($att_arr_exist_tmp) && in_array($json_str, $att_arr_exist_tmp)) {
			return true;
		} else {
			$json_str = $att_arr_exist ? $att_arr_exist.'||'.$json_str : $json_str;
			param::set_cookie('att_json',$json_str);
			return true;			
		}
	}
	
	/**
	 * 删除swfupload上传的json格式cookie
	 */	
	public function swfupload_json_del() {
		$arr['aid'] = intval($_GET['aid']);
		$arr['src'] = trim($_GET['src']);
		$arr['filename'] = urlencode($_GET['filename']);
		$json_str = json_encode($arr);
		$att_arr_exist = param::get_cookie('att_json');
		$att_arr_exist = str_replace(array($json_str,'||||'), array('','||'), $att_arr_exist);
		$att_arr_exist = preg_replace('/^\|\|||\|\|$/i', '', $att_arr_exist);
		param::set_cookie('att_json',$att_arr_exist);
	}

	/**
	* 导入KU6视频
	*/
	public function import_ku6video(){
		if(!$this->ku6api->testapi()) {
			header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
		}
		pc_base::load_sys_class('format','',0);
		$do = isset($_GET['do']) ? $_GET['do'] : '';
		$ku6url = isset($_GET['ku6url']) ? $_GET['ku6url'] : '';
		$time = isset($_GET['time']) ? $_GET['time'] : '';
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '*:*';
		$len = isset($_GET['len']) ? $_GET['len'] : '';//时长s:小于4分钟 I:大于4分钟
		$fenlei = isset($_GET['fenlei']) ? $_GET['fenlei'] : '*:*';//搜索分类
		$srctype = isset($_GET['srctype']) ? $_GET['srctype'] : 0;//视频质量 
		$videotime = isset($_GET['videotime']) ? $_GET['videotime'] : 0;//视频时长 
 		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$pagesize = 20;
 		$list = array();
		
		if(CHARSET!='utf-8'){
			$keyword = iconv('gbk', 'utf-8', $keyword);
		}
		$keyword = urlencode($keyword);
		
  		$data = $this->ku6api->Ku6search($keyword,$pagesize,$page,$srctype,$len,$fenlei,$videotime); 
 		$totals = $data['data']['total'];
		$list = $data['data']['list'];
		//获取视频大小接口
		if(isset($list) && is_array($list) && count($list) > 0) {
			foreach ($list as $key=>$v) {
				$spaceurl = "http://v.ku6.com/fetchVideo4Player/1/$v[vid].html";
				$spacejson = file_get_contents($spaceurl);
				$space = json_decode($spacejson, 1);	 
				$list[$key]['size'] = $space['data']['videosize'];
				$list[$key]['uploadTime']  = substr($v['uploadtime'], 0, 10); 
				//判断那些已经导入过本机系统 $vidstr .= ',\''.$v['vid'].'\'';
			}
		}   
		//选择站点和栏目进行导入
		$sitelist = getcache('sitelist','commons');
		
		//分类数组
		$fenlei_array = array('101000'=>'资讯','102000'=>'体育','103000'=>'娱乐','104000'=>'电影','105000'=>'原创','106000'=>'广告','107000'=>'美女','108000'=>'搞笑','109000'=>'游戏','110000'=>'动漫','111000'=>'教育','113000'=>'生活','114000'=>'汽车','115000'=>'房产','116000'=>'音乐','117000'=>'电视','118000'=>'综艺','125000'=>'女生','126000'=>'记录','127000'=>'科技','190000'=>'其它');
		//视频质量
		$srctype_array = array('1'=>'超清','2'=>'高清','3'=>'标清','4'=>'流畅');
 		$videotime_array = array('1'=>'短视频','2'=>'普通视频','3'=>'中视频','4'=>'长视频');
		
		//本机视频栏目
		$categoryrr = $this->get_category();
  		include $this->admin_tpl('import_ku6video');   
 	}

	/**
	* 搜索视频浏览 
	*/
	public function preview_ku6video(){
		$ku6vid = $_GET['ku6vid'];
 		$data = $this->ku6api->Preview($ku6vid);
   		include $this->admin_tpl('priview_ku6video');
	}
	
	/**
	* 获取站点栏目数据
	*/
	public function get_category(){
  		$siteid = get_siteid();//直取SITEID值
		$sitemodel_field = pc_base::load_model('sitemodel_field_model');
		$result = $sitemodel_field->select(array('formtype'=>'video', 'siteid'=>$siteid), 'modelid');
		if (is_array($result)) {
			$models = '';
			foreach ($result as $r) {
				$models .= $r['modelid'].',';
			}
		}
		$models = substr(trim($models), 0, -1);
		$cat_db = pc_base::load_model('category_model');
		if ($models) {
			$where = '`modelid` IN ('.$models.') AND `type`=0 AND `siteid`=\''.$siteid.'\'';
			$result = $cat_db->select($where, '`catid`, `catname`, `parentid`, `siteid`, `child`');
			if (is_array($result)) { 
				$data = $return_data = $categorys = array(); 
				$tree = pc_base::load_sys_class('tree');   
				$data = $return_data = $categorys = array(); 
				$tree = pc_base::load_sys_class('tree');//factory::load_class('tree', 'utils');
 				$string = '<select name="select_category" id="select_category" onchange="select_pos(this)">';
				$string .= "<option value=0>请选择分类</option>";
				foreach ($result as $r) {
					$r['html_disabled'] = "";
					if ($r['child']) {
						$r['html_disabled'] = "disabled";
					} 
					$categorys[$r['catid']] = $r;
				}
				$str  = $str2 = "<option value=\$catid \$html_disabled \$selected>\$spacer \$catname</option>"; 			     $tree->init($categorys);
				$string .= $tree->get_tree_category(0, $str, $str2);
 				$string .= '</select>';
				return $string;//不使用前台js调用，使用return ;
			}
 		}
		return array();
	}

	public function public_view_video() {
		$id = intval($_GET['id']);
		if (!$id) showmessage('请选择要浏览的视频！');
		$r = $this->db->get_one(array('videoid'=>$id), 'vid,channelid');
		$video_cache = $this->setting;
		$show_header = 1;
		include $this->admin_tpl('view_video');
	}

	/**
	 *@ function public_check_status
	 *@ 手动检查视频状态 
	 */
	public function public_check_status() {
		$id = intval($_GET['id']);
		if (!$id) exit('1');
		$r = $this->db->get_one(array('videoid'=>$id), 'vid,channelid,status,picpath');
		if (!$r) exit('2');
		$return = $this->ku6api->check_status($r['vid']);
		if (!$return) exit('3');
		
		$status_arr = pc_base::load_config('ku6status_config');
		if ($return['ku6status'] != $r['status']) {
			$this->db->update(array('status'=>$return['ku6status'], 'picpath'=>$return['picpath']), array('videoid'=>$id));
			
			if ($return['ku6status']==21) {
				/**
				 * 加载视频内容对应关系数据模型，检索与删除视频相关的内容。
				 * 在对应关系表中找出对应的内容id，并更新内容的静态页
				 */
				$video_content_db = pc_base::load_model('video_content_model');
				$result = $video_content_db->select(array('videoid'=>$id));
				if (is_array($result) && !empty($result)) {
					//加载更新html类
					$html = pc_base::load_app_class('html', 'content');
					$content_db = pc_base::load_model('content_model');
					$content_check_db = pc_base::load_model('content_check_model');
					$url = pc_base::load_app_class('url', 'content');
					foreach ($result as $rs) {
						$modelid = intval($rs['modelid']);
						$contentid = intval($rs['contentid']);
						$content_db->set_model($modelid);
						$c_info = $content_db->get_one(array('id'=>$contentid), 'thumb');

						$where = array('status'=>99);
						if (!$c_info['thumb']) $where['thumb'] = $return['picpath'];
						$content_db->update($where, array('id'=>$contentid));
						$checkid = 'c-'.$contentid.'-'.$modelid;
						$content_check_db->delete(array('checkid'=>$checkid));
						$table_name = $content_db->table_name;
						$r1 = $content_db->get_one(array('id'=>$contentid));
						/**
						 * 判断如果内容页生成了静态页，则更新静态页
						 */
						if (ishtml($r1['catid'])) {
							$content_db->table_name = $table_name.'_data';
							$r2 = $content_db->get_one(array('id'=>$contentid));
							$r = array_merge($r1, $r2);unset($r1, $r2);
							if($r['upgrade']) {
								$urls[1] = $r['url'];
							} else {
								$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
							}
							$html->show($urls[1], $r, 0, 'edit');
							
						} else {
							continue;
						}
					}
				}
				$msg_r = json_encode(array('change'=>1, 'status'=>21, 'statusname'=>iconv(CHARSET, 'UTF-8', $status_arr[$return['ku6status']])));
			} else {
				$msg_r = json_encode(array('change'=>1, 'status'=>$return['ku6status'], 'statusname'=>iconv(CHARSET, 'UTF-8', $status_arr[$return['ku6status']])));
			}
		} else if (!$r['picpath'] && $return['picpath']) {
			$this->db->update(array('picpath'=>$return['picpath']), array('videoid'=>$id));
			$msg_r = json_encode(array('change'=>1, 'status'=>$return['ku6status'], 'statusname'=>iconv(CHARSET, 'UTF-8', $status_arr[$return['ku6status']])));
		}else {
			$msg_r = json_encode(array('change'=>0));
		}	
		exit($msg_r);	
	}
	
	/***********2013.1.15添加**********/
	
	/** 
	 * 后台申请开通视频聚合功能。服务器自动返回配置视频参数。包括身份识别码、加密密钥、调用方案编号等信息
	 */
	public function open() {   
		$this->setting = getcache('video');
 		if(empty($this->setting['skey']) || empty($this->setting['sn'])){
			//配置不存在，则先验证域名是否存在，如果存在，直接跳去验证页面
			$check_user_back = APP_PATH . 'api.php?op=video_api';
			$return_check = $this->ku6api->check_user_back($check_user_back);
			if ($return_check==200 && SITE_URL != 'localhost' && !preg_match("/^(127|192|10)\.([1-2]?)([0-9]?)([0-9])\.([1-2]?)([0-9]?)([0-9])\.([1-2]?)([0-9]?)([0-9])/", SITE_URL)) {//存在同域名记录，进行email验证
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=check_user_back&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
				exit;
			}
			
			//配置不存在，跳转至盛大通行证登录页面 
			$user_back = APP_PATH . 'api.php?op=video_api';
			$user_back = str_replace("/","__",$user_back);
			$user_back = urlencode(str_replace(".php","@php",$user_back));
			include $this->admin_tpl('video_open');
		} else {
			$config_flag = false;
			if($this->ku6api->testapi()) {
				$config_flag = true;
			}
			include $this->admin_tpl('video_setting');
		} 
	}
	
	//完善详细资料，通过API接口完善资料,获取 SKEY,SN 
	public function complete_info() { 
 		if(isset($_POST['dosubmit'])) {
			$info = safe_replace($_POST['info']); //包含隐藏的uid
			if (CHARSET == 'gbk') {
				$info = array_iconv($info);
			}
			//提交数据，获取SKEY,SN  
			$return_skey_sn = $this->ku6api->complete_info($info);
 			if(is_array($return_skey_sn) && !empty($return_skey_sn)){
				$setting = array2string($return_skey_sn);
				setcache('video', $return_skey_sn);
				$this->ku6api->ku6api_skey = $return_skey_sn['skey'];
				$this->ku6api->ku6api_sn = $return_skey_sn['sn'];
				$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
				showmessage('资料提交成功，已成功开通视频应用，正在返回！','?m=video&c=video&a=open');
			}else{
				echo $return_skey_sn;exit;
			showmessage('资料提交失败，请联系商务人员处理！','?m=video&c=video&a=open');
			} 
		}else{ 
			//如果传递uid,snid则为登录通行证成功，返回完善资料，没有传递则为自行填写资料申请开通视频应用
			$uid = intval($_GET['uid']);
			$snid = $_GET['snid'];
			if(empty($this->setting['skey']) || empty($this->setting['sn'])){
				if(!$snid) showmessage("请先登录盛大通行证");
			}	
			//如果skey,sn存在，通过接口调取用户完善的资料，再提交为修改操作
			$skey_sn_array = getcache('video');
			if(!empty($skey_sn_array['skey']) && !empty($skey_sn_array['sn'])){ 
   				$return_info = $this->ku6api->Get_Complete_Info($skey_sn_array);
				if (CHARSET == 'gbk') {
					$return_info = array_iconv($return_info,'utf-8','gbk');
				} 
  				$complete_info = is_array($return_info) ? $return_info : array(); 
				$uid = $complete_info['uid'];
				$snid = $complete_info['sndaid'];
			}else{
				//没有配置则判断域名在聚合平台是否已经存在，如果存在进行验证获取SKEY
				$check_user_back = APP_PATH . 'api.php?op=video_api';
				$return_check = $this->ku6api->check_user_back($check_user_back);
				if($return_check==200){//存在同域名记录，进行email验证
					showmessage('域名已经存在，请验证开通视频应用！','?m=video&c=video&a=check_user_back');
				}
 				$complete_info = array();	
			}
			$show_dialog = 1;
			$show_header = $show_scroll = true;
			include $this->admin_tpl('video_complete_info');
		}
	}
	
	//Email 验证老网站，获取sn,skey
	public function check_user_back(){
		if(isset($_POST['dosubmit_new'])) {
			$data['email'] = $_POST['email'];
			$data['code'] = $_POST['code'];
			if(empty($data['email']) || empty($data['code'])) return false;
			$return_skey_sn = $this->ku6api->check_email_code($data);
			if(is_array($return_skey_sn) && !empty($return_skey_sn)){
				$setting = array2string($return_skey_sn);
				setcache('video', $return_skey_sn);
				$this->ku6api->ku6api_skey = $return_skey_sn['skey'];
				$this->ku6api->ku6api_sn = $return_skey_sn['sn'];
				$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
				showmessage('验证成功，已成功开通视频应用，正在返回！','?m=video&c=video&a=open');
			}else{
				showmessage('验证失败，请返回！',HTTP_REFERER);
			}  
		}else{
			$show_dialog = 1;
			$show_header = $show_scroll = true;
			include $this->admin_tpl('video_check_user_back');
		}
	}
	
	//由平台发送验证码到指定信箱
	public function send_code(){ 
		$data['email'] = $_GET['email'];
		$data['url'] = APP_PATH . 'api.php?op=video_api';
 		$return = $this->ku6api->send_code($data);
 		if($return['code']=='200'){
			echo 1;
		}else{
			echo 2;
		}
	}
	
	
	//获取传递的skey ,sn 写入缓存
	public function get_skey_sn(){
		$skey = $_REQUEST['skey'];
		$sn = $_REQUEST['sn'];
		if(empty($skey) || empty($sn)){
			showmessage('视频配置信息不能为空',HTTP_REFERER);
		}
		$setting_arr['skey'] = $skey;
		$setting_arr['sn'] = $sn;
		$setting = array2string($setting_arr);
		setcache('video', $setting_arr);//写缓存  
		$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));//更新模版数据
		//验证配置
		$this->ku6api->ku6api_skey = $skey;
		$this->ku6api->ku6api_sn = $sn;
		if(!$this->ku6api->testapi()) {
			showmessage(L('vms_sn_skey_error'),'?m=video&c=video&a=open');
		}
		showmessage(L('operation_success'),'?m=video&c=video&a=open');
	}
	
	public function open_setting() {
		if(isset($_POST['dosubmit'])) {
			$setting = array2string($_POST['setting']);
			setcache('video', $_POST['setting']);
			$this->ku6api->ku6api_skey = $_POST['setting']['skey'];
			$this->ku6api->ku6api_sn = $_POST['setting']['sn'];
			$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
			if(!$this->ku6api->testapi()) {
				showmessage(L('vms_sn_skey_error'),HTTP_REFERER);
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_pc_hash = '';
			$v_model_categorys = $this->ku6api->get_categorys(true, $this->setting['catid']);
			$category_list = '<select name="setting[catid]" id="catid"><option value="0">'.L('please_choose_catid').'</option>'.$v_model_categorys.'</select>';
			include $this->admin_tpl('video_opensetting');
		}
	}
	
	//获取userid下的视频
	public function ajax_getuseridvideo(){
		$userid = intval($_GET['userid']);
		if (!$userid) exit(0);
		$url = "http://v.ku6.com/video.htm?t=list&uid=" . $userid . "&p=1";
		$data = @file_get_contents($url);
		$data = json_decode($data, 1);
		$list = $data['data'];
		if (is_array($list)) {
			$sub['userid'] = $userid;
			$result = $this->ku6api->checkusersubscribe($sub);
			$status = $result['status'];
			exit($status);
		} 
		exit('0');
	}

	/**
	 * 订阅用户视频
	 */
	public function subscribe_uservideo() {
		if (is_array($_GET['sub']) && !empty($_GET['sub'])) {
			$sub = $_GET['sub'];
			if (!$sub['userid'] || !$sub['catid']) showmessage(L('please_choose_catid_and_channel'));
			$sub['catid'] = intval($sub['catid']);
			$sub['posid'] = intval($sub['posid']);
			$result = $this->ku6api->usersubscribe($sub);
			if ($result['check'] == 6) showmessage(L('subscribe_for_default')); 
			if ($result['code'] == 200) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list&type=2');
			else showmessage(L('subscribe_set_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		} else {
			showmessage(L('please_choose_catid_and_iputuserid'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid'].'&type=2');
		}
	}	
	
}

?>