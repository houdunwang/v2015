<?php namespace houdunwang\model\build;
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

class ViewModel extends Model {
	protected $view = [ ];

	public function view() {
		if ( ! empty( $this->view ) ) {
			foreach ( $this->view as $table => $view ) {
				if ( $table !== '_field' ) {
					$action = $view['action'];
					$info   = preg_split( '/(=|>=|<=)/', $view['on'], 8, PREG_SPLIT_DELIM_CAPTURE );

					$this->$action( $table, $info[0], $info[1], $info[2] );
				} else {
					$this->field( $view );
				}
			}

			return $this;
		}
	}
}