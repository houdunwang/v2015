<?php
if ( ! function_exists( 'trace' ) ) {
	/**
	 * trace
	 *
	 * @param string $value 变量
	 * @param string $label 标签
	 * @param string $level 日志级别(或者页面Trace的选项卡)
	 * @param bool|false $record 是否记录日志
	 *
	 * @return mixed
	 */
	function trace( $value = '[hdphp]', $label = '', $level = 'DEBUG', $record = false ) {
		return Error::trace( $value, $label, $level, $record );
	}
}