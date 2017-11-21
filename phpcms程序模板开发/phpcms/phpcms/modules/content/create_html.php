<?php
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);

class create_html extends admin {
	private $db;
	public $siteid,$categorys;
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('content_model');
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		foreach($_GET as $k=>$v) {
			$_POST[$k] = $v;
		}
	}
	
	public function update_urls() {
		if(isset($_POST['dosubmit'])) {
			extract($_POST,EXTR_SKIP);
			$this->url = pc_base::load_app_class('url');

			$modelid = intval($_POST['modelid']);
			if($modelid) {
				//设置模型数据表名
				$this->db->set_model($modelid);
				$table_name = $this->db->table_name;

				if($type == 'lastinput') {
					$offset = 0;
				} else {
					$page = max(intval($page), 1);
					$offset = $pagesize*($page-1);
				}
				$where = ' WHERE status=99 ';
				$order = 'ASC';
				
				if(!isset($first) && is_array($catids) && $catids[0] > 0)  {
					setcache('url_show_'.$_SESSION['userid'], $catids,'content');
					$catids = implode(',',$catids);
					$where .= " AND catid IN($catids) ";
					$first = 1;
				} elseif($first) {
					$catids = getcache('url_show_'.$_SESSION['userid'],'content');
					$catids = implode(',',$catids);
					$where .= " AND catid IN($catids) ";
				} else {
					$first = 0;
				}

				if($type == 'lastinput' && $number) {
					$offset = 0;
					$pagesize = $number;
					$order = 'DESC';
				} elseif($type == 'date') {
					if($fromdate) {
						$fromtime = strtotime($fromdate.' 00:00:00');
						$where .= " AND `inputtime`>=$fromtime ";
					}
					if($todate) {
						$totime = strtotime($todate.' 23:59:59');
						$where .= " AND `inputtime`<=$totime ";
					}
				} elseif($type == 'id') {
					$fromid = intval($fromid);
					$toid = intval($toid);
					if($fromid) $where .= " AND `id`>=$fromid ";
					if($toid) $where .= " AND `id`<=$toid ";
				}
				
				if(!isset($total) && $type != 'lastinput') {
					$rs = $this->db->query("SELECT COUNT(*) AS `count` FROM `$table_name` $where");
					$result = $this->db->fetch_array($rs);
					
					$total = $result[0]['count']; 
					$pages = ceil($total/$pagesize);
					$start = 1;
				}
				
				$rs = $this->db->query("SELECT * FROM `$table_name` $where ORDER BY `id` $order LIMIT $offset,$pagesize");
				$data = $this->db->fetch_array($rs);
				foreach($data as $r) {
					if($r['islink'] || $r['upgrade']) continue;
					//更新URL链接
					$this->urls($r['id'], $r['catid'], $r['inputtime'], $r['prefix']);

				}

				if($pages > $page) {
					$page++;
					$http_url = get_url();
					$creatednum = $offset + count($data);
					$percent = round($creatednum/$total, 2)*100;

					$message = L('need_update_items',array('total'=>$total,'creatednum'=>$creatednum,'percent'=>$percent));
					$forward = $start ? "?m=content&c=create_html&a=update_urls&type=$type&dosubmit=1&first=$first&fromid=$fromid&toid=$toid&fromdate=$fromdate&todate=$todate&pagesize=$pagesize&page=$page&pages=$pages&total=$total&modelid=$modelid" : preg_replace("/&page=([0-9]+)&pages=([0-9]+)&total=([0-9]+)/", "&page=$page&pages=$pages&total=$total", $http_url);
				} else {
					delcache('url_show_'.$_SESSION['userid'],'content');
					$message = L('create_update_success');
					$forward = '?m=content&c=create_html&a=update_urls';
				}
				showmessage($message,$forward,200);
			} else {
				//当没有选择模型时，需要按照栏目来更新
				if(!isset($set_catid)) {
					if($catids[0] != 0) {
						$update_url_catids = $catids;
					} else {
						foreach($this->categorys as $catid=>$cat) {
							if($cat['child'] || $cat['siteid'] != $this->siteid || $cat['type']!=0) continue;
							$update_url_catids[] = $catid;
						}
					}
					setcache('update_url_catid'.'-'.$this->siteid.'-'.$_SESSION['userid'],$update_url_catids,'content');
					$message = L('start_update_urls');
					$forward = "?m=content&c=create_html&a=update_urls&set_catid=1&pagesize=$pagesize&dosubmit=1";
					showmessage($message,$forward,200);
				}
				$catid_arr = getcache('update_url_catid'.'-'.$this->siteid.'-'.$_SESSION['userid'],'content');
				$autoid = $autoid ? intval($autoid) : 0;
				if(!isset($catid_arr[$autoid])) showmessage(L('create_update_success'),'?m=content&c=create_html&a=update_urls',200);
				$catid = $catid_arr[$autoid];

				$modelid = $this->categorys[$catid]['modelid'];
				//设置模型数据表名
				$this->db->set_model($modelid);
				$table_name = $this->db->table_name;

				$page = max(intval($page), 1);
				$offset = $pagesize*($page-1);
				$where = " WHERE status=99 AND catid='$catid'";
				$order = 'ASC';
				
				if(!isset($total)) {
					$rs = $this->db->query("SELECT COUNT(*) AS `count` FROM `$table_name` $where");
					$result = $this->db->fetch_array($rs);
					$total = $result[0]['count']; 
					$pages = ceil($total/$pagesize);
					$start = 1;
				}
				$rs = $this->db->query("SELECT * FROM `$table_name` $where ORDER BY `id` $order LIMIT $offset,$pagesize");
				$data = $this->db->fetch_array($rs);
				foreach($data as $r) {
					if($r['islink'] || $r['upgrade']) continue;
					//更新URL链接
					$this->urls($r['id'], $r['catid'], $r['inputtime'], $r['prefix']);
				}
				if($pages > $page) {
					$page++;
					$http_url = get_url();
					$creatednum = $offset + count($data);
					$percent = round($creatednum/$total, 2)*100;
					$message = '【'.$this->categorys[$catid]['catname'].'】 '.L('have_update_items',array('total'=>$total,'creatednum'=>$creatednum,'percent'=>$percent));
					$forward = $start ? "?m=content&c=create_html&a=update_urls&type=$type&dosubmit=1&first=$first&fromid=$fromid&toid=$toid&fromdate=$fromdate&todate=$todate&pagesize=$pagesize&page=$page&pages=$pages&total=$total&autoid=$autoid&set_catid=1" : preg_replace("/&page=([0-9]+)&pages=([0-9]+)&total=([0-9]+)/", "&page=$page&pages=$pages&total=$total", $http_url);
				} else {
					$autoid++;
					$message = L('updating').$this->categorys[$catid]['catname']." ...";
					$forward = "?m=content&c=create_html&a=update_urls&set_catid=1&pagesize=$pagesize&dosubmit=1&autoid=$autoid";
				}
				showmessage($message,$forward,200);
			}

		} else {
			$show_header = $show_dialog  = '';
			$admin_username = param::get_cookie('admin_username');
			$modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
			
			$tree = pc_base::load_sys_class('tree');
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$categorys = array();
			if(!empty($this->categorys)) {
				foreach($this->categorys as $catid=>$r) {
					if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
					if($modelid && $modelid != $r['modelid']) continue;
					$r['disabled'] = $r['child'] ? 'disabled' : '';
					$categorys[$catid] = $r;
				}
			}
			$str  = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";

			$tree->init($categorys);
			$string .= $tree->get_tree(0, $str);
			include $this->admin_tpl('update_urls');
		}
	}

	private function urls($id, $catid= 0, $inputtime = 0, $prefix = ''){
		$urls = $this->url->show($id, 0, $catid, $inputtime, $prefix,'','edit');
		//更新到数据库
		$url = $urls[0];
		$this->db->update(array('url'=>$url),array('id'=>$id));
		//echo $id; echo "|";
		return $urls;
	}
	/**
	* 生成内容页
	*/
	public function show() {
		if(isset($_POST['dosubmit'])) {
			extract($_POST,EXTR_SKIP);
			$this->html = pc_base::load_app_class('html');

			$modelid = intval($_POST['modelid']);
			if($modelid) {
				//设置模型数据表名
				$this->db->set_model($modelid);
				$table_name = $this->db->table_name;

				if($type == 'lastinput') {
					$offset = 0;
				} else {
					$page = max(intval($page), 1);
					$offset = $pagesize*($page-1);
				}
				$where = ' WHERE status=99 ';
				$order = 'ASC';
				
				if(!isset($first) && is_array($catids) && $catids[0] > 0)  {
					setcache('html_show_'.$_SESSION['userid'], $catids,'content');
					$catids = implode(',',$catids);
					$where .= " AND catid IN($catids) ";
					$first = 1;
				} elseif(count($catids)==1 && $catids[0] == 0) {
					$catids = array();
					foreach($this->categorys as $catid=>$cat) {
						if($cat['child'] || $cat['siteid'] != $this->siteid || $cat['type']!=0) continue;
							$setting = string2array($cat['setting']);
							if(!$setting['content_ishtml']) continue;
						$catids[] = $catid;
					}
					setcache('html_show_'.$_SESSION['userid'], $catids,'content');
					$catids = implode(',',$catids);
					$where .= " AND catid IN($catids) ";
					$first = 1;
				} elseif($first) {
					$catids = getcache('html_show_'.$_SESSION['userid'],'content');
					$catids = implode(',',$catids);
					$where .= " AND catid IN($catids) ";
				} else {
					$first = 0;
				}
				if(count($catids)==1 && $catids[0]==0) {
					$message = L('create_update_success');
					$forward = '?m=content&c=create_html&a=show';
					showmessage($message,$forward);
				}
				if($type == 'lastinput' && $number) {
					$offset = 0;
					$pagesize = $number;
					$order = 'DESC';
				} elseif($type == 'date') {
					if($fromdate) {
						$fromtime = strtotime($fromdate.' 00:00:00');
						$where .= " AND `inputtime`>=$fromtime ";
					}
					if($todate) {
						$totime = strtotime($todate.' 23:59:59');
						$where .= " AND `inputtime`<=$totime ";
					}
				} elseif($type == 'id') {
					$fromid = intval($fromid);
					$toid = intval($toid);
					if($fromid) $where .= " AND `id`>=$fromid ";
					if($toid) $where .= " AND `id`<=$toid ";
				}
				if(!isset($total) && $type != 'lastinput') {
					$rs = $this->db->query("SELECT COUNT(*) AS `count` FROM `$table_name` $where");
					$result = $this->db->fetch_array($rs);
					
					$total = $result[0]['count']; 
					$pages = ceil($total/$pagesize);
					$start = 1;
				}
				$rs = $this->db->query("SELECT * FROM `$table_name` $where ORDER BY `id` $order LIMIT $offset,$pagesize");
				$data = $this->db->fetch_array($rs);
				$tablename = $this->db->table_name.'_data';
				$this->url = pc_base::load_app_class('url');
				foreach($data as $r) {
					if($r['islink']) continue;
					$this->db->table_name = $tablename;
					$r2 = $this->db->get_one(array('id'=>$r['id']));
					if($r) $r = array_merge($r,$r2);
					if($r['upgrade']) {
						$urls[1] = $r['url'];
					} else {
						$urls = $this->url->show($r['id'], '', $r['catid'],$r['inputtime']);
					}
					$this->html->show($urls[1],$r,0,'edit',$r['upgrade']);
				}

				if($pages > $page) {
					$page++;
					$http_url = get_url();
					$creatednum = $offset + count($data);
					$percent = round($creatednum/$total, 2)*100;

					$message = L('need_update_items',array('total'=>$total,'creatednum'=>$creatednum,'percent'=>$percent));
					$forward = $start ? "?m=content&c=create_html&a=show&type=$type&dosubmit=1&first=$first&fromid=$fromid&toid=$toid&fromdate=$fromdate&todate=$todate&pagesize=$pagesize&page=$page&pages=$pages&total=$total&modelid=$modelid" : preg_replace("/&page=([0-9]+)&pages=([0-9]+)&total=([0-9]+)/", "&page=$page&pages=$pages&total=$total", $http_url);
				} else {
					delcache('html_show_'.$_SESSION['userid'],'content');
					$message = L('create_update_success');
					$forward = '?m=content&c=create_html&a=show';
				}
				showmessage($message,$forward,200);
			} else {
				//当没有选择模型时，需要按照栏目来更新
				if(!isset($set_catid)) {
					if($catids[0] != 0) {
						$update_url_catids = $catids;
					} else {
						foreach($this->categorys as $catid=>$cat) {
							if($cat['child'] || $cat['siteid'] != $this->siteid || $cat['type']!=0) continue;
								$setting = string2array($cat['setting']);
								if(!$setting['content_ishtml']) continue;
							$update_url_catids[] = $catid;
						}
					}
					setcache('update_html_catid'.'-'.$this->siteid.'-'.$_SESSION['userid'],$update_url_catids,'content');
					$message = L('start_update');
					$forward = "?m=content&c=create_html&a=show&set_catid=1&pagesize=$pagesize&dosubmit=1";
					showmessage($message,$forward,200);
				}
				if(count($catids)==1 && $catids[0]==0) {
					$message = L('create_update_success');
					$forward = '?m=content&c=create_html&a=show';
					showmessage($message,$forward,200);
				}
				$catid_arr = getcache('update_html_catid'.'-'.$this->siteid.'-'.$_SESSION['userid'],'content');
				$autoid = $autoid ? intval($autoid) : 0;
				if(!isset($catid_arr[$autoid])) showmessage(L('create_update_success'),'?m=content&c=create_html&a=show',200);
				$catid = $catid_arr[$autoid];
				
				$modelid = $this->categorys[$catid]['modelid'];
				//设置模型数据表名
				$this->db->set_model($modelid);
				$table_name = $this->db->table_name;

				$page = max(intval($page), 1);
				$offset = $pagesize*($page-1);
				$where = " WHERE status=99 AND catid='$catid'";
				$order = 'ASC';
				
				if(!isset($total)) {
					$rs = $this->db->query("SELECT COUNT(*) AS `count` FROM `$table_name` $where");
					$result = $this->db->fetch_array($rs);
					$total = $result[0]['count']; 
					$pages = ceil($total/$pagesize);
					$start = 1;
				}
				$rs = $this->db->query("SELECT * FROM `$table_name` $where ORDER BY `id` $order LIMIT $offset,$pagesize");
				$data = $this->db->fetch_array($rs);
				$tablename = $this->db->table_name.'_data';
				$this->url = pc_base::load_app_class('url');
				foreach($data as $r) {
					if($r['islink']) continue;
					//写入文件
					$this->db->table_name = $tablename;
					$r2 = $this->db->get_one(array('id'=>$r['id']));
					if($r2) $r = array_merge($r,$r2);
					if($r['upgrade']) {
						$urls[1] = $r['url'];
					} else {
						$urls = $this->url->show($r['id'], '', $r['catid'],$r['inputtime']);
					}
					$this->html->show($urls[1],$r,0,'edit',$r['upgrade']);
				}
				if($pages > $page) {
					$page++;
					$http_url = get_url();
					$creatednum = $offset + count($data);
					$percent = round($creatednum/$total, 2)*100;
					$message = '【'.$this->categorys[$catid]['catname'].'】 '.L('have_update_items',array('total'=>$total,'creatednum'=>$creatednum,'percent'=>$percent));
					$forward = $start ? "?m=content&c=create_html&a=show&type=$type&dosubmit=1&first=$first&fromid=$fromid&toid=$toid&fromdate=$fromdate&todate=$todate&pagesize=$pagesize&page=$page&pages=$pages&total=$total&autoid=$autoid&set_catid=1" : preg_replace("/&page=([0-9]+)&pages=([0-9]+)&total=([0-9]+)/", "&page=$page&pages=$pages&total=$total", $http_url);
				} else {
					$autoid++;
					$message = L('start_update').$this->categorys[$catid]['catname']." ...";
					$forward = "?m=content&c=create_html&a=show&set_catid=1&pagesize=$pagesize&dosubmit=1&autoid=$autoid";
				}
				showmessage($message,$forward,200);
			}

		} else {
			$show_header = $show_dialog  = '';
			$admin_username = param::get_cookie('admin_username');
			$modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
			
			$tree = pc_base::load_sys_class('tree');
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$categorys = array();
			if(!empty($this->categorys)) {
				foreach($this->categorys as $catid=>$r) {
					if($this->siteid != $r['siteid'] || ($r['type']!=0 && $r['child']==0)) continue;
					if($modelid && $modelid != $r['modelid']) continue;
					if($r['child']==0) {
						$setting = string2array($r['setting']);
						if(!$setting['content_ishtml']) continue;
					}
					$r['disabled'] = $r['child'] ? 'disabled' : '';
					$categorys[$catid] = $r;
				}
			}
			$str  = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";

			$tree->init($categorys);
			$string .= $tree->get_tree(0, $str);
			include $this->admin_tpl('create_html_show');
		}

	}
	/**
	* 生成栏目页
	*/
	public function category() {
		if(isset($_POST['dosubmit'])) {
			extract($_POST,EXTR_SKIP);
			$this->html = pc_base::load_app_class('html');
			$referer = isset($referer) ? urlencode($referer) : '';

			$modelid = intval($_POST['modelid']);
			if(!isset($set_catid)) {
				if($catids[0] != 0) {
					$update_url_catids = $catids;
				} else {
					foreach($this->categorys as $catid=>$cat) {
						if($cat['siteid'] != $this->siteid || $cat['type']==2 || !$cat['ishtml']) continue;
						if($modelid && ($modelid != $cat['modelid'])) continue;
						$update_url_catids[] = $catid;
					}
				}
				setcache('update_html_catid'.'-'.$this->siteid.'-'.$_SESSION['userid'],$update_url_catids,'content');
				$message = L('start_update_category');
				$forward = "?m=content&c=create_html&a=category&set_catid=1&pagesize=$pagesize&dosubmit=1&modelid=$modelid&referer=$referer";
				
				showmessage($message,$forward);
			}
			
			$catid_arr = getcache('update_html_catid'.'-'.$this->siteid.'-'.$_SESSION['userid'],'content');
			
			$autoid = $autoid ? intval($autoid) : 0;
			
			if(!isset($catid_arr[$autoid])) {
				if(!empty($referer) && $this->categorys[$catid_arr[0]]['type']!=1) {
					showmessage(L('create_update_success'),'?m=content&c=content&a=init&catid='.$catid_arr[0],200);
				} else {
					showmessage(L('create_update_success'),'?m=content&c=create_html&a=category',200);
				}
			}
			$catid = $catid_arr[$autoid];
			$page = $page ? $page : 1;
			$j = 1;
			do {
				$this->html->category($catid,$page);
				$page++;
				$j++;
				$total_number = isset($total_number) ? $total_number : PAGES;
			} while ($j <= $total_number && $j < $pagesize);
			if($page <= $total_number) {
				$endpage = intval($page+$pagesize);
				$message = L('updating').$this->categorys[$catid]['catname'].L('start_to_end_id',array('page'=>$page,'endpage'=>$endpage));
				$forward = "?m=content&c=create_html&a=category&set_catid=1&pagesize=$pagesize&dosubmit=1&autoid=$autoid&page=$page&total_number=$total_number&modelid=$modelid&referer=$referer";
			} else {
				$autoid++;
				$message = $this->categorys[$catid]['catname'].L('create_update_success');
				$forward = "?m=content&c=create_html&a=category&set_catid=1&pagesize=$pagesize&dosubmit=1&autoid=$autoid&modelid=$modelid&referer=$referer";
			}
			showmessage($message,$forward,200);
		} else {
			$show_header = $show_dialog  = '';
			$admin_username = param::get_cookie('admin_username');
			$modelid = isset($_GET['modelid']) ? intval($_GET['modelid']) : 0;
			
			$tree = pc_base::load_sys_class('tree');
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$categorys = array();
			if(!empty($this->categorys)) {
				foreach($this->categorys as $catid=>$r) {
					if($this->siteid != $r['siteid'] || ($r['type']==2 && $r['child']==0)) continue;
					if($modelid && $modelid != $r['modelid']) continue;
					if($r['child']==0) {
						if(!$r['ishtml']) continue;
					}
					$categorys[$catid] = $r;
				}
			}
			$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>";

			$tree->init($categorys);
			$string .= $tree->get_tree(0, $str);
			include $this->admin_tpl('create_html_category');
		}

	}
	//生成首页
	public function public_index() {
		$this->html = pc_base::load_app_class('html');
		$size = $this->html->index();
		showmessage(L('index_create_finish',array('size'=>sizecount($size))));
	}
	/**
	* 批量生成内容页
	*/
	public function batch_show() {
		if(isset($_POST['dosubmit'])) {
			$catid = intval($_GET['catid']);
			if(!$catid) showmessage(L('missing_part_parameters'));
			$modelid = $this->categorys[$catid]['modelid'];
			$setting = string2array($this->categorys[$catid]['setting']);
			$content_ishtml = $setting['content_ishtml'];
			if($content_ishtml) {
				$this->url = pc_base::load_app_class('url');
				$this->db->set_model($modelid);
				if(empty($_POST['ids'])) showmessage(L('you_do_not_check'));
				$this->html = pc_base::load_app_class('html');
				$ids = implode(',', $_POST['ids']);
				$rs = $this->db->select("catid='$catid' AND id IN ($ids)");
				$tablename = $this->db->table_name.'_data';
				foreach($rs as $r) {
					if($r['islink']) continue;
					$this->db->table_name = $tablename;
					$r2 = $this->db->get_one(array('id'=>$r['id']));
					if($r2) $r = array_merge($r,$r2);
					//判断是否为升级或转换过来的数据
					if(!$r['upgrade']) {
						$urls = $this->url->show($r['id'], '', $r['catid'],$r['inputtime']);
					} else {
						$urls[1] = $r['url'];
					}
					$this->html->show($urls[1],$r,0,'edit',$r['upgrade']);
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}
		}
	}
}
?>