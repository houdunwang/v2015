<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
class file extends admin {
	//模板文件夹
	private $filepath;
	//风格名
	private $style;
	//风格属性
	private $style_info;
	//是否允许在线编辑模板
	private $tpl_edit;
	
	public function __construct() {
		$this->style = isset($_GET['style']) && trim($_GET['style']) ? str_replace(array('..\\', '../', './', '.\\', '/', '\\'), '', trim($_GET['style'])) : showmessage(L('illegal_operation'), HTTP_REFERER);
		if (empty($this->style)) {
			showmessage(L('illegal_operation'), HTTP_REFERER);
		}
		$this->filepath = PC_PATH.'templates'.DIRECTORY_SEPARATOR.$this->style.DIRECTORY_SEPARATOR;
		if (file_exists($this->filepath.'config.php')) {
			$this->style_info = include $this->filepath.'config.php';
			if (!isset($this->style_info['name'])) $this->style_info['name'] = $this->style;
		}
		$this->tpl_edit = pc_base::load_config('system', 'tpl_edit');
		parent::__construct();
	}
	
	public function init() {
		$dir = isset($_GET['dir']) && trim($_GET['dir']) ? str_replace(array('..\\', '../', './', '.\\', '/', '\\'), '', trim($_GET['dir'])) : '';
		$filepath = $this->filepath.$dir;
		$list = glob($filepath.DIRECTORY_SEPARATOR.'*');
		if(!empty($list)) ksort($list);
		$local = str_replace(array(PC_PATH, DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('',DIRECTORY_SEPARATOR), $filepath);
		if (substr($local, -1, 1) == '.') {
			$local = substr($local, 0, (strlen($local)-1));
		}
		$encode_local = str_replace(array('/', '\\'), '|', $local);
		$file_explan = $this->style_info['file_explan'];
		$show_header = true;
		$tpl_edit = $this->tpl_edit;
		include $this->admin_tpl('file_list');
	}
	
	public function updatefilename() {
		$file_explan = isset($_POST['file_explan']) ? $_POST['file_explan'] : '';
		if (!isset($this->style_info['file_explan'])) $this->style_info['file_explan'] = array();
		$this->style_info['file_explan'] = array_merge($this->style_info['file_explan'], $file_explan);
		@file_put_contents($this->filepath.'config.php', '<?php return '.var_export($this->style_info, true).';?>');
		showmessage(L('operation_success'), HTTP_REFERER);
	}
	
	public function edit_file() {
		if (empty($this->tpl_edit)) {
			showmessage(L('tpl_edit'));
		}
		$dir = isset($_GET['dir']) && trim($_GET['dir']) ? str_replace(array('..\\', '../', './', '.\\'), '', urldecode(trim($_GET['dir']))) : '';
		$file = isset($_GET['file']) && trim($_GET['file']) ? trim($_GET['file']) : '';
		if ($file) {
			preg_match('/^([a-zA-Z0-9])?([^.|-|_]+)/i', $file, $file_t);
			$file_t = $file_t[0];
			$file_t_v = array('header'=>array('{$SEO[\'title\']}'=>L('seo_title'), '{$SEO[\'site_title\']}'=>L('site_title'), '{$SEO[\'keyword\']}'=>L('seo_keyword'), '{$SEO[\'description\']}'=>L('seo_des')), 'category'=>array('{$catid}'=>L('cat_id'), '{$catname}'=>L('cat_name'), '{$url}'=>L('cat_url'), '{$r[catname]}'=>L('cat_name'), '{$r[url]}'=>'URL', '{$CATEGORYS}'=>L('cats')), 'list'=>array('{$catid}'=>L('cat_id'), '{$catname}'=>L('cat_name'), '{$url}'=>L('cat_url'), '{$CATEGORYS}'=>L('cats')), 'show'=> array('{$title}'=>L('title'), '{$inputtime}'=>L('inputtime'), '{$copyfrom}'=>L('comeform'), '{$content}'=>L('content'), '{$previous_page[url]}'=>L('pre_url'), '{$previous_page[title]}'=>L('pre_title'), '{$next_page[url]}'=>L('next_url'), '{$next_page[title]}'=>L('next_title')), 'page'=>array('{$CATEGORYS}'=>L('cats'), '{$content}'=>L('content')));
		}
		if (substr($file, -4, 4) != 'html') showmessage(L("can_edit_html_files"));
		$filepath = $this->filepath.$dir.DIRECTORY_SEPARATOR.$file;
		$is_write = 0;
		if (is_writable($filepath)) {
			$is_write = 1;
		}
		if ($_POST['dosubmit']) {
			$code = isset($_POST['code']) ? stripslashes($_POST['code']) : showmessage(L('illegal_operation'), HTTP_REFERER);
			$code = str_replace(array('<?','{php'),array('<？','{ php'),$code);
			if ($is_write == 1) {
				pc_base::load_app_func('global');
				creat_template_bak($filepath, $this->style, $dir);
				file_put_contents($filepath,htmlspecialchars_decode($code));
				showmessage(L('operation_success'), HTTP_REFERER);
			} else{
				showmessage(L("file_does_not_writable"), HTTP_REFERER);
			}
		} else {
			if (file_exists($filepath)) {
				$data = new_html_special_chars(file_get_contents($filepath));
			} else {
				showmessage(L('file_does_not_exists'));
			}
		}
		$show_header = true;
		include $this->admin_tpl('file_edit_file');
	}
	
	public function add_file() {
		if (empty($this->tpl_edit)) {
			showmessage(L('tpl_edit'));
		}
		$dir = isset($_GET['dir']) && trim($_GET['dir']) ? str_replace(array('..\\', '../', './', '.\\'), '', urldecode(trim($_GET['dir']))) : '';
		$filepath = $this->filepath.$dir.DIRECTORY_SEPARATOR;
		$is_write = 0;
		if (is_writable($filepath)) {
			$is_write = 1;
		}
		if (!$is_write) {
			showmessage('dir_not_writable');
		}
		if ($_POST['dosubmit']) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage('');
			if (!preg_match('/^[\w]+$/i', $name)) {
				showmessage(L('name_datatype_error'), HTTP_REFERER);
			}
			if ($is_write == 1) {
				@file_put_contents($filepath.$name.'.html','');
				showmessage('','','', 'add_file');
			} else {
				showmessage(L("dir_not_writable"), HTTP_REFERER);
			}
		}
		$show_header = $show_validator = true;
		include $this->admin_tpl('file_add_file');
	}
	
