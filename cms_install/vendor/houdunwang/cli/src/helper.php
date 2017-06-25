<?php
function cli( $cli ) {
	$_SERVER['argv'] = preg_split( '/\s+/', $cli );
	//执行命令行指令
	\Cli::bootstrap(true);
}