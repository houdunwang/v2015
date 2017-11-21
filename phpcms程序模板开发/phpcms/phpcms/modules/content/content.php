<?php
set_time_limit(300);
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
//定义在单独操作内容的时候，同时更新相关栏目页面
define('RELATION_HTML',true);

pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
pc_base::load_app_func('util');
pc_base::load_sys_class('format','',0);

class content extends admin {
	private $db,$priv_db;
	public $siteid,$categorys;
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('content_model');
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		//权限判断
		if(isset($_GET['catid']) && $_SESSION['roleid'] != 1 && ROUTE_A !='pass' && strpos(ROUTE_A,'public_')===false) {
			$catid = intval($_GET['catid']);
			$this->priv_db = pc_base::load_model('category_priv_model');
			$action = $this->categorys[$catid]['type']==0 ? ROUTE_A : 'init';
			$priv_datas = $this->priv_db->get_one(array('catid'=>$catid,'is_admin'=>1,'action'=>$action));
			if(!$priv_datas) showmessage(L('permission_to_operate'),'blank');
		}
	}
	
	public function init() {
		$show_header = $show_dialog  = $show_pc_hash = '';
		if(isset($_GET['catid']) && $_GET['catid'] && $this->categorys[$_GET['catid']]['siteid']==$this->siteid) {
			$catid = $_GET['catid'] = intval($_GET['catid']);
			$category = $this->categorys[$catid];
			$modelid = $category['modelid'];
			$model_arr = getcache('model', 'commons');
			$MODEL = $model_arr[$modelid];
			unset($model_arr);
			$admin_username = param::get_cookie('admin_username');
			//查询当前的工作流
			$setting = string2array($category['setting']);
			$workflowid = $setting['workflowid'];
			$workflows = getcache('workflow_'.$this->siteid,'commons');
			$workflows = $workflows[$workflowid];
			$workflows_setting = string2array($workflows['setting']);

			//将有权限的级别放到新数组中
			$admin_privs = array();
			foreach($workflows_setting as $_k=>$_v) {
				if(empty($_v)) continue;
				foreach($_v as $_value) {
					if($_value==$admin_username) $admin_privs[$_k] = $_k;
				}
			}
			//工作流审核级别
			$workflow_steps = $workflows['steps'];
			$workflow_menu = '';
			$steps = isset($_GET['steps']) ? intval($_GET['steps']) : 0;
			//工作流权限判断
			if($_SESSION['roleid']!=1 && $steps && !in_array($steps,$admin_privs)) showmessage(L('permission_to_operate'));
			$this->db->set_model($modelid);
			if($this->db->table_name==$this->db->db_tablepre) showmessage(L('model_table_not_exists'));;
			$status = $steps ? $steps : 99;
			if(isset($_GET['reject'])) $status = 0;
			$where = 'catid='.$catid.' AND status='.$status;
			//搜索
			
			if(isset($_GET['start_time']) && $_GET['start_time']) {
				$start_time = strtotime($_GET['start_time']);
				$where .= " AND `inputtime` > '$start_time'";
			}
			if(isset($_GET['end_time']) && $_GET['end_time']) {
				$end_time = strtotime($_GET['end_time']);
				$where .= " AND `inputtime` < '$end_time'";
			}
			if($start_time>$end_time) showmessage(L('starttime_than_endtime'));
			if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
				$type_array = array('title','description','username');
				$searchtype = intval($_GET['searchtype']);
				if($searchtype < 3) {
					$searchtype = $type_array[$searchtype];
					$keyword = strip_tags(trim($_GET['keyword']));
					$where .= " AND `$searchtype` like '%$keyword%'";
				} elseif($searchtype==3) {
					$keyword = intval($_GET['keyword']);
					$where .= " AND `id`='$keyword'";
				}
			}
			if(isset($_GET['posids']) && !empty($_GET['posids'])) {
				$posids = $_GET['posids']==1 ? intval($_GET['posids']) : 0;
				$where .= " AND `posids` = '$posids'";
			}
			
			$datas = $this->db->listinfo($where,'id desc',$_GET['page']);
			$pages = $this->db->pages;
			$pc_hash = $_SESSION['pc_hash'];
			for($i=1;$i<=$workflow_steps;$i++) {
				if($_SESSION['roleid']!=1 && !in_array($i,$admin_privs)) continue;
				$current = $steps==$i ? 'class=on' : '';
				$r = $this->db->get_one(array('catid'=>$catid,'status'=>$i));
				$newimg = $r ? '<img src="'.IMG_PATH.'icon/new.png" style="padding-bottom:2px" onclick="window.location.href=\'?m=content&c=content&a=&menuid='.$_GET['menuid'].'&catid='.$catid.'&steps='.$i.'&pc_hash='.$pc_hash.'\'">' : '';
				$workflow_menu .= '<a href="?m=content&c=content&a=&menuid='.$_GET['menuid'].'&catid='.$catid.'&steps='.$i.'&pc_hash='.$pc_hash.'" '.$current.' ><em>'.L('workflow_'.$i).$newimg.'</em></a><span>|</span>';
			}
			if($workflow_menu) {
				$current = isset($_GET['reject']) ? 'class=on' : '';
				$workflow_menu .= '<a href="?m=content&c=content&a=&menuid='.$_GET['menuid'].'&catid='.$catid.'&pc_hash='.$pc_hash.'&reject=1" '.$current.' ><em>'.L('reject').'</em></a><span>|</span>';
			}
			//$ = 153fc6d28dda8ca94eaa3686c8eed857;获取模型的thumb字段配置信息
			$model_fields = getcache('model_field_'.$modelid, 'model');
			$setting = string2array($model_fields['thumb']['setting']);
			$args = '1,'.$setting['upload_allowext'].','.$setting['isselectimage'].','.$setting['images_width'].','.$setting['images_height'].','.$setting['watermark'];
			$authkey = upload_key($args);
			$template = $MODEL['admin_list_template'] ? $MODEL['admin_list_template'] : 'content_list';
			include $this->admin_tpl($template);
		} else {
			include $this->admin_tpl('content_quick');
		}
	}
	public function add() {
		if(isset($_POST['dosubmit']) || isset($_POST['dosubmit_continue'])) {
			define('INDEX_HTML',true);
			$catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
			if(trim($_POST['info']['title'])=='') showmessage(L('title_is_empty'));
			$category = $this->categorys[$catid];
			if($category['type']==0) {
				$modelid = $this->categorys[$catid]['modelid'];
				$this->db->set_model($modelid);
				//如果该栏目设置了工作流，那么必须走工作流设定
				$setting = string2array($category['setting']);
				$workflowid = $setting['workflowid'];
				if($workflowid && $_POST['status']!=99) {
					//如果用户是超级管理员，那么则根据自己的设置来发布
					$_POST['info']['status'] = $_SESSION['roleid']==1 ? intval($_POST['status']) : 1;
				} else {
					$_POST['info']['status'] = 99;
				}
				$this->db->add_content($_POST['info']);
				if(isset($_POST['dosubmit'])) {
					showmessage(L('add_success').L('2s_close'),'blank','','','function set_time() {$("#secondid").html(1);}setTimeout("set_time()", 500);setTimeout("window.close()", 1200);');
				} else {
					showmessage(L('add_success'),HTTP_REFERER);
				}
			} else {
				//单网页
				$this->page_db = pc_base::load_model('page_model');
				$style_font_weight = $_POST['style_font_weight'] ? 'font-weight:'.strip_tags($_POST['style_font_weight']) : '';
				$_POST['info']['style'] = strip_tags($_POST['style_color']).';'.$style_font_weight;
				
				if($_POST['edit']) {
					$this->page_db->update($_POST['info'],array('catid'=>$catid));
				} else {
					$catid = $this->page_db->insert($_POST['info'],1);
				}
				$this->page_db->create_html($catid,$_POST['info']);
				$forward = HTTP_REFERER;
			}
			showmessage(L('add_success'),$forward);
		} else {
			$show_header = $show_dialog = $show_validator = '';
			//设置cookie 在附件添加处调用
			param::set_cookie('module', 'content');

			if(isset($_GET['catid']) && $_GET['catid']) {
				$catid = $_GET['catid'] = intval($_GET['catid']);
				
				param::set_cookie('catid', $catid);
				$category = $this->categorys[$catid];
				if($category['type']==0) {
					$modelid = $category['modelid'];
					//取模型ID，依模型ID来生成对应的表单
					require CACHE_MODEL_PATH.'content_form.class.php';
					$content_form = new content_form($modelid,$catid,$this->categorys);
					$forminfos = $content_form->get();
 					$formValidator = $content_form->formValidator;
					$setting = string2array($category['setting']);
					$workflowid = $setting['workflowid'];
					$workflows = getcache('workflow_'.$this->siteid,'commons');
					$workflows = $workflows[$workflowid];
					$workflows_setting = string2array($workflows['setting']);
					$nocheck_users = $workflows_setting['nocheck_users'];
					$admin_username = param::get_cookie('admin_username');
					if(!empty($nocheck_users) && in_array($admin_username, $nocheck_users)) {
						$priv_status = true;
					} else {
						$priv_status = false;
					}
					include $this->admin_tpl('content_add');
				} else {
					//单网页
					$this->page_db = pc_base::load_model('page_model');
					
					$r = $this->page_db->get_one(array('catid'=>$catid));
					
					if($r) {
						extract($r);
						$style_arr = explode(';',$style);
						$style_color = $style_arr[0];
						$style_font_weight = $style_arr[1] ? substr($style_arr[1],12) : '';
					}
					include $this->admin_tpl('content_page');
				}
			} else {
				include $this->admin_tpl('content_add');
			}
			header("Cache-control: private");
		}
	}
	
	public function edit() {
			//设置cookie 在附件添加处调用
			param::set_cookie('module', 'content');
			if(isset($_POST['dosubmit']) || isset($_POST['dosubmit_continue'])) {
				define('INDEX_HTML',true);
				$id = $_POST['info']['id'] = intval($_POST['id']);
				$catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
				if(trim($_POST['info']['title'])=='') showmessage(L('title_is_empty'));
				$modelid = $this->categorys[$catid]['modelid'];
				$this->db->set_model($modelid);
				$this->db->edit_content($_POST['info'],$id);
				if(isset($_POST['dosubmit'])) {
					showmessage(L('update_success').L('2s_close'),'blank','','','function set_time() {$("#secondid").html(1);}setTimeout("set_time()", 500);setTimeout("window.close()", 1200);');
				} else {
					showmessage(L('update_success'),HTTP_REFERER);
				}
			} else {
				$show_header = $show_dialog = $show_validator = '';
				//从数据库获取内容
				$id = intval($_GET['id']);
				if(!isset($_GET['catid']) || !$_GET['catid']) showmessage(L('missing_part_parameters'));
				$catid = $_GET['catid'] = intval($_GET['catid']);
				
				$this->model = getcache('model', 'commons');
				
				param::set_cookie('catid', $catid);
				$category = $this->categorys[$catid];
				$modelid = $category['modelid'];
				$this->db->table_name = $this->db->db_tablepre.$this->model[$modelid]['tablename'];
				$r = $this->db->get_one(array('id'=>$id));
				$this->db->table_name = $this->db->table_name.'_data';
				$r2 = $this->db->get_one(array('id'=>$id));
				if(!$r2) showmessage(L('subsidiary_table_datalost'),'blank');
				$data = array_merge($r,$r2);
				$data = array_map('htmlspecialchars_decode',$data);
				require CACHE_MODEL_PATH.'content_form.class.php';
				$content_form = new content_form($modelid,$catid,$this->categorys);

				$forminfos = $content_form->get($data);
				$formValidator = $content_form->formValidator;
				include $this->admin_tpl('content_edit');
			}
			header("Cache-control: private");
	}
	/**
	 * 删除
	 */
	public function delete() {
		if(isset($_GET['dosubmit'])) {
			$catid = intval($_GET['catid']);
			if(!$catid) showmessage(L('missing_part_parameters'));
			$modelid = $this->categorys[$catid]['modelid'];
			$sethtml = $this->categorys[$catid]['sethtml'];
			$siteid = $this->categorys[$catid]['siteid'];
			
			$html_root = pc_base::load_config('system','html_root');
			if($sethtml) $html_root = '';
			
			$setting = string2array($this->categorys[$catid]['setting']);
			$content_ishtml = $setting['content_ishtml']; 
			$this->db->set_model($modelid);
			$this->hits_db = pc_base::load_model('hits_model');
			$this->queue = pc_base::load_model('queue_model');
			if(isset($_GET['ajax_preview'])) {
				$ids = intval($_GET['id']);
				$_POST['ids'] = array(0=>$ids);
			}
			if(empty($_POST['ids'])) showmessage(L('you_do_not_check'));
			//附件初始化
			$attachment = pc_base::load_model('attachment_model');
			$this->content_check_db = pc_base::load_model('content_check_model');
			$this->position_data_db = pc_base::load_model('position_data_model');
			$this->search_db = pc_base::load_model('search_model');
			//判断视频模块是否安装 
			if (module_exists('video') && file_exists(PC_PATH.'model'.DIRECTORY_SEPARATOR.'video_content_model.class.php')) {
				$video_content_db = pc_base::load_model('video_content_model');
				$video_install = 1;
			}
			$this->comment = pc_base::load_app_class('comment', 'comment');
			$search_model = getcache('search_model_'.$this->siteid,'search');
			$typeid = $search_model[$modelid]['typeid'];
			$this->url = pc_base::load_app_class('url', 'content');
			
			foreach($_POST['ids'] as $id) {
				$r = $this->db->get_one(array('id'=>$id));
				if($content_ishtml && !$r['islink']) {
					$urls = $this->url->show($id, 0, $r['catid'], $r['inputtime']);
					$fileurl = $urls[1];
					if($this->siteid != 1) {
						$sitelist = getcache('sitelist','commons');
						$fileurl = $html_root.'/'.$sitelist[$this->siteid]['dirname'].$fileurl;
					}
					//删除静态文件，排除htm/html/shtml外的文件
					$lasttext = strrchr($fileurl,'.');
					$len = -strlen($lasttext);
					$path = substr($fileurl,0,$len);
					$path = ltrim($path,'/');
					$filelist = glob(PHPCMS_PATH.$path.'{_,-,.}*',GLOB_BRACE);
					foreach ($filelist as $delfile) {
						$lasttext = strrchr($delfile,'.');
						if(!in_array($lasttext, array('.htm','.html','.shtml'))) continue;
						@unlink($delfile);
						//删除发布点队列数据
						$delfile = str_replace(PHPCMS_PATH, '/', $delfile);
						$this->queue->add_queue('del',$delfile,$this->siteid);
					}
				} else {
					$fileurl = 0;
				}
				//删除内容
				$this->db->delete_content($id,$fileurl,$catid);
				//删除统计表数据
				$this->hits_db->delete(array('hitsid'=>'c-'.$modelid.'-'.$id));
				//删除附件
				$attachment->api_delete('c-'.$catid.'-'.$id);
				//删除审核表数据
				$this->content_check_db->delete(array('checkid'=>'c-'.$id.'-'.$modelid));
				//删除推荐位数据
				$this->position_data_db->delete(array('id'=>$id,'catid'=>$catid,'module'=>'content'));
				//删除全站搜索中数据
				$this->search_db->delete_search($typeid,$id);
				//删除视频库与内容对应关系数据
				if ($video_install ==1) {
					$video_content_db->delete(array('contentid'=>$id, 'modelid'=>$modelid));
				}
				
				//删除相关的评论,删除前应该判断是否还存在此模块
				if(module_exists('comment')){
					$commentid = id_encode('content_'.$catid, $id, $siteid);
					$this->comment->del($commentid, $siteid, $id, $catid);
				}
				
 			}
			//更新栏目统计
			$this->db->cache_items();
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'));
		}
	}
	/**
	 * 过审内容
	 */
	public function pass() {
		$admin_username = param::get_cookie('admin_username');
		$catid = intval($_GET['catid']);
		
		if(!$catid) showmessage(L('missing_part_parameters'));
		$category = $this->categorys[$catid];
		$setting = string2array($category['setting']);
		$workflowid = $setting['workflowid'];
		//只有存在工作流才需要审核
		if($workflowid) {
			$steps = intval($_GET['steps']);
			//检查当前用户有没有当前工作流的操作权限
			$workflows = getcache('workflow_'.$this->siteid,'commons');
			$workflows = $workflows[$workflowid];
			$workflows_setting = string2array($workflows['setting']);
			//将有权限的级别放到新数组中
			$admin_privs = array();
			foreach($workflows_setting as $_k=>$_v) {
				if(empty($_v)) continue;
				foreach($_v as $_value) {
					if($_value==$admin_username) $admin_privs[$_k] = $_k;
				}
			}
			if($_SESSION['roleid']!=1 && $steps && !in_array($steps,$admin_privs)) showmessage(L('permission_to_operate'));
			//更改内容状态
				if(isset($_GET['reject'])) {
				//退稿
					$status = 0;
				} else {
					//工作流审核级别
					$workflow_steps = $workflows['steps'];
					
					if($workflow_steps>$steps) {
						$status = $steps+1;
					} else {
						$status = 99;
					}
				}
				
				$modelid = $this->categorys[$catid]['modelid'];
				$this->db->set_model($modelid);
				$this->db->search_db = pc_base::load_model('search_model');
				//审核通过，检查投稿奖励或扣除积分
				if ($status==99) {
					$html = pc_base::load_app_class('html', 'content');
					$this->url = pc_base::load_app_class('url', 'content');
					$member_db = pc_base::load_model('member_model');
					if (isset($_POST['ids']) && !empty($_POST['ids'])) {
						foreach ($_POST['ids'] as $id) {
							$content_info = $this->db->get_content($catid,$id);
							$memberinfo = $member_db->get_one(array('username'=>$content_info['username']), 'userid, username');
							$flag = $catid.'_'.$id;
							if($setting['presentpoint']>0) {
								pc_base::load_app_class('receipts','pay',0);
								receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
							} else {
								pc_base::load_app_class('spend','pay',0);
								spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
							}
							if($setting['content_ishtml'] == '1'){//栏目有静态配置
  								$urls = $this->url->show($id, 0, $content_info['catid'], $content_info['inputtime'], '',$content_info,'add');
   								$html->show($urls[1],$urls['data'],0);
 							}
							//更新到全站搜索
							$inputinfo = '';
							$inputinfo['system'] = $content_info;
							$this->db->search_api($id,$inputinfo);
						}
					} else if (isset($_GET['id']) && $_GET['id']) {
						$id = intval($_GET['id']);
						$content_info = $this->db->get_content($catid,$id);
						$memberinfo = $member_db->get_one(array('username'=>$content_info['username']), 'userid, username');
						$flag = $catid.'_'.$id;
						if($setting['presentpoint']>0) {
							pc_base::load_app_class('receipts','pay',0);
							receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
						} else {
							pc_base::load_app_class('spend','pay',0);
							spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
						}
						//单篇审核，生成静态
						if($setting['content_ishtml'] == '1'){//栏目有静态配置
						$urls = $this->url->show($id, 0, $content_info['catid'], $content_info['inputtime'], '',$content_info,'add');
						$html->show($urls[1],$urls['data'],0);
						}
						//更新到全站搜索
						$inputinfo = '';
						$inputinfo['system'] = $content_info;
						$this->db->search_api($id,$inputinfo);
					}
				}
				if(isset($_GET['ajax_preview'])) {
					$_POST['ids'] = $_GET['id'];
				}
				$this->db->status($_POST['ids'],$status);
		}
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_GET['dosubmit'])) {
			$catid = intval($_GET['catid']);
			if(!$catid) showmessage(L('missing_part_parameters'));
			$modelid = $this->categorys[$catid]['modelid'];
			$this->db->set_model($modelid);
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'));
		} else {
			showmessage(L('operation_failure'));
		}
	}
	/**
	 * 显示栏目菜单列表
	 */
	public function public_categorys() {
		$show_header = '';
		$cfg = getcache('common','commons');
		$ajax_show = intval($cfg['category_ajax']);
		$from = isset($_GET['from']) && in_array($_GET['from'],array('block')) ? $_GET['from'] : 'content';
		$tree = pc_base::load_sys_class('tree');
		if($from=='content' && $_SESSION['roleid'] != 1) {	
			$this->priv_db = pc_base::load_model('category_priv_model');
			$priv_result = $this->priv_db->select(array('action'=>'init','roleid'=>$_SESSION['roleid'],'siteid'=>$this->siteid,'is_admin'=>1));
			$priv_catids = array();
			foreach($priv_result as $_v) {
				$priv_catids[] = $_v['catid'];
			}
			if(empty($priv_catids)) return '';
		}
		$_GET['menuid'] = intval($_GET['menuid']);
		$categorys = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $r) {
				if($r['siteid']!=$this->siteid ||  ($r['type']==2 && $r['child']==0)) continue;
				if($from=='content' && $_SESSION['roleid'] != 1 && !in_array($r['catid'],$priv_catids)) {
					$arrchildid = explode(',',$r['arrchildid']);
					$array_intersect = array_intersect($priv_catids,$arrchildid);
					if(empty($array_intersect)) continue;
				}
				if($r['type']==1 || $from=='block') {
					if($r['type']==0) {
						$r['vs_show'] = "<a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=".$r['catid']."&type=show' target='right'>[".L('content_page')."]</a>";
					} else {
						$r['vs_show'] ='';
					}
					$r['icon_type'] = 'file';
					$r['add_icon'] = '';
					$r['type'] = 'add';
				} else {
					$r['icon_type'] = $r['vs_show'] = '';
					$r['type'] = 'init';
					$r['add_icon'] = "<a target='right' href='?m=content&c=content&menuid=".$_GET['menuid']."&catid=".$r['catid']."' onclick=javascript:openwinx('?m=content&c=content&a=add&menuid=".$_GET['menuid']."&catid=".$r['catid']."&hash_page=".$_SESSION['hash_page']."','')><img src='".IMG_PATH."add_content.gif' alt='".L('add')."'></a> ";
				}
				$categorys[$r['catid']] = $r;
			}
		}
		if(!empty($categorys)) {
			$tree->init($categorys);
				switch($from) {
					case 'block':
						$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=\$catid&type=list' target='right'>\$catname</a> \$vs_show</span>";
						$strs2 = "<img src='".IMG_PATH."folder.gif'> <a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=\$catid&type=category' target='right'>\$catname</a>";
					break;

					default:
						$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=content&c=content&a=\$type&menuid=".$_GET['menuid']."&catid=\$catid' target='right' onclick='open_list(this)'>\$catname</a></span>";
						$strs2 = "<span class='folder'>\$catname</span>";
						break;
				}
			$categorys = $tree->get_treeview(0,'category_tree',$strs,$strs2,$ajax_show);
		} else {
			$categorys = L('please_add_category');
		}
        include $this->admin_tpl('category_tree');
		exit;
	}
	/**
	 * 检查标题是否存在
	 */
	public function public_check_title() {
		if($_GET['data']=='' || (!$_GET['catid'])) return '';
		$catid = intval($_GET['catid']);
		$modelid = $this->categorys[$catid]['modelid'];
		$this->db->set_model($modelid);
		$title = $_GET['data'];
		if(CHARSET=='gbk') $title = iconv('utf-8','gbk',$title);
		$r = $this->db->get_one(array('title'=>$title));
		if($r) {
			exit('1');
		} else {
			exit('0');
		}
	}

	/**
	 * 修改某一字段数据
	 */
	public function update_param() {
		$id = intval($_GET['id']);
		$field = $_GET['field'];
		$modelid = intval($_GET['modelid']);
		$value = $_GET['value'];
		if (CHARSET!='utf-8') {
			$value = iconv('utf-8', 'gbk', $value);
		}
		//检查字段是否存在
		$this->db->set_model($modelid);
		if ($this->db->field_exists($field)) {
			$this->db->update(array($field=>$value), array('id'=>$id));
			exit('200');
		} else {
			$this->db->table_name = $this->db->table_name.'_data';
			if ($this->db->field_exists($field)) {
				$this->db->update(array($field=>$value), array('id'=>$id));
				exit('200');
			} else {
				exit('300');
			}
		}
	}
	
	/**
	 * 图片裁切
	 */
	public function public_crop() {
		if (isset($_GET['picurl']) && !empty($_GET['picurl'])) {
			$picurl = $_GET['picurl'];
			$catid = intval($_GET['catid']);
			if (isset($_GET['module']) && !empty($_GET['module'])) {
				$module = $_GET['module'];
			}
			$show_header =  '';
			include $this->admin_tpl('crop');
		}
	}
	/**
	 * 相关文章选择
	 */
	public function public_relationlist() {
		pc_base::load_sys_class('format','',0);
		$show_header = '';
		$model_cache = getcache('model','commons');
		if(!isset($_GET['modelid'])) {
			showmessage(L('please_select_modelid'));
		} else {
			$page = intval($_GET['page']);
			
			$modelid = intval($_GET['modelid']);
			$this->db->set_model($modelid);
			$where = '';
			if($_GET['catid']) {
				$catid = intval($_GET['catid']);
				$where .= "catid='$catid'";
			}
			$where .= $where ?  ' AND status=99' : 'status=99';
			
			if(isset($_GET['keywords'])) {
				$keywords = trim($_GET['keywords']);
				$field = $_GET['field'];
				if(in_array($field, array('id','title','keywords','description'))) {
					if($field=='id') {
						$where .= " AND `id` ='$keywords'";
					} else {
						$where .= " AND `$field` like '%$keywords%'";
					}
				}
			}
			$infos = $this->db->listinfo($where,'',$page,12);
			$pages = $this->db->pages;
			include $this->admin_tpl('relationlist');
		}
	}
	public function public_getjson_ids() {
		$modelid = intval($_GET['modelid']);
		$id = intval($_GET['id']);
		$this->db->set_model($modelid);
		$tablename = $this->db->table_name;
		$this->db->table_name = $tablename.'_data';
		$r = $this->db->get_one(array('id'=>$id),'relation');

		if($r['relation']) {
			$relation = str_replace('|', ',', $r['relation']);
			$relation = trim($relation,',');
			$where = "id IN($relation)";
			$infos = array();
			$this->db->table_name = $tablename;
			$datas = $this->db->select($where,'id,title');
			foreach($datas as $_v) {
				$_v['sid'] = 'v'.$_v['id'];
				if(strtolower(CHARSET)=='gbk') $_v['title'] = iconv('gbk', 'utf-8', $_v['title']);
				$infos[] = $_v;
			}
			echo json_encode($infos);
		}
	}

	//文章预览
	public function public_preview() {
		$catid = intval($_GET['catid']);
		$id = intval($_GET['id']);
		
		if(!$catid || !$id) showmessage(L('missing_part_parameters'),'blank');
		$page = intval($_GET['page']);
		$page = max($page,1);
		$CATEGORYS = getcache('category_content_'.$this->get_siteid(),'commons');
		
		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) showmessage(L('missing_part_parameters'),'blank');
		define('HTML', true);
		$CAT = $CATEGORYS[$catid];
		
		$siteid = $CAT['siteid'];
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];

		$this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$r = $this->db->get_one(array('id'=>$id));
		if(!$r) showmessage(L('information_does_not_exist'));
		$this->db->table_name = $this->db->table_name.'_data';
		$r2 = $this->db->get_one(array('id'=>$id));
		$rs = $r2 ? array_merge($r,$r2) : $r;

		//再次重新赋值，以数据库为准
		$catid = $CATEGORYS[$r['catid']]['catid'];
		$modelid = $CATEGORYS[$catid]['modelid'];
		
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$data = $content_output->get($rs);
		extract($data);
		$CAT['setting'] = string2array($CAT['setting']);
		$template = $template ? $template : $CAT['setting']['show_template'];
		$allow_visitor = 1;
		//SEO
		$SEO = seo($siteid, $catid, $title, $description);
		
		define('STYLE',$CAT['setting']['template_list']);
		if(isset($rs['paginationtype'])) {
			$paginationtype = $rs['paginationtype'];
			$maxcharperpage = $rs['maxcharperpage'];
		}
		$pages = $titles = '';
		if($rs['paginationtype']==1) {
			//自动分页
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = pc_base::load_app_class('contentpage');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
		if($rs['paginationtype']!=0) {
			//手动分页
			$CONTENT_POS = strpos($content, '[page]');
			if($CONTENT_POS !== false) {
				$this->url = pc_base::load_app_class('url', 'content');
				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
				if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i][0] = 'index.php?m=content&c=content&a=public_preview&steps='.intval($_GET['steps']).'&catid='.$catid.'&id='.$id.'&page='.$i;
				}
				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if($CONTENT_POS>7) {
						$content = '[page]'.$title.'[/page]'.$content;
					}
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}
				//当不存在 [/page]时，则使用下面分页
				$pages = content_pages($pagenumber,$page, $pageurls);
				//判断[page]出现的位置是否在第一位 
				if($CONTENT_POS<7) {
					$content = $contents[$page];
				} else {
					if ($page==1 && !empty($titles)) {
						$content = $title.'[/page]'.$contents[$page-1];
					} else {
						$content = $contents[$page-1];
					}
				}
				if($titles) {
					list($title, $content) = explode('[/page]', $content);
					$content = trim($content);
					if(strpos($content,'</p>')===0) {
						$content = '<p>'.$content;
					}
					if(stripos($content,'<p>')===0) {
						$content = $content.'</p>';
					}
				}
			}
		}
		include template('content',$template);
		$pc_hash = $_SESSION['pc_hash'];
		$steps = intval($_GET['steps']);
		echo "
		<link href=\"".CSS_PATH."dialog_simp.css\" rel=\"stylesheet\" type=\"text/css\" />
		<script language=\"javascript\" type=\"text/javascript\" src=\"".JS_PATH."dialog.js\"></script>
		<script type=\"text/javascript\">art.dialog({lock:false,title:'".L('operations_manage')."',mouse:true, id:'content_m', content:'<span id=cloading ><a href=\'javascript:ajax_manage(1)\'>".L('passed_checked')."</a> | <a href=\'javascript:ajax_manage(2)\'>".L('reject')."</a> |　<a href=\'javascript:ajax_manage(3)\'>".L('delete')."</a></span>',left:'100%',top:'100%',width:200,height:50,drag:true, fixed:true});
		function ajax_manage(type) {
			if(type==1) {
				$.get('?m=content&c=content&a=pass&ajax_preview=1&catid=".$catid."&steps=".$steps."&id=".$id."&pc_hash=".$pc_hash."');
			} else if(type==2) {
				$.get('?m=content&c=content&a=pass&ajax_preview=1&reject=1&catid=".$catid."&steps=".$steps."&id=".$id."&pc_hash=".$pc_hash."');
			} else if(type==3) {
				$.get('?m=content&c=content&a=delete&ajax_preview=1&dosubmit=1&catid=".$catid."&steps=".$steps."&id=".$id."&pc_hash=".$pc_hash."');
			}
			$('#cloading').html('<font color=red>".L('operation_success')."<span id=\"secondid\">2</span>".L('after_a_few_seconds_left')."</font>');
			setInterval('set_time()', 1000);
			setInterval('window.close()', 2000);
		}
		function set_time() {
			$('#secondid').html(1);
		}
		</script>";
	}

	/**
	 * 审核所有内容
	 */
	public function public_checkall() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		
		$show_header = '';
		$workflows = getcache('workflow_'.$this->siteid,'commons');
		$datas = array();
		$pagesize = 20;
		$sql = '';
		if (in_array($_SESSION['roleid'], array('1'))) {
			$super_admin = 1;
			$status = isset($_GET['status']) ? $_GET['status'] : -1;
		} else {
			$super_admin = 0;
			$status = isset($_GET['status']) ? $_GET['status'] : 1;
			if($status==-1) $status = 1;
		}
		if($status>4) $status = 4;
		$this->priv_db = pc_base::load_model('category_priv_model');;
		$admin_username = param::get_cookie('admin_username');
		if($status==-1) {
			$sql = "`status` NOT IN (99,0,-2) AND `siteid`=$this->siteid";
		} else {
			$sql = "`status` = '$status' AND `siteid`=$this->siteid";
		}
		if($status!=0 && !$super_admin) {
			//以栏目进行循环
			foreach ($this->categorys as $catid => $cat) {
				if($cat['type']!=0) continue;
				//查看管理员是否有这个栏目的查看权限。
				if (!$this->priv_db->get_one(array('catid'=>$catid, 'siteid'=>$this->siteid, 'roleid'=>$_SESSION['roleid'], 'is_admin'=>'1'))) {
					continue;
				}
				//如果栏目有设置工作流，进行权限检查。
				$workflow = array();
				$cat['setting'] = string2array($cat['setting']);
				if (isset($cat['setting']['workflowid']) && !empty($cat['setting']['workflowid'])) {
					$workflow = $workflows[$cat['setting']['workflowid']];
					$workflow['setting'] = string2array($workflow['setting']);
					$usernames = $workflow['setting'][$status];
					if (empty($usernames) || !in_array($admin_username, $usernames)) {//判断当前管理，在工作流中可以审核几审
						continue;
					}
				}
				$priv_catid[] = $catid;
			}
			if(empty($priv_catid)) {
				$sql .= " AND catid = -1";
			} else {
				$priv_catid = implode(',', $priv_catid);
				$sql .= " AND catid IN ($priv_catid)";
			}
		}
		$this->content_check_db = pc_base::load_model('content_check_model');
		$datas = $this->content_check_db->listinfo($sql,'inputtime DESC',$page);		
		$pages = $this->content_check_db->pages;
		include $this->admin_tpl('content_checkall');
	}
	
	/**
	 * 批量移动文章
	 */
	public function remove() {
		if(isset($_POST['dosubmit'])) {
			$this->content_check_db = pc_base::load_model('content_check_model');
			$this->hits_db = pc_base::load_model('hits_model');
			if($_POST['fromtype']==0) {
				if($_POST['ids']=='') showmessage(L('please_input_move_source'));
				if(!$_POST['tocatid']) showmessage(L('please_select_target_category'));
				$tocatid = intval($_POST['tocatid']);
				$modelid = $this->categorys[$tocatid]['modelid'];
				if(!$modelid) showmessage(L('illegal_operation'));
				$ids = array_filter(explode(',', $_POST['ids']),"is_numeric");
				foreach ($ids as $id) {
					$checkid = 'c-'.$id.'-'.$this->siteid;
					$this->content_check_db->update(array('catid'=>$tocatid), array('checkid'=>$checkid));
					$hitsid = 'c-'.$modelid.'-'.$id;
					$this->hits_db->update(array('catid'=>$tocatid),array('hitsid'=>$hitsid));
				}
				$ids = implode(',', $ids);
				$this->db->set_model($modelid);
				$this->db->update(array('catid'=>$tocatid),"id IN($ids)");
			} else {
				if(!$_POST['fromid']) showmessage(L('please_input_move_source'));
				if(!$_POST['tocatid']) showmessage(L('please_select_target_category'));
				$tocatid = intval($_POST['tocatid']);
				$modelid = $this->categorys[$tocatid]['modelid'];
				if(!$modelid) showmessage(L('illegal_operation'));
				$fromid = array_filter($_POST['fromid'],"is_numeric");
				$fromid = implode(',', $fromid);
				$this->db->set_model($modelid);
				$this->db->update(array('catid'=>$tocatid),"catid IN($fromid)");
				$this->hits_db->update(array('catid'=>$tocatid),"catid IN($fromid)");
			}
			showmessage(L('operation_success'),HTTP_REFERER);
			//ids
		} else {
			$show_header = '';
			$catid = intval($_GET['catid']);
			$modelid = $this->categorys[$catid]['modelid'];
			$tree = pc_base::load_sys_class('tree');
			$tree->icon = array('&nbsp;&nbsp;│ ','&nbsp;&nbsp;├─ ','&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;';
			$categorys = array();
			foreach($this->categorys as $cid=>$r) {
				if($this->siteid != $r['siteid'] || $r['type']) continue;
				if($modelid && $modelid != $r['modelid']) continue;
				$r['disabled'] = $r['child'] ? 'disabled' : '';
				$r['selected'] = $cid == $catid ? 'selected' : '';
				$categorys[$cid] = $r;
			}
			$str  = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";

			$tree->init($categorys);
			$string .= $tree->get_tree(0, $str);
 			$str  = "<option value='\$catid'>\$spacer \$catname</option>";
			$source_string = '';
			$tree->init($categorys);
			$source_string .= $tree->get_tree(0, $str);
			$ids = empty($_POST['ids']) ? '' : implode(',',$_POST['ids']);
			include $this->admin_tpl('content_remove');
		}
	}
	
	/**
	 * 同时发布到其他栏目
	 */
	public function add_othors() {
		$show_header = '';
		$sitelist = getcache('sitelist','commons');
		$siteid = $_GET['siteid'];
		include $this->admin_tpl('add_othors');
		
	}
	/**
	 * 同时发布到其他栏目 异步加载栏目
	 */
	public function public_getsite_categorys() {
		$siteid = intval($_GET['siteid']);
		$this->categorys = getcache('category_content_'.$siteid,'commons');
		$models = getcache('model','commons');
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		if($_SESSION['roleid'] != 1) {
			$this->priv_db = pc_base::load_model('category_priv_model');
			$priv_result = $this->priv_db->select(array('action'=>'add','roleid'=>$_SESSION['roleid'],'siteid'=>$siteid,'is_admin'=>1));
			$priv_catids = array();
			foreach($priv_result as $_v) {
				$priv_catids[] = $_v['catid'];
			}
			if(empty($priv_catids)) return '';
		}
		
		foreach($this->categorys as $r) {
			if($r['siteid']!=$siteid || $r['type']!=0) continue;
			if($_SESSION['roleid'] != 1 && !in_array($r['catid'],$priv_catids)) {
				$arrchildid = explode(',',$r['arrchildid']);
				$array_intersect = array_intersect($priv_catids,$arrchildid);
				if(empty($array_intersect)) continue;
			}
			$r['modelname'] = $models[$r['modelid']]['name'];
			$r['style'] = $r['child'] ? 'color:#8A8A8A;' : '';
			$r['click'] = $r['child'] ? '' : "onclick=\"select_list(this,'".safe_replace($r['catname'])."',".$r['catid'].")\" class='cu' title='".L('click_to_select')."'";
			$categorys[$r['catid']] = $r;
		}
		$str  = "<tr \$click >
					<td align='center'>\$id</td>
					<td style='\$style'>\$spacer\$catname</td>
					<td align='center'>\$modelname</td>
				</tr>";
		$tree->init($categorys);
		$categorys = $tree->get_tree(0, $str);
		echo $categorys;
	}
	
	public function public_sub_categorys() {
		$cfg = getcache('common','commons');
		$ajax_show = intval(abs($cfg['category_ajax']));	
		$catid = intval($_POST['root']);
		$modelid = intval($_POST['modelid']);
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$tree = pc_base::load_sys_class('tree');
		$_GET['menuid'] = intval($_GET['menuid']);
		if(!empty($this->categorys)) {
			foreach($this->categorys as $r) {
				if($r['siteid']!=$this->siteid ||  ($r['type']==2 && $r['child']==0)) continue;
				if($from=='content' && $_SESSION['roleid'] != 1 && !in_array($r['catid'],$priv_catids)) {
					$arrchildid = explode(',',$r['arrchildid']);
					$array_intersect = array_intersect($priv_catids,$arrchildid);
					if(empty($array_intersect)) continue;
				}
				if($r['type']==1 || $from=='block') {
					if($r['type']==0) {
						$r['vs_show'] = "<a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=".$r['catid']."&type=show' target='right'>[".L('content_page')."]</a>";
					} else {
						$r['vs_show'] ='';
					}
					$r['icon_type'] = 'file';
					$r['add_icon'] = '';
					$r['type'] = 'add';
				} else {
					$r['icon_type'] = $r['vs_show'] = '';
					$r['type'] = 'init';
					$r['add_icon'] = "<a target='right' href='?m=content&c=content&menuid=".$_GET['menuid']."&catid=".$r['catid']."' onclick=javascript:openwinx('?m=content&c=content&a=add&menuid=".$_GET['menuid']."&catid=".$r['catid']."&hash_page=".$_SESSION['hash_page']."','')><img src='".IMG_PATH."add_content.gif' alt='".L('add')."'></a> ";
				}
				$categorys[$r['catid']] = $r;
			}
		}
		if(!empty($categorys)) {
			$tree->init($categorys);
				switch($from) {
					case 'block':
						$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=\$catid&type=list&pc_hash=".$_SESSION['pc_hash']."' target='right'>\$catname</a> \$vs_show</span>";
					break;

					default:
						$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=content&c=content&a=\$type&menuid=".$_GET['menuid']."&catid=\$catid&pc_hash=".$_SESSION['pc_hash']."' target='right' onclick='open_list(this)'>\$catname</a></span>";
						break;
				}
			$data = $tree->creat_sub_json($catid,$strs);
		}		
		echo $data;
	}

	/**
	 * 一键清理演示数据
	 */
	public function clear_data() {
		//清理数据涉及到的数据表
		
		if ($_POST['dosubmit']) {
			set_time_limit(0);
			$models = array('category', 'content', 'hits', 'search', 'position_data', 'video_content', 'video_store', 'comment');
			$tables = $_POST['tables'];
			if (is_array($tables)) {
				foreach ($tables as $t) {
					if (in_array($t, $models)) {
						if ($t=='content') {
							$model = $_POST['model'];
							$db = pc_base::load_model('content_model');
							//读取网站的所有模型
							$model_arr = getcache('model', 'commons');
							foreach ($model as $modelid) {
								$db->set_model($modelid);
								if ($r = $db->count()) { //判断模型下是否有数据
									$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$model_arr[$modelid]['tablename'].'.sql';
									$result = $data = $db->select();
									$this->create_sql_file($result, $db->db_tablepre.$model_arr[$modelid]['tablename'], $sql_file);
									$db->query('TRUNCATE TABLE `phpcms_'.$model_arr[$modelid]['tablename'].'`');
									//开始清理模型data表数据
									$db->table_name = $db->table_name.'_data';
									$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$model_arr[$modelid]['tablename'].'_data.sql';
									$result = $db->select();
									$this->create_sql_file($result, $db->db_tablepre.$model_arr[$modelid]['tablename'].'_data', $sql_file);
									$db->query('TRUNCATE TABLE `phpcms_'.$model_arr[$modelid]['tablename'].'_data`');
									//删除该模型中在hits表的数据
									$hits_db = pc_base::load_model('hits_model');
									$hitsid = 'c-'.$modelid.'-';
									$result = $hits_db->select("`hitsid` LIKE '%$hitsid%'");
									if (is_array($result)) {
										$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'hits-'.$modelid.'.sql';
										$this->create_sql_file($result, $hits_db->db_tablepre.'hits', $sql_file);
									}
									$hits_db->delete("`hitsid` LIKE '%$hitsid%'");
									//删除该模型在search中的数据
									$search_db = pc_base::load_model('search_model');
									$type_model = getcache('type_model_'.$model_arr[$modelid]['siteid'], 'search');
									$typeid = $type_model[$modelid];
									$result = $search_db->select("`typeid`=".$typeid);
									if (is_array($result)) {
										$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'search-'.$modelid.'.sql';
										$this->create_sql_file($result, $search_db->db_tablepre.'search', $sql_file);
									}
									$search_db->delete("`typeid`=".$typeid);
									//Delete the model data in the position table
									$position_db = pc_base::load_model('position_data_model');
									$result = $position_db->select('`modelid`='.$modelid.' AND `module`=\'content\'');
									if (is_array($result)) {
										$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'position_data-'.$modelid.'.sql';
										$this->create_sql_file($result, $position_db->db_tablepre.'position_data', $sql_file);
									}
									$position_db->delete('`modelid`='.$modelid.' AND `module`=\'content\'');
									//清理视频库与内容对应关系表
									if (module_exists('video')) {
										$video_content_db = pc_base::load_model('video_content_model');
										$result = $video_content_db->select('`modelid`=\''.$modelid.'\'');
										if (is_array($result)) {
											$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'video_content-'.$modelid.'.sql';
											$this->create_sql_file($result, $video_content_db->db_tablepre.'video_content', $sql_file);
										}
										$video_content_db->delete('`modelid`=\''.$modelid.'\'');
									}
									//清理评论表及附件表，附件的清理为不可逆操作。
									//附件初始化
									//$attachment = pc_base::load_model('attachment_model');
									//$comment = pc_base::load_app_class('comment', 'comment');
									//if(module_exists('comment')){
										//$comment_exists = 1;
									//}
									//foreach ($data as $d) {
										//$attachment->api_delete('c-'.$d['catid'].'-'.$d['id']);
										//if ($comment_exists) {
											//$commentid = id_encode('content_'.$d['catid'], $d['id'], $model_arr[$modelid]['siteid']);
											//$comment->del($commentid, $model_arr[$modelid]['siteid'], $d['id'], $d['catid']);
										//}
									//}
								}
							}
							
						} elseif ($t=='comment') {
							$comment_db = pc_base::load_model('comment_data_model');
							for($i=1;;$i++) {
								$comment_db->table_name($i);
								if ($comment_db->table_exists(str_replace($comment_db->db_tablepre, '', $comment_db->table_name))) {
									if ($r = $comment_db->count()) {
										$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'comment_data_'.$i.'.sql';
										$result = $comment_db->select();
										$this->create_sql_file($result, $comment_db->db_tablepre.'comment_data_'.$i, $sql_file);
										$comment_db->query('TRUNCATE TABLE `phpcms_comment_data_'.$i.'`');
									}
								} else {
									break;
								}
							}
						} else {
							$db = pc_base::load_model($t.'_model');
							if ($r = $db->count()) {
								$result = $db->select();
								$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$t.'.sql';
								$this->create_sql_file($result, $db->db_tablepre.$t, $sql_file);
								$db->query('TRUNCATE TABLE `phpcms_'.$t.'`');
							}
						}
					}
				}
			}
			showmessage(L('clear_data_message'));
		} else {
			//读取网站的所有模型
			$model_arr = getcache('model', 'commons');
			include $this->admin_tpl('clear_data');
		}
	}

	/**
	 * 备份数据到文件
	 * @param $data array 备份的数据数组
	 * @param $tablename 数据所属数据表
	 * @param $file 备份到的文件
	 */
	private function create_sql_file($data, $db, $file) {
		if (is_array($data)) {
			$sql = '';
			foreach ($data as $d) {
				$tag = '';
				$sql .= "INSERT INTO `".$db.'` VALUES(';
				foreach ($d as $_f => $_v) {
					$sql .= $tag.'\''.addslashes($_v).'\'';
					$tag = ',';
				}
				$sql .= ');'."\r\n";
			}
			file_put_contents($file, $sql);
		}
		return true;
	}
}
?>