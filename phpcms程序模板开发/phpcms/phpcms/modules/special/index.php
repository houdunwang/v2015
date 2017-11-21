<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_func('global', 'special');
class index {
	
	private $db;
	
	function __construct() {
		$this->db = pc_base::load_model('special_model');
	}
	
	/**
	 * 专题列表 
	 */
	public function special() {
		$siteid = $_GET['siteid'] ? intval($_GET['siteid']) : (get_siteid() ? get_siteid() : 1);
		$SEO = seo($siteid);
		include template('special', 'special_list');
	}
	
	/**
	 * 专题首页
	 */
	public function init() {
		$specialid = $_GET['id'] ? intval($_GET['id']) : ($_GET['specialid'] ? intval($_GET['specialid']) : 0);
		if (!$specialid) showmessage(L('illegal_action'));
		$info = $this->db->get_one(array('id'=>$specialid, 'disabled'=>0));
		if(!$info) showmessage(L('special_not_exist'), 'back');
		extract($info);
		$css = get_css(unserialize($css));
		if(!$ispage) {
			$type_db = pc_base::load_model('type_model');
			$types = $type_db->select(array('module'=>'special', 'parentid'=>$specialid), '*', '', '`listorder` ASC, `typeid` ASC', '', 'listorder');
		}
		if ($pics) {
			$pic_data = get_pic_content($pics);
			unset($pics);
		}
		if ($voteid) {
			$vote_info = explode('|', $voteid);
			$voteid = $vote_info[1];
		}
		$siteid =  $_GET['siteid'] ? $_GET['siteid'] : get_siteid();
		$SEO = seo($siteid, '', $title, $description);
		$commentid = id_encode('special', $id, $siteid);
		$template = $info['index_template'] ? $info['index_template'] : 'index';
		define('STYLE',$info['style']);
		include template('special', $template);
	}
	
	/**
	 * 专题分类
	 */
	public function type() {
		$typeid = intval($_GET['typeid']);
		$specialid = intval($_GET['specialid']);
		if (!$specialid || !$typeid) showmessage(L('illegal_action'));
		$info = $this->db->get_one(array('id'=>$specialid, 'disabled'=>0));
		if(!$info) showmessage(L('special_not_exist'), 'back');
		$page = max(intval($_GET['page']), 1);
		extract($info);
		$css = get_css(unserialize($css));
		if(!$typeid) showmessage(L('illegal_action'));
		$type_db = pc_base::load_model('type_model');
		$info = $type_db->get_one(array('typeid'=>$typeid));
		$SEO = seo($siteid, '', $info['typename'], '');
		$template = $list_template ? $list_template : 'list';
 		include template('special', $template);
	}
	
	/**
	 * 专题展示
	 */
	public function show() {
		$id = intval($_GET['id']);
		if(!$id) showmessage(L('content_not_exist'),'blank');
		
		$page = $_GET['page'];
		$c_db = pc_base::load_model('special_content_model');
		$c_data_db = pc_base::load_model('special_c_data_model');
		$rs = $c_db->get_one(array('id'=>$id));
 		if(!$rs) showmessage(L('content_checking'),'blank');
		extract($rs);
		if ($isdata) {
			$arr_content = $c_data_db->get_one(array('id'=>$id));
			if (is_array($arr_content)) extract($arr_content);
		}
		$siteid = get_siteid();
		if ($paginationtype) { 			//文章使用分页时
			if($paginationtype==1) {
				if (strpos($content, '[/page]')!==false) {
					$content = preg_replace("|\[page\](.*)\[/page\]|U", '', $content);
				}
				if (strpos($content, '[page]')!==false) {
					$content = str_replace('[page]', '', $content);
				}
				$contentpage = pc_base::load_app_class('contentpage', 'content'); //调用自动分页类
				$content = $contentpage->get_data($content, $maxcharperpage); //自动分页，自动添加上[page]
			} 
		} else {
			if (strpos($content, '[/page]')!==false) {
				$content = preg_replace("|\[page\](.*)\[/page\]|U", '', $content);
			}
			if (strpos($content, '[page]')!==false) {
				$content = str_replace('[page]', '', $content);
			}
		}
		$template = $show_template ? $show_template : 'show'; //调用模板
		$CONTENT_POS = strpos($content, '[page]');
		if ($CONTENT_POS !== false) {
			$contents = array_filter(explode('[page]', $content));
			$pagenumber = count($contents);
			$END_POS = strpos($content, '[/page]');
			if ($END_POS!==false && ($CONTENT_POS<7)) {
				$pagenumber--;
			}
			for ($i=1; $i<=$pagenumber; $i++) {
				$pageurls[$i] = content_url($id, $i, $inputtime, 'php');
			}
			if ($END_POS !== false) {
				if($CONTENT_POS>7) {
					$content = '[page]'.$title.'[/page]'.$content;
				}
				if (preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
					foreach ($m[1] as $k=>$v) {
						$p = $k+1;
						$titles[$p]['title'] = strip_tags($v);
						$titles[$p]['url'] = $pageurls[$p][1];
					}
				}
			}
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
			pc_base::load_app_func('util', 'content');
			$title_pages = content_pages($pagenumber,$page, $pageurls);
		}
		$_special = $this->db->get_one(array('id'=>$specialid), '`title`, `url`, `show_template`, `isvideo`');
		if ($_special['isvideo']) {
			$video_store = pc_base::load_model('video_store_model');
			$v_r = $video_store->get_one(array('videoid'=>$videoid), 'vid');
			$video['vid'] = $v_r['vid'];
		}
		pc_base::load_sys_class('format', '', 0);
		$inputtime = format::date($inputtime,1);
		$SEO = seo($siteid, '', $title);
		$template = $show_template ? $show_template : ($_special['show_template'] ? $_special['show_template'] : 'show');
		$style = $style ? $style : 'default';
		include template('special', $template, $style);
	}
	
	public function comment_show() {
		$commentid = isset($_GET['commentid']) ? $_GET['commentid'] : 0;
		$url = isset($_GET['url']) ? $_GET['url'] : HTTP_REFERER;
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$userid = param::get_cookie('_userid');
		include template('special', 'comment_show');
	}
	
	public function comment() {
		if (!$_GET['id']) return '0';
		$siteid =  $_GET['siteid'] ? $_GET['siteid'] : get_siteid();
		$id = intval($_GET['id']);
		$commentid = id_encode('special', $id, $siteid);
		$username = param::get_cookie('_username');
		$userid = param::get_cookie('_userid');
		if (!$userid) {
			showmessage(L('login_website'), APP_PATH.'index.php?m=member&c=index');
		}
		$date = date('m-d H:i', SYS_TIME);
		if ($_POST['dosubmit']) {
			$r = $this->db->get_one(array('id'=>intval($_POST['id'])), '`title`, `url`');
			$comment = pc_base::load_app_class('comment', 'comment');
			if ($comment->add($commentid, $siteid, array('userid'=>$userid, 'username'=>$username, 'content'=>addslashes($_POST['content'])), '', $r['title'], $r['url'])) {
				exit(remove_xss($username.'|'.SYS_TIME.'|'.$_POST['content']));
			} else {
				exit(0);
			}
		} else {
			pc_base::load_sys_class('form');
			include template('special', 'comment');
		}
	}
}
?>