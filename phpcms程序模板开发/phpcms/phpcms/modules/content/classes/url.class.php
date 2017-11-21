<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class url{
	private $urlrules,$categorys,$html_root;
	public function __construct() {
		$this->urlrules = getcache('urlrules','commons');
		self::set_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$this->html_root = pc_base::load_config('system','html_root');
	}

	/**
	 * 内容页链接
	 * @param $id 内容id
	 * @param $page 当前页
	 * @param $catid 栏目id
	 * @param $time 添加时间
	 * @param $prefix 前缀
	 * @param $data 数据
	 * @param $action 操作方法
	 * @param $upgrade 是否是升级数据
	 * @return array 0=>url , 1=>生成路径
	 */
	public function show($id, $page = 0, $catid = 0, $time = 0, $prefix = '',$data = '',$action = 'edit',$upgrade = 0) {
		$page = max($page,1);
		$urls = $catdir = '';
		$category = $this->categorys[$catid];
		$setting = string2array($category['setting']);
		$content_ishtml = $setting['content_ishtml'];
		//当内容为转换或升级时
		if($upgrade || (isset($_POST['upgrade']) && defined('IN_ADMIN') && $_POST['upgrade'])) {
			if($_POST['upgrade']) $upgrade = $_POST['upgrade'];
			$upgrade = '/'.ltrim($upgrade,WEB_PATH);
			if($page==1) {
				$url_arr[0] = $url_arr[1] = $upgrade;
			} else {
				$lasttext = strrchr($upgrade,'.');
				$len = -strlen($lasttext);
				$path = substr($upgrade,0,$len);
				$url_arr[0] = $url_arr[1] = $path.'_'.$page.$lasttext;
			}
		} else {
			$show_ruleid = $setting['show_ruleid'];
			$urlrules = $this->urlrules[$show_ruleid];
			if(!$time) $time = SYS_TIME;
			$urlrules_arr = explode('|',$urlrules);
			if($page==1) {
				$urlrule = $urlrules_arr[0];
			} else {
				$urlrule = isset($urlrules_arr[1]) ? $urlrules_arr[1] : $urlrules_arr[0];
			}
			$domain_dir = '';
			if (strpos($category['url'], '://')!==false && strpos($category['url'], '?')===false) {
				if (preg_match('/^((http|https):\/\/)?([^\/]+)/i', $category['url'], $matches)) {
					$match_url = $matches[0];
					$url = $match_url.'/';
				}
				$db = pc_base::load_model('category_model');
				$r = $db->get_one(array('url'=>$url), '`catid`');
				
				if($r) $domain_dir = $this->get_categorydir($r['catid']).$this->categorys[$r['catid']]['catdir'].'/';
			}
			$categorydir = $this->get_categorydir($catid);
			$catdir = $category['catdir'];
			$year = date('Y',$time);
			$month = date('m',$time);
			$day = date('d',$time);
			
			$urls = str_replace(array('{$categorydir}','{$catdir}','{$year}','{$month}','{$day}','{$catid}','{$id}','{$page}'),array($categorydir,$catdir,$year,$month,$day,$catid,$id,$page),$urlrule);
			$create_to_html_root = $category['create_to_html_root'];
			
			if($create_to_html_root || $category['sethtml']) {
				$html_root = '';
			} else {
				$html_root = $this->html_root;
			}
			if($content_ishtml && $url) {
				if ($domain_dir && $category['isdomain']) {
					$url_arr[1] = $html_root.'/'.$domain_dir.$urls;
					$url_arr[0] = $url.$urls;
				} else {
					$url_arr[1] = $html_root.'/'.$urls;
					$url_arr[0] = WEB_PATH == '/' ? $match_url.$html_root.'/'.$urls : $match_url.rtrim(WEB_PATH,'/').$html_root.'/'.$urls;
				}
			} elseif($content_ishtml) {
				$url_arr[0] = WEB_PATH == '/' ? $html_root.'/'.$urls : rtrim(WEB_PATH,'/').$html_root.'/'.$urls;
				$url_arr[1] = $html_root.'/'.$urls;
			} else {
				$url_arr[0] = $url_arr[1] = APP_PATH.$urls;
			}
		}
		//生成静态 ,在添加文章的时候，同时生成静态，不在批量更新URL处调用
		if($content_ishtml && $data) {
			$data['id'] = $id;
			$url_arr['content_ishtml'] = 1;
			$url_arr['data'] = $data;
		}
		return $url_arr;
	}
	
	/**
	 * 获取栏目的访问路径
	 * 在修复栏目路径处重建目录结构用
	 * @param intval $catid 栏目ID
	 * @param intval $page 页数
	 */
	public function category_url($catid, $page = 1) {
		$category = $this->categorys[$catid];
		if($category['type']==2) return $category['url'];
		$page = max(intval($page), 1);
		$setting = string2array($category['setting']);
		$category_ruleid = $setting['category_ruleid'];
		$urlrules = $this->urlrules[$category_ruleid];
		$urlrules_arr = explode('|',$urlrules);
		if ($page==1) {
			$urlrule = $urlrules_arr[0];
		} else {
			$urlrule = $urlrules_arr[1];
		}
		if (!$setting['ishtml']) { //如果不生成静态
			
			$url = str_replace(array('{$catid}', '{$page}'), array($catid, $page), $urlrule);
			if (strpos($url, '\\')!==false) {
					$url = APP_PATH.str_replace('\\', '/', $url);
			}
		}  else { //生成静态
			if ($category['arrparentid']) {
				$parentids = explode(',', $category['arrparentid']);
			}
			$parentids[] = $catid;
			$domain_dir = '';
			foreach ($parentids as $pid) { //循环查询父栏目是否设置了二级域名
				$r = $this->categorys[$pid];
				if (strpos(strtolower($r['url']), '://')!==false && strpos($r['url'], '?')===false) {
					$r['url'] = preg_replace('/([(http|https):\/\/]{0,})([^\/]*)([\/]{1,})/i', '$1$2/', $r['url'], -1); //取消掉双'/'情况
					if (substr_count($r['url'], '/')==3 && substr($r['url'],-1,1)=='/') { //如果url中包含‘http://’并且‘/’在3个则为二级域名设置栏目
						$url = $r['url'];
						$domain_dir = $this->get_categorydir($pid).$this->categorys[$pid]['catdir'].'/'; //得到二级域名的目录
					}
				}
			}
			
			$category_dir = $this->get_categorydir($catid);
			$urls = str_replace(array('{$categorydir}','{$catdir}','{$catid}','{$page}'),array($category_dir,$category['catdir'],$catid,$page),$urlrule);
			if ($url && $domain_dir) { //如果存在设置二级域名的情况
				if (strpos($urls, $domain_dir)===0) {
					$url = str_replace(array($domain_dir, '\\'), array($url, '/'), $urls);
				} else {
					$urls = $domain_dir.$urls;
					$url = str_replace(array($domain_dir, '\\'), array($url, '/'), $urls);
				}
			} else { //不存在二级域名的情况
				$url = $urls;
			}
		}
		if (in_array(basename($url), array('index.html', 'index.htm', 'index.shtml'))) {
			$url = dirname($url).'/';
		}
		if (strpos($url, '://')===false) $url = str_replace('//', '/', $url);
		if(strpos($url, '/')===0) $url = substr($url,1);
		return $url;
	}
	/**
	 * 生成列表页分页地址
	 * @param $ruleid 角色id
	 * @param $categorydir 父栏目路径
	 * @param $catdir 栏目路径
	 * @param $catid 栏目id
	 * @param $page 当前页
	 */
	public function get_list_url($ruleid,$categorydir, $catdir, $catid, $page = 1) {
		$urlrules = $this->urlrules[$ruleid];
		$urlrules_arr = explode('|',$urlrules);
		if ($page==1) {
			$urlrule = $urlrules_arr[0];
		} else {
			$urlrule = $urlrules_arr[1];
		}
		$urls = str_replace(array('{$categorydir}','{$catdir}','{$year}','{$month}','{$day}','{$catid}','{$page}'),array($categorydir,$catdir,$year,$month,$day,$catid,$page),$urlrule);
		return $urls;
	}
	
	/**
	 * 获取父栏目路径
	 * @param $catid
	 * @param $dir
	 */
	private function get_categorydir($catid, $dir = '') {
		$setting = array();
		$setting = string2array($this->categorys[$catid]['setting']);
		if ($setting['create_to_html_root']) return $dir;
		if ($this->categorys[$catid]['parentid']) {
			$dir = $this->categorys[$this->categorys[$catid]['parentid']]['catdir'].'/'.$dir;
			return $this->get_categorydir($this->categorys[$catid]['parentid'], $dir);
		} else {
			return $dir;
		}
	}
	/**
	 * 设置当前站点
	 */
	private function set_siteid() {
		if(defined('IN_ADMIN')) {
			$this->siteid = get_siteid();
		} else {
			if (param::get_cookie('siteid')) {
				$this->siteid = param::get_cookie('siteid');
			} else {
				$this->siteid = 1;
			}
		}
	}
}