<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class node extends admin {

	private $db,$siteid;
	
	//HTML标签
	private static $html_tag = array("<p([^>]*)>(.*)</p>[|]"=>'<p>', "<a([^>]*)>(.*)</a>[|]"=>'<a>',"<script([^>]*)>(.*)</script>[|]"=>'<script>', "<iframe([^>]*)>(.*)</iframe>[|]"=>'<iframe>', "<table([^>]*)>(.*)</table>[|]"=>'<table>', "<span([^>]*)>(.*)</span>[|]"=>'<span>', "<b([^>]*)>(.*)</b>[|]"=>'<b>', "<img([^>]*)>[|]"=>'<img>', "<object([^>]*)>(.*)</object>[|]"=>'<object>', "<embed([^>]*)>(.*)</embed>[|]"=>'<embed>', "<param([^>]*)>(.*)</param>[|]"=>'<param>', '<div([^>]*)>[|]'=>'<div>', '</div>[|]'=>'</div>', '<!--([^>]*)-->[|]'=>'<!-- -->');
	
	//网址类型
	private $url_list_type = array();
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('collection_node_model');
		$this->siteid = get_siteid();
		$this->url_list_type = array('1'=>L('sequence'), '2'=>L('multiple_pages'), '3'=>L('single_page'), '4'=>'RSS');
		
	}

	/**
	 * node list
	 */
	public function manage() {
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$nodelist = $this->db->listinfo(array('siteid'=>$this->get_siteid()), 'nodeid DESC', $page, 15);
		$pages = $this->db->pages;
		pc_base::load_sys_class('format', '', 0);
		include $this->admin_tpl('node_list');
	}
		
	/**
	 * add node
	 */
	public function add() {
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			$data = isset($_POST['data']) ? $_POST['data'] :  showmessage(L('illegal_parameters'), HTTP_REFERER);
			$customize_config = isset($_POST['customize_config']) ? $_POST['customize_config'] :  '';
			if (!$data['name'] = trim($data['name'])) {
				showmessage(L('nodename').L('empty'), HTTP_REFERER);
			}
			if ($this->db->get_one(array('name'=>$data['name']))) {
				showmessage(L('nodename').L('exists'), HTTP_REFERER);
			}
			$data['urlpage'] = isset($_POST['urlpage'.$data['sourcetype']]) ? $_POST['urlpage'.$data['sourcetype']] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$data['siteid']= $this->get_siteid();
			$data['customize_config'] = array();
			if (is_array($customize_config)) foreach ($customize_config['en_name'] as $k => $v) {
				if (empty($v) || empty($customize_config['name'][$k])) continue;
				$data['customize_config'][] = array('name'=>$customize_config['name'][$k], 'en_name'=>$v, 'rule'=>$customize_config['rule'][$k], 'html_rule'=>$customize_config['html_rule'][$k]);
			}
			$data['customize_config'] = array2string($data['customize_config']);
			if ($this->db->insert($data)) {
				showmessage(L('operation_success'), '?m=collection&c=node&a=manage');
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		} else {
			$show_dialog = $show_validator = true;
			include $this->admin_tpl('node_form');
		}
		
	}

	//修改采集配置
	public function edit() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$data = $this->db->get_one(array('nodeid'=>$nodeid));
		if(isset($_POST['dosubmit'])) {
			$datas = $data;
			unset($data);
			$data = isset($_POST['data']) ? $_POST['data'] :  showmessage(L('illegal_parameters'), HTTP_REFERER);
			$customize_config = isset($_POST['customize_config']) ? $_POST['customize_config'] :  '';
			if (!$data['name'] = trim($data['name'])) {
				showmessage(L('nodename').L('empty'), HTTP_REFERER);
			}
			
			if ($datas['name'] != $data['name']) {
				if ($this->db->get_one(array('name'=>$data['name']))) {
					showmessage(L('nodename').L('exists'), HTTP_REFERER);
				}
			}
			
			$data['urlpage'] = isset($_POST['urlpage'.$data['sourcetype']]) ? $_POST['urlpage'.$data['sourcetype']] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$data['customize_config'] = array();
			if (is_array($customize_config)) foreach ($customize_config['en_name'] as $k => $v) {
				if (empty($v) || empty($customize_config['name'][$k])) continue;
				$data['customize_config'][] = array('name'=>$customize_config['name'][$k], 'en_name'=>$v, 'rule'=>$customize_config['rule'][$k], 'html_rule'=>$customize_config['html_rule'][$k]);
			}
			$data['customize_config'] = array2string($data['customize_config']);
			if ($this->db->update($data, array('nodeid'=>$nodeid))) {
				showmessage(L('operation_success'), '?m=collection&c=node&a=manage');
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		} else {
			$model_cache = getcache('model', 'commons');
			$siteid = get_siteid();
			foreach($model_cache as $k=>$v) {
				$modellist[0] = L('select_model');
				if($v['siteid'] == $siteid) {
					$modellist[$k] = $v['name'];
				}
			}
			if (isset($data['customize_config'])) {
				$data['customize_config'] = string2array($data['customize_config']);
			}
			$show_dialog = $show_validator = true;
			//print_r($nodeinfo);exit;	
			include $this->admin_tpl('node_form');
		}
	}
	
	//复制采集
	public function copy() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		if ($data = $this->db->get_one(array('nodeid'=>$nodeid))) {
			if (isset($_POST['dosubmit'])) {
				unset($data['nodeid']);
				$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
				if ($this->db->get_one(array('name'=>$name), 'nodeid')) {
					showmessage(L('nodename').L('exists'), HTTP_REFERER);
				}
				$data['name'] = $name;
				$data = new_addslashes($data);
				if ($this->db->insert($data)) {
					showmessage(L('operation_success'), '', '', 'test');
				} else {
					showmessage(L('operation_failure'));
				}
			} else {
				$show_validator = $show_header = true;
				include $this->admin_tpl('node_copy');
			}
		} else {
			showmessage(L('notfound'));
		}
	}
	
	//导入采集点
	public function node_import() {
		if (isset($_POST['dosubmit'])) {
			$filename = $_FILES['file']['tmp_name'];
			if (strtolower(substr($_FILES['file']['name'], -3, 3)) != 'txt') {
				showmessage(L('only_allowed_to_upload_txt_files'), HTTP_REFERER);
			}
			$data = json_decode(base64_decode(file_get_contents($filename)), true);
			if (pc_base::load_config('system', 'charset') == 'gbk') {
				$data = array_iconv($data, 'utf-8', 'gbk');
			}
			@unlink($filename);
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
			if ($this->db->get_one(array('name'=>$name), 'nodeid')) {
				showmessage(L('nodename').L('exists'), HTTP_REFERER);
			}
			$data['name'] = $name;
			$data['siteid'] = $this->get_siteid();
			$data = new_addslashes($data);
			if ($this->db->insert($data)) {
				showmessage(L('operation_success'), '', '', 'test');
			} else {
				showmessage(L('operation_failure'));
			}
		} else {
			$show_header = $show_validator = true;
			include $this->admin_tpl('node_import');
		}
	}
	
	//导出采集配置
	public function export() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		if ($data = $this->db->get_one(array('nodeid'=>$nodeid))) {
			unset($data['nodeid'], $data['name'], $data['siteid']);
			if (pc_base::load_config('system', 'charset') == 'gbk') {
				$data = array_iconv($data);
			}
			header("Content-type: application/octet-stream");
		    header("Content-Disposition: attachment; filename=pc_collection_".$nodeid.'.txt');
		    echo base64_encode(json_encode($data));
		} else {
			showmessage(L('notfound'));
		}
	}
	
	//URL配置显示结果
	public function public_url() {
		$sourcetype = isset($_GET['sourcetype']) && intval($_GET['sourcetype']) ? intval($_GET['sourcetype']) : showmessage(L('illegal_parameters'));
		$pagesize_start = isset($_GET['pagesize_start']) && intval($_GET['pagesize_start']) ? intval($_GET['pagesize_start']) : 1;
		$pagesize_end = isset($_GET['pagesize_end']) && intval($_GET['pagesize_end']) ? intval($_GET['pagesize_end']) : 10;
		$par_num = isset($_GET['par_num']) && intval($_GET['par_num']) ? intval($_GET['par_num']) : 1;
		$urlpage = isset($_GET['urlpage']) && trim($_GET['urlpage']) ? trim($_GET['urlpage']) : showmessage(L('illegal_parameters'));
		$show_header = true;
		include $this->admin_tpl('node_public_url');
	}
	
	//删除采集节点
	public function del() {
		if (isset($_POST['dosubmit'])) {
			$nodeid = isset($_POST['nodeid']) ? $_POST['nodeid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			foreach ($nodeid as $k=>$v) {
				if(intval($v)) {
					$nodeid[$k] = intval($v);
				} else {
					unset($nodeid[$k]);
				}
			}
			$nodeid = implode('\',\'', $nodeid);
			$this->db->delete("nodeid in ('$nodeid')");
			$content_db = pc_base::load_model('collection_content_model');
			$content_db->delete("nodeid in ('$nodeid')");
			showmessage(L('operation_success'), '?m=collection&c=node&a=manage');
		} else {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
	}
	
	//测试文章URL采集
	public function public_test() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		pc_base::load_app_class('collection', '', 0);
		if ($data = $this->db->get_one(array('nodeid'=>$nodeid))) {
			$urls = collection::url_list($data, 1);
			if (!empty($urls)) foreach ($urls as $v) {
				$url = collection::get_url_lists($v, $data);
			}
			$show_header = $show_dialog = true;
			include $this->admin_tpl('public_test');
		} else {
			showmessage(L('notfound'));
		}
	}
	
	//测试文章内容采集
	public function public_test_content() {
		$url = isset($_GET['url']) ? urldecode($_GET['url']) : exit('0');
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		pc_base::load_app_class('collection', '', 0);
		if ($data = $this->db->get_one(array('nodeid'=>$nodeid))) {
			$contents = collection::get_content($url, $data);
			foreach ($contents as $_key=>$_content) {
				if(trim($_content)=='') $contents[$_key] = '◆◆◆◆◆◆◆◆◆◆'.$_key.' empty◆◆◆◆◆◆◆◆◆◆';
			}
			print_r($contents);
		} else {
			showmessage(L('notfound'));
		}
	}
	
	//采集节点名验证
	public function public_name() {
		$name = isset($_GET['name']) && trim($_GET['name']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['name'])) : trim($_GET['name'])) : exit('0');
		$nodeid = isset($_GET['nodeid']) && intval($_GET['nodeid']) ? intval($_GET['nodeid']) : '';
 		$data = array();
		if ($nodeid) {
			$data = $this->db->get_one(array('nodeid'=>$nodeid), 'name');
			if (!empty($data) && $data['name'] == $name) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$name), 'nodeid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	//采集网址
	public function col_url_list() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		if ($data = $this->db->get_one(array('nodeid'=>$nodeid))) {
			pc_base::load_app_class('collection', '', 0);
			$urls = collection::url_list($data);
			$total_page = count($urls);
			if ($total_page > 0) {
				$page = isset($_GET['page']) ? intval($_GET['page']) : 0;
				$url_list = $urls[$page];
				$url = collection::get_url_lists($url_list, $data);
				$history_db = pc_base::load_model('collection_history_model');
				$content_db = pc_base::load_model('collection_content_model');
				$total = count($url);
				$re = 0;
				if (is_array($url) && !empty($url)) foreach ($url as $v) {
					if (empty($v['url']) || empty($v['title'])) continue;
					$v = new_addslashes($v);
					$v['title'] = strip_tags($v['title']);
					$md5 = md5($v['url']);
					if (!$history_db->get_one(array('md5'=>$md5, 'siteid'=>$this->get_siteid()))) {
						$history_db->insert(array('md5'=>$md5, 'siteid'=>$this->get_siteid()));
						$content_db->insert(array('nodeid'=>$nodeid, 'status'=>0, 'url'=>$v['url'], 'title'=>$v['title'], 'siteid'=>$this->get_siteid()));
					} else {
						$re++;
					}
				}
				$show_header = $show_dialog = true;
				if ($total_page <= $page) {
					$this->db->update(array('lastdate'=>SYS_TIME), array('nodeid'=>$nodeid));
				}
				include $this->admin_tpl('col_url_list');
			} else {
				showmessage(L('not_to_collect'));
			}
		} else {
			showmessage(L('notfound'));
		}
	}
	
	//采集文章
	public function col_content() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		if ($data = $this->db->get_one(array('nodeid'=>$nodeid))) {
			$content_db = pc_base::load_model('collection_content_model');
			//更新附件状态
			$attach_status = false;
			if(pc_base::load_config('system','attachment_stat')) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$attach_status = true;
			}
			pc_base::load_app_class('collection', '', 0);
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$total = isset($_GET['total']) ? intval($_GET['total']) : 0;
			if (empty($total)) $total = $content_db->count(array('nodeid'=>$nodeid, 'siteid'=>$this->get_siteid(), 'status'=>0));
			$total_page = ceil($total/2);
			$list = $content_db->select(array('nodeid'=>$nodeid, 'siteid'=>$this->get_siteid(), 'status'=>0), 'id,url', '2', 'id desc');
			$i = 0;
			if (!empty($list) && is_array($list)) {
				foreach ($list as $v) {
					$GLOBALS['downloadfiles'] = array();
					$html = collection::get_content($v['url'], $data);
					//更新附件状态
					if($attach_status) {
						$this->attachment_db->api_update($GLOBALS['downloadfiles'],'cj-'.$v['id'],1);
					}
					$content_db->update(array('status'=>1, 'data'=>array2string($html)), array('id'=>$v['id']));
					$i++;
				}
			} else {
				showmessage(L('url_collect_msg'), '?m=collection&c=node&a=manage');
			}
			
			if ($total_page > $page) {
				showmessage(L('collectioning').($i+($page-1)*2).'/'.$total.'<script type="text/javascript">location.href="?m=collection&c=node&a=col_content&page='.($page+1).'&nodeid='.$nodeid.'&total='.$total.'&pc_hash='.$_SESSION['pc_hash'].'"</script>', '?m=collection&c=node&a=col_content&page='.($page+1).'&nodeid='.$nodeid.'&total='.$total);
			} else {
				$this->db->update(array('lastdate'=>SYS_TIME), array('nodeid'=>$nodeid));
				showmessage(L('collection_success'), '?m=collection&c=node&a=manage');
			}
		}
	}
	
	//文章列表
	public function publist() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$node = $this->db->get_one(array('nodeid'=>$nodeid), 'name');
		$content_db = pc_base::load_model('collection_content_model');
		$status = isset($_GET['status']) ? intval($_GET['status']) : '';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$sql = array('nodeid'=>$nodeid, 'siteid'=>$this->get_siteid());
		if ($status) {
			$sql['status'] = $status - 1;
		}
		$data = $content_db->listinfo($sql, 'id desc', $page);
		$pages = $content_db->pages;
		$show_header = true;
		include $this->admin_tpl('publist');
	}
	
	//导入文章
	public function import() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$type = isset($_GET['type']) ? trim($_GET['type']) : '';
		if ($type == 'all') {
			
		} else {
			$ids = implode(',', $id);
		}
		$program_db = pc_base::load_model('collection_program_model');
		$program_list = $program_db->select(array('nodeid'=>$nodeid, 'siteid'=>$this->get_siteid()), 'id, catid');
		$cat = getcache('category_content_'.$this->siteid, 'commons');
		include $this->admin_tpl('import_program');
	}
	
	//删除文章
	public function content_del() {
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$history = isset($_GET['history']) ? $_GET['history'] : '';
		if (is_array($id)) {
			$collection_content_db = pc_base::load_model('collection_content_model');
			$history_db = pc_base::load_model('collection_history_model');
			$del_array = $id;
			$ids = implode('\',\'', $id);
			if ($history) {
				$data = $collection_content_db->select("id in ('$ids')", 'url');
				foreach ($data as $v) {
					$list[] = md5($v['url']);
				}
				$md5 = implode('\',\'', $list);
				$history_db->delete("md5 in ('$md5')");
			}
			$collection_content_db->delete("id in ('$ids')");
			//同时删除关联附件
			if(!empty($del_array)) {
				$attachment = pc_base::load_model('attachment_model');
				foreach ($del_array as $id) {
					$attachment->api_delete('cj-'.$id);
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
	
	//添加导入方案
	public function import_program_add() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$ids = isset($_GET['ids']) ? $_GET['ids'] : '';
		$catid = isset($_GET['catid']) && intval($_GET['catid']) ? intval($_GET['catid']) : showmessage(L('please_select_cat'), HTTP_REFERER);
		$type = isset($_GET['type']) ? trim($_GET['type']) : '';
		
		include dirname(__FILE__).DIRECTORY_SEPARATOR.'spider_funs'.DIRECTORY_SEPARATOR.'config.php';
		
		//读取栏目缓存
		$catlist = getcache('category_content_'.$this->siteid, 'commons');
		$cat = $catlist[$catid];
		$cat['setting'] = string2array($cat['setting']);
		if ($cat['siteid'] != $this->get_siteid() || $cat['type'] != 0) showmessage(L('illegal_section_parameter'), HTTP_REFERER);
		
		if (isset($_POST['dosubmit'])) {
			$config = array();
			$model_field = isset($_POST['model_field']) ? $_POST['model_field'] :  showmessage(L('illegal_parameters'), HTTP_REFERER);
			$node_field = isset($_POST['node_field']) ? $_POST['node_field'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$funcs = isset($_POST['funcs']) ? $_POST['funcs'] : array();
			
			$config['add_introduce'] = isset($_POST['add_introduce']) && intval($_POST['add_introduce']) ? intval($_POST['add_introduce']) : 0;
			$config['auto_thumb'] = isset($_POST['auto_thumb']) && intval($_POST['auto_thumb']) ? intval($_POST['auto_thumb']) : 0;
			$config['introcude_length'] = isset($_POST['introcude_length']) && intval($_POST['introcude_length']) ? intval($_POST['introcude_length']) : 0;
			$config['auto_thumb_no'] = isset($_POST['auto_thumb_no']) && intval($_POST['auto_thumb_no']) ? intval($_POST['auto_thumb_no']) : 0;
			$config['content_status'] = isset($_POST['content_status']) && intval($_POST['content_status']) ? intval($_POST['content_status']) : 1;
			
			foreach ($node_field as $k => $v) {
				if (empty($v)) continue;
				$config['map'][$model_field[$k]] = $v;
			}
			
			foreach ($funcs as $k=>$v) {
				if (empty($v)) continue;
				$config['funcs'][$model_field[$k]] = $v;
			} 
			
			$data = array('config'=>array2string($config), 'siteid'=>$this->get_siteid(), 'nodeid'=>$nodeid, 'modelid'=>$cat['modelid'], 'catid'=>$catid);
			$program_db = pc_base::load_model('collection_program_model');
			if ($id = $program_db->insert($data, true)) {
				showmessage(L('program_add_operation_success'), '?m=collection&c=node&a=import_content&programid='.$id.'&nodeid='.$nodeid.'&ids='.$ids.'&type='.$type);
			} else {
				showmessage(L('illegal_parameters'));
			}
		}
		
		
		//读取数据模型缓存
		$model = getcache('model_field_'.$cat['modelid'], 'model');
		if (empty($model)) showmessage(L('model_does_not_exist_please_update_the_cache_model'));
		$node_data = $this->db->get_one(array('nodeid'=>$nodeid), "customize_config");
		$node_data['customize_config'] = string2array($node_data['customize_config']);
		$node_field = array(''=>L('please_choose'),'title'=>L('title'), 'author'=>L('author'), 'comeform'=>L('comeform'), 'time'=>L('time'), 'content'=>L('content'));
		if (is_array($node_data['customize_config'])) foreach ($node_data['customize_config'] as $k=>$v) {
			if (empty($v['en_name']) || empty($v['name'])) continue;
			$node_field[$v['en_name']] = $v['name'];
		}
		$show_header = true;
		include $this->admin_tpl('import_program_add');
	}
	
	public function import_program_del() {
		$id = isset($_GET['id']) ? intval($_GET['id']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$program_db = pc_base::load_model('collection_program_model');
		if ($program_db->delete(array('id'=>$id))) {
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('illegal_parameters'));
		}
	}
	
	//导入文章到模型
	public function import_content() {
		$nodeid = isset($_GET['nodeid']) ? intval($_GET['nodeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$programid = isset($_GET['programid']) ? intval($_GET['programid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$ids = isset($_GET['ids']) ? $_GET['ids'] : '';
		$type = isset($_GET['type']) ? trim($_GET['type']) : '';
		if (!$node = $this->db->get_one(array('nodeid'=>$nodeid), 'coll_order,content_page')) {
			showmessage(L('node_not_found'), '?m=collection&c=node&a=manage');
		}
		$program_db = pc_base::load_model('collection_program_model');
		$collection_content_db = pc_base::load_model('collection_content_model');
		$content_db = pc_base::load_model('content_model');
		//更新附件状态
		$attach_status = false;
		if(pc_base::load_config('system','attachment_stat')) {
			$attachment_db = pc_base::load_model('attachment_model');
			$att_index_db = pc_base::load_model('attachment_index_model');
			$attach_status = true;
		}
		$order = $node['coll_order'] == 1 ? 'id desc' : '';
		$str = L('operation_success');
		$url = '?m=collection&c=node&a=publist&nodeid='.$nodeid.'&status=2&pc_hash='.$_SESSION['pc_hash'];
		if ($type == 'all') {
			$total = isset($_GET['total']) && intval($_GET['total']) ? intval($_GET['total']) : '';
			if (empty($total)) $total = $collection_content_db->count(array('siteid'=>$this->get_siteid(), 'nodeid'=>$nodeid, 'status'=>1));
			$total_page = ceil($total/20);
			$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
			$total_page = ceil($total/20);
			$data = $collection_content_db->select(array('siteid'=>$this->get_siteid(), 'nodeid'=>$nodeid, 'status'=>1), 'id, data', '20', $order);
			
		} else {
			$ids = explode(',', $ids);
			$ids = implode('\',\'', $ids);
			$data = $collection_content_db->select("siteid='".$this->get_siteid()."' AND id in ('$ids') AND nodeid = '$nodeid' AND status = '1'", 'id, data', '', $order);
			$total = count($data);
			$str = L('operation_success').$total.L('article_was_imported');
		}
		$program = $program_db->get_one(array('id'=>$programid));
		$program['config'] = string2array($program['config']);
		$_POST['add_introduce'] = $program['config']['add_introduce'];
		$_POST['introcude_length'] = $program['config']['introcude_length'];
		$_POST['auto_thumb'] = $program['config']['auto_thumb'];
		$_POST['auto_thumb_no'] = $program['config']['auto_thumb_no'];
		$_POST['spider_img'] = 0;
		$i = 0;
		$content_db->set_model($program['modelid']);
		$coll_contentid = array();
		
		//加载所有的处理函数
		$funcs_file_list = glob(dirname(__FILE__).DIRECTORY_SEPARATOR.'spider_funs'.DIRECTORY_SEPARATOR.'*.php');
		foreach ($funcs_file_list as $v) {
			include $v;
		}
		foreach ($data as $k=>$v) {
			$sql = array('catid'=>$program['catid'], 'status'=>$program['config']['content_status']);
			$v['data'] = string2array($v['data']);
			
			foreach ($program['config']['map'] as $a=>$b) {
				if (isset($program['config']['funcs'][$a]) && function_exists($program['config']['funcs'][$a])) {
					$GLOBALS['field'] = $a;
					$sql[$a] = $program['config']['funcs'][$a]($v['data'][$b]);
				} else {
					$sql[$a] = $v['data'][$b];
				}
			}
			if ($node['content_page'] == 1) $sql['paginationtype'] = 2;
			$contentid = $content_db->add_content($sql, 1);
			if ($contentid) {
				$coll_contentid[] = $v['id'];
				$i++;
				//更新附件状态,将采集关联重置到内容关联
				if($attach_status) {
					$datas = $att_index_db->select(array('keyid'=>'cj-'.$v['id']),'*',100,'','','aid');
					if(!empty($datas)) {
						$datas = array_keys($datas);
						$datas = implode(',',$datas);
						$att_index_db->update(array('keyid'=>'c-'.$program['catid'].'-'.$contentid),array('keyid'=>'cj-'.$v['id']));
						$attachment_db->update(array('module'=>'content')," aid IN ($datas)");
					}
				}
			} else {
				$collection_content_db->delete(array('id'=>$v['id']));
			}
		}
		$sql_id = implode('\',\'', $coll_contentid);
		$collection_content_db->update(array('status'=>2), " id IN ('$sql_id')");
		if ($type == 'all' && $total_page > $page) {
			$str = L('are_imported_the_import_process').(($page-1)*20+$i).'/'.$total.'<script type="text/javascript">location.href="?m=collection&c=node&a=import_content&nodeid='.$nodeid.'&programid='.$programid.'&type=all&page='.($page+1).'&total='.$total.'&pc_hash='.$_SESSION['pc_hash'].'"</script>';
			$url = '';
		}
		showmessage($str, $url);
	}
}
?>