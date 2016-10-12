<?php namespace system\tag;

use hdphp\view\TagBase;

class Tag extends TagBase {
	/**
	 * 标签声明
	 * @var array
	 */
	public $tags
		= [
			'line' => [ 'block' => FALSE, 'level' => 4 ],
			'tag'  => [ 'block' => TRUE, 'level' => 4 ],
		];

	public function _line( $attr ) {
		static $instance = [ ];
		$info   = explode( '.', $attr['action'] );
		$action = $info[1];
		if ( $module = Db::table( 'modules' )->where( 'name', $info[0] )->first() ) {
			$class = ( $module['is_system'] == 1 ? 'module' : 'addons' ) . '\\' . $info[0] . '\tag';
			if ( ! isset( $instance[ $class ] ) ) {
				$instance[ $class ] = new $class;
			}

			return $instance[ $class ]->$action( $attr );
		}
	}

	public function _tag( $attr, $content ) {
		static $instance = [ ];
		$info   = explode( '.', $attr['action'] );
		$action = $info[1];
		if ( $module = Db::table( 'modules' )->where( 'name', $info[0] )->first() ) {
			$class = ( $module['is_system'] == 1 ? 'module' : 'addons' ) . '\\' . $info[0] . '\tag';
			if ( ! isset( $instance[ $class ] ) ) {
				$instance[ $class ] = new $class;
			}

			return $instance[ $class ]->$action( $attr, $content );
		}
	}
}