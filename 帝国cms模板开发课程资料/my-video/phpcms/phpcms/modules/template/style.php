<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
class style extends admin {
	//模板文件夹
	private $filepath;
	
	public function __construct() {
		$this->filepath = PC_PATH.'templates'.DIRECTORY_SEPARATOR;
		parent::__construct();
	}
	
	public function init() {
		pc_base::load_app_func('global', 'admin');
		$list = template_list('', 1);
		$big_menu = array('javascript:window.top.art.dialog({id:\'import\',iframe:\'?m=template&c=style&a=import\', title:\''.L('import_style').'\', width:\'500\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'import\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'import\'}).close()});void(0);', L('import_style'));
		include $this->admin_tpl('style_list');
	}
	
	public function disable() {
		$style = isset($_GET['style']) && trim($_GET['style']) ? trim($_GET['style']) : showmessage(L('illegal_operation'), HTTP_REFERER);
		if (!preg_match('/([a-z0-9_\-]+)/i',$style)) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
		$filepath = $this->filepath.$style.DIRECTORY_SEPARATOR.'config.php';
		if (file_exists($filepath)) {
			$arr = include $filepath;
			if (!isset($arr['disable'])) {
				$arr['disable'] = 1;
			} else {
				if ($arr['disable'] ==1 ) {
					$arr['disable'] = 0;
				} else {
					$arr['disable'] = 1;
				}
			}
			if (is_writable($filepath)) {
				file_put_contents($filepath, '<?php return '.var_export($arr, true).';?>');
			} else {
				showmessage(L('file_does_not_writable'), HTTP_REFERER);
			}
		} else {
			$arr = array('name'=>$style,'disable'=>1, 'dirname'=>$style);
			file_put_contents($filepath, '<?php return '.var_export($arr, true).';?>');
		}
		showmessage(L('operation_success'), HTTP_REFERER);
	}
	
	public function export() {
		$style = isset($_GET['style']) && trim($_GET['style']) ? trim($_GET['style']) : showmessage(L('illegal_operation'), HTTP_REFERER);
		if (!preg_match('/([a-z0-9_\-]+)/i',$style)) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
		$filepath = $this->filepath.$style.DIRECTORY_SEPARATOR.'config.php';
		if (file_exists($filepath)) {
			$arr = include $filepath;
			if (pc_base::load_config('system', 'charset') == 'gbk') {
				$arr = array_iconv($arr);
			}
			$data = base64_encode(json_encode($arr));
		    header("Content-type: application/octet-stream");
		    header("Content-Disposition: attachment; filename=pc_template_".$style.'.txt');
		    echo $data;
		} else {
			showmessage(L('file_does_not_exists'), HTTP_REFERER);
		}
	}
	
	public function import() {
		if (isset($_POST['dosubmit'])) {
			$type = isset($_POST['type']) && trim($_POST['type']) ? trim($_POST['type']) : showmessage(L('illegal_operation'), HTTP_REFERER);
			if ($type == 1) {
				$filename = $_FILES['file']['tmp_name'];
				if (strtolower(substr($_FILES['file']['name'], -3, 3)) != 'txt') {
					showmessage(L('only_allowed_to_upload_txt_files'), HTTP_REFERER);
				}
				$code = json_decode(base64_decode(file_get_contents($filename)), true);
				if (!preg_match('/([a-z0-9_\-]+)/i',$code['dirname'])) {
					showmessage(L('illegal_parameters'), HTTP_REFERER);
				}
				@unlink($filename);
			} elseif ($type == 2) {
				$code = isset($_POST['code']) && trim($_POST['code']) ? json_decode(base64_decode(trim($_POST['code'])),true) : showmessage(L('illegal_operation'), HTTP_REFERER);
				if (!isset($code['dirname']) && !preg_match('/([a-z0-9_\-]+)/i',$code['dirname'])) {
					showmessage(L('illegal_parameters'), HTTP_REFERER);
				}
			}
			if (pc_base::load_config('system', 'charset') == 'gbk') {
				$code = array_iconv($code, 'utf-8', 'gbk');
			}
			//echo $this->filepath.$code['dirname'].DIRECTORY_SEPARATOR.'config.php';
			if (!file_exists($this->filepath.$code['dirname'].DIRECTORY_SEPARATOR.'config.php')) {
				@mkdir($this->filepath.$code['dirname'].DIRECTORY_SEPARATOR, 0755, true);
				if (@is_writable($this->filepath.$code['dirname'].DIRECTORY_SEPARATOR)) {
					@file_put_contents($this->filepath.$code['dirname'].DIRECTORY_SEPARATOR.'config.php', '<?php return '.var_export($code, true).';?>');
					showmessage(L('operation_success'), HTTP_REFERER, '', 'import');
				} else {
					showmessage(L('template_directory_not_write'), HTTP_REFERER);
				}
			} else {
				showmessage(L('file_exists'), HTTP_REFERER);
			}
		} else {
			$show_header = true;
			include $this->admin_tpl('style_import');
		}
	}
	
	public function updatename() {
		$name = isset($_POST['name']) ? $_POST['name'] : showmessage(L('illegal_operation'), HTTP_REFERER);
		if (is_array($name)) {
			foreach ($name as $key=>$val) {
				$filepath = $this->filepath.$key.DIRECTORY_SEPARATOR.'config.php';
				if (file_exists($filepath)) {
					$arr = include $filepath;
					$arr['name'] = $val;
				} else {
					$arr = array('name'=>$val,'disable'=>0, 'dirname'=>$key);
				}
				@file_put_contents($filepath, '<?php return '.var_export($arr, true).';?>');
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
	}
}