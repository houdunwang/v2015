<?php
/**
 *  session mysql 数据库存储类
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-8
 */
class session_mysql {
	var $lifetime = 1800;
	var $db;
	var $table;
/**
 * 构造函数
 * 
 */
    public function __construct() {
		$this->db = pc_base::load_model('session_model');
		$this->lifetime = pc_base::load_config('system','session_ttl');
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
		ini_set("session.cookie_httponly", 1);
    	session_start();
    }
/**
 * session_set_save_handler  open方法
 * @param $save_path
 * @param $session_name
 * @return true
 */
    public function open($save_path, $session_name) {
		
		return true;
    }
/**
 * session_set_save_handler  close方法
 * @return bool
 */
    public function close() {
        return $this->gc($this->lifetime);
    } 
/**
 * 读取session_id
 * session_set_save_handler  read方法
 * @return string 读取session_id
 */
    public function read($id) {
		$r = $this->db->get_one(array('sessionid'=>$id), 'data');
		return $r ? $r['data'] : '';
    } 
/**
 * 写入session_id 的值
 * 
 * @param $id session
 * @param $data 值
 * @return mixed query 执行结果
 */
    public function write($id, $data) {
    	$uid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
    	$roleid = isset($_SESSION['roleid']) ? $_SESSION['roleid'] : 0;
    	$groupid = isset($_SESSION['groupid']) ? $_SESSION['groupid'] : 0;
		$m = defined('ROUTE_M') ? ROUTE_M : '';
		$c = defined('ROUTE_C') ? ROUTE_C : '';
		$a = defined('ROUTE_A') ? ROUTE_A : '';
		if(strlen($data) > 255) $data = '';
		$ip = ip();
		$sessiondata = array(
							'sessionid'=>$id,
							'userid'=>$uid,
							'ip'=>$ip,
							'lastvisit'=>SYS_TIME,
							'roleid'=>$roleid,
							'groupid'=>$groupid,
							'm'=>$m,
							'c'=>$c,
							'a'=>$a,
							'data'=>$data,
						);
		return $this->db->insert($sessiondata, 1, 1);
    }
/** 
 * 删除指定的session_id
 * 
 * @param $id session
 * @return bool
 */
    public function destroy($id) {
		return $this->db->delete(array('sessionid'=>$id));
    }
/**
 * 删除过期的 session
 * 
 * @param $maxlifetime 存活期时间
 * @return bool
 */
   public function gc($maxlifetime) {
		$expiretime = SYS_TIME - $maxlifetime;
		return $this->db->delete("`lastvisit`<$expiretime");
    }
}
?>