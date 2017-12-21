<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('phpsso', 'phpsso', 0);
pc_base::load_app_class('messagequeue', 'admin' , 0);
pc_base::load_app_func('global', 'admin');

class index extends phpsso {
	
	private $username, $config;
	
	public function __construct() {
		parent::__construct();
		$this->config = pc_base::load_config('system');
		/*判断应用字符集和phpsso字符集是否相同，如果不相同，转换用户名为phpsso所用字符集*/
		$this->username = isset($this->data['username']) ? $this->data['username'] : '';

		if ($this->username && CHARSET != $this->applist[$this->appid]['charset']) {
			if($this->applist[$this->appid]['charset'] == 'utf-8') {	//判断应用字符集是否为utf-8编码
				//应用字符集如果是utf-8，并且用户名是utf-8编码，转换用户名为phpsso字符集，如果为英文，is_utf8返回false，不进行转换
				if(is_utf8($this->username)) {
					$this->username = iconv($this->applist[$this->appid]['charset'], CHARSET, $this->username);
				}
			} else {
				if(!is_utf8($this->username)) {
					$this->username = iconv($this->applist[$this->appid]['charset'], CHARSET, $this->username);
				}
			}
		}
	}
	
	/**
	 * 用户注册
	 * @param string $username 	用户名
	 * @param string $password 	密码
	 * @param string $email		email
	 * @return int {-1:用户名已经存在 ;-2:email已存在;-4:用户名禁止注册;-5:邮箱禁止注册;-6:uc注册失败;int(uid):成功}
	 */
	public function register() {
		$this->random = isset($this->data['random']) && !empty($this->data['random']) ? $this->data['random'] : create_randomstr(6);
		$this->password = isset($this->data['password']) ? create_password($this->data['password'], $this->random) : '';
		$this->email = isset($this->data['email']) ? $this->data['email'] : '';
		$this->type = isset($this->appid) ? 'app' : 'connect';
		$this->regip = isset($this->data['regip']) ? $this->data['regip'] : '';
		$this->appid = isset($this->appid) ? $this->appid : '';
		$this->appname = $this->applist[$this->appid]['name'];

		$checkname = $this->checkname(1);
		if ($checkname == -1) {
			exit('-1');
		} elseif ($checkname == -4) {
			exit('-4');
		}
		
		$checkemail = $this->checkemail(1);
		if($checkemail == -1) {
			exit('-2');
		} elseif ($checkemail == -5) {
			exit('-5');
		}
		
		//UCenter会员注册
		$ucuserid = 0;
		if ($this->config['ucuse']) {
			pc_base::load_config('uc_config');
			require_once PHPCMS_PATH.'api/uc_client/client.php';
			$uid= uc_user_register($this->username, $this->data['password'], $this->email, $this->random);
			if(is_numeric($uid)) {
				switch ($uid) {
					case '-3':
						exit('-1');
						break;
					case '-6':
						exit('-2');
						break;
					case '-2':
						exit('-4');
						break;
					case '-5':
						exit('-5');
						break;
					case '-1':
						exit('-4');
						break;
					case '-4':
						exit('-5');
						break;
					default :
						$ucuserid = $uid;
						break;
				}
			} else {
				exit('-6');
			}
		}	
		
		$data = array(
					'username' => $this->username,
					'password' => $this->password,
					'email' => $this->email,
					'regip' => $this->regip,
					'regdate' => SYS_TIME,
					'lastdate' => SYS_TIME,
					'appname' => $this->appname,
					'type' => $this->type,
					'random' => $this->random,
					'ucuserid'=>$ucuserid
					);
		$uid = $this->db->insert($data, 1);
		/*插入消息队列*/
		$noticedata = $data;
		$noticedata['uid'] = $uid;
		messagequeue::add('member_add', $noticedata);
		exit("$uid");	//exit($uid) 不可以If status is an integer, that value will also be used as the exit status. 
	}
	
