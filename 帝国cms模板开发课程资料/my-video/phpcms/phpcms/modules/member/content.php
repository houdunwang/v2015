<?php
/**
 * 会员前台投稿操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('foreground');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_func('global', 'member');

class content extends foreground {
	private $times_db;
	function __construct() {
		parent::__construct();
	}
	public function publish() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist');
		$priv_db = pc_base::load_model('category_priv_model'); //加载栏目权限表数据模型
		
		//判断会员组是否允许投稿
		if(!$grouplist[$memberinfo['groupid']]['allowpost']) {
			showmessage(L('member_group').L('publish_deny'), HTTP_REFERER);
		}
		//判断每日投稿数
		$this->content_check_db = pc_base::load_model('content_check_model');
		$todaytime = strtotime(date('y-m-d',SYS_TIME));
		$_username = $this->memberinfo['username'];
		$allowpostnum = $this->content_check_db->count("`inputtime` > $todaytime AND `username`='$_username'");
		if($grouplist[$memberinfo['groupid']]['allowpostnum'] > 0 && $allowpostnum >= $grouplist[$memberinfo['groupid']]['allowpostnum']) {
			showmessage(L('allowpostnum_deny').$grouplist[$memberinfo['groupid']]['allowpostnum'], HTTP_REFERER);
		}
		$siteids = getcache('category_content', 'commons');
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			
			$catid = intval($_POST['info']['catid']);
			//判断此类型用户是否有权限在此栏目下提交投稿
			if (!$priv_db->get_one(array('catid'=>$catid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) showmessage(L('category').L('publish_deny'), APP_PATH.'index.php?m=member'); 
			
			
			$siteid = $siteids[$catid];
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$category = $CATEGORYS[$catid];
			$modelid = $category['modelid'];
			if(!$modelid) showmessage(L('illegal_parameters'), HTTP_REFERER);
			$this->content_db = pc_base::load_model('content_model');
			$this->content_db->set_model($modelid);
			$table_name = $this->content_db->table_name;
			$fields_sys = $this->content_db->get_fields();
			$this->content_db->table_name = $table_name.'_data';
			
			$fields_attr = $this->content_db->get_fields();
			$fields = array_merge($fields_sys,$fields_attr);
			$fields = array_keys($fields);
			$info = array();
			foreach($_POST['info'] as $_k=>$_v) {
				if($_k == 'content') {
					$info[$_k] = remove_xss(strip_tags($_v, '<p><a><br><img><ul><li><div>'));
				} elseif(in_array($_k, $fields)) {
					$info[$_k] = new_html_special_chars(trim_script($_v));
				}
			}
			$_POST['linkurl'] = str_replace(array('"','(',')',",",' ','%'),'',new_html_special_chars(strip_tags($_POST['linkurl'])));
			$post_fields = array_keys($_POST['info']);
			$post_fields = array_intersect_assoc($fields,$post_fields);
			$setting = string2array($category['setting']);
			if($setting['presentpoint'] < 0 && $memberinfo['point'] < abs($setting['presentpoint']))
			showmessage(L('points_less_than',array('point'=>$memberinfo['point'],'need_point'=>abs($setting['presentpoint']))),APP_PATH.'index.php?m=pay&c=deposit&a=pay&exchange=point',3000);
			
			//判断会员组投稿是否需要审核
			if($grouplist[$memberinfo['groupid']]['allowpostverify'] || !$setting['workflowid']) {
				$info['status'] = 99;
			} else {
				$info['status'] = 1;
			}
			$info['username'] = $memberinfo['username'];
			if(isset($info['title'])) $info['title'] = safe_replace($info['title']);
			$this->content_db->siteid = $siteid;
			
			$id = $this->content_db->add_content($info);
			//检查投稿奖励或扣除积分
			if ($info['status']==99) {
				$flag = $catid.'_'.$id;
				if($setting['presentpoint']>0) {
					pc_base::load_app_class('receipts','pay',0);
					receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
				} else {
					pc_base::load_app_class('spend','pay',0);
					spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
				}
			}
			//缓存结果
			$model_cache = getcache('model','commons');
			$infos = array();
			foreach ($model_cache as $modelid=>$model) {
				if($model['siteid']==$siteid) {
					$datas = array();
					$this->content_db->set_model($modelid);
					$datas = $this->content_db->select(array('username'=>$memberinfo['username'],'sysadd'=>0),'id,catid,title,url,username,sysadd,inputtime,status',100,'id DESC');
					if($datas) $infos = array_merge($infos,$datas);
				}
			}
			setcache('member_'.$memberinfo['userid'].'_'.$siteid, $infos,'content');
			//缓存结果 END
			if($info['status']==99) {
				showmessage(L('contributors_success'), APP_PATH.'index.php?m=member&c=content&a=published');
			} else {
				showmessage(L('contributors_checked'), APP_PATH.'index.php?m=member&c=content&a=published');
			}
			
		} else {		
			$show_header = $show_dialog = $show_validator = '';
			$temp_language = L('news','','content');
			$sitelist = getcache('sitelist','commons');
			if(!isset($_GET['siteid']) && count($sitelist)>1) {
				include template('member', 'content_publish_select_model');
				exit;
			}
			//设置cookie 在附件添加处调用
			param::set_cookie('module', 'content');
			$siteid = intval($_GET['siteid']);
			if(!$siteid) $siteid = 1;
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons'); 
			foreach ($CATEGORYS as $catid=>$cat) {
				if($cat['siteid']==$siteid && $cat['child']==0 && $cat['type']==0 && $priv_db->get_one(array('catid'=>$catid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) break;
			}
			$catid = $_GET['catid'] ? intval($_GET['catid']) : $catid;
			if (!$catid) showmessage(L('category').L('publish_deny'), APP_PATH.'index.php?m=member');

			//判断本栏目是否允许投稿
			if (!$priv_db->get_one(array('catid'=>$catid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) showmessage(L('category').L('publish_deny'), APP_PATH.'index.php?m=member');
			$category = $CATEGORYS[$catid];
			if($category['siteid']!=$siteid) showmessage(L('site_no_category'),'?m=member&c=content&a=publish');
			$setting = string2array($category['setting']);

			if($setting['presentpoint'] < 0 && $memberinfo['point'] < abs($setting['presentpoint']))
			showmessage(L('points_less_than',array('point'=>$memberinfo['point'],'need_point'=>abs($setting['presentpoint']))),APP_PATH.'index.php?m=pay&c=deposit&a=pay&exchange=point',3000);
			if($category['type']!=0) showmessage(L('illegal_operation'));
			$modelid = $category['modelid'];
			$model_arr = getcache('model', 'commons');
			$MODEL = $model_arr[$modelid];
			unset($model_arr);
	
			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form($modelid, $catid, $CATEGORYS);
			$forminfos_data = $content_form->get();
			$forminfos = array();
 			foreach($forminfos_data as $_fk=>$_fv) {
				if($_fv['isomnipotent']) continue;
				if($_fv['formtype']=='omnipotent') {
					foreach($forminfos_data as $_fm=>$_fm_value) {
						if($_fm_value['isomnipotent']) {
							$_fv['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$_fv['form']);
						}
					}
				}
				$forminfos[$_fk] = $_fv;
			}
			$formValidator = $content_form->formValidator;
			//去掉栏目id
			unset($forminfos['catid']);
			$workflowid = $setting['workflowid'];
			header("Cache-control: private");
			$template = $MODEL['member_add_template'] ? $MODEL['member_add_template'] : 'content_publish';
			include template('member', $template);
		}
	}
	
	public function published() {
		$memberinfo = $this->memberinfo;
		$sitelist = getcache('sitelist','commons');
		if(!isset($_GET['siteid']) && count($sitelist)>1) {
			include template('member', 'content_publish_select_model');
			exit;
		}
		$_username = $this->memberinfo['username'];
		$_userid = $this->memberinfo['userid'];
		$siteid = intval($_GET['siteid']);
		if(!$siteid) $siteid = 1;
		$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
		$siteurl = siteurl($siteid);
		$pagesize = 20;
		$page = max(intval($_GET['page']),1);
		$workflows = getcache('workflow_'.$siteid,'commons');	
		$this->content_check_db = pc_base::load_model('content_check_model');
		$infos = $this->content_check_db->listinfo(array('username'=>$_username, 'siteid'=>$siteid),'inputtime DESC',$page);
		$datas = array();
		foreach($infos as $_v) {
			$arr_checkid = explode('-',$_v['checkid']);
			$_v['id'] = $arr_checkid[1];
			$_v['modelid'] = $arr_checkid[2];
			$_v['url'] = $_v['status']==99 ? go($_v['catid'],$_v['id']) : APP_PATH.'index.php?m=content&c=index&a=show&catid='.$_v['catid'].'&id='.$_v['id'];
			if(!isset($setting[$_v['catid']])) $setting[$_v['catid']] = string2array($CATEGORYS[$_v['catid']]['setting']);
			$workflowid = $setting[$_v['catid']]['workflowid'];
			$_v['flag'] = $workflows[$workflowid]['flag'];
			$datas[] = $_v;
		}
 		$pages = $this->content_check_db->pages;
		include template('member', 'content_published');	
	}
	/**
	 * 编辑内容
	 */
	public function edit() {
		$_username = $this->memberinfo['username'];
		if(isset($_POST['dosubmit'])) {
			$catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
			$siteids = getcache('category_content', 'commons');
			$siteid = $siteids[$catid];
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$category = $CATEGORYS[$catid];
			if($category['type']==0) {
				$id = intval($_POST['id']);
				$catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
				$this->content_db = pc_base::load_model('content_model');
				$modelid = $category['modelid'];
				$this->content_db->set_model($modelid);
				//判断会员组投稿是否需要审核
				$memberinfo = $this->memberinfo;
				$grouplist = getcache('grouplist');
				$setting = string2array($category['setting']);
				if(!$grouplist[$memberinfo['groupid']]['allowpostverify'] || $setting['workflowid']) {
					$_POST['info']['status'] = 1;
				}
				$info = array();
				foreach($_POST['info'] as $_k=>$_v) {
					if($_k == 'content') {
						$_POST['info'][$_k] = strip_tags($_v, '<p><a><br><img><ul><li><div>');
					} elseif(in_array($_k, $fields)) {
						$_POST['info'][$_k] = new_html_special_chars(trim_script($_v));
					}
				}
				$_POST['linkurl'] = str_replace(array('"','(',')',",",' ','%'),'',new_html_special_chars(strip_tags($_POST['linkurl'])));
				$this->content_db->edit_content($_POST['info'],$id);
				$forward = $_POST['forward'];
				showmessage(L('update_success'),$forward);
			}
		} else {
			$show_header = $show_dialog = $show_validator = '';
			$temp_language = L('news','','content');
			//设置cookie 在附件添加处调用
			param::set_cookie('module', 'content');
			$id = intval($_GET['id']);
			if(isset($_GET['catid']) && $_GET['catid']) {
				$catid = $_GET['catid'] = intval($_GET['catid']);
				param::set_cookie('catid', $catid);
				$siteids = getcache('category_content', 'commons');
				$siteid = $siteids[$catid];
				$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
				$category = $CATEGORYS[$catid];
				if($category['type']==0) {
					$modelid = $category['modelid'];
					$this->model = getcache('model', 'commons');
					$this->content_db = pc_base::load_model('content_model');
					$this->content_db->set_model($modelid);
		
					$this->content_db->table_name = $this->content_db->db_tablepre.$this->model[$modelid]['tablename'];
					$r = $this->content_db->get_one(array('id'=>$id,'username'=>$_username,'sysadd'=>0));
		
					if(!$r) showmessage(L('illegal_operation'));
					if($r['status']==99) showmessage(L('has_been_verified'));
					$this->content_db->table_name = $this->content_db->table_name.'_data';
					$r2 = $this->content_db->get_one(array('id'=>$id));
					$data = array_merge($r,$r2);
					require CACHE_MODEL_PATH.'content_form.class.php';
					$content_form = new content_form($modelid,$catid,$CATEGORYS);
				
					$forminfos_data = $content_form->get($data);
					$forminfos = array();
					foreach($forminfos_data as $_fk=>$_fv) {
						if($_fv['isomnipotent']) continue;
						if($_fv['formtype']=='omnipotent') {
							foreach($forminfos_data as $_fm=>$_fm_value) {
								if($_fm_value['isomnipotent']) {
									$_fv['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$_fv['form']);
								}
							}
						}
						$forminfos[$_fk] = $_fv;
					}
					$formValidator = $content_form->formValidator;
				
					include template('member', 'content_publish');
				}
			}
			header("Cache-control: private");
			
		}
	}
	
	/**
	 * 
	 * 会员删除投稿 ...
	 */
	public function delete(){
		$id = intval($_GET['id']);
 		if(!$id){
			return false;
		}
 		//判断该文章是否待审，并且属于该会员
		$username = param::get_cookie('_username');
		$userid = param::get_cookie('_userid');
		$siteid = get_siteid();
		$catid = intval($_GET['catid']);
		$siteids = getcache('category_content', 'commons');
		$siteid = $siteids[$catid];
		$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
		$category = $CATEGORYS[$catid];
		if(!$category){
			showmessage(L('operation_failure'), HTTP_REFERER); 
 		}
		$modelid = $category['modelid'];
		$checkid = 'c-'.$id.'-'.$modelid;
 		$where = " checkid='$checkid' and username='$username' and status!=99 ";
		$check_pushed_db = pc_base::load_model('content_check_model');
 		$array = $check_pushed_db->get_one($where);
		if(!$array){
 			showmessage(L('operation_failure'), HTTP_REFERER); 
		}else{
			$content_db = pc_base::load_model('content_model');
			$content_db->set_model($modelid);
			$table_name = $content_db->table_name;
 			$content_db->delete_content($id); //删除文章
 			$check_pushed_db->delete(array('checkid'=>$checkid));//删除对应投稿表
			showmessage(L('operation_success'), HTTP_REFERER); 
		}
	}
	
	public function info_publish() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist');
		$SEO['title'] = L('info_publish','','info');
		//判断会员组是否允许投稿
		if(!$grouplist[$memberinfo['groupid']]['allowpost']) {
			showmessage(L('member_group').L('publish_deny'), HTTP_REFERER);
		}

		//判断每日投稿数
		$this->content_check_db = pc_base::load_model('content_check_model');
		$todaytime = strtotime(date('y-m-d',SYS_TIME));
		$_username = $memberinfo['username'];
		$allowpostnum = $this->content_check_db->count("`inputtime` > $todaytime AND `username`='$_username'");
		if($grouplist[$memberinfo['groupid']]['allowpostnum'] > 0 && $allowpostnum >= $grouplist[$memberinfo['groupid']]['allowpostnum']) {
			showmessage(L('allowpostnum_deny').$grouplist[$memberinfo['groupid']]['allowpostnum'], HTTP_REFERER);
		}
		
		$siteids = getcache('category_content', 'commons');
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			$catid = intval($_POST['info']['catid']);
			$siteid = $siteids[$catid];
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$category = $CATEGORYS[$catid];
			$modelid = $category['modelid'];
			if(!$modelid) showmessage(L('illegal_parameters'), HTTP_REFERER);
			$this->content_db = pc_base::load_model('content_model');
			$this->content_db->set_model($modelid);
			$table_name = $this->content_db->table_name;
			$fields_sys = $this->content_db->get_fields();
			$this->content_db->table_name = $table_name.'_data';
			
			$fields_attr = $this->content_db->get_fields();
			$fields = array_merge($fields_sys,$fields_attr);
			$fields = array_keys($fields);
			$info = array();
			foreach($_POST['info'] as $_k=>$_v) {
				if(in_array($_k, $fields)) $info[$_k] = $_v;
			}
			$post_fields = array_keys($_POST['info']);
			$post_fields = array_intersect_assoc($fields,$post_fields);
			$setting = string2array($category['setting']);
			if($setting['presentpoint'] < 0 && $memberinfo['point'] < abs($setting['presentpoint']))
			showmessage(L('points_less_than',array('point'=>$memberinfo['point'],'need_point'=>abs($setting['presentpoint']))),APP_PATH.'index.php?m=pay&c=deposit&a=pay&exchange=point',3000);
			
			//判断会员组投稿是否需要审核
			if($grouplist[$memberinfo['groupid']]['allowpostverify'] || !$setting['workflowid']) {
				$info['status'] = 99;
			} else {
				$info['status'] = 1;
			}
			$info['username'] = $memberinfo['username'];
			$this->content_db->siteid = $siteid;

			$id = $this->content_db->add_content($info);
			//检查投稿奖励或扣除积分
			$flag = $catid.'_'.$id;
			if($setting['presentpoint']>0) {
				pc_base::load_app_class('receipts','pay',0);
				receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
			} else {
				pc_base::load_app_class('spend','pay',0);
				spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
			}
			//缓存结果
			$model_cache = getcache('model','commons');
			$infos = array();
			foreach ($model_cache as $modelid=>$model) {
				if($model['siteid']==$siteid) {
					$datas = array();
					$this->content_db->set_model($modelid);
					$datas = $this->content_db->select(array('username'=>$memberinfo['username'],'sysadd'=>0),'id,catid,title,url,username,sysadd,inputtime,status',100,'id DESC');
				}
			}
			setcache('member_'.$memberinfo['userid'].'_'.$siteid, $infos,'content');
			//缓存结果 END
			if($info['status']==99) {
				showmessage(L('contributors_success'), APP_PATH.'index.php?m=member&c=content&a=info_top&id='.$id.'&catid='.$catid.'&msg=1');
			} else {
				showmessage(L('contributors_checked'), APP_PATH.'index.php?m=member&c=content&a=info_top&id='.$id.'&catid='.$catid.'&msg=1');
			}
			
		} else {		
			$show_header = $show_dialog = $show_validator = '';
			$step = $step_1 = $step_2 = $step_3 = $step_4;
			$temp_language = L('news','','content');
			$sitelist = getcache('sitelist','commons');
			/*
			if(!isset($_GET['siteid']) && count($sitelist)>1) {
				include template('member', 'content_publish_select_model');
				exit;
			}
			*/
			//设置cookie 在附件添加处调用
			param::set_cookie('module', 'content');
			$siteid = intval($_GET['siteid']);
			
			//获取信息模型类别、区域、城市信息
			$info_linkageid = getinfocache('info_linkageid');
			$cityid = getcity(trim($_GET['city']),'linkageid');
			$cityname = getcity(trim($_GET['city']),'name');			
			$citypinyin = getcity(trim($_GET['city']),'pinyin');			
			$zone = intval($_GET['zone']);
			$zone_name = get_linkage($zone, $info_linkageid, '', 0);
			
			if(!$siteid) $siteid = 1;
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$priv_db = pc_base::load_model('category_priv_model'); //加载栏目权限表数据模型
			foreach ($CATEGORYS as $catid=>$cat) {
				if($cat['siteid']==$siteid && $cat['child']==0 && $cat['type']==0 && $priv_db->get_one(array('catid'=>$catid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) break;
			}
			$catid = $_GET['catid'] ? intval($_GET['catid']) : $catid;
			if (!$catid) showmessage(L('category').L('publish_deny'), APP_PATH.'index.php?m=member');

			//判断本栏目是否允许投稿
			if (!$priv_db->get_one(array('catid'=>$catid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) showmessage(L('category').L('publish_deny'), APP_PATH.'index.php?m=member');
			$category = $CATEGORYS[$catid];
			if($category['siteid']!=$siteid) showmessage(L('site_no_category'),'?m=member&c=content&a=info_publish');
			$setting = string2array($category['setting']);
			if($zone == 0 && !isset($_GET['catid'])) {
				$step = 1;
				include template('member', 'info_content_publish_select');
				exit;
			} elseif($zone == 0 && $category['child']) {
				$step = 2;	
				$step_1 = '<a href="'.APP_PATH.'index.php?m=member&c=content&a=info_publish&siteid='.$siteid.'&city='.$citypinyin.'">'.$category['catname'].'</a>';
				include template('member', 'info_content_publish_select');
				exit;
			} elseif($zone == 0 && isset($_GET['catid'])) {
				$step = 3;	
				$step_1 = '<a href="'.APP_PATH.'index.php?m=member&c=content&a=info_publish&siteid='.$siteid.'">'.$CATEGORYS[$category['parentid']]['catname'].'</a>';
				$step_2 = '<a href="'.APP_PATH.'index.php?m=member&c=content&a=info_publish&siteid='.$siteid.'&city='.$citypinyin.'&catid='.$category['parentid'].'">'.$category['catname'].'</a>';			
				$zone_arrchild = show_linkage($info_linkageid,$cityid,$cityid);
				include template('member', 'info_content_publish_select');
				exit;
			} elseif($zone !== 0 && get_linkage_level($info_linkageid,$zone,'child') && !$_GET['jumpstep']) {
				$step = 4;				
				$step_1 = '<a href="'.APP_PATH.'index.php?m=member&c=content&a=info_publish&siteid='.$siteid.'&city='.$citypinyin.'">'.$CATEGORYS[$category['parentid']]['catname'].'</a>';	
				$step_2 = '<a href="'.APP_PATH.'index.php?m=member&c=content&a=info_publish&siteid='.$siteid.'&city='.$citypinyin.'&catid='.$category['parentid'].'">'.$category['catname'].'</a>';	
				$step_3 = '<a href="'.APP_PATH.'index.php?m=member&c=content&a=info_publish&siteid='.$siteid.'&city='.$citypinyin.'&catid='.$catid.'">'.$zone_name.'</a>';	
							
				$zone_arrchild = get_linkage_level($info_linkageid,$zone,'arrchildinfo');
				include template('member', 'info_content_publish_select');
				exit;				
			}
									
			if($setting['presentpoint'] < 0 && $memberinfo['point'] < abs($setting['presentpoint']))
			showmessage(L('points_less_than',array('point'=>$memberinfo['point'],'need_point'=>abs($setting['presentpoint']))),APP_PATH.'index.php?m=pay&c=deposit&a=pay&exchange=point',3000);
			if($category['type']!=0) showmessage(L('illegal_operation'));
			$modelid = $category['modelid'];

			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form($modelid, $catid, $CATEGORYS);
			
			$data = array('zone'=>$zone,'city'=>$cityid);
			$forminfos_data = $content_form->get($data);
			
			$forminfos = array();
			foreach($forminfos_data as $_fk=>$_fv) {
				if($_fv['isomnipotent']) continue;
				if($_fv['formtype']=='omnipotent') {
					foreach($forminfos_data as $_fm=>$_fm_value) {
						if($_fm_value['isomnipotent']) {
							$_fv['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$_fv['form']);
						}
					}
				}
				$forminfos[$_fk] = $_fv;
			}
			$formValidator = $content_form->formValidator;
			//去掉栏目id
			unset($forminfos['catid']);
			
			
			$workflowid = $setting['workflowid'];
			header("Cache-control: private");
			include template('member', 'info_content_publish');
		}
	}
	function info_top() {
		$exist_posids = array();
		$memberinfo = $this->memberinfo;
		$_username = $this->memberinfo['username'];
		$id = intval($_GET['id']);
		
		$catid = $_GET['catid'];
		$pos_data = pc_base::load_model('position_data_model');
		
		if(!$id || !$catid) showmessage(L('illegal_parameters'), HTTP_REFERER);	
		if(isset($catid) && $catid) {
			$siteids = getcache('category_content', 'commons');
			$siteid = $siteids[$catid];
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$category = $CATEGORYS[$catid];	
			if($category['type']==0) {
				$modelid = $category['modelid'];
				$this->model = getcache('model', 'commons');
				$this->content_db = pc_base::load_model('content_model');
				$this->content_db->set_model($modelid);				
				$this->content_db->table_name = $this->content_db->db_tablepre.$this->model[$modelid]['tablename'];
				$r = $this->content_db->get_one(array('id'=>$id,'username'=>$_username,'sysadd'=>0));
				if(!$r) showmessage(L('illegal_operation'));

				//再次重新赋值，以数据库为准
				$catid = $CATEGORYS[$r['catid']]['catid'];
				$modelid = $CATEGORYS[$catid]['modelid'];
				
				require_once CACHE_MODEL_PATH.'content_output.class.php';
				$content_output = new content_output($modelid,$catid,$CATEGORYS);
				$data = $content_output->get($r);
				extract($data);								
			}
		}
		//置顶推荐位数组
			$infos = getcache('info_setting','commons'); 
		$toptype_posid = array('1'=>$infos['top_city_posid'],
							   '2'=>$infos['top_zone_posid'],
							   '3'=>$infos['top_district_posid'],
							  );
		foreach($toptype_posid as $_k => $_v) {
			if($pos_data->get_one(array('id'=>$id,'catid'=>$catid,'posid'=>$_v))) {
				$exist_posids[$_k] = 1;
			}			
		}
		include template('member', 'info_top');
	}
	function info_top_cost() {
		$amount = $msg = '';
		$memberinfo = $this->memberinfo;
		$_username = $this->memberinfo['username'];	
		$_userid = $this->memberinfo['userid'];	
		$infos = getcache('info_setting','commons');
		$toptype_arr = array(1,2,3);
		//置顶积分数组
		$toptype_price = array('1'=>$infos['top_city'],
							   '2'=>$infos['top_zone'],
							   '3'=>$infos['top_district'],
							  );
		//置顶推荐位数组					  
		$toptype_posid = array('1'=>$infos['top_city_posid'],
							   '2'=>$infos['top_zone_posid'],
							   '3'=>$infos['top_district_posid'],
							  );							  				
		if(isset($_POST['dosubmit'])) {
			$posids = array();
			$push_api = pc_base::load_app_class('push_api','admin');
			$pos_data = pc_base::load_model('position_data_model');
			$catid = intval($_POST['catid']);
			$id = intval($_POST['id']);
			$flag = $catid.'_'.$id;			
			$toptime = intval($_POST['toptime']);
			if($toptime == 0 || empty($_POST['toptype'])) showmessage(L('info_top_not_setting_toptime'));
			//计算置顶扣费积分，时间
			if(is_array($_POST['toptype']) && !empty($_POST['toptype'])) {
				foreach($_POST['toptype'] as $r) {
					if(is_numeric($r) && in_array($r, $toptype_arr)) {
						$posids[] = $toptype_posid[$r];
						$amount += $toptype_price[$r];
						$msg .= $r.'-';
					}				
				}
			}
			//应付总积分
			$amount = $amount * $toptime;
				
			//扣除置顶点数		
			pc_base::load_app_class('spend','pay',0);
			$pay_status = spend::point($amount, L('info_top').$msg, $_userid, $_username, '', '', $flag);
			if($pay_status == false) {
				$msg = spend::get_msg();
				showmessage($msg);
			}
			//置顶过期时间
			//TODO
			$expiration = SYS_TIME + $toptime * 3600;

			//获取置顶文章信息内容
			if(isset($catid) && $catid) {
				$siteids = getcache('category_content', 'commons');
				$siteid = $siteids[$catid];
				$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
				$category = $CATEGORYS[$catid];	
				if($category['type']==0) {
					$modelid = $category['modelid'];
					$this->model = getcache('model', 'commons');
					$this->content_db = pc_base::load_model('content_model');
					$this->content_db->set_model($modelid);				
					$this->content_db->table_name = $this->content_db->db_tablepre.$this->model[$modelid]['tablename'];
					$r = $this->content_db->get_one(array('id'=>$id,'username'=>$_username,'sysadd'=>0));							
				}
			}
			if(!$r) showmessage(L('illegal_operation'));	
			
			$push_api->position_update($id, $modelid, $catid, $posids, $r, $expiration, 1);	
			$refer = $_POST['msg'] ? $r['url'] : '';
			if($_POST['msg']) showmessage(L('ding_success'),$refer);
			else showmessage(L('ding_success'), '', '', 'top');
			
		} else {	
				
			$toptype = trim($_POST['toptype']);
			$toptime = trim($_POST['toptime']);
			$types = explode('_', $toptype);
			if(is_array($types) && !empty($types)) {
				foreach($types as $r) {
					if(is_numeric($r) && in_array($r, $toptype_arr)) {
						$amount += $toptype_price[$r];
					}				
				}
			}
			$amount = $amount * $toptime;
			echo $amount;
		}
	}		
	/**
	 * 初始化phpsso
	 * about phpsso, include client and client configure
	 * @return string phpsso_api_url phpsso地址
	 */
	private function _init_phpsso() {
		pc_base::load_app_class('client', '', 0);
		define('APPID', pc_base::load_config('system', 'phpsso_appid'));
		$phpsso_api_url = pc_base::load_config('system', 'phpsso_api_url');
		$phpsso_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$this->client = new client($phpsso_api_url, $phpsso_auth_key);
		return $phpsso_api_url;
	}
	
	/**
	 * Function UPLOAD_VIDEO
	 * 用户上传视频
	 */
	public function upload_video() {
		
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist');
		//判断会员组是否允许投稿
		if(!$grouplist[$memberinfo['groupid']]['allowpost']) {
			showmessage(L('member_group').L('publish_deny'), HTTP_REFERER);
		}
		//判断每日投稿数
		$this->content_check_db = pc_base::load_model('content_check_model');
		$todaytime = strtotime(date('y-m-d',SYS_TIME));
		$_username = $this->memberinfo['username'];
		$allowpostnum = $this->content_check_db->count("`inputtime` > $todaytime AND `username`='$_username'");
		if($grouplist[$memberinfo['groupid']]['allowpostnum'] > 0 && $allowpostnum >= $grouplist[$memberinfo['groupid']]['allowpostnum']) {
			showmessage(L('allowpostnum_deny').$grouplist[$memberinfo['groupid']]['allowpostnum'], HTTP_REFERER);
		}
		//加载视频库配置信息 
		pc_base::load_app_class('ku6api', 'video', 0);
		$setting = getcache('video', 'video');
		if(empty($setting)) {
			showmessage('上传功能还在开发中，请稍后重试！');
		}
		$ku6api = new ku6api($setting['sn'], $setting['skey']);
		if (isset($_POST['dosubmit'])) {
			$_POST['info']['catid'] = isset($_POST['info']['catid']) ? intval($_POST['info']['catid']) : showmessage('请选择栏目！');
			$_POST['info']['title'] = isset($_POST['info']['title']) ? safe_replace($_POST['info']['title']) : showmessage('标题不能为空！');
			$_POST['info']['keywords'] = isset($_POST['info']['keywords']) ? safe_replace($_POST['info']['keywords']) : '';
			$_POST['info']['description'] = isset($_POST['info']['description']) ? safe_replace($_POST['info']['description']) : '';
			//查询此模型下的视频字段
			$field = get_video_field($_POST['info']['catid']);
			if (!$field) showmessage('上传功能还在开发中，请稍后重试！');
			$_POST['info'][$field] = 1;
			$_POST[$field.'_video'] = array(1=>array('title'=>$_POST['info']['title'], 'vid' => $_POST['vid'], 'listorder'=>1)); 
			unset($_POST['vid']);
			$this->publish();
		} else {
			$categorys = video_categorys();
			if (is_array($categorys) && !empty($categorys)) {
				$cat = array();
				$priv_db = pc_base::load_model('category_priv_model'); //加载栏目权限表数据模型
				foreach ($categorys as $cid=>$c) {
					if($c['child']==0 && $c['type']==0 && !$priv_db->get_one(array('catid'=>$cid, 'roleid'=>$memberinfo['groupid'], 'is_admin'=>0, 'action'=>'add'))) unset($categorys[$cid]);
				}
				if (empty($categorys)) showmessage(L('category').L('publish_deny'), APP_PATH.'index.php?m=member');
				foreach ($categorys as $cid => $c) {
					if ($c['child']) {
						$ischild = 1;
						$categorys[$cid]['disabled'] = 'disabled';
					}
					$cat[$cid] = $c['catname'];
				}
				if (!$ischild) {
					$cat_list = form::radio($cat, '', 'name="info[catid]"', '90');
				} else {
					$tree = pc_base::load_sys_class('tree');
					$str  = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";

					$tree->init($categorys);
					$string = $tree->get_tree(0, $str);
					$cat_list = '<select name="info[catid]" id="catid"><option value="0">请选择栏目</option>'.$string.'</select>';
				}
			}
			$flash_info = $ku6api->flashuploadparam(); //加载视频上传工具信息
			
			include template('member', 'upload_video');
		}
	}
}
?>