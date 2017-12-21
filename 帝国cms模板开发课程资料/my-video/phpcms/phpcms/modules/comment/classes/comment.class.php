<?php
/**
 * 评论操作类
 * @author chenzhouyu
 *
 */
class comment {
	//数据库连接
	private $comment_db, $comment_setting_db, $comment_data_db, $comment_table_db, $comment_check_db;
	
	public $msg_code = 0;
	
	public function __construct() {
		$this->comment_db = pc_base::load_model('comment_model');
		$this->comment_setting_db = pc_base::load_model('comment_setting_model');
		$this->comment_data_db = pc_base::load_model('comment_data_model');
		$this->comment_table_db = pc_base::load_model('comment_table_model');
		$this->comment_check_db = pc_base::load_model('comment_check_model');
	}
	
	/**
	 * 添加评论
	 * @param string $commentid 评论ID
	 * @param integer $siteid 站点ID
	 * @param array $data 内容数组应该包括array('userid'=>用户ID，'username'=>用户名,'content'=>内容,'direction'=>方向（0:没有方向 ,1:正方,2:反方,3:中立）)
	 * @param string $id 回复评论的内容
	 * @param string $title 文章标题
	 * @param string $url 文章URL地址
	 */
	public function add($commentid, $siteid, $data, $id = '', $title = '', $url = '') {
		//开始查询评论这条评论是否存在。
		$title = new_addslashes($title);
		if (!$comment = $this->comment_db->get_one(array('commentid'=>$commentid, 'siteid'=>$siteid), 'tableid, commentid')) { //评论不存在
			//取得当前可以使用的内容数据表
			$r = $this->comment_table_db->get_one('', 'tableid, total', 'tableid desc');
			$tableid = $r['tableid'];
			if ($r['total'] >= 1000000) {
				//当上一张数据表存的数据已经达到1000000时，创建新的数据存储表，存储数据。
				if (!$tableid = $this->comment_table_db->creat_table()) {
					$this->msg_code = 4;
					return false;
				}
			}
			//新建评论到评论总表中。
			$comment_data = array('commentid'=>$commentid, 'siteid'=>$siteid, 'tableid'=>$tableid, 'display_type'=>($data['direction']>0 ? 1 : 0));
			if (!empty($title)) $comment_data['title'] = $title;
			if (!empty($url)) $comment_data['url'] = $url;
			if (!$this->comment_db->insert($comment_data)) {
				$this->msg_code = 5;
				return false;
			}
		} else {//评论存在时
			$tableid = $comment['tableid'];
		}
		if (empty($tableid)) {
			$this->msg_code = 1;
			return false;
		}
		//为数据存储数据模型设置 数据表名。
		$this->comment_data_db->table_name($tableid);
		//检查数据存储表。
		if (!$this->comment_data_db->table_exists('comment_data_'.$tableid)) {
			//当存储数据表不存时，尝试创建数据表。
			if (!$tableid = $this->comment_table_db->creat_table($tableid)) {
				$this->msg_code = 2;
				return false;
			}
		}
		//向数据存储表中写入数据。	
		$data['commentid'] = $commentid;
		$data['siteid'] = $siteid;
		$data['ip'] = ip();
		$data['status'] = 1;
		$data['creat_at'] = SYS_TIME;
		//对评论的内容进行关键词过滤。
		$data['content'] = strip_tags($data['content']);
		$badword = pc_base::load_model('badword_model');
		$data['content'] = $badword->replace_badword($data['content']);
		if ($id) {
			$r = $this->comment_data_db->get_one(array('id'=>$id));
			if ($r) {
				pc_base::load_sys_class('format', '', 0);
				if ($r['reply']) {
					$data['content'] = '<div class="content">'.str_replace('<span></span>', '<span class="blue f12">'.$r['username'].' '.L('chez').' '.format::date($r['creat_at'], 1).L('release').'</span>', $r['content']).'</div><span></span>'.$data['content'];
				} else {
					$data['content'] = '<div class="content"><span class="blue f12">'.$r['username'].' '.L('chez').' '.format::date($r['creat_at'], 1).L('release').'</span><pre>'.$r['content'].'</pre></div><span></span>'.$data['content'];
				}
				$data['reply'] = 1;
			}
		}
		//判断当前站点是否需要审核
		$site = $this->comment_setting_db->site($siteid);
		if ($site['check']) {
			$data['status'] = 0;
		}
		$data['content'] = addslashes($data['content']);
		if ($comment_data_id = $this->comment_data_db->insert($data, true)) {
			//需要审核，插入到审核表
			if ($data['status']==0) {
				$this->comment_check_db->insert(array('comment_data_id'=>$comment_data_id, 'siteid'=>$siteid,'tableid'=>$tableid));
			} elseif (!empty($data['userid']) && !empty($site['add_point']) && module_exists('pay')) { //不需要审核直接给用户添加积分
				pc_base::load_app_class('receipts', 'pay', 0);
				receipts::point($site['add_point'], $data['userid'], $data['username'], '', 'selfincome', 'Comment');
			}
			//开始更新数据存储表数据总条数
			$this->comment_table_db->edit_total($tableid, '+=1');
			//开始更新评论总表数据总数
			$sql['lastupdate'] = SYS_TIME;
			//只有在评论通过的时候才更新评论主表的评论数
			if ($data['status'] == 1) {
				$sql['total'] = '+=1';
				switch ($data['direction']) {
					case 1: //正方
						$sql['square'] = '+=1';
						break;
					case 2://反方
						$sql['anti'] = '+=1';
						break;
					case 3://中立方
						$sql['neutral'] = '+=1';
						break;
				}
			}
			$this->comment_db->update($sql, array('commentid'=>$commentid));
			if ($site['check']) {
				$this->msg_code = 7;
			} else {
				$this->msg_code = 0;
			}
			return true;
		} else {
			$this->msg_code = 3;
			return false;
		}
	}
	
