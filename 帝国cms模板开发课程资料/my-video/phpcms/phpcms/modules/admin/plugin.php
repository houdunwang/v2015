<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_func('plugin');
class plugin extends admin {
	private $db,$db_var;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('plugin_model');
		$this->db_var = pc_base::load_model('plugin_var_model');
		pc_base::load_app_func('global');
	}
	
	/**
	 * 应用配置信息
	 */
	public function init() {
		$show_validator = true;
		$show_dialog = true;
		if($pluginfo = $this->db->select('','*','','disable DESC,listorder DESC')) {
			foreach ($pluginfo as $_k=>$_r) {
				if(file_exists(PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$_r['dir'].DIRECTORY_SEPARATOR.$_r['dir'].'.class.php')){
					$pluginfo[$_k]['url'] = 'plugin.php?id='.$_r['dir'];
				} else {
					$pluginfo[$_k]['url'] = '';
				}
  			 	$pluginfo[$_k]['dir'] = $_r['dir'].'/';	
			}		
		}
		
		include $this->admin_tpl('plugin_list');
	}
	
	/**
	 * 应用导入\安装
	 */
	 
	public function import() {
		if(!isset($_GET['dir'])) {
			$plugnum = 1;
			$installsdir = array();
			if($installs_pluginfo = $this->db->select()) {
				foreach ($installs_pluginfo as $_r) {
	  			 	$installsdir[] = $_r['dir'];	
				}		
			}	
			$pluginsdir = dir(PC_PATH.'plugin');
			while (false !== ($entry = $pluginsdir->read())) {
				$config_file = '';
				$plugin_data = array();
				if(!in_array($entry, array('.', '..')) && is_dir(PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$entry) && !in_array($entry, $installsdir) && !$this->db->get_one(array('identification'=>$entry))) {
					$config_file = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$entry.DIRECTORY_SEPARATOR.'plugin_'.$entry.'.cfg.php';
					if(file_exists($config_file)) {
						$plugin_data = @require($config_file);					
		  			 	$pluginfo[$plugnum]['name'] = $plugin_data['plugin']['name'];
		  			 	$pluginfo[$plugnum]['version'] = $plugin_data['plugin']['version'];
		  			 	$pluginfo[$plugnum]['copyright'] = $plugin_data['plugin']['copyright'];
		  			 	$pluginfo[$plugnum]['dir'] = $entry;
		  			 	$plugnum++;
					}
				}
			}		
			include $this->admin_tpl('plugin_list_import');
		} else {
			$dir = trim($_GET['dir']);
			$license = 0;
			$config_file = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'plugin_'.$dir.'.cfg.php';
			if(file_exists($config_file)) {
				$plugin_data = @require($config_file);
				$license = ($plugin_data['license'] == '' || !isset($plugin_data['license'])) ? 0 : 1;
			}
			if(empty($_GET['license']) && $license) {
				$submit_url = '?m=admin&c=plugin&a=import&dir='.$dir.'&license=1&pc_hash='. $_SESSION['pc_hash'].'&menuid='.$_GET['menuid'];
			} else {
				$submit_url = '?m=admin&c=plugin&a=install&dir='.$dir.'&pc_hash='. $_SESSION['pc_hash'].'&menuid='.$_GET['menuid'];
			}	
				$show_header = 0;
			include $this->admin_tpl('plugin_import_confirm');
		}
	}
	/**
	 * 应用删除程序
	 */
	public function delete() {
		if(isset($_POST['dosubmit'])) {
			$pluginid = intval($_POST['pluginid']);
			$plugin_data =  $this->db->get_one(array('pluginid'=>$pluginid));
			$op_status = FALSE;	
			$dir = $plugin_data['dir'];
			$config_file = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'plugin_'.$dir.'.cfg.php';	
			if(file_exists($config_file)) {
				$plugin_data = @require($config_file);
			}		
			$filename = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$plugin_data['plugin']['uninstallfile'];
			if(file_exists($filename)) {
				@include_once $filename;
			} else {
				showmessage(L('plugin_lacks_uninstall_file','','plugin'),HTTP_REFERER);
			}
			if($op_status) {
				$this->db->delete(array('pluginid'=>$pluginid));
				$this->db_var->delete(array('pluginid'=>$pluginid));
				delcache($dir,'plugins');
				delcache($dir.'_var','plugins');
				$this->set_hook_cache();
				if($plugin_data['plugin']['iframe']) {
					pc_base::load_sys_func('dir');
					if(!dir_delete(PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir)) {
						showmessage(L('plugin_uninstall_success_no_delete','','plugin'),'?m=admin&c=plugin');
					}
				}
				showmessage(L('plugin_uninstall_success','','plugin'),'?m=admin&c=plugin');
			} else {
				showmessage(L('plugin_uninstall_fail','','plugin'),'?m=admin&c=plugin');
			}	
		} else {
			$show_header = 0;
			$pluginid = intval($_GET['pluginid']);
			$plugin_data =  $this->db->get_one(array('pluginid'=>$pluginid));
			include $this->admin_tpl('plugin_delete_confirm');			
		}

	}
	
	/**
	 * 应用安装
	 */	
	public function install() {
		$op_status = FALSE;
		$dir = trim($_GET['dir']);
		$config_file = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'plugin_'.$dir.'.cfg.php';		
		if(file_exists($config_file)) {
			$plugin_data = @require($config_file);
		} else {
			showmessage(L('plugin_config_not_exist','','plugin'));
		}
		$app_status  = app_validity_check($plugin_data['appid']);
		if($app_status != 2){
			$app_msg = $app_status == '' ? L('plugin_not_exist_or_pending','','plugin') : ($app_status == 0 || $app_status == 1 ? L('plugin_developing','','plugin') : L('plugin_be_locked','','plugin'));
			showmessage($app_msg);
		}
		if($plugin_data['version'] && $plugin_data['version']!=pc_base::load_config('version', 'pc_version')) {
			showmessage(L('plugin_incompatible','','plugin'));
		}
		
		if($plugin_data['dir'] == '' || $plugin_data['identification'] == '' || $plugin_data['identification']!=$plugin_data['dir']) {
			showmessage(L('plugin_lack_of_necessary_configuration_items','','plugin'));
		}
		
		if(!pluginkey_check($plugin_data['identification'])) {
			showmessage(L('plugin_illegal_id','','plugin'));
		}
		if(is_array($plugin_data['plugin_var'])) {
			foreach($plugin_data['plugin_var'] as $config) {
				if(!pluginkey_check($config['fieldname'])) {
					showmessage(L('plugin_illegal_variable','','plugin'));
				}
			}
		}
		if($this->db->get_one(array('identification'=>$plugin_data['identification']))) {
			showmessage(L('plugin_duplication_name','','plugin'));
		};				
		$filename = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$plugin_data['plugin']['installfile'];
		
		if(file_exists($filename)) {
			@include_once $filename;
		} 
		
		if($op_status) {	
			//向插件表中插入数据
			
			$plugin = array('name'=>new_addslashes($plugin_data['plugin']['name']),'identification'=>$plugin_data['identification'],'appid'=>$plugin_data['appid'],'description'=>new_addslashes($plugin_data['plugin']['description']),'dir'=>$plugin_data['dir'],'copyright'=>new_addslashes($plugin_data['plugin']['copyright']),'setting'=>array2string($plugin_data['plugin']['setting']),'iframe'=>array2string($plugin_data['plugin']['iframe']),'version'=>$plugin_data['plugin']['version'],'disable'=>'0');
			
			$pluginid = $this->db->insert($plugin,TRUE);
			
			//向插件变量表中插入数据
			if(is_array($plugin_data['plugin_var'])) {
				foreach($plugin_data['plugin_var'] as $config) {
					$plugin_var = array();
					$plugin_var['pluginid'] = $pluginid;
					foreach($config as $_k => $_v) {
						if(!in_array($_k, array('title','description','fieldname','fieldtype','setting','listorder','value','formattribute'))) continue;
						if($_k == 'setting') $_v = array2string($_v);
						$plugin_var[$_k] = $_v;
					}
					$this->db_var->insert($plugin_var);				
				}
			}		
			plugin_install_stat($plugin_data['appid']);
			setcache($plugin_data['identification'], $plugin,'plugins');
			$this->set_var_cache($pluginid);
			showmessage(L('plugin_install_success','','plugin'),'?m=admin&c=plugin');
		} else {
			showmessage(L('plugin_install_fail','','plugin'),'?m=admin&c=plugin');
		}
	}	
	
	/**
	 * 应用升级
	 */		
	public function upgrade() {
		//TODO		
	}
	
	/**
	 * 应用排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $pluginid => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('pluginid'=>$pluginid));
			}
			$this->set_hook_cache();
			showmessage(L('operation_success'),'?m=admin&c=plugin');
		} else {
			showmessage(L('operation_failure'),'?m=admin&c=plugin');
		}
	}
	

	public function design() {
		
	    if(isset($_POST['dosubmit'])) {
			$data['identification'] = $_POST['info']['identification'];
			$data['realease'] = date('YMd',SYS_TIME);
			$data['dir'] = $_POST['info']['identification'];
			$data['appid'] = '';
			$data['plugin'] = array(
							'version' => '0.0.2',
							'name' => $_POST['info']['name'],
							'copyright' => $_POST['info']['copyright'],
							'description' => "",
							'installfile' => 'install.php',
							'uninstallfile' => 'uninstall.php',
						);

			
			$filepath = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$data['identification'].DIRECTORY_SEPARATOR.'plugin_'.$data['identification'].'.cfg.php';
			pc_base::load_sys_func('dir');
			dir_create(dirname($filepath));	
		    $data = "<?php\nreturn ".var_export($data, true).";\n?>";			
			if(pc_base::load_config('system', 'lock_ex')) {
				$file_size = file_put_contents($filepath, $data, LOCK_EX);
			} else {
				$file_size = file_put_contents($filepath, $data);
			}
			echo 'success';
		} else {
			include $this->admin_tpl('plugin_design');
		}
	}
	/**
	 * 应用中心
	 * Enter description here ...
	 */ 
	public function appcenter() {
		$data = array();
		$p = intval($_GET[p]) ? intval($_GET[p]) : 1;
		$s = 8;
		
		$data = file_get_contents('http://open.phpcms.cn/index.php?m=open&c=api&a=get_applist&s='.$s.'&p='.$p);
		$data = array_iconv(json_decode($data, true),'utf-8',CHARSET);
		
		$recommed_data = file_get_contents('http://open.phpcms.cn/index.php?m=open&c=api&a=get_recommed_applist&s=5&p=1');
		$recommed_data = array_iconv(json_decode($recommed_data, true),'utf-8',CHARSET);
		
		$focus_data = file_get_contents('http://open.phpcms.cn/index.php?m=open&c=api&a=get_app_focus&num=3');
		$focus_data = array_iconv(json_decode($focus_data, true),'utf-8',CHARSET);	
		$pages = $data['pages'];
		$pre_page = $p <= 1 ? 1 : $p - 1;
		$next_page = $p >= $pages ? $pages : $p + 1;
		$pages = '<a class="a1">'.$data['total'].L('plugin_item','','plugin').'</a> <a href="?m=admin&c=plugin&a=appcenter&p=1">'.L('plugin_firstpage').'</a> <a href="?m=admin&c=plugin&a=appcenter&p='.$pre_page.'">'.L('plugin_prepage').'</a> <a href="?m=admin&c=plugin&a=appcenter&p='.$next_page.'">'.L('plugin_nextpage').'</a> <a href="?m=admin&c=plugin&a=appcenter&p='.$pages.'">'.L('plugin_lastpage').'</a>';
		$show_header = 1;
		include $this->admin_tpl('plugin_appcenter');
	}
	
	/**
	 * 显示应用详情
	 */
	public function appcenter_detail() {
		$data = array();
		$id = intval($_GET['id']);
		$data = file_get_contents('http://open.phpcms.cn/index.php?m=open&c=api&a=get_detail_byappid&id='.$id);
		$data = array_iconv(json_decode($data, true),'utf-8',CHARSET);
		extract($data);		
		if($appname) {
			include $this->admin_tpl('plugin_appcenter_detail');
		} else {
			showmessage(L('plugin_not_exist_or_pending','','plugin'));
		}
	}
	
	/**
	 * 在线安装
	 */
	public function install_online() {
		$data = array();
		$id = intval($_GET['id']);
		$data = file_get_contents('http://open.phpcms.cn/index.php?m=open&c=api&a=get_detail_byappid&id='.$id);
		$data = array_iconv(json_decode($data, true),'utf-8',CHARSET);
		
		//如果为iframe类型应用，无需下载压缩包，之间创建插件文件夹
		if(!empty($data['iframe'])) {
			$appdirname = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$data['appenname'];
			if(!file_exists($appdirname)) {
				if(!mkdir($appdirname)) {
					showmessage(L('plugin_mkdir_fail', '', 'plugin'));
				} else {
					//创建安装、配置文件
					$installdata = <<<EOF
<?php 
	defined('IN_PHPCMS') or exit('No permission resources.');
	\$op_status = TRUE;
?>
EOF;
					$uninstallres = @file_put_contents($appdirname.DIRECTORY_SEPARATOR.'uninstall.php', $installdata);
					$installres = @file_put_contents($appdirname.DIRECTORY_SEPARATOR.'install.php', $installdata);
					
					$cfgdata = <<<EOF
<?php
return array (
  'identification' => '$data[appenname]',
  'dir' => '$data[appenname]',
  'appid' => '$data[id]',
  'plugin'=> array(
		  'version' => '1.0',
		  'name' => '$data[appname]',
		  'copyright' => 'phpcms team',
		  'description' =>'$data[description]',
		  'installfile' => 'install.php',
		  'uninstallfile' => 'uninstall.php',
		  'iframe' => array('width'=>'960','height'=>'640','url'=>'$data[iframe]'),		  
	),
   'plugin_var'=> array(   array('title'=>'宽度','description'=>'','fieldname'=>'width','fieldtype'=>'text','value'=>'960','formattribute'=>'style="width:50px"','listorder'=>'1',),		array('title'=>'高度','description'=>'','fieldname'=>'height','fieldtype'=>'text','value'=>'640','formattribute'=>'style="width:50px"','listorder'=>'2',),   
	),	
);
?>				
EOF;
					$cfgres = @file_put_contents($appdirname.DIRECTORY_SEPARATOR.'plugin_'.$data['appenname'].'.cfg.php', $cfgdata);
					
					//检查配置文件是否写入成功
					if($installres*$uninstallres*$cfgres > 0) {
						showmessage(L('plugin_configure_success', '', 'plugin'), 'index.php?m=admin&c=plugin&a=import&dir='.$data['appenname']);
					} else {
						showmessage(L('plugin_install_fail', '', 'plugin'));
					}
				}
			} else {
				showmessage(L('plugin_allready_exists', '', 'plugin'));
			}
		} else {	
			//远程压缩包地址
			$upgradezip_url = $data['downurl'];
			if(empty($upgradezip_url)) {
				showmessage(L('download_fail', '', 'plugin'), 'index.php?m=admin&c=plugin&a=appcenter');
			}
			
			//创建缓存文件夹
			if(!file_exists(CACHE_PATH.'caches_open')) {
				@mkdir(CACHE_PATH.'caches_open');
			}
			//保存到本地地址
			$upgradezip_path = CACHE_PATH.'caches_open'.DIRECTORY_SEPARATOR.$data['id'].'.zip';
			//解压路径
			$upgradezip_source_path = CACHE_PATH.'caches_open'.DIRECTORY_SEPARATOR.$data['id'];
				
			//下载压缩包
			@file_put_contents($upgradezip_path, @file_get_contents($upgradezip_url));
			//解压缩
			pc_base::load_app_class('pclzip', 'upgrade', 0);
			$archive = new PclZip($upgradezip_path);
	
			if($archive->extract(PCLZIP_OPT_PATH, $upgradezip_source_path, PCLZIP_OPT_REPLACE_NEWER) == 0) {
				die("Error : ".$archive->errorInfo(true));
			}
			//删除压缩包
			@unlink($upgradezip_path);
			
			//拷贝gbk/upload文件夹到根目录
			$copy_from = $upgradezip_source_path.DIRECTORY_SEPARATOR.CHARSET;
			//动态程序路径
			$copy_to_pcpath = PC_PATH.'plugin';
			//静态程序路径
			$copy_to_staticspath = PHPCMS_PATH.'statics'.DIRECTORY_SEPARATOR.'plugin';

			//应用文件夹名称
			$appdirname = $data['appenname'];
	
			$this->copyfailnum = 0;
			$this->copydir($copy_from.DIRECTORY_SEPARATOR.'phpcms'.DIRECTORY_SEPARATOR.'plugin', $copy_to_pcpath, $_GET['cover']);
			$this->copydir($copy_from.DIRECTORY_SEPARATOR.'statics'.DIRECTORY_SEPARATOR.'plugin', $copy_to_staticspath, $_GET['cover']);
			$this->deletedir($copy_from);
			//检查文件操作权限，是否复制成功
			if($this->copyfailnum > 0) {
				showmessage(L('download_fail', '', 'plugin'), 'index.php?m=admin&c=plugin&a=appcenter');	
			} else {
				showmessage(L('download_success', '', 'plugin'), 'index.php?m=admin&c=plugin&a=import&dir='.$appdirname);	
			}
		}
	}
		
	/**
	 * 异步方式调用详情
	 * Enter description here ...
	 */
	public function public_appcenter_ajx_detail() {
		$id = intval($_GET['id']);
		$data = file_get_contents('http://open.phpcms.cn/index.php?m=open&c=api&a=get_detail_byappid&id='.$id);
		//$data = json_decode($data, true);
		echo $_GET['jsoncallback'].'(',$data,')';
		exit;		
	}
	
	/**
	 * 配置应用.
	 */
	public function config() {
		if(isset($_POST['dosubmit'])) {
			$pluginid = intval($_POST['pluginid']);
			foreach ($_POST['info'] as $_k => $_v) {
				 $this->db_var->update(array('value'=>$_v),array('pluginid'=>$pluginid,'fieldname'=>$_k));
			}
			$this->set_var_cache($pluginid);
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$pluginid = intval($_GET['pluginid']);
			$plugin_menus = array();
			$info = $this->db->get_one(array('pluginid'=>$pluginid));
			extract($info);
			if(!isset($_GET['module'])) {	
				$plugin_menus[] =array('name'=>L('plugin_desc','','plugin'),'url'=>'','status'=>'1');
				if($disable){
					if($info_var = $this->db_var->select(array('pluginid'=>$pluginid),'*','','listorder ASC,id DESC')) {
						$plugin_menus[] =array('name'=>L('plugin_config','','plugin'),'url'=>'','status'=>'0');
						$form = $this->creatconfigform($info_var);
					}
					$meun_total = count($plugin_menus);;
					$setting = string2array($setting);
					if(is_array($setting)) {
						foreach($setting as $m) {
							$plugin_menus[] = array('name'=>$m['menu'],'extend'=>1,'url'=>$m['name']);
							$mods[] = $m['name'];
						}
					}
				}
				include $this->admin_tpl('plugin_setting');
			} else {
				define('PLUGIN_ID', $identification);
				$plugin_module = trim($_GET['module']);
				$plugin_admin_path = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$identification.DIRECTORY_SEPARATOR.'plugin_admin.class.php';
				if (file_exists($plugin_admin_path)) {
					include $plugin_admin_path;
					$plugin_admin = new plugin_admin($pluginid);
					call_user_func(array($plugin_admin, $plugin_module));
				}				
			}
		}
	}
	/**
	 * 开启/关闭插件
	 * Enter description here ...
	 */
	public function status() {
		$disable = intval($_GET['disable']);
		$pluginid = intval($_GET['pluginid']);
		$this->db->update(array('disable'=>$disable),array('pluginid'=>$pluginid));
		$this->set_cache($pluginid);
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	
	/**
	 * 设置字段缓存
	 * @param int $pluginid
	 */
	private function set_var_cache($pluginid) {
		if($info = $this->db_var->select(array('pluginid'=>$pluginid))) {
			$plugin_data =  $this->db->get_one(array('pluginid'=>$pluginid));
			foreach ($info as $_value) {
				$plugin_vars[$_value['fieldname']] = $_value['value'];
			}
			setcache($plugin_data['identification'].'_var', $plugin_vars,'plugins');
		}
	}
	
	/**
	 * 设置缓存
	 * @param int $pluginid
	 */
	private function set_cache($pluginid) {
		if($info = $this->db->get_one(array('pluginid'=>$pluginid))) {		
			setcache($info['identification'], $info,'plugins');
		}
		$this->set_hook_cache();
	}

	/**
	 * 设置hook缓存
	 */
	function set_hook_cache() {
		if($info = $this->db->select(array('disable'=>1),'*','','listorder DESC')) {
			foreach($info as $i) {
				$id = $i['identification'];
				$hook_file = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.'hook.class.php';
				if(file_exists($hook_file)) {
					$hook[$i['appid']] = $i['identification'];
				}
			}			
		}
		setcache('hook',$hook,'plugins');
	}
	
	/**
	 * 创建配置表单
	 * @param array $data
	 */
	private function creatconfigform($data) {
		if(!is_array($data) || empty($data)) return false;
		foreach ($data as $r) {
			$form .= '<tr><th width="120">'.$r['title'].'</th><td class="y-bg">'.$this->creatfield($r).'</td></tr>';			
		}
		return $form;		
	}
	
	/**
	 * 创建配置表单字段
	 * @param array $data
	 */
	private function creatfield($data) {
		extract($data);
		$fielda_array = array('text','radio','checkbox','select','datetime','textarea');
		if(in_array($fieldtype, $fielda_array)) {
			if($fieldtype == 'text') {
				return '<input type="text" name="info['.$fieldname.']" id="'.$fieldname.'" value="'.$value.'" class="input-text" '.$formattribute.' > '.' '.$description;
			} elseif($fieldtype == 'checkbox') {
				return form::checkbox(string2array($setting),$value,"name='info[$fieldname]' $formattribute",'',$fieldname).' '.$description;
			} elseif($fieldtype == 'radio') {
				return form::radio(string2array($setting),$value,"name='info[$fieldname]' $formattribute",'',$fieldname).' '.$description;
			}  elseif($fieldtype == 'select') {
				return form::select(string2array($setting),$value,"name='info[$fieldname]' $formattribute",'',$fieldname).' '.$description;
			} elseif($fieldtype == 'datetime') {
				return form::date("info[$fieldname]",$value,$isdatetime,1).' '.$description;
			} elseif($fieldtype == 'textarea') {
				return '<textarea name="info['.$fieldname.']" id="'.$fieldname.'" '.$formattribute.'>'.$value.'</textarea>'.' '.$description;
			}
		}
	}
	/**
	 * 执行SQL
	 * @param string $sql 要执行的sql语句
	 */
 	private function _sql_execute($sql) {
	    $sqls = $this->_sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					$this->db->query($sql);
				}
			}
		} else {
			$this->db->query($sqls);
		}
		return true;
	}	
	
	/**
	 * 分割SQL语句
	 * @param string $sql 要执行的sql语句
	 */	
 	private function _sql_split($sql) {
		$database = pc_base::load_config('database');
		$db_charset = $database['default']['charset'];
		if($this->db->version() > '4.1' && $db_charset) {
			$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$db_charset,$sql);
		}
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach($queriesarray as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			$queries = array_filter($queries);
			foreach($queries as $query) {
				$str1 = substr($query, 0, 1);
				if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
			}
			$num++;
		}
		return($ret);
	}
				
	private function copydir($dirfrom, $dirto, $cover='') {
	    //如果遇到同名文件无法复制，则直接退出
	    if(is_file($dirto)){
	        die(L('have_no_pri').$dirto);
	    }
	    //如果目录不存在，则建立之
	    if(!file_exists($dirto)){
	        mkdir($dirto);
	    }
	    
	    $handle = opendir($dirfrom); //打开当前目录
    
	    //循环读取文件
	    while(false !== ($file = readdir($handle))) {
	    	if($file != '.' && $file != '..'){ //排除"."和"."
		        //生成源文件名
			    $filefrom = $dirfrom.DIRECTORY_SEPARATOR.$file;
		     	//生成目标文件名
		        $fileto = $dirto.DIRECTORY_SEPARATOR.$file;
		        if(is_dir($filefrom)){ //如果是子目录，则进行递归操作
		            $this->copydir($filefrom, $fileto, $cover);
		        } else { //如果是文件，则直接用copy函数复制
		        	if(!empty($cover)) {
						if(!copy($filefrom, $fileto)) {
							$this->copyfailnum++;
						    echo L('copy').$filefrom.L('to').$fileto.L('failed')."<br />";
						}
		        	} else {
		        		if(fileext($fileto) == 'html' && file_exists($fileto)) {

		        		} else {
		        			if(!copy($filefrom, $fileto)) {
								$this->copyfailnum++;
							    echo L('copy').$filefrom.L('to').$fileto.L('failed')."<br />";
							}
		        		}
		        	}
		        }
	    	}
	    }
	}
	
	private function deletedir($dirname){
	    $result = false;
	    if(! is_dir($dirname)){
	        echo " $dirname is not a dir!";
	        exit(0);
	    }
	    $handle = opendir($dirname); //打开目录
	    while(($file = readdir($handle)) !== false) {
	        if($file != '.' && $file != '..'){ //排除"."和"."
	            $dir = $dirname.DIRECTORY_SEPARATOR.$file;
	            //$dir是目录时递归调用deletedir,是文件则直接删除
	            is_dir($dir) ? $this->deletedir($dir) : unlink($dir);
	        }
	    }
	    closedir($handle);
	    $result = rmdir($dirname) ? true : false;
	    return $result;
	}

}
?>