	/**
	 * 编辑用户，可以不传入旧密码和新密码
	 * 如果传入新密码，则修改密码为新密码
	 * @param string $username		用户名
	 * @param string $password		旧密码
	 * @param string $newpassword	新密码
	 * @param string $email			email
	 * @param string $random		密码随机数
	 * @return int {-1:用户不存在;-2:旧密码错误;-3:email已经存在 ;1:成功;0:未作修改}
	 */
	public function edit() {
		$this->email = isset($this->data['email']) ? $this->data['email'] : '';
		$this->uid = isset($this->data['uid']) ? $this->data['uid'] : '';

		$userinfo = $this->getuserinfo(1);
		
		if (isset($this->data['password']) && !empty($this->data['password'])) {
			$this->password = create_password($this->data['password'], $userinfo['random']);
		}
		
		$this->random = !empty($this->data['random']) ? $this->data['random'] : $userinfo['random'];
		if (isset($this->data['newpassword']) && !empty($this->data['newpassword'])) {
			$this->newpassword = create_password($this->data['newpassword'], $this->random);
		}

		if ($userinfo == -1) {
			exit('-1');
		}

		if (isset($this->password) && !empty($this->password) && $userinfo['password'] != $this->password) {
			exit('-2');
		}

		if ($this->email && $userinfo['email'] != $this->email) {
			if($this->checkemail(1) == -1) exit('-3');
		}	
		
		$data = array();
		$data['appname'] = $this->applist[$this->appid]['name'];
		
		if (!empty($this->email) && $userinfo['email'] != $this->email) {
			$data['email'] = $this->email;
		}

		if (isset($this->newpassword) && $userinfo['password'] != $this->newpassword) {
			$data['password'] = $this->newpassword;
			$data['random'] = $this->random;
		}

		if (!empty($data)) {
			
			//ucenter部份
			if ($this->config['ucuse']) {
				pc_base::load_config('uc_config');
				require_once PHPCMS_PATH.'api/uc_client/client.php';
				$r = uc_user_edit($userinfo['username'], '', (isset($this->data['newpassword']) && !empty($this->data['newpassword']) ? $this->data['newpassword'] : ''), $data['email'],1);
				if ($r != 1) {
				 //{-1:用户不存在;-2:旧密码错误;-3:email已经存在 ;1:成功;0:未作修改}
					switch ($r) {
						case '-1':
							exit('-2');
						break;
						case '0':				
						case '-4':						
						case '-5':						
						case '-6':
						case '-7':
						case '-8':
							exit('0');
						break;
					}
				}
			}
			if (empty($data['email'])) unset($data['email']);
		
			/*插入消息队列*/
			$noticedata = $data;
			$noticedata['uid'] = $userinfo['uid'];
			messagequeue::add('member_edit', $noticedata);
			if($this->uid > 0) {
				$res = $this->db->update($data, array('uid'=>$this->uid));
			} else if($this->username) {
				$res = $this->db->update($data, array('username'=>$this->username));
			}
			exit("$res");
		} else {
			exit('0');
		}
	}

	/**
	 * 删除用户
	 * @param string {$uid:用户id;$username:用户名;$email:email}
	 * @return array {-1:删除失败;>0:删除成功}
	 */
	public function delete() {
		$this->uid = isset($this->data['uid']) ? $this->data['uid'] : '';
		$this->email = isset($this->data['email']) ? $this->data['email'] : '';

		if($this->uid > 0 || is_array($this->uid)) {
			$where = to_sqls($this->uid, '', 'uid');
			
			//ucenter部份
			if ($this->config['ucuse']) {
				pc_base::load_config('uc_config');
				require_once PHPCMS_PATH.'api/uc_client/client.php';
				$s = $this->db->select($where, 'ucuserid');
				if ($s) {
					$uc_data = array();
					foreach ($s as $k=>$v) {
						$uc_data[$k] = $v['ucuserid'];
					}
					if (!empty($uc_data)) $r = uc_user_delete($uc_data);
					if (!$r) {
						exit('-1');
					}
				} else {
					exit('-1');
				}
				
			}
			
			/*插入消息队列*/
			$noticedata['uids'] = $this->uid;
			messagequeue::add('member_delete', $noticedata);
			
			$this->db->delete($where);
			exit('1');
		} elseif(!empty($this->username)) {
			$this->db->delete(array('username'=>$this->username));
			exit('2');
		} elseif(!empty($this->email)) {
			$this->db->delete(array('email'=>$this->email));
			exit('3');
		} else {
			exit('-1');
		}
	}