	/**
	 * 支持评论
	 * @param integer $commentid    评论ID
	 * @param integer $id           内容ID
	 */
	public function support($commentid, $id) {
		if ($data = $this->comment_db->get_one(array('commentid'=>$commentid), 'tableid')) {
			$this->comment_data_db->table_name($data['tableid']);
			if ($this->comment_data_db->update(array('support'=>'+=1'), array('id'=>$id))) {
				$this->msg_code = 0;
				return true;
			} else {
				$this->msg_code = 3;
				return false;
			}
		} else {
			$this->msg_code = 6;
			return false;
		}
	}
	
	/**
	 * 更新评论的状态
	 * @param string $commentid      评论ID 
	 * @param integer $id            内容ID
	 * @param integer $status        状态{1:通过 ,0:未审核， -1:不通过,将做删除操作}
	 */
	public function status($commentid, $id, $status = -1) {
		if (!$comment = $this->comment_db->get_one(array('commentid'=>$commentid), 'tableid, commentid')) {
			$this->msg_code = 6;
			return false;
		}
		
		//为数据存储数据模型设置 数据表名。
		$this->comment_data_db->table_name($comment['tableid']);
		if (!$comment_data = $this->comment_data_db->get_one(array('id'=>$id, 'commentid'=>$commentid))) {
			$this->msg_code = 6;
			return false;
		}
		
		//读取评论的站点配置信息
		$site = $this->comment_setting_db->get_one(array('siteid'=>$comment_data['siteid']));
		
		
		if ($status == 1) {//通过的时候
			$sql['total'] = '+=1';
			switch ($comment_data['direction']) {
				case 1: //正方
					$sql['square'] = '+=1';
					break;
				case 2://反方
					$sql['anti'] = '+=1';
					break;
				case 3://中立方
					$sql['neutral'] = '+=1';
					break;
			}
			
			//当评论被设置为通过的时候，更新评论总表的数量。
			$this->comment_db->update($sql, array('commentid'=>$comment['commentid']));
			//更新评论内容状态
			$this->comment_data_db->update(array('status'=>$status), array('id'=>$id, 'commentid'=>$commentid));
			
			//当评论用户ID不为空，而且站点配置了积分添加项，支付模块也存在的时候，为用户添加积分。
			if (!empty($comment_data['userid']) && !empty($site['add_point']) && module_exists('pay')) {
				pc_base::load_app_class('receipts', 'pay', 0);
				receipts::point($site['add_point'], $comment_data['userid'], $comment_data['username'], '', 'selfincome', 'Comment');
			}
			
		} elseif ($status == -1) { //删除数据
			//如果数据原有状态为已经通过，需要删除评论总表中的总数
			if ($comment_data['status'] == 1) {
				$sql['total'] = '-=1';
				switch ($comment_data['direction']) {
					case '1': //正方
						$sql['square'] = '-=1';
						break;
					case '2'://反方
						$sql['anti'] = '-=1';
						break;
					case '3'://中立方
						$sql['neutral'] = '-=1';
						break;
				}
				$this->comment_db->update($sql, array('commentid'=>$comment['commentid']));
			}
			
			//删除存储表的数据
			$this->comment_data_db->delete(array('id'=>$id, 'commentid'=>$commentid));
			//删除存储表总数记录,判断总数是否为0，否则不能再删除了。
			$this->comment_table_db->edit_total($comment['tableid'], '-=1');
			
			//当评论ID不为空，站点配置了删除的点数，支付模块存在的时候，删除用户的点数。
			if (!empty($comment_data['userid']) && !empty($site['del_point']) && module_exists('pay')) {
				pc_base::load_app_class('spend', 'pay', 0);
				$op_userid = param::get_cookie('userid');
				$op_username = param::get_cookie('admin_username');
				spend::point($site['del_point'], L('comment_point_del', '', 'comment'), $comment_data['userid'], $comment_data['username'], $op_userid, $op_username);
			}
		}
		
		//删除审核表中的数据
		$this->comment_check_db->delete(array('comment_data_id'=>$id));
		
		$this->msg_code = 0;
		return true;
	}
	
	/**
	 * 
	 * 删除评论
	 * @param string $commentid 评论ID
	 * @param intval $siteid 站点ID
	 * @param intval $id 内容ID
	 * @param intval $catid 栏目ID
	 */
	public function del($commentid, $siteid, $id, $catid) {
		if ($commentid != id_encode('content_'.$catid, $id, $siteid)) return false;
		//循环评论内容表删除commentid的评论内容
		for ($i=1; ;$i++) {
			$table = 'comment_data_'.$i; //构建评论内容存储表名
			if ($this->comment_data_db->table_exists($table)) { //检查构建的表名是否存在，如果存在执行删除操作
				$this->comment_data_db->table_name($i);
				$this->comment_data_db->delete(array('commentid'=>$commentid));
			} else { //不存在，则退出循环
				break;
			}
		}
		$this->comment_db->delete(array('commentid'=>$commentid)); //删除评论主表的内容
		return true;
	}
	
	/**
	 * 
	 * 获取报错的详细信息。
	 */
	public function get_error() {
		$msg = array('0'=>L('operation_success'),
		'1'=>L('coment_class_php_1'),
		'2'=>L('coment_class_php_2'),
		'3'=>L('coment_class_php_3'),
		'4'=>L('coment_class_php_4'),
		'5'=>L('coment_class_php_5'),
		'6'=>L('coment_class_php_6'),
		'7'=>L('coment_class_php_7'),
		);
		return $msg[$this->msg_code];
	}
}