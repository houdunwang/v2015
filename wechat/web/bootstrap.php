<?php
//自动加载类   php >5.4
function __autoload( $class ) {
	include str_replace( '\\', '/', $class ) . '.php';
}

( new \app\Entry() )->handler();