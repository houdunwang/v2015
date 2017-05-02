<?php
function dd( $data ) {
	echo "<pre>" . print_r( $data, true );
}

/**
 * 全局变量
 *
 * @param $name 变量名
 * @param string $value 变量值
 *
 * @return mixed 返回值
 * v('a','abc');  v('a')
 */
if ( ! function_exists( 'v' ) ) {
	function v( $name = null, $value = '[null]' ) {
		static $vars = [ ];
		if ( is_null( $name ) ) {
			return $vars;
		} else if ( $value == '[null]' ) {
			//取变量
			$tmp = $vars;
			foreach ( explode( '.', $name ) as $d ) {
				if ( isset( $tmp[ $d ] ) ) {
					$tmp = $tmp[ $d ];
				} else {
					return null;
				}
			}

			return $tmp;
		} else {
			//设置
			$tmp = &$vars;
			foreach ( explode( '.', $name ) as $d ) {
				if ( ! isset( $tmp[ $d ] ) ) {
					$tmp[ $d ] = [ ];
				}
				$tmp = &$tmp[ $d ];
			}

			return $tmp = $value;
		}
	}
}

/**
 * 生成模块的后台访问地址
 * @param $url
 * @param array $args
 *
 * @return string
 */
function site_url( $url, $args = [ ] ) {
	$info = explode( '.', $url );

	return __APP__ . "?mo={$info[0]}&ac={$info[1]}&t=site&" . http_build_query( $args );
}


/**
 * 生成模块的前台访问地址
 * @param $url
 * @param array $args
 *
 * @return string
 */
function web_url( $url, $args = [ ] ) {
	$info = explode( '.', $url );

	return __APP__ . "?mo={$info[0]}&ac={$info[1]}&t=web&" . http_build_query( $args );
}


















