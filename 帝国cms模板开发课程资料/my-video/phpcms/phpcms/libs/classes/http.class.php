<?php 
class http {
	var $method;
	var $cookie;
	var $post;
	var $header;
	var $ContentType;
	var $errno;
	var $errstr;

    function __construct() {
		$this->method = 'GET';
		$this->cookie = '';
		$this->post = '';
		$this->header = '';
		$this->errno = 0;
		$this->errstr = '';
    }

	function post($url, $data = array(), $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
		$this->method = 'POST';
		$this->ContentType = "Content-Type: application/x-www-form-urlencoded\r\n";
		if($data) {
			$post = '';
			foreach($data as $k=>$v) {
				$post .= $k.'='.rawurlencode($v).'&';
			}
			$this->post .= substr($post, 0, -1);
		}
		return $this->request($url, $referer, $limit, $timeout, $block);
	}

	function get($url, $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
		$this->method = 'GET';
		return $this->request($url, $referer, $limit, $timeout, $block);
	}

	function upload($url, $data = array(), $files = array(), $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
		$this->method = 'POST';
		$boundary = "AaB03x";
		$this->ContentType = "Content-Type: multipart/form-data; boundary=$boundary\r\n";
		if($data) {
			foreach($data as $k => $v) { 
				$this->post .= "--$boundary\r\n"; 
				$this->post .= "Content-Disposition: form-data; name=\"".$k."\"\r\n"; 
				$this->post .= "\r\n".$v."\r\n"; 
				$this->post .= "--$boundary\r\n";
			} 
		}
		foreach($files as $k=>$v) {
            $this->post .= "--$boundary\r\n"; 
			$this->post .= "Content-Disposition: file; name=\"$k\"; filename=\"".basename($v)."\"\r\n"; 
			$this->post .= "Content-Type: ".$this->get_mime($v)."\r\n"; 
			$this->post .= "\r\n".file_get_contents($v)."\r\n"; 
			$this->post .= "--$boundary\r\n"; 
		}
        $this->post .= "--$boundary--\r\n";
		return $this->request($url, $referer, $limit, $timeout, $block);
	}
    
