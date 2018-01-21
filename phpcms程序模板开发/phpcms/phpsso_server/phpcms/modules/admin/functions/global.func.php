<?php 

	/**
	 * 生成加密后的密码
	 * @param string $password 密码
	 * @return array 加密后的密码
	 */
	function creat_password($password) {
		$encrypt = substr(md5(rand()), 0, 6);
		return array(md5(md5($password).$encrypt),$encrypt);
	}

	/**
	 * 发送数据
	 * @param $action 操作
	 * @param $data 数据
	 */
	function ps_send($url, $data = null, $key) {
		$s = $sep = '';
		foreach($data as $k => $v) {
			if(is_array($v)) {
				$s2 = $sep2 = '';
				foreach($v as $k2 => $v2) {
					if(is_array($v2)) {
						$s3 = $sep3 = '';
						foreach($v2 as $k3=>$v3) {
							$k3 = $k3;
							$s3 .= "$sep3{$k}[$k2][$k3]=".ps_stripslashes($v3);
							$sep3 = '&';
						}
						$s .= $sep2.$s3;
					} else {
						$s2 .= "$sep2{$k}[$k2]=".ps_stripslashes($v2);
						$sep2 = '&';
						$s .= $sep.$s2;
					}
				}
			} else {
				$s .= "$sep$k=".ps_stripslashes($v);
				
			}
			$sep = '&';
		}

		$auth_s = 'code='.urlencode(sys_auth($s, 'ENCODE', $key));
		return ps_post($url, 500000, $auth_s);
	}
	
	/**
	 *  post数据
	 *  @param string $url		post的url
	 *  @param int $limit		返回的数据的长度
	 *  @param string $post		post数据，字符串形式username='dalarge'&password='123456'
	 *  @param string $cookie	模拟 cookie，字符串形式username='dalarge'&password='123456'
	 *  @param string $ip		ip地址
	 *  @param int $timeout		连接超时时间
	 *  @param bool $block		是否为阻塞模式
	 *  @return string			返回字符串
	 */
	
	function ps_post($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 15, $block = true) {
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;
		$siteurl = get_url();
		if($post) {
			$out = "POST $path HTTP/1.1\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Referer: ".$siteurl."\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n" ;
			$out .= 'Content-Length: '.strlen($post)."\r\n" ;
			$out .= "Connection: Close\r\n" ;
			$out .= "Cache-Control: no-cache\r\n" ;
			$out .= "Cookie: $cookie\r\n\r\n" ;
			$out .= $post ;
		} else {
			$out = "GET $path HTTP/1.1\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Referer: ".$siteurl."\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		if(!$fp) return '';
	
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
	
		if($status['timed_out']) return '';	
		while (!feof($fp)) {
			if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))  break;				
		}
		
		$stop = false;
		while(!feof($fp) && !$stop) {
			$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
			$return .= $data;
			if($limit) {
				$limit -= strlen($data);
				$stop = $limit <= 0;
			}
		}
		@fclose($fp);
	
		return $return;
	}
	
	/**
	 * 过滤字符串
	 * @param $string
	 */
	function ps_stripslashes($string) {
		!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
		if(MAGIC_QUOTES_GPC) {
			return stripslashes($string);
		} else {
			return $string;
		}
	}
	
	/**
	 * 根据phpsso uid获取头像url
	 */
	function ps_getavatar($uid, $is_url=0) {
		$dir1 = ceil($uid / 10000);
		$dir2 = ceil($uid % 10000 / 1000);
		//$avatar = array($url.'30x30.jpg', $url.'45x45.jpg', $url.'90x90.jpg', $url.'180x180.jpg');
		if($is_url) {
			$url = PHPCMS_PATH.'uploadfile'.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR.$dir1.DIRECTORY_SEPARATOR.$dir2.DIRECTORY_SEPARATOR.$uid.DIRECTORY_SEPARATOR;
			return $url;
		} else {
			$url = APP_PATH.'uploadfile/avatar/'.$dir1.'/'.$dir2.'/'.$uid.'/';
			return $url.'45x45.jpg';
		}
	}
	
	/**
	 * 删除目录
	 */
	function ps_unlink($dir) {
		if(is_dir($dir)) {
			if($handle = opendir($dir)) {
			    while(false !== ($file = readdir($handle))) {
					if($file !== '.' && $file !== '..') {
						if(file_exists($dir.$file)) {
							@unlink($dir.$file);
						}
					}
			    }
			    closedir($handle);    
			}
			@rmdir($dir);
		} else {
			@unlink($dir);
		}
	}
?>