	/**
	 * 获取用户信息
	 * @param string {$uid:用户id;$username:用户名;$email:email}
	 * @return array {-1:用户不存在;array(userinfo):用户信息}
	 */
	public function getuserinfo($is_return = 0) {
		$this->uid = isset($this->data['uid']) ? $this->data['uid'] : '';
		$this->email = isset($this->data['email']) ? $this->data['email'] : '';
		if($this->uid > 0) {
			$r = $this->db->get_one(array('uid'=>$this->uid));
		} elseif(!empty($this->username)) {
			$r = $this->db->get_one(array('username'=>$this->username));
		} elseif(!empty($this->email)) {
			$r = $this->db->get_one(array('email'=>$this->email));
		} else {
			return false;
		}
		if(!empty($r)) {
			if($is_return) {
				return $r;
			} else {
				exit(serialize($r));
			}
		} else {
			exit('-1');
		}
	}

	/**
	 * 用户登录
	 * @param string $username	用户名
	 * @param string $password	密码
	 * @return array {-2;密码错误;-1:用户不存在;array(userinfo):用户信息}
	 */
	public function login() {
		$this->password = isset($this->data['password']) ? $this->data['password'] : '';
		$this->email = isset($this->data['email']) ? $this->data['email'] : '';
		if($this->email) {
			$userinfo = $this->db->get_one(array('email'=>$this->email));
		} else {
			$userinfo = $this->db->get_one(array('username'=>$this->username));
		}
		
		if ($this->config['ucuse']) {
			pc_base::load_config('uc_config');
			require_once PHPCMS_PATH.'api/uc_client/client.php';
			list($uid, $uc['username'], $uc['password'], $uc['email']) = uc_user_login($this->username, $this->password, 0);
		}
		
		if($userinfo) {
			//ucenter登陆部份
			if ($this->config['ucuse']) {
				if($uid == -1) {	//uc不存在该用户，调用注册接口注册用户
					$uid = uc_user_register($this->username , $this->password, $userinfo['email'], $userinfo['random']);
					if($uid >0) {
						$this->db->update(array('ucuserid'=>$uid), array('username'=>$this->username));
					}
				}
			}
		} else {	//用户在phpsso中不存在
			//ucenter登陆部份
			if ($this->config['ucuse']) {
				if ($uid < 0) {	//用户不存在或者密码错误
					exit('-1');
				}  else {
					//当前使用只在uc中存在，在PHPSSO中是不存在的。需要进行注册。
					pc_base::load_sys_class('uc_model', 'model', 0);
					$db_config = get_uc_database();
					$uc_db = new uc_model($db_config);

					//获取UC中用户的信息
					$r = $uc_db->get_one(array('uid'=>$uid));
					$datas = $data = array('username'=>$r['username'], 'password'=>$r['password'], 'random'=>$r['salt'], 'email'=>$r['email'], 'regip'=>$r['regip'], 'regdate'=>$r['regdate'],  'lastdate'=>$r['lastlogindate'], 'appname'=>'ucenter', 'type'=>'app');
					$datas['ucuserid'] = $uid;
					$datas['lastip'] = $r['lastloginip'];
					if ($data['uid'] = $this->db->insert($datas, true)) {
						//向所有的应用中发布新用户注册通知
						messagequeue::add('member_add', $data);
					}
					$userinfo = $data;
				}
			} else {
				exit('-1');
			}	
		}
			
		//如果开启phpcms_2008_sp4兼容模式，根据sp4规则验证密码，如果不成功再根据phpsso规则验证密码
		$setting_sp4 = getcache('settings_sp4', 'admin');
		if($setting_sp4['sp4use']) {
			if(!empty($userinfo) && $userinfo['password'] == md5($setting_sp4['sp4_password_key'].$this->password)) {
				//登录成功更新用户最近登录时间和ip
				$this->db->update(array('lastdate'=>SYS_TIME, 'lastip'=>ip()), array('uid'=>$userinfo['uid']));
				exit(serialize($userinfo));
			}
		}
		
		if(!empty($userinfo) && $userinfo['password'] == create_password($this->password, $userinfo['random'])) {
			//登录成功更新用户最近登录时间和ip
			$this->db->update(array('lastdate'=>SYS_TIME, 'lastip'=>ip()), array('uid'=>$userinfo['uid']));
			exit(serialize($userinfo));
		} else {
			exit('-2');
		}

	}
	