	function request($url, $referer = '', $limit = 0, $timeout = 30, $block = TRUE) {
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = $matches['port'] ? $matches['port'] : 80;
		if($referer == '') $referer = URL;
		$out = "$this->method $path HTTP/1.1\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Referer: $referer\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
		$out .= "Host: $host\r\n";
		if($this->cookie) $out .= "Cookie: $this->cookie\r\n";
		if($this->method == 'POST') {
			$out .= $this->ContentType;
			$out .= "Content-Length: ".strlen($this->post)."\r\n";
			$out .= "Cache-Control: no-cache\r\n";
			$out .= "Connection: Close\r\n\r\n";
			$out .= $this->post;
		} else {
			$out .= "Connection: Close\r\n\r\n";
		}
 		if($timeout > ini_get('max_execution_time')) @set_time_limit($timeout);
		$fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
		$this->post = '';
 		if(!$fp) {
			$this->errno = $errno;
			$this->errstr = $errstr;
			return false;
		} else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			fwrite($fp, $out);
			$this->data = '';
			$status = stream_get_meta_data($fp);
			if(!$status['timed_out']) {
				$maxsize = min($limit, 1024000);
				if($maxsize == 0) $maxsize = 1024000;
				$start = false;
				while(!feof($fp)) {
					if($start) {
						$line = fread($fp, $maxsize);
						if(strlen($this->data) > $maxsize) break;
						$this->data .= $line;
					} else {
						$line = fgets($fp);
						$this->header .= $line;
						if($line == "\r\n" || $line == "\n") $start = true;
					}
				}
			}
			fclose($fp);
			return $this->is_ok();
		}
	}

    function save($file) {
		dir_create(dirname($file));
		return file_put_contents($file, $this->data);
    }

	function set_cookie($name, $value) {
		$this->cookie .= "$name=$value;";
	}

	function get_cookie() {
		$cookies = array();
		if(preg_match_all("|Set-Cookie: ([^;]*);|", $this->header, $m)) {
			foreach($m[1] as $c) {
				list($k, $v) = explode('=', $c);
				$cookies[$k] = $v;
			}
		}
        return $cookies;
	}

	function get_data() {
		if (strpos($this->header,'chunk')) {
			$data = explode(chr(13), $this->data);
			return $data[1];
		} else {
			return $this->data;
		}
	}

	function get_header() {
		return $this->header;
	}

	function get_status() {
		preg_match("|^HTTP/1.1 ([0-9]{3}) (.*)|", $this->header, $m);
		return array($m[1], $m[2]);
	}

	function get_mime($file) {
		$ext = strtolower(trim(substr(strrchr($file, '.'), 1, 10)));
		if($ext == '') return '';
		$mime_types = array (
						  'acx' => 'application/internet-property-stream',
						  'ai' => 'application/postscript',
						  'aif' => 'audio/x-aiff',
						  'aifc' => 'audio/x-aiff',
						  'aiff' => 'audio/x-aiff',
						  'asp' => 'text/plain',
						  'aspx' => 'text/plain',
						  'asf' => 'video/x-ms-asf',
						  'asr' => 'video/x-ms-asf',
						  'asx' => 'video/x-ms-asf',
						  'au' => 'audio/basic',
						  'avi' => 'video/x-msvideo',
						  'axs' => 'application/olescript',
						  'bas' => 'text/plain',
						  'bcpio' => 'application/x-bcpio',
						  'bin' => 'application/octet-stream',
						  'bmp' => 'image/bmp',
						  'c' => 'text/plain',
						  'cat' => 'application/vnd.ms-pkiseccat',
						  'cdf' => 'application/x-cdf',
						  'cer' => 'application/x-x509-ca-cert',
						  'class' => 'application/octet-stream',
						  'clp' => 'application/x-msclip',
						  'cmx' => 'image/x-cmx',
						  'cod' => 'image/cis-cod',
						  'cpio' => 'application/x-cpio',
						  'crd' => 'application/x-mscardfile',
						  'crl' => 'application/pkix-crl',
						  'crt' => 'application/x-x509-ca-cert',
						  'csh' => 'application/x-csh',
						  'css' => 'text/css',
						  'dcr' => 'application/x-director',
						  'der' => 'application/x-x509-ca-cert',
						  'dir' => 'application/x-director',
						  'dll' => 'application/x-msdownload',
						  'dms' => 'application/octet-stream',
						  'doc' => 'application/msword',
						  'dot' => 'application/msword',
						  'dvi' => 'application/x-dvi',
						  'dxr' => 'application/x-director',
						  'eps' => 'application/postscript',
						  'etx' => 'text/x-setext',
						  'evy' => 'application/envoy',
						  'exe' => 'application/octet-stream',
						  'fif' => 'application/fractals',
						  'flr' => 'x-world/x-vrml',
						  'flv' => 'video/x-flv',
						  'gif' => 'image/gif',
						  'gtar' => 'application/x-gtar',
						  'gz' => 'application/x-gzip',
						  'h' => 'text/plain',
						  'hdf' => 'application/x-hdf',
						  'hlp' => 'application/winhlp',
						  'hqx' => 'application/mac-binhex40',
						  'hta' => 'application/hta',
						  'htc' => 'text/x-component',
						  'htm' => 'text/html',
						  'html' => 'text/html',
						  'htt' => 'text/webviewhtml',
						  'ico' => 'image/x-icon',
						  'ief' => 'image/ief',
						  'iii' => 'application/x-iphone',
						  'ins' => 'application/x-internet-signup',
						  'isp' => 'application/x-internet-signup',
						  'jfif' => 'image/pipeg',
						  'jpe' => 'image/jpeg',
						  'jpeg' => 'image/jpeg',
						  'jpg' => 'image/jpeg',
						  'js' => 'application/x-javascript',
						  'latex' => 'application/x-latex',
						  'lha' => 'application/octet-stream',
						  'lsf' => 'video/x-la-asf',
						  'lsx' => 'video/x-la-asf',
						  'lzh' => 'application/octet-stream',
						  'm13' => 'application/x-msmediaview',
						  'm14' => 'application/x-msmediaview',
						  'm3u' => 'audio/x-mpegurl',
						  'man' => 'application/x-troff-man',
						  'mdb' => 'application/x-msaccess',
						  'me' => 'application/x-troff-me',
						  'mht' => 'message/rfc822',
						  'mhtml' => 'message/rfc822',
						  'mid' => 'audio/mid',
						  'mny' => 'application/x-msmoney',
						  'mov' => 'video/quicktime',
						  'movie' => 'video/x-sgi-movie',
						  'mp2' => 'video/mpeg',
						  'mp3' => 'audio/mpeg',
						  'mpa' => 'video/mpeg',
						  'mpe' => 'video/mpeg',
						  'mpeg' => 'video/mpeg',
						  'mpg' => 'video/mpeg',
						  'mpp' => 'application/vnd.ms-project',
						  'mpv2' => 'video/mpeg',
						  'ms' => 'application/x-troff-ms',
						  'mvb' => 'application/x-msmediaview',
						  'nws' => 'message/rfc822',
						  'oda' => 'application/oda',
						  'p10' => 'application/pkcs10',
						  'p12' => 'application/x-pkcs12',
						  'p7b' => 'application/x-pkcs7-certificates',
						  'p7c' => 'application/x-pkcs7-mime',
						  'p7m' => 'application/x-pkcs7-mime',
						  'p7r' => 'application/x-pkcs7-certreqresp',
						  'p7s' => 'application/x-pkcs7-signature',
						  'pbm' => 'image/x-portable-bitmap',
						  'pdf' => 'application/pdf',
						  'pfx' => 'application/x-pkcs12',
						  'pgm' => 'image/x-portable-graymap',
						  'php' => 'text/plain',
						  'pko' => 'application/ynd.ms-pkipko',
						  'pma' => 'application/x-perfmon',
						  'pmc' => 'application/x-perfmon',
						  'pml' => 'application/x-perfmon',
						  'pmr' => 'application/x-perfmon',
						  'pmw' => 'application/x-perfmon',
						  'png' => 'image/png',
						  'pnm' => 'image/x-portable-anymap',
						  'pot,' => 'application/vnd.ms-powerpoint',
						  'ppm' => 'image/x-portable-pixmap',
						  'pps' => 'application/vnd.ms-powerpoint',
						  'ppt' => 'application/vnd.ms-powerpoint',
						  'prf' => 'application/pics-rules',
						  'ps' => 'application/postscript',
						  'pub' => 'application/x-mspublisher',
						  'qt' => 'video/quicktime',
						  'ra' => 'audio/x-pn-realaudio',
						  'ram' => 'audio/x-pn-realaudio',
						  'ras' => 'image/x-cmu-raster',
						  'rgb' => 'image/x-rgb',
						  'rmi' => 'audio/mid',
						  'roff' => 'application/x-troff',
						  'rtf' => 'application/rtf',
						  'rtx' => 'text/richtext',
						  'scd' => 'application/x-msschedule',
						  'sct' => 'text/scriptlet',
						  'setpay' => 'application/set-payment-initiation',
						  'setreg' => 'application/set-registration-initiation',
						  'sh' => 'application/x-sh',
						  'shar' => 'application/x-shar',
						  'sit' => 'application/x-stuffit',
						  'snd' => 'audio/basic',
						  'spc' => 'application/x-pkcs7-certificates',
						  'spl' => 'application/futuresplash',
						  'src' => 'application/x-wais-source',
						  'sst' => 'application/vnd.ms-pkicertstore',
						  'stl' => 'application/vnd.ms-pkistl',
						  'stm' => 'text/html',
						  'svg' => 'image/svg+xml',
						  'sv4cpio' => 'application/x-sv4cpio',
						  'sv4crc' => 'application/x-sv4crc',
						  'swf' => 'application/x-shockwave-flash',
						  't' => 'application/x-troff',
						  'tar' => 'application/x-tar',
						  'tcl' => 'application/x-tcl',
						  'tex' => 'application/x-tex',
						  'texi' => 'application/x-texinfo',
						  'texinfo' => 'application/x-texinfo',
						  'tgz' => 'application/x-compressed',
						  'tif' => 'image/tiff',
						  'tiff' => 'image/tiff',
						  'tr' => 'application/x-troff',
						  'trm' => 'application/x-msterminal',
						  'tsv' => 'text/tab-separated-values',
						  'txt' => 'text/plain',
						  'uls' => 'text/iuls',
						  'ustar' => 'application/x-ustar',
						  'vcf' => 'text/x-vcard',
						  'vrml' => 'x-world/x-vrml',
						  'wav' => 'audio/x-wav',
						  'wcm' => 'application/vnd.ms-works',
						  'wdb' => 'application/vnd.ms-works',
						  'wks' => 'application/vnd.ms-works',
						  'wmf' => 'application/x-msmetafile',
						  'wmv' => 'video/x-ms-wmv',
						  'wps' => 'application/vnd.ms-works',
						  'wri' => 'application/x-mswrite',
						  'wrl' => 'x-world/x-vrml',
						  'wrz' => 'x-world/x-vrml',
						  'xaf' => 'x-world/x-vrml',
						  'xbm' => 'image/x-xbitmap',
						  'xla' => 'application/vnd.ms-excel',
						  'xlc' => 'application/vnd.ms-excel',
						  'xlm' => 'application/vnd.ms-excel',
						  'xls' => 'application/vnd.ms-excel',
						  'xlt' => 'application/vnd.ms-excel',
						  'xlw' => 'application/vnd.ms-excel',
						  'xof' => 'x-world/x-vrml',
						  'xpm' => 'image/x-xpixmap',
						  'xwd' => 'image/x-xwindowdump',
						  'z' => 'application/x-compress',
						  'zip' => 'application/zip',
						);
		return isset($mime_types[$ext]) ? $mime_types[$ext] : '';
	}

	function is_ok() {
		$status = $this->get_status();
		if(intval($status[0]) != 200) {
			$this->errno = $status[0];
			$this->errstr = $status[1];
			return false;
		}
		return true;
	}

	function errno() {
		return $this->errno;
	}

	function errmsg() {
		return $this->errstr;
	}
}
?>