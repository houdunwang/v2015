<?php
defined('IN_PHPCMS') or exit('No permission resources.');
function spider_photos($str) {
	$field = $GLOBALS['field'];
	$_POST[$field.'_url'] = array();
	preg_match_all('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', $str, $out);
	$array = array();
	if (isset($out[1]))foreach ($out[1] as $v) {
		$_POST[$field.'_url'][] = $v;
	}
	return '1';
}
function spider_downurls($str) {
	$field = $GLOBALS['field'];
	$_POST[$field.'_fileurl'] = array();
	preg_match_all('/<a[^>]*href=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', $str, $out);
	$array = array();
	if (isset($out[1]))foreach ($out[1] as $v) {
		$_POST[$field.'_fileurl'][] = $v;
	}
	return '1';
}