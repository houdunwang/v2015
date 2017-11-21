<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

$session_storage = 'session_'.pc_base::load_config('system','session_storage');
pc_base::load_sys_class($session_storage);
pc_base::load_sys_func('iconv');
/**
 * 
 * ------------------------------------------
 * video_for_ck
 * ------------------------------------------
 * @package 	PHPCMS V9.1.16
 * @author		王参加
 * @copyright	CopyRight (c) 2006-2012 上海盛大网络发展有限公司
 * 
 */

class video_for_ck {
	
	public $db;
	
	public function __construct() {
		$this->db = pc_base::load_model('video_store_model');
		pc_base::load_app_class('ku6api', 'video', 0);
		$this->userid = param::get_cookie('_userid');
		pc_base::load_app_class('v', 'video', 0);
		$this->v =  new v($this->db);

		$this->setting = getcache('video', 'video');
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
	}
	
	/**
	 * 
	 * 视频列表
	 */
	public function init() {
		
		if (!$this->check_priv('video2content')) {
			showmessage('您没有权限操作该项','blank');
		}
		$where = '`status`=21';
		$page = max(intval($_GET['page']), 1);
		$pagesize = 6;
		if (!param::get_cookie('admin_username')) {
			$where .= " AND `userid`='".$this->userid."'";
		}
		$infos = $this->db->listinfo($where, 'videoid DESC', $page, $pagesize);
		$number = $this->db->number;
		$pages = $this->pages($number, $page, $pagesize, 4, 'get_videoes');
		$flash_info = $this->ku6api->flashuploadparam();

		include template('content','video_for_ck');
	}
	
	public function search() {
		$title = safe_replace($_GET['title']);
		if (CHARSET=='gbk') {
			$title = utf8_to_gbk($title);
		}
		$where = '`status`=21';
		if ($title) {
			$where .= ' AND `title` LIKE \'%'.$title.'%\'';
		}
		$userupload = intval($_GET['userupload']);
		if ($userupload) {
			$where .= ' AND `userupload`=1';
		}
		$page = $_GET['page'];
		$pagesize = 6;
		$infos = $this->db->listinfo($where, 'videoid DESC', $page, $pagesize);
		$number = $this->db->number;
		$pages = $this->pages($number, $page, $pagesize, 4, 'get_videoes');
		if (is_array($infos) && !empty($infos)) {
			$html = '';
			foreach ($infos as $info) {
				$html .= '<li><div class="w9"><a href="javascript:void(0);" onclick="a_click(this);" title="'.$info['title'].'" data-vid="'.$info['vid'].'" ><span></span><img src="'.$info['picpath'].'" width="90" height="51" /></a><p>'.str_cut($info['title'], 18).'</p></div></li>';
			}
		}
		$data['pages'] = $pages;
		$data['html'] = $html;
		if (CHARSET=='gbk') {
			$data = gbk_to_utf8($data);
		}
		exit(json_encode($data));
	}
	
	/**
	 * Function add_f_ckeditor
	 * ckeditor中添加视频
	 */
	public function add_f_ckeditor () {
		//首先处理，提交过来的数据

		$data = array();
		$data['vid'] = $_GET['vid'];
		if (!$data['vid']) exit('1');
		$data['title'] = isset($_GET['title']) && trim($_GET['title']) ? addslashes(trim($_GET['title'])) : exit('2');
		$data['title'] = safe_replace($data['title']);
		$data['title'] = str_replace(array('select','from','concat'),'',$data['title']);
		$data['description'] = addslashes(trim($_GET['description']));
		$data['description'] = safe_replace(str_replace(array('select','from','concat'),'',$data['description']));
		$data['keywords'] = addslashes(trim(strip_tags($_GET['keywords'])));
		$data['keywords'] = safe_replace(str_replace(array('select','from','concat'),'',$data['keywords']));
		//其次向vms post数据，并取得返回值
		$get_data = $this->ku6api->vms_add($data);
		if (!$get_data) {
			exit('3');
		}
		$data['vid'] = $get_data['vid'];
		$data['addtime'] = SYS_TIME;
		if (strtolower(CHARSET)=='gbk') {
			$data = array_utf8_to_gbk($data);
		}
		$data['userupload'] = intval($_GET['userupload']);
		$videoid = $this->v->add($data);
		$vid_url = $data['vid'];
		
		exit($vid_url);
	}
	
