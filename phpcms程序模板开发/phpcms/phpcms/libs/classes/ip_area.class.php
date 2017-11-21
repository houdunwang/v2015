<?php 
/**
 * ip_area.class.php 根据ip地址获取ip所在地区的类
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-7
 */
class ip_area {
	public $fp = NULL;		//定义文件指针
	public $func;			//处理的方法
	private $offset;		
	private $index;
	
	/**
 	 * 构造函数
 	 * 
 	 */
	public function __construct() {
		if(@file_exists(PC_PATH.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ipdata'.DIRECTORY_SEPARATOR.'mini.Dat')) {
			$this->func = 'data_mini';
			$this->fp = @fopen(PC_PATH.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ipdata'.DIRECTORY_SEPARATOR.'mini.Dat', 'rb');
			$this->offset = unpack('Nlen', fread($this->fp, 4));
			$this->index  = fread($this->fp, $this->offset['len'] - 4);
		} elseif(@file_exists(PC_PATH.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ipdata'.DIRECTORY_SEPARATOR.'QQWry.Dat')) {
			$this->func = 'data_full';
			$this->fp = @fopen(PC_PATH.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ipdata'.DIRECTORY_SEPARATOR.'QQWry.Dat', 'rb');
		} elseif(@file_exists(PC_PATH.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ipdata'.DIRECTORY_SEPARATOR.'qqwry.dat')) {
			$this->func = 'data_full';
			$this->fp = @fopen(PC_PATH.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ipdata'.DIRECTORY_SEPARATOR.'qqwry.dat', 'rb');
		}
	}

	/**
 	 * 取得地区名
 	 * @param  string $ip IP地址
 	 * @ return string/null
 	 */
	public function get($ip) {
		$return = '';
		if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
			$iparray = explode('.', $ip);
			if($iparray[0] == 10 || $iparray[0] == 127 || ($iparray[0] == 192 && $iparray[1] == 168) || ($iparray[0] == 172 && ($iparray[1] >= 16 && $iparray[1] <= 31))) {
				$return = 'LAN';
			} elseif($iparray[0] > 255 || $iparray[1] > 255 || $iparray[2] > 255 || $iparray[3] > 255) {
				$return = 'Invalid IP Address';
			} else {
				$return = $this->func ? $this->{$this->func}($ip) : '';
				if(strpos($return, ' ') !== false) $return = substr($return, 0, strpos($return,' '));
			}
			if(strtolower(pc_base::load_config('system', 'charset')) == 'utf-8') $return = iconv('gbk', 'utf-8', $return);
		}
		return $return;
	}
	
	/**
	* 通过外部接口方式获取详细地址信息
	* @return $localinfo province 省份 city城市  sp网络 提供商  pinyin拼音
	*/
	public function getcitybyapi($ip) {
		$api_url = $localinfo = '';
		$xml = pc_base::load_sys_class('xml');
		pc_base::load_sys_func('iconv');
		$api_url = 'http://ipquery.sdo.com/getipinfo.php?ip='.$ip;
		$data = $xml->xml_unserialize(@file_get_contents($api_url));
		if (CHARSET == 'gbk') {
			$data = !empty($data) ? array_iconv($data, 'utf-8', 'gbk') : array();
		}		
		if($data['ip']['result']) {
			$localinfo['province'] = $data['ip']['country'];
			$localinfo['city'] = $data['ip']['city'];
			$localinfo['sp'] = $data['ip']['sp'];		
			//$name = strtolower(CHARSET) == 'gbk' ? $localinfo['city'] : iconv(CHARSET,'gbk',$localinfo['city']);
			$name = str_replace(L('city'),'',$localinfo['city']);
			$letters = gbk_to_pinyin($name);	
			$localinfo['pinyin'] =strtolower(implode('', $letters));		
		}		
		return $localinfo;		
	}
	
	/**
	*获取城市名称
	*/
	public function getcity($ip) {
		$localinfo = '';
		$address = $this->get($ip);
		if(strpos($address,L('province'))!== false && strpos($address,L('city'))!== false){
			$address = explode(L('province'), $address);
			$address=$address[1];
		}
		$address = str_replace(L('city'),'',$address);
		$localinfo['city']= trim($address);
		$name = CHARSET == 'gbk' ? $localinfo['city'] : iconv('utf-8','gbk',$localinfo['city']);
		$name = str_replace(L('city'),'',$name);
		$letters = gbk_to_pinyin($name);	
		$localinfo['pinyin'] =strtolower(implode('', $letters));
		return $localinfo;
	}
	/**
 	 * 使用mini.Dat ip数据包获取地区
 	 * @param  string $ip IP地址
 	 * @ return string/null
 	 */
	private function data_mini($ip) {
		$ipdot = explode('.', $ip);
		$ipdot[0] = (int)$ipdot[0];
		$ipdot[1] = (int)$ipdot[1];
		$ip    = pack('N', ip2long($ip));
		$length = $this->offset['len'] - 1028;
		$start  = unpack('Vlen', $this->index[$ipdot[0] * 4] . $this->index[$ipdot[0] * 4 + 1] . $this->index[$ipdot[0] * 4 + 2] . $this->index[$ipdot[0] * 4 + 3]);
		for($start = $start['len'] * 8 + 1024; $start < $length; $start += 8) {
			if($this->index{$start} . $this->index{$start + 1} . $this->index{$start + 2} . $this->index{$start + 3} >= $ip) {
				$this->index_offset = unpack('Vlen', $this->index{$start + 4} . $this->index{$start + 5} . $this->index{$start + 6} . "\x0");
				$this->index_length = unpack('Clen', $this->index{$start + 7});
				break;
			}
		}
		fseek($this->fp, $this->offset['len'] + $this->index_offset['len'] - 1024);
		if($this->index_length['len']) {
			return str_replace('- ', '', fread($this->fp, $this->index_length['len']));
		} else {
			return 'Unknown';
		}
	}
	
	/**
 	 * 使用QQWry.Dat ip数据包获取地区
 	 * @param  string $ip IP地址
 	 * @ return string/null
 	 */
	private function data_full($ip) {
		rewind($this->fp);
		$ip = explode('.', $ip);
		$ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];
		if(!($DataBegin = fread($this->fp, 4)) || !($DataEnd = fread($this->fp, 4)) ) return;
		@$ipbegin = implode('', unpack('L', $DataBegin));
		if($ipbegin < 0) $ipbegin += pow(2, 32);
		@$ipend = implode('', unpack('L', $DataEnd));
		if($ipend < 0) $ipend += pow(2, 32);
		$ipAllNum = ($ipend - $ipbegin) / 7 + 1;
		$BeginNum = $ip2num = $ip1num = 0;
		$ipAddr1 = $ipAddr2 = '';
		$EndNum = $ipAllNum;
		while($ip1num > $ipNum || $ip2num < $ipNum) {
			$Middle= intval(($EndNum + $BeginNum) / 2);
			fseek($this->fp, $ipbegin + 7 * $Middle);
			$ipData1 = fread($this->fp, 4);
			if(strlen($ipData1) < 4) {
				fclose($this->fp);
				return 'System Error';
			}
			$ip1num = implode('', unpack('L', $ipData1));
			if($ip1num < 0) $ip1num += pow(2, 32);
			if($ip1num > $ipNum) {
				$EndNum = $Middle;
				continue;
			}
			$DataSeek = fread($this->fp, 3);
			if(strlen($DataSeek) < 3) {
				fclose($this->fp);
				return 'System Error';
			}
			$DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
			fseek($this->fp, $DataSeek);
			$ipData2 = fread($this->fp, 4);
			if(strlen($ipData2) < 4) {
				fclose($this->fp);
				return 'System Error';
			}
			$ip2num = implode('', unpack('L', $ipData2));
			if($ip2num < 0) $ip2num += pow(2, 32);
			if($ip2num < $ipNum) {
				if($Middle == $BeginNum) {
					fclose($this->fp);
					return 'Unknown';
				}
				$BeginNum = $Middle;
			}
		}
		$ipFlag = fread($this->fp, 1);
		if($ipFlag == chr(1)) {
			$ipSeek = fread($this->fp, 3);
			if(strlen($ipSeek) < 3) {
				fclose($this->fp);
				return 'System Error';
			}
			$ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
			fseek($this->fp, $ipSeek);
			$ipFlag = fread($this->fp, 1);
		}
		if($ipFlag == chr(2)) {
			$AddrSeek = fread($this->fp, 3);
			if(strlen($AddrSeek) < 3) {
				fclose($this->fp);
				return 'System Error';
			}
			$ipFlag = fread($this->fp, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($this->fp, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($this->fp);
					return 'System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($this->fp, $AddrSeek2);
			} else {
				fseek($this->fp, -1, SEEK_CUR);
			}
			while(($char = fread($this->fp, 1)) != chr(0))
			$ipAddr2 .= $char;
			$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
			fseek($this->fp, $AddrSeek);
			while(($char = fread($this->fp, 1)) != chr(0))
			$ipAddr1 .= $char;
		} else {
			fseek($this->fp, -1, SEEK_CUR);
			while(($char = fread($this->fp, 1)) != chr(0))
			$ipAddr1 .= $char;
			$ipFlag = fread($this->fp, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($this->fp, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($this->fp);
					return 'System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($this->fp, $AddrSeek2);
			} else {
				fseek($this->fp, -1, SEEK_CUR);
			}
			while(($char = fread($this->fp, 1)) != chr(0))
			$ipAddr2 .= $char;
		}
		if(preg_match('/http/i', $ipAddr2)) $ipAddr2 = '';
		$ipaddr = "$ipAddr1 $ipAddr2";
		$ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
		$ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
		$ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
		if(preg_match('/http/i', $ipaddr) || $ipaddr == '') $ipaddr = 'Unknown';
		return ''.$ipaddr;
	}

	private function close() {
		@fclose($this->fp);
	}
}
?>