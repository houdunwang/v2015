<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
class index extends admin {
	private $_filearr = array('api', 'phpcms', 'statics', '');
	//md5验证地址
	private $_upgrademd5 = 'http://www.phpcms.cn/upgrademd5/';
	//补丁地址
	private $_patchurl = 'http://download.phpcms.cn/v9/9.0/patch/';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function init() {

		$patch_charset = str_replace('-', '', CHARSET);
		$upgrade_path_base = $this->_patchurl.$patch_charset.'/';
		//获取当前版本
		$current_version = pc_base::load_config('version');
		$pathlist_str = @file_get_contents($upgrade_path_base);
		$pathlist = $allpathlist = array();
		$key = -1;
		//获取压缩包列表
		preg_match_all("/\"(patch_[\w_]+\.zip)\"/", $pathlist_str, $allpathlist);
		$allpathlist = $allpathlist[1];
		//获取可供当前版本升级的压缩包
		foreach($allpathlist as $k=>$v) {
			if(strstr($v, 'patch_'.$current_version['pc_release'])) {
				$key = $k;
				break;
			}
		}
		$key = $key < 0 ? 9999 : $key;
		foreach($allpathlist as $k=>$v) {
			if($k >= $key) {
				$pathlist[$k] = $v;
			}
		}
		
		//开始升级
		if(!empty($_GET['s'])) {
			if(empty($_GET['do'])) {
				showmessage(L('upgradeing'), '?m=upgrade&c=index&a=init&s=1&do=1&cover='.$_GET['cover']);
			}
			//检查服务器是否支持zip

			if(empty($pathlist)) {
				showmessage(L('upgrade_success'), '?m=upgrade&c=index&a=checkfile');
			}
			
			//创建缓存文件夹
			if(!file_exists(CACHE_PATH.'caches_upgrade')) {
				@mkdir(CACHE_PATH.'caches_upgrade');
			}
			
			//根据版本下载zip升级包，解压覆盖
			pc_base::load_app_class('pclzip', 'upgrade', 0);

			foreach($pathlist as $k=>$v) {
				//远程压缩包地址
				$upgradezip_url = $upgrade_path_base.$v;
				//保存到本地地址
				$upgradezip_path = CACHE_PATH.'caches_upgrade'.DIRECTORY_SEPARATOR.$v;
				//解压路径
				$upgradezip_source_path = CACHE_PATH.'caches_upgrade'.DIRECTORY_SEPARATOR.basename($v,".zip");
				
				//下载压缩包
				@file_put_contents($upgradezip_path, @file_get_contents($upgradezip_url));
				//解压缩
				$archive = new PclZip($upgradezip_path);

				if($archive->extract(PCLZIP_OPT_PATH, $upgradezip_source_path, PCLZIP_OPT_REPLACE_NEWER) == 0) {
					die("Error : ".$archive->errorInfo(true));
				}
								
				//拷贝gbk/upload文件夹到根目录
				$copy_from = $upgradezip_source_path.DIRECTORY_SEPARATOR.$patch_charset.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
				$copy_to = PHPCMS_PATH;
				
				$this->copyfailnum = 0;
				$this->copydir($copy_from, $copy_to, $_GET['cover']);
				
				//检查文件操作权限，是否复制成功
				if($this->copyfailnum > 0) {
					//如果失败，恢复当前版本
					@file_put_contents(CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.'version.php', '<?php return '.var_export($current_version, true).';?>');
				
					showmessage(L('please_check_filepri'));	
				}
				
				//执行sql
				//sql目录地址
				$sql_path = CACHE_PATH.'caches_upgrade'.DIRECTORY_SEPARATOR.basename($v,".zip").DIRECTORY_SEPARATOR.$patch_charset.DIRECTORY_SEPARATOR.'upgrade'.DIRECTORY_SEPARATOR.'ext'.DIRECTORY_SEPARATOR;
				$file_list = glob($sql_path.'*');
				if(!empty($file_list)) {
					foreach ($file_list as $fk=>$fv) {
						if(in_array(strtolower(substr($fv, -3, 3)), array('php', 'sql'))) {
							if (strtolower(substr($file_list[$fk], -3, 3)) == 'sql' && $data = file_get_contents($file_list[$fk])) {
								$model_name = substr(basename($fv), 0, -4);
								if (!$db = pc_base::load_model($model_name.'_model')) {
									showmessage($model_name.L('lost'), '?m=upgrade&c=index&a=init&s=1');	
								}
								$mysql_server_version = $db->version();
								$dbcharset = pc_base::load_config('database','default');
								$dbcharset = $dbcharset['charset'];
				
								$sqls = explode(';', $data);
								foreach ($sqls as $sql) {
									if (empty($sql)) continue;
									if(mysql_get_server_info > '4.1' && $dbcharset) {
										$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=".$dbcharset,$sql);
									}
									$db->query($sql);
								}
							} elseif (strtolower(substr($file_list[$fk], -3, 3)) == 'php' && file_exists($file_list[$fk])) {
								include $file_list[$fk];
								
								//同步菜单语言包
								if (strtolower(basename($file_list[$fk])) == 'system_menu.lang.php' && file_exists($file_list[$fk])) {
									include $file_list[$fk];
									$new_lan = $LANG;
									unset($LANG);
									$lang = pc_base::load_config('system','lang');
									$menu_lan_file = PC_PATH.'languages'.DIRECTORY_SEPARATOR.$lang.DIRECTORY_SEPARATOR.'system_menu.lang.php';
									include $menu_lan_file;
									$original_lan = $LANG;
									unset($LANG);
									$diff_lan = array_diff($new_lan, $original_lan);
				
									$content = file_get_contents($menu_lan_file);
									$content = substr($content,0,-2);
									$data = '';
									foreach ($diff_lan as $lk => $l) {
										$data .= "\$LANG['".$lk."'] = '".$l."';\n\r";
									}
									$data = $content.$data."?>";
									file_put_contents($menu_lan_file, $data);
								}
								
							}
						}
					}
				}
				
				//读取版本号写入version.php文件
				//配置文件地址
				$configpath = CACHE_PATH.'caches_upgrade'.DIRECTORY_SEPARATOR.basename($v,".zip").DIRECTORY_SEPARATOR.$patch_charset.DIRECTORY_SEPARATOR.'upgrade'.DIRECTORY_SEPARATOR.'config.php';
				if(file_exists($configpath)) {
					$config_arr = include $configpath;
					$version_arr = array('pc_version'=>$config_arr['to_version'], 'pc_release'=>$config_arr['to_release']);
					//版本文件地址
					$version_filepath = CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.'version.php';
					@file_put_contents($version_filepath, '<?php return '.var_export($version_arr, true).';?>');
				}

				//删除文件
				@unlink($upgradezip_path);
				//删除文件夹
	 			$this->deletedir($upgradezip_source_path);
	 			
				//提示语
				$tmp_k = $k + 1;
				if(!empty($pathlist[$tmp_k])) {
					$next_update = '<br />'.L('upgradeing').basename($pathlist[$tmp_k],".zip");
				} else {
					$next_update;
				}
				//文件校验是否升级成功		
				showmessage(basename($v,".zip").L('upgrade_success').$next_update, '?m=upgrade&c=index&a=init&s=1&do=1&cover='.$_GET['cover']);	
			}	
		} else {
			
			include $this->admin_tpl('upgrade_index');
		}
	}
	
	
	//检查文件md5值
	public function checkfile() {
		if(!empty($_GET['do'])) {
			$this->md5_arr = array();
			$this->_pc_readdir(".");

			//读取phpcms接口
			$current_version = pc_base::load_config('version');
			$phpcms_md5 = @file_get_contents($this->_upgrademd5.$current_version['pc_release'].'_'.CHARSET.".php");
			$phpcms_md5_arr = json_decode($phpcms_md5, 1);
			//计算数组差集
			$diff = array_diff($phpcms_md5_arr, $this->md5_arr);

			//丢失文件列表
			$lostfile = array();
			foreach($phpcms_md5_arr as $k=>$v) {
				if(!in_array($k, array_keys($this->md5_arr))) {
					$lostfile[] = $k;
					unset($diff[$k]);
				}
			}
			
			//未知文件列表
			$unknowfile = array_diff(array_keys($this->md5_arr), array_keys($phpcms_md5_arr));
			
			include $this->admin_tpl('check_file');
		} else {
			showmessage(L('begin_checkfile'), '?m=upgrade&c=index&a=checkfile&do=1&menuid='.$_GET['menuid']);
		}
	}
	
	private function _pc_readdir($path='') {
		$dir_arr = explode('/', dirname($path));
		if(is_dir($path)) {
			$handler = opendir($path);
			while(($filename = @readdir($handler)) !== false) {
				if(substr($filename, 0, 1) != ".") {
					$this->_pc_readdir($path.'/'.$filename);
				}
			}
			closedir($handler);
		} else {

			if (dirname($path) == '.' || (isset($dir_arr[1]) && in_array($dir_arr[1], $this->_filearr))) {
				$this->md5_arr[base64_encode($path)] = md5_file($path);
			}
		}
	}
	
	public function copydir($dirfrom, $dirto, $cover='') {
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
	
	function deletedir($dirname){
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