	/**
	 * Funtion pages
	 * 视频分页
	 * @param int $number 总页数 
	 * @param int $page 当前页
 	 * @param int $pagesize 每页数量
 	 * @param string $js JS属性
	 */
	private function pages($num, $curr_page, $perpage = 20, $setpages = 5, $js = '') {
		$urlrule = url_par('page={$page}');
		$multipage = '';
		if($num > $perpage) {
			$page = $setpages+1;
			$offset = ceil($setpages/2-1);
			$pages = ceil($num / $perpage);
			if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
			$from = $curr_page - $offset;
			$to = $curr_page + $offset;
			$more = 0;
			if($page >= $pages) {
				$from = 2;
				$to = $pages-1;
			} else {
				if($from <= 1) {
					$to = $page-1;
					$from = 2;
				}  elseif($to >= $pages) {
					$from = $pages-($page-2);
					$to = $pages-1;
				}
				$more = 1;
			}
			$multipage .= '<a class="a1">'.$num.L('page_item').'</a>';
			if($curr_page>0) {
				$multipage .= ' <a href="javascript:void(0);" onclick="'.$js.'('.intval($curr_page-1).')" class="a1">'.L('previous').'</a>';
				if($curr_page==1) {
					$multipage .= ' <span>1</span>';
				} elseif($curr_page>3 && $more) {
					$multipage .= ' <a href="javascript:void(0);" onclick="'.$js.'(1)">1</a>..';
				} else {
					$multipage .= ' <a href="javascript:void(0);" onclick="'.$js.'(1)">1</a>';
				}
			}
			for($i = $from; $i <= $to; $i++) {
				if($i != $curr_page) {
					$multipage .= ' <a href="javascript:void(0);" onclick="'.$js.'('.$i.')">'.$i.'</a>';
				} else {
					$multipage .= ' <span>'.$i.'</span>';
				}
			}
			if($curr_page<$pages) {
				if($curr_page<$pages-2 && $more) {
					$multipage .= ' ..<a href="javascript:void(0);" onclick="'.$js.'('.$pages.')">'.$pages.'</a> <a href="javascript:void(0);" onclick="'.$js.'('.intval($curr_page+1).')" class="a1">'.L('next').'</a>';
				} else {
					$multipage .= ' <a href="javascript:void(0);" onclick="'.$js.'('.$pages.')">'.$pages.'</a> <a href="javascript:void(0);" onclick="'.$js.'('.intval($curr_page+1).')" class="a1">'.L('next').'</a>';
				}
			} elseif($curr_page==$pages) {
				$multipage .= ' <span>'.$pages.'</span> <a href="javascript:void(0);" onclick="'.$js.'('.$curr_page.')" class="a1">'.L('next').'</a>';
			} else {
				$multipage .= ' <a href="javascript:void(0);" onclick="'.$js.'('.$pages.')">'.$pages.'</a> <a href="javascript:void(0);" onclick="'.$js.'('.intval($curr_page+1).')" class="a1">'.L('next').'</a>';
			}
		}
		return $multipage;
	}
	
	/**
	 * Function CHECK_VID
	 * 检查vid是否可用
	 */
	public function check_vid() {
		$vid = $_GET['vid'];
		$r = $this->db->get_one(array('vid'=>$vid));
		if (is_array($r)) {
			$data = player_code('video_player',$r['channelid'],$r['vid'],300,225);
			exit($data);
		} else {
			exit(1);
		}
		$url = pc_base::load_config('ku6server', 'player_url').$vid.'/style/'.$this->setting['style_projectid'].'/';
		$data = @file_get_contents($url);
		if ($data = json_decode($data,true)) {
			if ($data['code']<0) {
				exit($data['msg']);
			} else {
				exit('1');
			}
		} else {
			exit('1');
		}
	}

	/**
	 * Function CHECK_priv
	 * 检查权限
	 */
	private function check_priv($action = '') {
		if (!$action) $action = 'init';
		if (isset($_SESSION['roleid']) && !$_SESSION['roleid'] && $_SESSION['roleid']!=1) {
			$siteid = get_siteid();
			$admin_role_priv_db = pc_base::load_model('admin_role_priv_model');
			$r = $admin_role_priv_db->get_one(array('m'=>'video','c'=>'video','a'=>$action,'roleid'=>$_SESSION['roleid'],'siteid'=>$siteid));
			if ($r) return true;
			else return false;
		} else {
			return true;
		}
	}
}

?>