<?php
defined('IN_PHPCMS') or exit('No permission resources.');

class rss {
	private $db;
	function __construct() {
		$this->db = pc_base::load_model('content_model');
		pc_base::load_app_class('rssbuilder','','','0');
		$this->siteid = $_GET['siteid'] ? intval($_GET['siteid']) : '1';
		$this->rssid = intval($_GET['rssid']);
		define('SITEID', $this->siteid);
	}

	public function init() {
		$siteurl = siteurl(SITEID);
		if(empty($this->rssid)) {
			$catid = $_GET['catid'] ? intval($_GET['catid']) : '0';
			$siteids = getcache('category_content','commons');
			$siteid = $siteids[$catid] ? $siteids[$catid] : 1;
			$CATEGORYS = getcache('category_content_'.$siteid,'commons');
			$subcats = subcat($catid,0,1,$siteid);
			foreach ($CATEGORYS as $r) if($r['parentid'] == 0) $channel[] = $r;
			include template('content','rss');
		} else {
			$CATEGORYS = getcache('category_content_'.$this->siteid,'commons');
			$SITEINFO = getcache('sitelist','commons');
			$CAT = $CATEGORYS[$this->rssid];
			if(count($CAT) == 0) showmessage(L('missing_part_parameters'),'blank');
			$siteid = $CAT['siteid'];
			$sitedomain = $SITEINFO[$siteid]['domain'];  //获取站点域名
			$MODEL = getcache('model','commons');
			$modelid = $CAT['modelid'];		
		    $encoding   =  CHARSET;
		    $about      =  SITE_PROTOCOL.SITE_URL;
		    $title      =  $CAT['catname'];
		    $description = $CAT['description'];
		    $content_html = $CAT['content_ishtml'];
		    $image_link =  "<![CDATA[".$CAT['image']."]]> ";
		    $category   =  '';
		    $cache      =  60;
		    $rssfile    = new RSSBuilder($encoding, $about, $title, $description, $image_link, $category, $cache);
		    $publisher  =  '';
		    $creator    =  SITE_PROTOCOL.SITE_URL;
		    $date       =  date('r');
		    $rssfile->addDCdata($publisher, $creator, $date);
		    $ids = explode(",",$CAT['arrchildid']);
		    if(count($ids) == 1 && in_array($this->rssid, $ids)) {
		        $sql .= "`catid` = '$this->rssid' AND `status` = '99'";
		    } else {
		        $sql .= get_sql_catid('category_content_'.$siteid,$this->rssid)." AND `status` = '99'";
		    }
			if(empty($MODEL[$modelid]['tablename'])) showmessage(L('missing_part_parameters'),'blank');
		    $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
			$info = $this->db->select($sql,'`title`, `description`, `url`, `inputtime`, `thumb`, `keywords`','0,20','id DESC');
		
			foreach ($info as $r) {
			    //添加项目
			    if(!empty($r['thumb'])) $img = "<img src=".thumb($r['thumb'], 150, 150)." border='0' /><br />";else $img = '';
		        $about          =  $link = (strpos($r['url'], 'http://') !== FALSE || strpos($r['url'], 'https://') !== FALSE) ? "<![CDATA[".$r['url']."]]> " : (($content_html == 1) ? "<![CDATA[".substr($sitedomain,0,-1).$r['url']."]]> " : "<![CDATA[".substr(APP_PATH,0,-1).$r['url']."]]> ");
		        $title          =   "<![CDATA[".$r['title']."]]> ";
		        $description    =  "<![CDATA[".$img.$r['description']."]]> ";
		        $subject        =  '';
		        $date           =  date('Y-m-d H:i:s' , $r['inputtime']);
		        $author         =  $PHPCMS['sitename'].' '.SITE_PROTOCOL.SITE_URL;
		        $comments       =  '';//注释;
	
		        $rssfile->addItem($about, $title, $link, $description, $subject, $date,	$author, $comments, $image);
			}	
			$version = '2.00';
	    	$rssfile->outputRSS($version);
		}    	        	
	}
}
?>