	/**
	 * 同步登陆
	 * @param string $uid	用户id
	 * @return string javascript用户同步登陆js
	 */
	public function synlogin() {
		//判断本应用是否开启同步登陆
		if($this->applist[$this->appid]['synlogin']) {
			$this->uid = isset($this->data['uid']) ? $this->data['uid'] : '';
			$this->password = isset($this->data['password']) ? $this->data['password'] : '';
		
			$res = '';
			//ucenter登陆部份
			if ($this->config['ucuse']) {
				pc_base::load_config('uc_config');
				require_once PHPCMS_PATH.'api/uc_client/client.php';
				$r = $this->db->get_one(array('uid'=>$this->uid), "ucuserid");
				if($r['ucuserid']) $res .= uc_user_synlogin($r['ucuserid']);
			}	
			
			foreach($this->applist as $v) {
				if (!$v['synlogin']) continue;
				if($v['appid'] != $this->appid) {
					$tmp_s = strstr($v['url'].$v['apifilename'], '?') ? '&' : '?';
					$res .= '<script type="text/javascript" src="'.$v['url'].$v['apifilename'].$tmp_s.'time='.SYS_TIME.'&code='.urlencode(sys_auth('action=synlogin&username='.$this->username.'&uid='.$this->uid.'&password='.$this->password."&sys_auth_time=".microtime(true), 'ENCODE', $v['authkey'])).'" reload="1"></script>';
				}
			}
			exit($res);
		} else {
			exit('0');
		}
	}

	/**
	 * 同步退出
	 * @return string javascript用户同步退出js
	 */
	public function synlogout() {
		if($this->applist[$this->appid]['synlogin']) {
			$res = '';
			//ucenter登陆部份
			if ($this->config['ucuse']) {
				pc_base::load_config('uc_config');
				require_once PHPCMS_PATH.'api/uc_client/client.php';
				$res .= uc_user_synlogout();
			}	
			foreach($this->applist as $v) {
				if (!$v['synlogin']) continue;
				if($v['appid'] != $this->appid) {
					$tmp_s = strstr($v['url'].$v['apifilename'], '?') ? '&' : '?';
					$res .= '<script type="text/javascript" src="'.$v['url'].$v['apifilename'].$tmp_s.'time='.SYS_TIME.'&code='.urlencode(sys_auth('action=synlogout&sys_auth_time='.microtime(true), 'ENCODE', $v['authkey'])).'" reload="1"></script>';
				}
			}
			exit($res);
		} else {
			exit;
		}
	}
	
	/**
	 * 获取应用列表
	 */
	public function getapplist() {
		$applist = getcache('applist', 'admin');
		foreach($applist as $key=>$value){
			unset($applist[$key]['authkey']);
		}
		exit(serialize($applist));
	}
	
