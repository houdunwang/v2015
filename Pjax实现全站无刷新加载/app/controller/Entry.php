<?php

namespace app\controller;


class Entry
{
	public function __construct () {
		define ('IS_PJAX',isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX']=='true');
	}

	public function index ()
	{
		$tpl = IS_PJAX ? 'index-pjax':'index' ;

		include './view/'.$tpl.'.php';
	}

	public function php ()
	{
		$tpl = IS_PJAX ? 'php-pjax':'php' ;
		include './view/'.$tpl.'.php';
	}

	public function linux ()
	{
		$tpl = IS_PJAX ? 'linux-pjax':'linux' ;
		include './view/'.$tpl.'.php';
	}

	public function nodejs ()
	{
		$tpl = IS_PJAX ? 'nodejs-pjax':'nodejs' ;
		include './view/'.$tpl.'.php';
	}

	public function search ()
	{
		$search  =  $_GET['search'];
		$tpl = IS_PJAX ? 'search-pjax':'search' ;
		include './view/'.$tpl.'.php';
	}
}
