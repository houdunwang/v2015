<?php 
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
class special extends admin {
	private $db, $special_api;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('special_model');
		$this->special_api = pc_base::load_app_class('special_api', 'special');
	}
	
	/**
	 * 专题列表
	 */
	public function init() {
		$page = max(intval($_GET['page']), 1);
		$infos = $this->db->listinfo(array('siteid'=>$this->get_siteid()), '`listorder` DESC, `id` DESC', $page, 6);
		pc_base::load_sys_class('format', '', 0);
		include $this->admin_tpl('special_list');
	}
	
	/**
	 * 添加专题
	 */
	public function add() {
		if (isset($_POST['dosubmit']) && !empty($_POST['dosubmit'])) {
			$special = $this->check($_POST['special']);
			$id = $this->db->insert($special, true);
			if ($id) {
				$this->special_api->_update_type($id, $_POST['type']);
				if ($special['siteid']>1) {
					$site = pc_base::load_app_class('sites', 'admin');
					$site_info = $site->get_by_id($special['siteid']);
					if ($special['ishtml']) {
						$special['filename'] = str_replace('..','',$special['filename']);
						$url =  $site_info['domain'].'special/'.$special['filename'].'/';
					} else {
						$url = $site_info['domain'].'index.php?m=special&c=index&id='.$id;
					}
				} else {
					$url = $special['ishtml'] ? APP_PATH.substr(pc_base::load_config('system', 'html_root'), 1).'/special/'.$special['filename'].'/' : APP_PATH.'index.php?m=special&c=index&id='.$id;
				}
				$this->db->update(array('url'=>$url), array('id'=>$id, 'siteid'=>$this->get_siteid()));
				
				//调用生成静态类
				if ($special['ishtml']) {
					$html = pc_base::load_app_class('html', 'special'); 
					$html->_index($id, 20, 5);
				}
				//更新附件状态
				if(pc_base::load_config('system','attachment_stat')) {
					$this->attachment_db = pc_base::load_model('attachment_model');
					$this->attachment_db->api_update(array($special['thumb'], $special['banner']),'special-'.$id, 1);
				}
				$this->special_cache();
			}
			showmessage(L('add_special_success'), HTTP_REFERER);
		} else {
			//获取站点模板信息
			pc_base::load_app_func('global', 'admin');
			$siteid = $this->get_siteid();
			$template_list = template_list($siteid, 0);
			$site = pc_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			include $this->admin_tpl('special_add');
		}
	}
	
	/**
	 * 专题修改
	 */
	public function edit() {
		if (!isset($_GET['specialid']) || empty($_GET['specialid'])) {
			showmessage(L('illegal_action'), HTTP_REFERER);
		}
		$_GET['specialid'] = intval($_GET['specialid']);
		if (isset($_POST['dosubmit']) && !empty($_POST['dosubmit'])) {
			$special = $this->check($_POST['special'], 'edit');
			$siteid = get_siteid();
			$site = pc_base::load_app_class('sites', 'admin');
			$site_info = $site->get_by_id($siteid);
			if ($special['ishtml'] && $special['filename']) {
				$special['filename'] = str_replace('..','',$special['filename']);
				if ($siteid>1) {
					$special['url'] =  $site_info['domain'].'special/'.$special['filename'].'/';
				} else {
					$special['url'] = APP_PATH.substr(pc_base::load_config('system', 'html_root'), 1).'/special/'.$special['filename'].'/';
				}
			} elseif ($special['ishtml']=='0') {
				if ($siteid>1) {
					$special['url'] = $site_info['domain'].'index.php?m=special&c=index&specialid='.$_GET['specialid'];
				} else {
					$special['url'] = APP_PATH.'index.php?m=special&c=index&specialid='.$_GET['specialid'];
				}
			}
			$this->db->update($special, array('id'=>$_GET['specialid'], 'siteid'=>$this->get_siteid()));
			$this->special_api->_update_type($_GET['specialid'], $_POST['type'], 'edit');
			
			//调用生成静态类
			if ($special['ishtml']) {
				$html = pc_base::load_app_class('html', 'special'); 
				$html->_index($_GET['specialid'], 20, 5);
			}
			//更新附件状态
			if(pc_base::load_config('system','attachment_stat')) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update(array($special['thumb'], $special['banner']),'special-'.$_GET['specialid'], 1);
			}
			$this->special_cache();
			showmessage(L('edit_special_success'), HTTP_REFERER);
		} else {
			$info = $this->db->get_one(array('id'=>$_GET['specialid'], 'siteid'=>$this->get_siteid()));
			//获取站点模板信息
			pc_base::load_app_func('global', 'admin');
			$template_list = template_list($this->siteid, 0);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			if ($info['pics']) {
				$pics = explode('|', $info['pics']);
			}
			if ($info['voteid']) {
				$vote_info = explode('|', $info['voteid']);
			}
			$type_db = pc_base::load_model('type_model');
			$types = $type_db->select(array('module'=>'special', 'parentid'=>$_GET['specialid'], 'siteid'=>$this->get_siteid()), '`typeid`, `name`, `listorder`, `typedir`', '', '`listorder` ASC, `typeid` ASC');
			include $this->admin_tpl('special_edit');
		}
	}
	
	/**
	 * 信息导入专题
	 */
	public function import() {
		if(isset($_POST['dosubmit']) || isset($_GET['dosubmit'])) {
			if(!is_array($_POST['ids']) || empty($_POST['ids']) || !$_GET['modelid']) showmessage(L('illegal_action'), HTTP_REFERER);
			if(!isset($_POST['typeid']) || empty($_POST['typeid'])) showmessage(L('select_type'), HTTP_REFERER);
			foreach($_POST['ids'] as $id) {
				$this->special_api->_import($_GET['modelid'], $_GET['specialid'], $id, $_POST['typeid'], $_POST['listorder'][$id]);
			}
			$html = pc_base::load_app_class('html', 'special'); 
			$html->_index($_GET['specialid'], 20, 5);
			showmessage(L('import_success'), 'blank', '', 'import');
		} else {
			if(!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);
			$_GET['modelid'] = $_GET['modelid'] ? intval($_GET['modelid']) : 0;
			$_GET['catid'] = $_GET['catid'] ? intval($_GET['catid']) : 0;
			$_GET['page'] = max(intval($_GET['page']), 1);
			$where = '';
			if($_GET['catid']) $where .= get_sql_catid('category_content_'.$this->get_siteid(), $_GET['catid'])." AND `status`=99";
			else $where .= " `status`=99";
			if($_GET['start_time']) {
				$where .= " AND `inputtime`>=".strtotime($_GET['start_time']);
			}
			if($_GET['end_time']) {
				$where .= " AND `inputtime`<=".strtotime($_GET['end_time']);
			}
			if ($_GET['key']) {
				$where .= " AND `title` LIKE '%$_GET[key]%' OR `keywords` LIKE '%$_GET[key]%'";
			}
			$data = $this->special_api->_get_import_data($_GET['modelid'], $where, $_GET['page']);
			$pages = $this->special_api->pages;
			$models = getcache('model','commons');
			$model_datas = array();
			foreach($models as $_k=>$_v) {
				if($_v['siteid']==$this->get_siteid()) {
					$model_datas[$_v['modelid']] = $_v['name'];
				}
			}
			$model_form = form::select($model_datas, $_GET['modelid'], 'name="modelid" onchange="select_categorys(this.value)"', L('select_model'));
			$types = $this->special_api->_get_types($_GET['specialid']);
			include $this->admin_tpl('import_content');
		}
	}
	
	public function public_get_pics() {
		$_GET['modelid'] = $_GET['modelid'] ? intval($_GET['modelid']) : 0;
			$_GET['catid'] = $_GET['catid'] ? intval($_GET['catid']) : 0;
			$_GET['page'] = max(intval($_GET['page']), 1);
			$where = '';
			if($_GET['catid']) $where .= get_sql_catid('category_content_'.$this->get_siteid(), $_GET['catid'])." AND `status`=99";
			else $where .= " `status`=99";
			if ($_GET['title']) {
				$where .= " AND `title` LIKE '%".$_GET['title']."%'";
			}
			if($_GET['start_time']) {
				$where .= " AND `inputtime`>=".strtotime($_GET['start_time']);
			}
			if($_GET['end_time']) {
				$where .= " AND `inputtime`<=".strtotime($_GET['end_time']);
			}
			$data = $this->special_api->_get_import_data($_GET['modelid'], $where, $_GET['page']);
			$pages = $this->special_api->pages;
			$models = getcache('model','commons');
			$model_datas = array();
			foreach($models as $_k=>$_v) {
				if($_v['siteid']==$this->get_siteid()) {
					$model_datas[$_v['modelid']] = $_v['name'];
				}
			}
			$model_form = form::select($model_datas, $_GET['modelid'], 'name="modelid" onchange="select_categorys(this.value)"', L('select_model'));
			$types = $this->special_api->_get_types($_GET['specialid']);
			include $this->admin_tpl('import_pics');
	}
	
	public function html() {
		if((!isset($_POST['id']) || empty($_POST['id']))) {
			$result = $this->db->select(array('disabled'=>0, 'siteid'=>$this->get_siteid()), 'id', '', '', '', 'id');
			$id = array_keys($result);
		} else {
			$id = $_POST['id'];
		}
		setcache('create_specials', $id, 'commons');
		$this->public_create_html();
	}
	
	public	function create_special_list() {
		$siteid = get_siteid();
		$html = pc_base::load_app_class('html');
		$c = pc_base::load_model('special_model');
		$result = $c->get_one(array('siteid'=>$siteid), 'COUNT(*) AS total');
		$total = $result['total'];
		$pages = ceil($total/20);
		for ( $i=1; $i <= $pages ; $i++ ){ 
			$size = $html->create_list($i);
		}
		showmessage(L('index_create_finish',array('size'=>sizecount($size))));
	}
	
	/**
	 * 专题排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorder'] as $id => $order) {
				$id = intval($id);
				$order = intval($order);
				$this->db->update(array('listorder'=>$order), array('id'=>$id));
			}
			$this->special_cache();
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('please_in_admin'), HTTP_REFERER);
		}
	}
	
	//生成专题首页控制中心
	public function public_create_html() {
		
		$specials = getcache('create_specials', 'commons');
		if (is_array($specials) && !empty($specials)) {
			$specialid = array_shift($specials);
			setcache('create_specials', $specials, 'commons');
			$this->create_index($specialid);
		} else {
			delcache('create_specials', 'commons');
			showmessage(L('update_special_success'), '?m=special&c=special&a=init');
		}
	}
	
	//生成某专题首页
	private function create_index($specialid) {
		$info = $this->db->get_one(array('id'=>$specialid));
		if (!$info['ishtml']) {
			showmessage($info['title'].L('update_success'), '?m=special&c=special&a=public_create_html');
		}
		$html = pc_base::load_app_class('html');
		$html->_index($specialid);
		showmessage($info['title'].L('index_update_success'), '?m=special&c=special&a=public_create_type&specialid='.$specialid);
	}
	
	//生成专题里列表页
	public function public_create_type() {
		$specialid = $_GET['specialid'] ? intval($_GET['specialid']) : 0;
		if (!$specialid) showmessage(L('illegal_action'));
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$pages = isset($_GET['pages']) ? intval($_GET['pages']) : 0;
		$types = getcache('create_types', 'commons');
		if (is_array($types) && !empty($types) || $pages) {
			if (!isset($page) || $page==1) {
				$typeids = array_keys($types);
				$typeid = array_shift($typeids);
				$typename = $types[$typeid];
				unset($types[$typeid]);
				setcache('create_types', $types, 'commons');
			}
			if (!$pages) {
				$c = pc_base::load_model('special_content_model');
				$result = $c->get_one(array('typeid'=>$typeid), 'COUNT(*) AS total');
				$total = $result['total'];
				$pages = ceil($total/20);
			}
			if ($_GET['typeid']) {
				$typeid = intval($_GET['typeid']);
				$typename = $_GET['typename'];
			}
			$maxpage = $page+10;
			if ($maxpage>$pages) {
				$maxpage = $pages;
			}
			for ($page; $page<=$maxpage; $page++) {
				$html = pc_base::load_app_class('html');
				$html->create_type($typeid, $page);
			}
			if (empty($types) && $pages==$maxpage) {
				delcache('create_types', 'commons');
				showmessage($typename.L('type_update_success'), '?m=special&c=special&a=public_create_content&specialid='.$specialid);
			}
			if ($pages<=$maxpage) {
				showmessage($typename.L('update_success'), '?m=special&c=special&a=public_create_type&specialid='.$specialid);
			} else {
				showmessage($typename.L('type_from').($_GET['page'] ? $_GET['page'] : 1).L('type_end').$maxpage.'</font> '.L('update_success'), '?m=special&c=special&a=public_create_type&typeid='.$typeid.'&typename='.$typename.'&page='.$page.'&pages='.$pages.'&specialid='.$specialid);
			}
			
		} else {
			$special_api = pc_base::load_app_class('special_api');
			$types = $special_api->_get_types($specialid);
			setcache('create_types', $types, 'commons');
			showmessage(L('start_update_type'), '?m=special&c=special&a=public_create_type&specialid='.$specialid);
		}
	}
	
	//生成内容页
	public function public_create_content() {
		$specialid = $_GET['specialid'] ? intval($_GET['specialid']) : 0;
		if (!$specialid) showmessage(L('illegal_action'));
		$pages = $_GET['pages'] ? intval($_GET['pages']) : 0;
		$page = $_GET['page'] ? intval($_GET['page']) : 1;
		$c = pc_base::load_model('special_content_model');
		if (!$pages) {
			$result = $c->get_one(array('specialid'=>$specialid, 'isdata'=>1), 'COUNT(*) AS total');
			$total = $result['total'];
			$pages = ceil($total/10);
		}
		$offset = ($page-1)*10;
		$result = $c->select(array('specialid'=>$specialid, 'isdata'=>1), 'id', $offset.', 10', 'listorder ASC, id ASC');
		foreach ($result as $r) {
			$html = pc_base::load_app_class('html');
			$urls = $html->_create_content($r['id']);
			$c->update(array('url'=>$urls[0]), array('id'=>$r['id']));
		}
		if ($page>=$pages) {
			showmessage(L('content_update_success'), '?m=special&c=special&a=public_create_html&specialid='.$specialid);
		} else {
			$page++;
			showmessage(L('content_from').' <font color="red">'.intval($offset+1).L('type_end').intval($offset+10).'</font> '.L('update_success'), '?m=special&c=special&a=public_create_content&specialid='.$specialid.'&page='.$page.'&pages='.$pages);
		}
	}
	
	/**
	 * 推荐专题
	 */
	public function elite() {
		if(!isset($_GET['id']) || empty($_GET['id'])) {
			showmessage(L('illegal_action'));
		}
		$_GET['value'] = $_GET['value'] ? intval($_GET['value']) : 0;
		$this->db->update(array('elite'=>$_GET['value']), array('id'=>$_GET['id'], 'siteid'=>get_siteid()));
		showmessage(L('operation_success'), HTTP_REFERER);
	}
	
	/**
	 * 删除专题 未执行删除操作，仅进行递归循环
	 */
	public function delete($id = 0) {
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id'])) && !$id) {
			showmessage(L('illegal_action'), HTTP_REFERER);
		}
		if(is_array($_POST['id']) && !$id) {
			array_map(array($this, delete), $_POST['id']);
			$this->special_cache();
			showmessage(L('operation_success'), HTTP_REFERER);
		} elseif(is_numeric($id) && $id) {
			$id = $_GET['id'] ? intval($_GET['id']) : intval($id);
			$this->special_api->_del_special($id);
			return true;
		} else {
			$id = $_GET['id'] ? intval($_GET['id']) : intval($id);
			$this->special_api->_del_special($id);
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
	
	/**
	 * 专题缓存
	 */
	private function special_cache() {
		$specials = array();
		$result = $this->db->select(array('disabled'=>0), '`id`, `siteid`, `title`, `url`, `thumb`, `banner`, `ishtml`', '', '`listorder` DESC, `id` DESC');
		foreach($result as $r) {
			$specials[$r['id']] = $r;
		}
		setcache('special', $specials, 'commons');
		return true;
	}
	
	/**
	 * 获取专题的分类 
	 * 
	 * @param intval $specialid 专题ID
	 * @return 返回此专题分类的下拉列表
	 */
	public function public_get_type() {
		$_GET['specialid'] = intval($_GET['specialid']);
		if(!$_GET['specialid']) return '';
		$datas = $this->special_api->_get_types($_GET['specialid']);
		echo form::select($types, 0, 'name="typeid" id="typeid" onchange="import_c('.$_GET['specialid'].', this.value)"', L('please_select'));
	}
	
	/**
	 * 按模型ID列出模型下的栏目
	 */
	public function public_categorys_list() {
		if(!isset($_GET['modelid']) || empty($_GET['modelid'])) exit('');
		$modelid = intval($_GET['modelid']);
		exit(form::select_category('', $_GET['catid'], 'name="catid" id="catid"', L('please_select'), $modelid, 0, 1));
	}
	
	/**
	 * ajax验证专题是否已存在
	 */
	public function public_check_special() {
		if(!$_GET['title']) exit(0);
		if(pc_base::load_config('system', 'charset')=='gbk') {
			$_GET['title'] = safe_replace(iconv('UTF-8', 'GBK', $_GET['title']));
		}
		$title = addslashes($_GET['title']);
		if($_GET['id']) {
			$id = intval($_GET['id']);
			$r = $this->db->get_one(array('id'=>$id, 'siteid'=>$this->get_siteid()));
			if($r['title'] == $title) {
				exit('1');
			}
		}
		$r = $this->db->get_one(array('siteid' => $this->get_siteid(), 'title' => $title), 'id');
		if($r['id']) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/**
	 * ajax检验专题静态文件名是否存在，避免专题页覆盖
	 */
	public function public_check_dir() {
		if(!$_GET['filename']) exit(1);
		if($_GET['id']) {
			$id = intval($_GET['id']);
			$r = $this->db->get_one(array('id'=>$id, 'siteid'=>$this->get_siteid()));
			if($r['filename'] = $_GET['filename']) {
				exit('1');
			}
		}
		$r = $this->db->get_one(array('siteid'=>$this->get_siteid(), 'filename'=>$_GET['filename']), 'id');
		if($r['id']) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/**
	 * 表单验证
	 * @param array $data 表单传递的值
	 * @param string $a add/edit添加操作时，自动加上默认值
	 */
	private function check($data, $a = 'add') {
		if(!$data['title']) showmessage(L('title_cannot_empty'), HTTP_REFERER);
		if(!$data['banner']) showmessage(L('banner_no_empty'), HTTP_REFERER);
		if(!$data['thumb']) showmessage(L('thumb_no_empty'), HTTP_REFERER);
		if(is_array($data['catids']) && !empty($data['catids'])) {
			$data['catids'] = ','.implode(',', $data['catids']).',';
		}
		if($a=='add') {
			if(!$data['index_template']) $data['index_template'] = 'index';
			$data['siteid'] = $this->get_siteid();
			$data['createtime'] = SYS_TIME;
			$data['username'] = param::get_cookie('admin_username');
			$data['userid'] = $_SESSION['userid'];
		}
		if ($data['voteid']) {
			if (strpos($data['voteid'], '|')===false) {
				$vote_db = pc_base::load_model('vote_subject_model');
				$r = $vote_db->get_one(array('subject'=>$data['voteid'], 'siteid'=>$this->get_siteid()), 'subjectid, subject', 'addtime DESC');
				if ($r) {
					$data['voteid'] = 'vote|'.$r['subjectid'].'|'.$r['subject'];
				}
			}
		}
		return $data;
	}
}
?>