	public function public_name() {
		$dir = isset($_GET['dir']) && trim($_GET['dir']) ? str_replace(array('..\\', '../', './', '.\\'), '', urldecode(trim($_GET['dir']))) : '';
		$name = isset($_GET['name']) && trim($_GET['name']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['name'])) : trim($_GET['name'])) : exit('0');
		$filepath = $this->filepath.$dir.DIRECTORY_SEPARATOR.$name.'.html';
		if (file_exists($filepath)) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	public function visualization() {
		$dir = isset($_GET['dir']) && trim($_GET['dir']) ? str_replace(array('..\\', '../', './', '.\\'), '', urldecode(trim($_GET['dir']))) : showmessage(L('illegal_operation'), HTTP_REFERER);
		$file = isset($_GET['file']) && trim($_GET['file']) ? trim($_GET['file']) : showmessage(L('illegal_operation'), HTTP_REFERER);
		ob_start();
		//include $this->admin_tpl('base_tool');
		include template($dir,basename($file, '.html'),$this->style);
		$html = ob_get_contents();
		ob_clean();
		pc_base::load_app_func('global');
		$html = visualization($html, $this->style, $dir, $file);
		echo $html;
	}
	
	public function public_ajax_get() {
		$op_tag = pc_base::load_app_class($_GET['op']."_tag", $_GET['op']);
		$html = $op_tag->{$_GET['action']}($_GET['html'], $_GET['value'], $_GET['id']);
		echo $html;
	}
	
	public function edit_pc_tag() {
		if (empty($this->tpl_edit)) {
			showmessage(L('tpl_edit'));
		}
		$dir = isset($_GET['dir']) && trim($_GET['dir']) ? str_replace(array('..\\', '../', './', '.\\'), '', urldecode(trim($_GET['dir']))) : showmessage(L('illegal_operation'));
		$file = isset($_GET['file']) && trim($_GET['file']) ? urldecode(trim($_GET['file'])) : showmessage(L('illegal_operation'));
		$op = isset($_GET['op']) && trim($_GET['op']) ? trim($_GET['op']) : showmessage(L('illegal_operation'));
		$tag_md5 = isset($_GET['tag_md5']) && trim($_GET['tag_md5']) ? trim($_GET['tag_md5']) : showmessage(L('illegal_operation'));
		$show_header = $show_scroll = $show_validator = true;
		pc_base::load_app_func('global');
		pc_base::load_sys_class('form', '', 0);
		$filepath = $this->filepath.$dir.DIRECTORY_SEPARATOR.$file;
		switch ($op) {
			case 'xml':			
			case 'json':
				if ($_POST['dosubmit']) {
					$url = isset($_POST['url']) && trim($_POST['url']) ? trim($_POST['url']) : showmessage(L('data_address').L('empty'));
					$cache = isset($_POST['cache']) && trim($_POST['cache']) ? trim($_POST['cache']) : 0;
					$return = isset($_POST['return']) && trim($_POST['return']) ? trim($_POST['return']) : '';
					if (!preg_match('/http:\/\//i', $url)) {
						showmessage(L('data_address_reg_sg'), HTTP_REFERER);
					}
					$tag_md5_list = tag_md5($filepath);
					$pc_tag = creat_pc_tag($op, array('url'=>$url, 'cache'=>$cache, 'return'=>$return));
					if (in_array($tag_md5, $tag_md5_list[0])) {
						$old_pc_tag = $tag_md5_list[1][$tag_md5];
					}
					if (replace_pc_tag($filepath, $old_pc_tag, $pc_tag, $this->style, $dir)) {
						showmessage('<script style="text/javascript">if(!window.top.right){parent.location.reload();}art.dialog({id:"edit"}).close();</script>', '', '', 'edit');
					} else {
						showmessage(L('failure_the_document_may_not_to_write'));
					}
				}
				include $this->admin_tpl('pc_tag_tools_json_xml');
				break;
				
			case 'get':
				if ($_POST['dosubmit']) {
					$sql = isset($_POST['sql']) && trim($_POST['sql']) ? trim($_POST['sql']) : showmessage('SQL'.L('empty'));
					$dbsource = isset($_POST['dbsource']) && trim($_POST['dbsource']) ? trim($_POST['dbsource']) : '';
					$cache = isset($_POST['cache']) && intval($_POST['cache']) ? intval($_POST['cache']) : 0;
					$return = isset($_POST['return']) && trim($_POST['return']) ? trim($_POST['return']) : '';
					$tag_md5_list = tag_md5($filepath);
					$pc_tag = creat_pc_tag($op, array('sql'=>$sql, 'dbsource'=>$dbsource, 'cache'=>$cache, 'return'=>$return));
					if (in_array($tag_md5, $tag_md5_list[0])) {
						$old_pc_tag = $tag_md5_list[1][$tag_md5];
					}
					if (replace_pc_tag($filepath, $old_pc_tag, $pc_tag, $this->style, $dir)) {
						showmessage('<script style="text/javascript">if(!window.top.right){parent.location.reload();}art.dialog({id:"edit"}).close();</script>', '', '', 'edit');
					} else {
						showmessage(L('failure_the_document_may_not_to_write'));
					}
				}
				$dbsource_db = pc_base::load_model('dbsource_model');
				$r = $dbsource_db->select('', 'name');
				$dbsource_list = array(''=>L('please_select'));
				foreach ($r as $v) {
					$dbsource_list[$v['name']] = $v['name'];
				}
				include $this->admin_tpl('pc_tag_tools_get');
				break;
				
			default:
				if (!file_exists(PC_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$op.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$op.'_tag.class.php')) {
					showmessage(L('the_module_will_not_support_the_operation'));
				}
				$op_tag = pc_base::load_app_class($op."_tag", $op);
				if (!method_exists($op_tag, 'pc_tag')) {
					showmessage(L('the_module_will_not_support_the_operation'));
				}
				$html  = $op_tag->pc_tag();
				if ($_POST['dosubmit']) {
						$action = isset($_POST['action']) && trim($_POST['action']) ? trim($_POST['action']) : 0;
						$data = array('action'=>$action);
						if (isset($html[$action]) && is_array($html[$action])) {
							foreach ($html[$action] as $key=>$val) {
								$val['validator']['reg_msg'] = $val['validator']['reg_msg'] ? $val['validator']['reg_msg'] : $val['name'].L('inputerror');
								if ($val['htmltype'] != 'checkbox') {
									$$key = isset($_POST[$key]) && trim($_POST[$key]) ? trim($_POST[$key]) : '';
								} else {
									$$key = isset($_POST[$key]) && $_POST[$key] ? implode(',', $_POST[$key]) : '';
								}
								if (isset($val['ajax']['id']) && !empty($val['ajax']['id'])) {
									$data[$val['ajax']['id']]  = isset($_POST[$val['ajax']['id']]) && trim($_POST[$val['ajax']['id']]) ? trim($_POST[$val['ajax']['id']]) : '';
								}
								if (!empty($val['validator'])) {
									if (isset($val['validator']['min']) && strlen($$key) < $val['validator']['min']) {
										showmessage($val['name'].L('should').L('is_greater_than').$val['validator']['min'].L('lambda'));
									} 
									if (isset($val['validator']['max']) && strlen($$key) > $val['validator']['max']) {
										showmessage($val['name'].L('should').L('less_than').$val['validator']['max'].L('lambda'));
									} 
									if (!preg_match('/'.$val['validator']['reg'].'/'.$val['validator']['reg_param'], $$key)) {
										showmessage($val['name'].$val['validator']['reg_msg']);
									}
								}
								$data[$key] = $$key;
							}
						}
						
						$page = isset($_POST['page']) && trim($_POST['page']) ? trim($_POST['page']) : '';
						$num = isset($_POST['num']) && intval($_POST['num']) ? intval($_POST['num']) : 0;
						$return = isset($_POST['return']) && trim($_POST['return']) ? trim($_POST['return']) : '';
						$cache = isset($_POST['cache']) && intval($_POST['cache']) ? intval($_POST['cache']) : 0;
						$data['page'] = $page;
						$data['num'] = $num;
						$data['return']  = $return;
						$data['cache'] = $cache;
						
						$tag_md5_list = tag_md5($filepath);
						$pc_tag = creat_pc_tag($op, $data);
						if (in_array($tag_md5, $tag_md5_list[0])) {
							$old_pc_tag = $tag_md5_list[1][$tag_md5];
						}
						if(!file_exists($filepath)) showmessage($filepath.L('file_does_not_exists'));
						if (replace_pc_tag($filepath, $old_pc_tag, $pc_tag, $this->style, $dir)) {
							showmessage(L('operation_success').'<script style="text/javascript">top.art.dialog({id:"edit"}).close();</script>', '', '', 'edit');
						} else {
							showmessage(L('failure_the_document_may_not_to_write'));
						}
						
				}
				include $this->admin_tpl('pc_tag_modules');
				break;
		}
	}
}