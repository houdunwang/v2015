<?php
defined('IN_PHPCMS') or exit('No permission resources.');
if(!defined('CACHE_MODEL_PATH')) define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

/**
 * 内容模型数据库操作类
 */
pc_base::load_sys_class('model', '', 0);
class content_model extends model {
	public $table_name = '';
	public $category = '';
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		parent::__construct();
		$this->url = pc_base::load_app_class('url', 'content');
		$this->siteid = get_siteid();
	}
	public function set_model($modelid) {
		$this->model = getcache('model', 'commons');
		$this->modelid = $modelid;
		$this->table_name = $this->db_tablepre.$this->model[$modelid]['tablename'];
		$this->model_tablename = $this->model[$modelid]['tablename'];
	}
	/**
	 * 添加内容
	 * 
	 * @param $datas
	 * @param $isimport 是否为外部接口导入
	 */
	public function add_content($data,$isimport = 0) {
		if($isimport) $data = new_addslashes($data);
		$this->search_db = pc_base::load_model('search_model');
		$modelid = $this->modelid;
		require_once CACHE_MODEL_PATH.'content_input.class.php';
        require_once CACHE_MODEL_PATH.'content_update.class.php';
		$content_input = new content_input($this->modelid);
		$inputinfo = $content_input->get($data,$isimport);

		$systeminfo = $inputinfo['system'];
		$modelinfo = $inputinfo['model'];

		if($data['inputtime'] && !is_numeric($data['inputtime'])) {
			$systeminfo['inputtime'] = strtotime($data['inputtime']);
		} elseif(!$data['inputtime']) {
			$systeminfo['inputtime'] = SYS_TIME;
		} else {
			$systeminfo['inputtime'] = $data['inputtime'];
		}
		
		//读取模型字段配置中，关于日期配置格式，来组合日期数据
		$this->fields = getcache('model_field_'.$modelid,'model');
		$setting = string2array($this->fields['inputtime']['setting']);
		extract($setting);
		if($fieldtype=='date') {
			$systeminfo['inputtime'] = date('Y-m-d');
		}elseif($fieldtype=='datetime'){
 			$systeminfo['inputtime'] = date('Y-m-d H:i:s');
		}

		if($data['updatetime'] && !is_numeric($data['updatetime'])) {
			$systeminfo['updatetime'] = strtotime($data['updatetime']);
		} elseif(!$data['updatetime']) {
			$systeminfo['updatetime'] = SYS_TIME;
		} else {
			$systeminfo['updatetime'] = $data['updatetime'];
		}
		$inputinfo['system']['username'] = $systeminfo['username'] = $data['username'] ? $data['username'] : param::get_cookie('admin_username');
		$systeminfo['sysadd'] = defined('IN_ADMIN') ? 1 : 0;
		
		//自动提取摘要
		if(isset($_POST['add_introduce']) && $systeminfo['description'] == '' && isset($modelinfo['content'])) {
			$content = stripslashes($modelinfo['content']);
			$introcude_length = intval($_POST['introcude_length']);
			$systeminfo['description'] = str_cut(str_replace(array("'","\r\n","\t",'[page]','[/page]','&ldquo;','&rdquo;','&nbsp;'), '', strip_tags($content)),$introcude_length);
			$inputinfo['system']['description'] = $systeminfo['description'] = addslashes($systeminfo['description']);
		}
		//自动提取缩略图
		if(isset($_POST['auto_thumb']) && $systeminfo['thumb'] == '' && isset($modelinfo['content'])) {
			$content = $content ? $content : stripslashes($modelinfo['content']);
			$auto_thumb_no = intval($_POST['auto_thumb_no'])-1;
			if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
				$systeminfo['thumb'] = $matches[3][$auto_thumb_no];
			}
		}
		$systeminfo['description'] = str_replace(array('/','\\','#','.',"'"),' ',$systeminfo['description']);
		$systeminfo['keywords'] = str_replace(array('/','\\','#','.',"'"),' ',$systeminfo['keywords']);
		
		//主表
		$tablename = $this->table_name = $this->db_tablepre.$this->model_tablename;
		$id = $modelinfo['id'] = $this->insert($systeminfo,true);
		$this->update($systeminfo,array('id'=>$id));
		//更新URL地址
		if($data['islink']==1) {
			$urls[0] = trim_script($_POST['linkurl']);
			$urls[0] = remove_xss($urls[0]);
			
			$urls[0] = str_replace(array('select ',')','\\','#',"'"),' ',$urls[0]);
		} else {
			$urls = $this->url->show($id, 0, $systeminfo['catid'], $systeminfo['inputtime'], $data['prefix'],$inputinfo,'add');
		}
		$this->table_name = $tablename;
		$this->update(array('url'=>$urls[0]),array('id'=>$id));
		//附属表
		$this->table_name = $this->table_name.'_data';
		$this->insert($modelinfo);
		//添加统计
		$this->hits_db = pc_base::load_model('hits_model');
		$hitsid = 'c-'.$modelid.'-'.$id;
		$this->hits_db->insert(array('hitsid'=>$hitsid,'catid'=>$systeminfo['catid'],'updatetime'=>SYS_TIME));
		if($data['status']==99) {
			//更新到全站搜索
			$this->search_api($id,$inputinfo);
		}
		//更新栏目统计数据
		$this->update_category_items($systeminfo['catid'],'add',1);
		//调用 update
		$content_update = new content_update($this->modelid,$id);
		//合并后，调用update
		$merge_data = array_merge($systeminfo,$modelinfo);
		$merge_data['posids'] = $data['posids'];
		$content_update->update($merge_data);
		
		//发布到审核列表中
		if(!defined('IN_ADMIN') || $data['status']!=99) {
			$this->content_check_db = pc_base::load_model('content_check_model');
			$check_data = array(
				'checkid'=>'c-'.$id.'-'.$modelid,
				'catid'=>$systeminfo['catid'],
				'siteid'=>$this->siteid,
				'title'=>$systeminfo['title'],
				'username'=>$systeminfo['username'],
				'inputtime'=>$systeminfo['inputtime'],
				'status'=>$data['status'],
				);
			$this->content_check_db->insert($check_data);
		}
		//END发布到审核列表中
		if(!$isimport) {
			$html = pc_base::load_app_class('html', 'content');
			$urls['data']['system']['id'] = $id;
			if($urls['content_ishtml'] && $data['status']==99) $html->show($urls[1],$urls['data']);
			$catid = $systeminfo['catid'];
		}
		//发布到其他栏目
		if($id && isset($_POST['othor_catid']) && is_array($_POST['othor_catid'])) {
			$linkurl = $urls[0];
			$r = $this->get_one(array('id'=>$id));
			foreach ($_POST['othor_catid'] as $cid=>$_v) {
				$this->set_catid($cid);
				$mid = $this->category[$cid]['modelid'];
				if($modelid==$mid) {
					//相同模型的栏目插入新的数据
					$inputinfo['system']['catid'] = $systeminfo['catid'] = $cid;
					$newid = $modelinfo['id'] = $this->insert($systeminfo,true);
					$this->table_name = $tablename.'_data';
					$this->insert($modelinfo);
					if($data['islink']==1) {
						$urls = $_POST['linkurl'];
						$urls = str_replace(array('select ',')','\\','#',"'"),' ',$urls);
					} else {
						$urls = $this->url->show($newid, 0, $cid, $systeminfo['inputtime'], $data['prefix'],$inputinfo,'add');
					}
					$this->table_name = $tablename;
					$this->update(array('url'=>$urls[0]),array('id'=>$newid));
					//发布到审核列表中
					if($data['status']!=99) {
						$check_data = array(
							'checkid'=>'c-'.$newid.'-'.$mid,
							'catid'=>$cid,
							'siteid'=>$this->siteid,
							'title'=>$systeminfo['title'],
							'username'=>$systeminfo['username'],
							'inputtime'=>$systeminfo['inputtime'],
							'status'=>1,
							);
						$this->content_check_db->insert($check_data);
					}
					if($urls['content_ishtml'] && $data['status']==99) $html->show($urls[1],$urls['data']);
				} else {
					//不同模型插入转向链接地址
					$newid = $this->insert(
					array('title'=>$systeminfo['title'],
						'style'=>$systeminfo['style'],
						'thumb'=>$systeminfo['thumb'],
						'keywords'=>$systeminfo['keywords'],
						'description'=>$systeminfo['description'],
						'status'=>$systeminfo['status'],
						'catid'=>$cid,'url'=>$linkurl,
						'sysadd'=>1,
						'username'=>$systeminfo['username'],
						'inputtime'=>$systeminfo['inputtime'],
						'updatetime'=>$systeminfo['updatetime'],
						'islink'=>1
					),true);
					$this->table_name = $this->table_name.'_data';
					$this->insert(array('id'=>$newid));
					//发布到审核列表中
					if($data['status']!=99) {
						$check_data = array(
							'checkid'=>'c-'.$newid.'-'.$mid,
							'catid'=>$systeminfo['catid'],
							'siteid'=>$this->siteid,
							'title'=>$systeminfo['title'],
							'username'=>$systeminfo['username'],
							'inputtime'=>$systeminfo['inputtime'],
							'status'=>1,
							);
						$this->content_check_db->insert($check_data);
					}
				}
				$hitsid = 'c-'.$mid.'-'.$newid;
				$this->hits_db->insert(array('hitsid'=>$hitsid,'catid'=>$cid,'updatetime'=>SYS_TIME));
			}
		}
		//END 发布到其他栏目
		//更新附件状态
		if(pc_base::load_config('system','attachment_stat')) {
			$this->attachment_db = pc_base::load_model('attachment_model');
			$this->attachment_db->api_update('','c-'.$systeminfo['catid'].'-'.$id,2);
		}
		//生成静态
		if(!$isimport && $data['status']==99) {
			//在添加和修改内容处定义了 INDEX_HTML
			if(defined('INDEX_HTML')) $html->index();
			if(defined('RELATION_HTML')) $html->create_relation_html($catid);
		}
		return $id;
	}
	/**
	 * 修改内容
	 * 
	 * @param $datas
	 */
	public function edit_content($data,$id) {
		$model_tablename = $this->model_tablename;
		//前台权限判断
		if(!defined('IN_ADMIN')) {
			$_username = param::get_cookie('_username');
			$us = $this->get_one(array('id'=>$id,'username'=>$_username));
			if(!$us) return false;
		}
		
		$this->search_db = pc_base::load_model('search_model');
													
		require_once CACHE_MODEL_PATH.'content_input.class.php';
        require_once CACHE_MODEL_PATH.'content_update.class.php';
		$content_input = new content_input($this->modelid);
		$inputinfo = $content_input->get($data);

		$systeminfo = $inputinfo['system'];
		$modelinfo = $inputinfo['model'];
		if($data['inputtime'] && !is_numeric($data['inputtime'])) {
			$systeminfo['inputtime'] = strtotime($data['inputtime']);
		} elseif(!$data['inputtime']) {
			$systeminfo['inputtime'] = SYS_TIME;
		} else {
			$systeminfo['inputtime'] = $data['inputtime'];
		}
		
		if($data['updatetime'] && !is_numeric($data['updatetime'])) {
			$systeminfo['updatetime'] = strtotime($data['updatetime']);
		} elseif(!$data['updatetime']) {
			$systeminfo['updatetime'] = SYS_TIME;
		} else {
			$systeminfo['updatetime'] = $data['updatetime'];
		}
		//自动提取摘要
		if(isset($_POST['add_introduce']) && $systeminfo['description'] == '' && isset($modelinfo['content'])) {
			$content = stripslashes($modelinfo['content']);
			$introcude_length = intval($_POST['introcude_length']);
			$systeminfo['description'] = str_cut(str_replace(array("\r\n","\t",'[page]','[/page]','&ldquo;','&rdquo;','&nbsp;'), '', strip_tags($content)),$introcude_length);
			$inputinfo['system']['description'] = $systeminfo['description'] = addslashes($systeminfo['description']);
		}
		//自动提取缩略图
		if(isset($_POST['auto_thumb']) && $systeminfo['thumb'] == '' && isset($modelinfo['content'])) {
			$content = $content ? $content : stripslashes($modelinfo['content']);
			$auto_thumb_no = intval($_POST['auto_thumb_no'])-1;
			if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
				$systeminfo['thumb'] = $matches[3][$auto_thumb_no];
			}
		}
		if($data['islink']==1) {
			$systeminfo['url'] = $_POST['linkurl'];
			$systeminfo['url'] = str_replace(array('select ',')','\\','#',"'"),' ',$systeminfo['url']);
		} else {
			//更新URL地址
			$urls = $this->url->show($id, 0, $systeminfo['catid'], $systeminfo['inputtime'], $data['prefix'],$inputinfo,'edit');
			$systeminfo['url'] = $urls[0];
		}
		$systeminfo['description'] = str_replace(array('/','\\','#','.',"'"),' ',$systeminfo['description']);
		$systeminfo['keywords'] = str_replace(array('/','\\','#','.',"'"),' ',$systeminfo['keywords']);
		//主表
		$this->table_name = $this->db_tablepre.$model_tablename;
		$this->update($systeminfo,array('id'=>$id));

		//附属表
		$this->table_name = $this->table_name.'_data';
		$this->update($modelinfo,array('id'=>$id));
		$this->search_api($id,$inputinfo);
		//调用 update
		$content_update = new content_update($this->modelid,$id);
		$content_update->update($data);
		//更新附件状态
		if(pc_base::load_config('system','attachment_stat')) {
			$this->attachment_db = pc_base::load_model('attachment_model');
			$this->attachment_db->api_update('','c-'.$systeminfo['catid'].'-'.$id,2);
		}
		//更新审核列表
		$this->content_check_db = pc_base::load_model('content_check_model');
		$check_data = array(
			'catid'=>$systeminfo['catid'],
			'siteid'=>$this->siteid,
			'title'=>$systeminfo['title'],
			'status'=>$systeminfo['status'],
			);
		if(!isset($systeminfo['status'])) unset($check_data['status']);
		$this->content_check_db->update($check_data,array('checkid'=>'c-'.$id.'-'.$this->modelid));
		//生成静态
		$html = pc_base::load_app_class('html', 'content');
		if($urls['content_ishtml']) {
			$html->show($urls[1],$urls['data']);
		}
		//在添加和修改内容处定义了 INDEX_HTML
		if(defined('INDEX_HTML')) $html->index();
		if(defined('RELATION_HTML')) $html->create_relation_html($systeminfo['catid']);
		return true;
	}
	
	public function status($ids = array(), $status = 99) {
		$this->content_check_db = pc_base::load_model('content_check_model');
		$this->message_db = pc_base::load_model('message_model');
		$this->set_model($this->modelid);
		if(is_array($ids) && !empty($ids)) {
			foreach($ids as $id) {
				$this->update(array('status'=>$status),array('id'=>$id));
				$del = false;
				$r = $this->get_one(array('id'=>$id));
				if($status==0) {
				//退稿发送短消息、邮件
					$message = L('reject_message_tips').$r['title']."<BR><a href=\'index.php?m=member&c=content&a=edit&catid={$r[catid]}&id={$r[id]}\'><font color=red>".L('click_edit')."</font></a><br>";
					if(isset($_POST['reject_c']) && $_POST['reject_c'] != L('reject_msg')) {
						$message .= $_POST['reject_c'];
					} elseif(isset($_GET['reject_c']) && $_GET['reject_c'] != L('reject_msg')) {
						$message .= $_GET['reject_c'];
					}
					$this->message_db->add_message($r['username'],'SYSTEM',L('reject_message'),$message);
				} elseif($status==99 && $r['sysadd']) {
					$this->content_check_db->delete(array('checkid'=>'c-'.$id.'-'.$this->modelid));
					$del = true;
				}
				if(!$del) $this->content_check_db->update(array('status'=>$status),array('checkid'=>'c-'.$id.'-'.$this->modelid));
			}
		} else {
			$this->update(array('status'=>$status),array('id'=>$ids));
			$del = false;
			$r = $this->get_one(array('id'=>$ids));
			if($status==0) {
				//退稿发送短消息、邮件
				$message = L('reject_message_tips').$r['title']."<BR><a href=\'index.php?m=member&c=content&a=edit&catid={$r[catid]}&id={$r[id]}\'><font color=red>".L('click_edit')."</font></a><br>";
				if(isset($_POST['reject_c']) && $_POST['reject_c'] != L('reject_msg')) {
					$message .= $_POST['reject_c'];
				} elseif(isset($_GET['reject_c']) && $_GET['reject_c'] != L('reject_msg')) {
					$message .= $_GET['reject_c'];
				}
				$this->message_db->add_message($r['username'],'SYSTEM',L('reject_message'),$message);
			} elseif($status==99 && $r['sysadd']) {
				$this->content_check_db->delete(array('checkid'=>'c-'.$ids.'-'.$this->modelid));
				$del = true;
			}
			if(!$del) $this->content_check_db->update(array('status'=>$status),array('checkid'=>'c-'.$ids.'-'.$this->modelid));
		}
		return true;
	}
	/**
	 * 删除内容
	 * @param $id 内容id
	 * @param $file 文件路径
	 * @param $catid 栏目id
	 */
	public function delete_content($id,$file,$catid = 0) {
		//删除主表数据
		$this->delete(array('id'=>$id));
		//删除从表数据
		$this->table_name = $this->table_name.'_data';
		$this->delete(array('id'=>$id));
		//重置默认表
		$this->table_name = $this->db_tablepre.$this->model_tablename;
		//更新栏目统计
		$this->update_category_items($catid,'delete');
	}
	
	
	public function search_api($id = 0, $data = array(), $action = 'update') {
		$type_arr = getcache('search_model_'.$this->siteid,'search');
		$typeid = $type_arr[$this->modelid]['typeid'];
		if($action == 'update') {
			$fulltext_array = getcache('model_field_'.$this->modelid,'model');
			foreach($fulltext_array AS $key=>$value){
				if($value['isfulltext']) {
					$fulltextcontent .= $data['system'][$key] ? $data['system'][$key] : $data['model'][$key];
				}
			}
			$this->search_db->update_search($typeid ,$id, $fulltextcontent,addslashes($data['system']['title']).' '.addslashes($data['system']['keywords']),$data['system']['inputtime']);
		} elseif($action == 'delete') {
			$this->search_db->delete_search($typeid ,$id);
		}
	}
	/**
	 * 获取单篇信息
	 * 
	 * @param $catid
	 * @param $id
	 */
	public function get_content($catid,$id) {
		$catid = intval($catid);
		$id = intval($id);
		if(!$catid || !$id) return false;
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$this->category = getcache('category_content_'.$siteid,'commons');
		if(isset($this->category[$catid]) && $this->category[$catid]['type'] == 0) {
			$modelid = $this->category[$catid]['modelid'];
			$this->set_model($modelid);
			$r = $this->get_one(array('id'=>$id));
			//附属表
			$this->table_name = $this->table_name.'_data';
			$r2 = $this->get_one(array('id'=>$id));
			if($r2) {
				return array_merge($r,$r2);
			} else {
				return $r;
			}
		}
		return true;
	}
	/**
	 * 设置catid 所在的模型数据库
	 * 
	 * @param $catid
	 */
	public function set_catid($catid) {
		$catid = intval($catid);
		if(!$catid) return false;
		if(empty($this->category) || empty($this->category[$catid])) {
			$siteids = getcache('category_content','commons');
			$siteid = $siteids[$catid];
			$this->category = getcache('category_content_'.$siteid,'commons');
		}
		if(isset($this->category[$catid]) && $this->category[$catid]['type'] == 0) {
			$modelid = $this->category[$catid]['modelid'];
			$this->set_model($modelid);
		}
	}
	
	private function update_category_items($catid,$action = 'add',$cache = 0) {
		$this->category_db = pc_base::load_model('category_model');
		if($action=='add') {
			$this->category_db->update(array('items'=>'+=1'),array('catid'=>$catid));
		}  else {
			$this->category_db->update(array('items'=>'-=1'),array('catid'=>$catid));
		}
		if($cache) $this->cache_items();
	}
	
	public function cache_items() {
		$datas = $this->category_db->select(array('modelid'=>$this->modelid),'catid,type,items',10000);
		$array = array();
		foreach ($datas as $r) {
			if($r['type']==0) $array[$r['catid']] = $r['items'];
		}
		setcache('category_items_'.$this->modelid, $array,'commons');
	}
}
?>