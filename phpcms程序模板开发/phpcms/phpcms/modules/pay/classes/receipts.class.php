<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
pc_base::load_app_func('global','pay');
class receipts {
	
	//数据库连接
	protected static $db;
	
	/**
	 * 数据库连接
	 */
	protected  static function connect() {
		self::$db = pc_base::load_model("pay_account_model");
	}
	
	
	/**
	 * 添加金钱入账记录
	 * 添加金钱入账记录操作放放
	 * @param integer $value 入账金额
	 * @param integer $userid 用户ID
	 * @param string $username 用户名
	 * @param integer $trand_sn 操作订单ID,默认为自动生成
	 * @param string $pay_type 入账类型 （可选值  offline 线下充值，recharge 在线充值，selfincome 自助获取）
	 * @param string $payment 入账方式  （如后台充值，支付宝，银行汇款/转账等此处为自定义）
	 * @param string $status 入账状态  （可选值  succ 默认，入账成功，error 入账失败）注当且仅当为‘succ’时更改member数据
	 * @param string  $op_username 管理员信息
	 */
	public static function amount($value, $userid = '' , $username = '', $trade_sn = '', $pay_type = '', $payment = '', $op_username = '', $status = 'succ', $note = '') {
		return self::_add(array('username'=>$username, 'userid'=>$userid,'money'=>$value, 'trade_sn'=>$trade_sn, 'pay_type'=>$pay_type, 'payment'=>$payment, 'status'=>$status, 'type'=>1, 'adminnote'=>$op_username, 'usernote'=>$note));
	}
	
	/**
	 * 添加点数入账记录
	 * 添加点数入账记录操作放放
	 * @param integer $value 入账金额
	 * @param integer $userid 用户ID
	 * @param string $username 用户名
	 * @param integer $trade_sn 操作订单ID,默认为自动生成
	 * @param string $pay_type 入账类型 （可选值  offline 线下充值，recharge 在线充值，selfincome 自助获取）
	 * @param string $payment 入账方式  （如后台充值，支付宝，银行汇款/转账等此处为自定义）
	 * @param string $status 入账状态  （可选值  succ 默认，入账成功，failed 入账失败）
	 * @param string  $op_username 管理员信息
	 */
	public static function point($value, $userid = '' , $username = '', $trade_sn = '', $pay_type = '', $payment = '', $op_username = '', $status = 'succ', $note = '') {
		return self::_add(array('username'=>$username, 'userid'=>$userid,'money'=>$value, 'trade_sn'=>$trade_sn, 'pay_type'=>$pay_type, 'payment'=>$payment, 'status'=>$status, 'type'=>2, 'adminnote'=>$op_username, 'usernote'=>$note));
	}
	
	/**
	 * 添加入账记录
	 * @param array $data 添加入账记录参数
	 */
	private static function _add($data) {
		$data['money'] = isset($data['money']) && floatval($data['money']) ? floatval($data['money']) : 0;
		$data['userid'] = isset($data['userid']) && intval($data['userid']) ? intval($data['userid']) : 0;
		$data['username'] = isset($data['username']) ? trim($data['username']) : '';
		$data['trade_sn'] = (isset($data['trade_sn']) && $data['trade_sn']) ? trim($data['trade_sn']) : create_sn();
		$data['pay_type'] = isset($data['pay_type']) ? trim($data['pay_type']) : 'selfincome';
		$data['payment'] = isset($data['payment']) ? trim($data['payment']) : '';
		$data['adminnote'] = isset($data['op_username']) ? trim($data['op_username']) : '';
		$data['usernote'] = isset($data['usernote']) ? trim($data['usernote']) : '';
		$data['status'] = isset($data['status']) ? trim($data['status']) : 'succ';
		$data['type'] = isset($data['type']) && intval($data['type']) ? intval($data['type']) : 0;
		$data['addtime'] = SYS_TIME;
		$data['ip'] = ip();
		
		//检察消费类型
		if (!in_array($data['type'], array(1,2))) {
			return false;
		}
		
		//检查入账类型
		if (!in_array($data['pay_type'], array('offline','recharge','selfincome'))) {
			return false;
		}
		//检查入账状态
		if (!in_array($data['status'], array('succ','error','failed'))) {
			return false;
		}	
				
		//检查消费描述
		if (empty($data['payment'])) {
			return false;
		}
		
		//检查消费金额
		if (empty($data['money'])) {
			return false;
		}
	
		//检查userid和username并偿试再次的获取
		if (empty($data['userid']) || empty($data['username'])) {
			if (defined('IN_ADMIN')) {
				return false;
			} elseif (!$data['userid'] = param::get_cookie('_userid') || !$data['username'] = param::get_cookie('_username')) {
				return false;
			} else {
				return false;
			}
		}
	
		//检查op_userid和op_username并偿试再次的获取
		if (defined('IN_ADMIN') && empty($data['adminnote'])) {
			$data['adminnote'] = param::get_cookie('admin_username');
		}

		//数据库连接
		if (empty(self::$db)) {
			self::connect();
		}
		$member_db = pc_base::load_model('member_model');
				
		$sql = array();
		if ($data['type'] == 1) {//金钱方式充值
			$sql = array('amount'=>"+=".$data['money']);
		} elseif ($data['type'] == 2) { //积分方式充值
			$sql = array('point'=>'+='.$data['money']);
		} else {
			return false;
		}
				
		//进入数据库操作
		$insertid = self::$db->insert($data,true);
		if($insertid && $data['status'] == 'succ') {
			return $member_db->update($sql, array('userid'=>$data['userid'], 'username'=>$data['username'])) ? true : false;
		} else {
			return false;
		}
	}
}