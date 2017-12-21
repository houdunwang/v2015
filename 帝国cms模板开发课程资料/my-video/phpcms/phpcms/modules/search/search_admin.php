<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
class search_admin extends admin {
	function __construct() {
		parent::__construct();
		$this->siteid = $this->get_siteid();
		$this->db = pc_base::load_model('search_model');
		$this->module_db = pc_base::load_model('module_model');
		$this->type_db = pc_base::load_model('type_model');
	}

	public function setting() {
		$siteid = get_siteid();
		if(isset($_POST['dosubmit'])) {
			//合并数据库缓存与新提交缓存
			$r = $this->module_db->get_one(array('module'=>'search'));
			$search_setting = string2array($r['setting']);
			
			$search_setting[$siteid] = $_POST['setting'];
			$setting = array2string($search_setting);
			setcache('search', $search_setting);
			$this->module_db->update(array('setting'=>$setting),array('module'=>'search'));
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$r = $this->module_db->get_one(array('module'=>'search'));
			$setting = string2array($r['setting']);
			if($setting[$siteid]){
				extract($setting[$siteid]);
			}
			
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=search&c=search_type&a=add\', title:\''.L('add_search_type').'\', width:\'580\', height:\'240\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_search_type'));
			include $this->admin_tpl('setting');
		}
	}
	/**
	 * 创建索引
	 */
	public function createindex() {
		if(isset($_GET['dosubmit'])) {
			//重建索引首先清空表所有数据，然后根据搜索类型接口重新全部重建索引
			if(!isset($_GET['have_truncate'])) {
				$db_tablepre = $this->db->db_tablepre;
				//删除该站点全文索引
				$this->db->delete(array('siteid'=>$this->siteid));
				
				$types = $this->type_db->select(array('siteid'=> $this->siteid,'module'=>'search'));
				setcache('search_types',$types, 'search');
			} else{
				$types = getcache('search_types', 'search');
			}
			//$key typeid 的索引
			$key = isset($_GET['key']) ? intval($_GET['key']) : 0;
			foreach ($types as $_k=>$_v) {
				if($key==$_k) {
					$typeid = $_v['typeid'];
					if($_v['modelid']) {
						if ($_v['typedir']!=='yp') {
							$search_api = pc_base::load_app_class('search_api','content');
						} else {
							$search_api = pc_base::load_app_class('search_api',$_v['typedir']);
						}
						if(!isset($_GET['total'])) {
							$total = $search_api->total($_v['modelid']);
						} else {
							$total = intval($_GET['total']);
							$search_api->set_model($_v['modelid']);
						}
					} else {
						$module = trim($_v['typedir']);
						$search_api = pc_base::load_app_class('search_api',$module);
						if(!isset($_GET['total'])) {
							$total = $search_api->total();
						} else {
							$total = intval($_GET['total']);
						}
					}

					$pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 50;
					$page = max(intval($_GET['page']), 1);
					$pages = ceil($total/$pagesize);
				
					$datas = $search_api->fulltext_api($pagesize,$page);
					foreach ($datas as $id=>$r) {
						$this->db->update_search($typeid ,$id, $r['fulltextcontent'],$r['title'],$r['adddate'], 1);
					}
					$page++;
					if($pages>=$page) showmessage("正在更新 <span style='color:#ff0000;font-size:14px;text-decoration:underline;' >{$_v['name']}</span> - 总数：{$total} - 当前第 <font color='red'>{$page}</font> 页","?m=search&c=search_admin&a=createindex&menuid=909&page={$page}&total={$total}&key={$key}&pagesize={$pagesize}&have_truncate=1&dosubmit=1");
					$key++;
					showmessage("开始更新： <span style='color:#ff0000;font-size:14px;text-decoration:underline;' >{$_v['name']}</span> - 总数：{$total}条","?m=search&c=search_admin&a=createindex&menuid=909&page=1&key={$key}&pagesize={$pagesize}&have_truncate=1&dosubmit=1");
				
				}
			}
			showmessage('全站索引更新完成','blank');
		} else {
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=search&c=search_type&a=add\', title:\''.L('add_search_type').'\', width:\'580\', height:\'240\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_search_type'));
			include $this->admin_tpl('createindex');
		}
	}
	
	public function public_test_sphinx() {
		$sphinxhost = !empty($_POST['sphinxhost']) ? $_POST['sphinxhost'] : exit('-1');
		$sphinxport = !empty($_POST['sphinxport']) ? intval($_POST['sphinxport']) : exit('-2');
		$fp = @fsockopen($sphinxhost, $sphinxport, $errno, $errstr , 2);
		if (!$fp) {
			exit($errno.':'.$errstr);
		} else {
			exit('1');
		}
	}
	
}
?>