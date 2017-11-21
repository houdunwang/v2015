<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('http', '', 0);

class messagequeue extends admin {

	private $db;
	/**
	 * 析构函数
	 */
	public function __construct() {	
		parent::__construct();
		$this->db = pc_base::load_model('messagequeue_model');
	}
	
	/**
	 * 队列管理
	 */
	public function manage() {
		$where = '';
		$messagequeue = array();
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$messagequeuearr = $this->db->listinfo($where, 'id DESC', $page, 12);
		
		foreach ($messagequeuearr as $k=>$v) {
			$messagequeue[] = $v;
			$messagequeue[$k]['appstatus'] = json_decode($v['appstatus'], 1);
		}
		$pages = $this->db->pages;
		$applist = getcache('applist');

		include $this->admin_tpl('messagequeue_list');
	}
	

	/**
	 * 删除队列信息
	 */
	public function delete() {
		$idarr = isset($_POST['id']) ? $_POST['id'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$idarr = array_map("intval",$idarr);
		$where = to_sqls($idarr, '', 'id');
		if ($this->db->delete($where)) {
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * 重新通知
	 */
	public function renotice() {
		$noticeid = isset($_POST['noticeid']) ? intval($_POST['noticeid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$appid = isset($_POST['appid']) ? $_POST['appid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		if ($noticeinfo = $this->db->get_one(array('id'=>$noticeid))) {
			//通知app noticedata 返回通知成功的appid 1
			//debug post appid.phpsso.php?data=noticeinfo[noticedata];
			$applist = getcache('applist');
			$url = $applist[$appid]['url'].$applist[$appid]['apifilename'];
			$data = string2array($noticeinfo['noticedata']);
			$data['action'] = $noticeinfo['operation'];
			
			//转换中文编码
			if (CHARSET != $applist[$appid]['charset'] && isset($data['action']) && $data['action'] == 'member_add') {
				if(isset($data['username']) && !empty($data['username'])) {
					if(CHARSET == 'utf-8') {	//判断phpsso字符集是否为utf-8编码
						//应用字符集如果是utf-8，并且用户名是utf-8编码，转换用户名为phpsso字符集，如果为英文，is_utf8返回false，不进行转换
						if(!is_utf8($data['username'])) {
							$data['username'] = iconv(CHARSET, $applist[$appid]['charset'], $data['username']);
						}
					} else {
						if(!is_utf8($data['username'])) {
							$data['username'] = iconv(CHARSET, $applist[$appid]['charset'], $data['username']);
						}
					}
				}
			}
			$tmp_s = strstr($url, '?') ? '&' : '?';
			$status = ps_send($url.$tmp_s.'appid='.$appid, $data, $applist[$appid]['authkey']);

			//通信次数+1
			$this->db->update(array('totalnum'=>'+=1', 'dateline'=>SYS_TIME), array('id'=>$noticeid));
			
			if($status == 1) {
				//重置消息队列app通信状态
				$appstatusarr = json_decode($noticeinfo['appstatus'], 1);
				$appstatusarr[$appid] = 1;
				$appstatus = json_encode($appstatusarr);
				
				//全部通知成功后更新消息队列状态
				if (!strstr($appstatus, ':0')) {
					$this->db->update(array('succeed'=>1), array('id'=>$noticeid));
				}
				
				//更新消息队列
				$this->db->update(array('appstatus'=>$appstatus), array('id'=>$noticeid));
				exit('1');
			} else {
				exit('0');
			}
		} else {
			exit('0');
		}
	}
		
}
?>