	/**
	 * 获取积分兑换规则
	 */
	public function getcredit($return='') {
		$creditcache = getcache('creditlist', 'admin');
		foreach($creditcache as $v) {
			if($v['fromid'] == $this->appid) {
				$creditlist[$v['from'].'_'.$v['to']] = $v;
			}
		}
		if($return) {
			return $creditlist;
		} else {
			exit(serialize($creditlist));
		}
	}

	/**
	 * 兑换积分
	 * @param int $uid			phpssouid
	 * @param int $from			本系统积分类型id
	 * @param int $toappid 		目标系统应用appid
	 * @param int $to			目标系统积分类型id
	 * @param int $credit		本系统扣除积分数
	 * @return bool 			{1:成功;0:失败}
	 */
	public function changecredit() {
		$this->uid = isset($this->data['uid']) ? $this->data['uid'] : exit('0');
		$this->toappid = isset($this->data['toappid']) ? $this->data['toappid'] : exit('0');
		$this->from = isset($this->data['from']) ? $this->data['from'] : exit('0');
		$this->to = isset($this->data['to']) ? $this->data['to'] : exit('0');
		$this->credit = isset($this->data['credit']) ? $this->data['credit'] : exit('0');
		$this->appname = $this->applist[$this->appid]['name'];
		$outcredit = $this->getcredit(1);
		//目标系统积分增加数
		$this->credit = floor($this->credit * $outcredit[$this->from.'_'.$this->to]['torate'] / $outcredit[$this->from.'_'.$this->to]['fromrate']);
			
		/*插入消息队列*/
		$noticedata['appname'] = $this->appname;
		$noticedata['uid'] = $this->uid;
		$noticedata['toappid'] = $this->toappid;
		$noticedata['totypeid'] = $this->to;
		$noticedata['credit'] = $this->credit;
		messagequeue::add('change_credit', $noticedata);
		exit('1');
	}
	
	/**
	 * 检查用户名
	 * @param string $username	用户名
	 * @return int {-4：用户名禁止注册;-1:用户名已经存在 ;1:成功}
	 */
	public function checkname($is_return=0) {
		if(empty($this->username)) {
			if ($is_return) {
				return -1;
			} else {
				exit('-1');
			}
		}
		//非法关键词判断
		$denyusername = $this->settings['denyusername'];
		if(is_array($denyusername)) {
			$denyusername = implode("|", $denyusername);
			$pattern = '/^('.str_replace(array('\\*', ' ', "\|"), array('.*', '', '|'), preg_quote($denyusername, '/')).')$/i';
			if(preg_match($pattern, $this->username)) {
				if ($is_return) {
					return -4;
				} else {
					exit('-4');
				}
			}
		}
		
		//UCenter部分
		if ($this->config['ucuse']) {
			pc_base::load_config('uc_config');
			require_once PHPCMS_PATH.'api/uc_client/client.php';
			$rs= uc_user_checkname($this->username);
			if ($rs < 1) {
				exit('-4');
			}
		}

		$r = $this->db->get_one(array('username'=>$this->username));
		if ($is_return) {
			return !empty($r) ? -1 : 1;
		} else {
			echo !empty($r) ? -1 : 1;
			exit;
		}

	}
	
