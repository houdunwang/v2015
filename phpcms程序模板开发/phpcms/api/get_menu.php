<?php
/**
 * 获取联动菜单接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 
if(!$_GET['callback'] || !$_GET['act'])  showmessage(L('error'));

switch($_GET['act']) {
	case 'ajax_getlist':
		ajax_getlist();
	break;
	
	case 'ajax_getpath':
		ajax_getpath($_GET['parentid'],$_GET['keyid'],$_GET['callback'],$_GET['path']);
	break;	
	case 'ajax_gettopparent':
		ajax_gettopparent($_GET['id'],$_GET['keyid'],$_GET['callback'],$_GET['path']);
	break;		
}


/**
 * 获取地区列表
 */
function ajax_getlist() {
	$cachefile = safe_getcache($_GET['cachefile']);
	$path = safe_getcache($_GET['path']);
	$title = $_GET['title'];
	$key = $_GET['key'];
	$infos = getcache($cachefile,$path);
	$where_id = intval($_GET['parentid']);
	$parent_menu_name = ($where_id==0) ? '' : trim($infos[$where_id][$key]);
	is_array($infos)?null:$infos = array();
	foreach($infos AS $k=>$v) {
		if($v['parentid'] == $where_id) {
			if ($v['parentid']) $parentid = $infos[$v['parentid']]['parentid'];
			$s[]=iconv(CHARSET,'utf-8',$v['catid'].','.trim($v[$key]).','.$v['parentid'].','.$parent_menu_name.','.$parentid);
		}
	}
	if(count($s)>0) {
		$jsonstr = json_encode($s);
		echo trim_script($_GET['callback']).'(',$jsonstr,')';
		exit;			
	} else {
		echo trim_script($_GET['callback']).'()';exit;			
	}
}

/**
 * 获取地区父级路径路径
 * @param $parentid 父级ID
 * @param $keyid 菜单keyid
 * @param $callback json生成callback变量
 * @param $result 递归返回结果数组
 * @param $infos
 */
function ajax_getpath($parentid,$keyid,$callback,$path = 'commons',$result = array(),$infos = array()) {
	$path = safe_getcache($path);
	$keyid = safe_getcache($keyid);
	$parentid = intval($parentid);
	if(!$infos) {
		$infos = getcache($keyid,$path);
	}
	if(array_key_exists($parentid,$infos)) {
		$result[]=iconv(CHARSET,'utf-8',trim($infos[$parentid]['catname']));
		return ajax_getpath($infos[$parentid]['parentid'],$keyid,$callback,$path,$result,$infos);
	} else {
		if(count($result)>0) {
			krsort($result);
			$jsonstr = json_encode($result);
			echo trim_script($callback).'(',$jsonstr,')';
			exit;
		} else {
			$result[]=iconv(CHARSET,'utf-8',$datas['title']);
			$jsonstr = json_encode($result);
			echo trim_script($callback).'(',$jsonstr,')';
			exit;
		}
	}
}
/**
 * 获取地区顶级ID
 * Enter description here ...
 * @param  $linkageid 菜单id
 * @param  $keyid 菜单keyid
 * @param  $callback json生成callback变量
 * @param  $infos 递归返回结果数组
 */
function ajax_gettopparent($id,$keyid,$callback,$path,$infos = array()) {
	$path = str_replace(array('/', '//'), '', $path);
	$keyid = str_replace(array('/', '//'), '', $keyid);
	$id = intval($id);
	if(!$infos) {
		$infos = getcache($keyid,$path);
	}
	if($infos[$id]['parentid']!=0) {
		return ajax_gettopparent($infos[$id]['parentid'],$keyid,$callback,$path,$infos);
	} else {
		echo trim_script($callback).'(',$id,')';
		exit;		
	}
}
function safe_getcache($str) {
	$str = str_replace(array("'",'#','=','`','$','%','&',';','..'), '', $str);
	$str = preg_replace('/(\/){1,}|(\\\){1,}/', '', $str);
	return $str;
}
?>