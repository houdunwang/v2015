<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 消费记录类使用说明
 * @author chenzhouyu
 * 
 * 直接使用pc_base::load_app_class('spend', 'pay', 0);
 * 进行加载。
 * 使用spend::amount()进行金钱的消费
 * spend::point()进行积分消费
 * 当函数返回的结果为false是，可使用spend::get_msg()获取错误原因
 * 
 */
class spend {
	
	//数据库连接
	protected static $db;
	
	//错误代码
	public static $msg;
	
	/**
	 * 数据库连接
	 */
	protected  static function connect() {
		self::$db = pc_base::load_model("pay_spend_model");
	}
	
	/**
	 * 按用户名、时间、标识查询是否有消费记录
	 * @param integer $userid      用户名
	 * @param integer $time        时间。  从指定时间到现在的时间范围内。
	 * @param string $logo   标识
	 */
	public static function spend_time($userid, $time, $logo) {
		if (empty(self::$db)) {
			self::connect();
		}
		return self::$db->get_one("`userid` = '$userid' AND `creat_at` BETWEEN '$time' AND '".SYS_TIME."' AND `logo` = '$logo'");
	}
	
	/**
	 * 添加金钱消费记录
	 * @param integer $value          消费金额
	 * @param string $msg             消费信息
	 * @param integer $userid         用户ID
	 * @param string $username        用户名
	 * @param integer $op_userid      操作人
	 * @param string $op_username     操作人用户名
	 * @param string $logo            特殊标识，如文章消费时，可以对文章进行标识，以满足在一段时间内，都可以再次的使用
	 */
	public static function amount($value, $msg, $userid = '', $username = '', $op_userid = '', $op_username = '', $logo = '') {
		return self::_add(array('username'=>$username, 'userid'=>$userid, 'type'=>1, 'value'=>$value, 'op_userid'=>$op_userid, 'op_username'=>$op_username, 'msg'=>$msg,'logo'=>$logo));
	}
	
	/**
	 * 添加积分消费记录
	 * @param integer $value          消费金额
	 * @param string $msg             消费信息
	 * @param integer $userid         用户ID
	 * @param string $username        用户名
	 * @param integer $op_userid      操作人
	 * @param string $op_username     操作人用户名
	 * @param string $logo            特殊标识，如文章消费时，可以对文章进行标识，以满足在一段时间内，都可以再次的使用
	 */
	public static function point($value, $msg, $userid = '', $username = '', $op_userid = '', $op_username = '', $logo = '') {
		return self::_add(array('username'=>$username, 'userid'=>$userid, 'type'=>2, 'value'=>$value, 'op_userid'=>$op_userid, 'op_username'=>$op_username, 'msg'=>$msg,'logo'=>$logo));
	}
	
	/**
	 * 添加消费记录
	 * @param array $data 添加消费记录参数
	 */
	private static function _add($data) {
		$data['userid'] = isset($data['userid']) && intval($data['userid']) ? intval($data['userid']) : 0;
		$data['username'] = isset($data['username']) ? trim($data['username']) : '';
		$data['op_userid'] = isset($data['op_userid']) && intval($data['op_userid']) ? intval($data['op_userid']) : 0;
		$data['op_username'] = isset($data['op_username']) ? trim($data['op_username']) : '';
		$data['type'] = isset($data['type']) && intval($data['type']) ? intval($data['type']) : 0;
		$data['value'] = isset($data['value']) && intval($data['value']) ? abs(intval($data['value'])) : 0;
		$data['msg'] = isset($data['msg']) ? trim($data['msg']) : '';
		$data['logo'] = isset($data['logo']) ? trim($data['logo']) : '';
		$data['creat_at'] = SYS_TIME;
		
		//检察消费类型
		if (!in_array($data['type'], array(1,2))) {
			return false;
		}
		
		//检察消费描述
		if (empty($data['msg'])) {
			self::$msg = 1;
			return false;
		}
		
		//检察消费金额
		if (empty($data['value'])) {
			self::$msg = 2;
			return false;
		}
		
		//检察userid和username并偿试再次的获取
		if (empty($data['userid']) || empty($data['username'])) {
			if (defined('IN_ADMIN')) {
				self::$msg = 3;
				return false;
			} elseif (!$data['userid'] = param::get_cookie('_userid') || !$data['username'] = param::get_cookie('_username')) {
				self::$msg = 3;
				return false;
			} else {
				self::$msg = 3;
				return false;
			}
		}
		
		//检察op_userid和op_username并偿试再次的获取
		if (defined('IN_ADMIN') && (empty($data['op_userid']) || empty($data['op_username']))) {
			$data['op_username'] = param::get_cookie('admin_username');
			$data['op_userid'] = param::get_cookie('userid');
		}
		
		//数据库连接
		if (empty(self::$db)) {
			self::connect();
		}
		$member_db = pc_base::load_model('member_model');
		
		//判断用户的金钱或积分是否足够。
		if (!self::_check_user($data['userid'], $data['type'], $data['value'], $member_db)) {
			self::$msg = 6;
			return false;
		} 
				
		$sql = array();
		if ($data['type'] == 1) {//金钱方式消费
			$sql = array('amount'=>"-=".$data['value']);
		} elseif ($data['type'] == 2) { //积分方式消费
			$sql = array('point'=>'-='.$data['value']);
		} else {
			self::$msg = 7;
			return false;
		}
		
		//进入数据库操作
		if ($member_db->update($sql, array('userid'=>$data['userid'], 'username'=>$data['username'])) && self::$db->insert($data)) {
			self::$msg = 0;
			return true;
		} else {
			self::$msg = 8;
			return false;
		}
	}
	
/**
 * 判断用户的金钱、积分是否足够
 * @param integer $userid    用户ID
 * @param integer $type      判断（1：金钱，2：积分）
 * @param integer $value     数量
 * @param $db                数据库连接
 */
	private static function _check_user($userid, $type, $value, &$db) {
		if ($user = $db->get_one(array('userid'=>$userid), '`amount`, `point`')) {
			if ($type == 1) { //金钱消费
				if ($user['amount'] < $value) {
					return false;
				} else {
					return true;
				}
			} elseif ($type == 2) { //积分
				if ($user['point'] < $value) {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * 获取详细的报错信息
	 */
	public static function get_msg() {
		$msg = self::$msg;
		$arr = array(
			'1' => L('spend_msg_1', '', 'pay'),
			'2' => L('spend_msg_2', '', 'pay'),
			'3' => L('spend_msg_3', '', 'pay'),
			'6' => L('spend_msg_6', '', 'pay'),
			'7' => L('spend_msg_7', '', 'pay'),
			'8' => L('spend_msg_8', '', 'pay'),
		);
		return isset($arr[$msg]) ? $arr[$msg] : false;
	}
}