	/**
	 * 检查email
	 * @param string $email	email
	 * @return int {-1:email已经存在 ;-5:邮箱禁止注册;1:成功}
	 */
	public function checkemail($is_return=0) {
		$this->email = isset($this->email) ? $this->email : isset($this->data['email']) ? $this->data['email'] : '';
		if(empty($this->email)) {
			if ($is_return) {
				return -1;
			} else {
				exit('-1');
			}
		}
		//非法关键词判断
		$denyemail = $this->settings['denyemail'];
		if(is_array($denyemail)) {
			$denyemail = implode("|", $denyemail);
			$pattern = '/^('.str_replace(array('\\*', ' ', "\|"), array('.*', '', '|'), preg_quote($denyemail, '/')).')$/i';
			if(preg_match($pattern, $this->email)) {
				if ($is_return) {
					return -5;
				} else {
					exit('-5');
				}
			}
		}
		
		//UCenter部分
		if ($this->config['ucuse']) {
			pc_base::load_config('uc_config');
			require_once PHPCMS_PATH.'api/uc_client/client.php';
			$rs= uc_user_checkemail($this->email);
			if ($rs < 1) {
				exit('-5');
			}
		}

		$r = $this->db->get_one(array('email'=>$this->email));
		if ($is_return) {
			return !empty($r) ? -1 : 1;
		} else {
			!empty($r) ? exit('-1') : exit('1');
		}
	}
	
	/**
	 *  上传头像处理
	 *  传入头像压缩包，解压到指定文件夹后删除非图片文件
	 */
	public function uploadavatar() {
		
		//根据用户id创建文件夹
		if(isset($this->data['uid']) && isset($this->data['avatardata'])) {
			$this->uid = intval($this->data['uid']);
			$this->avatardata = $this->data['avatardata'];
		} else {
			exit('0');
		}
		
		$dir1 = ceil($this->uid / 10000);
		$dir2 = ceil($this->uid % 10000 / 1000);
		
		//创建图片存储文件夹
		$avatarfile = pc_base::load_config('system', 'upload_path').'avatar/';
		$dir = $avatarfile.$dir1.'/'.$dir2.'/'.$this->uid.'/';
		if(!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		//存储flashpost图片
		$filename = $dir.'180x180.jpg';

		$fp = fopen($filename, 'w');
		fwrite($fp, $this->avatardata);
		fclose($fp);

		$avatararr = array('180x180.jpg', '30x30.jpg', '45x45.jpg', '90x90.jpg');
		$files = glob($dir."*");
		foreach($files as $_files) {
			if(is_dir($_files)) dir_delete($_files);
			if(!in_array(basename($_files), $avatararr)) @unlink($_files);
		}
		if($handle = opendir($dir)) {
		    while(false !== ($file = readdir($handle))) {
				if($file !== '.' && $file !== '..') {
					if(!in_array($file, $avatararr)) {
						@unlink($dir.$file);
					} else {
						$info = @getimagesize($dir.$file);
						if(!$info || $info[2] !=2) {
							@unlink($dir.$file);
						}
					}
				}
		    }
		    closedir($handle);    
		}

		pc_base::load_sys_class('image','','0');
		$image = new image(1,0);
		$image->thumb($filename, $dir.'30x30.jpg', 30, 30);
		$image->thumb($filename, $dir.'45x45.jpg', 45, 45);
		$image->thumb($filename, $dir.'90x90.jpg', 90, 90);
		
		$this->db->update(array('avatar'=>1), array('uid'=>$this->uid));
		exit('1');
	}

	/**
	 *  删除用户头像
	 *  @return {0:失败;1:成功}
	 */
	public function deleteavatar() {
		//根据用户id创建文件夹
		if(isset($this->data['uid'])) {
			$this->uid = $this->data['uid'];
		} else {
			exit('0');
		}
		
		$dir1 = ceil($this->uid / 10000);
		$dir2 = ceil($this->uid % 10000 / 1000);
		
		//图片存储文件夹
		$avatarfile = pc_base::load_config('system', 'upload_path').'avatar/';
		$dir = $avatarfile.$dir1.'/'.$dir2.'/'.$this->uid.'/';
		$this->db->update(array('avatar'=>0), array('uid'=>$this->uid));
		if(!file_exists($dir)) {
			exit('1');
		} else {
			if($handle = opendir($dir)) {
			    while(false !== ($file = readdir($handle))) {
					if($file !== '.' && $file !== '..') {
						@unlink($dir.$file);
					}
			    }
			    closedir($handle);
			    @rmdir($dir);
			    exit('1');
			}
		}
	}
}
?>