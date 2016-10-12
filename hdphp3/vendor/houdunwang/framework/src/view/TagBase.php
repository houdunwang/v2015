<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\view;

//标签基类
abstract class TagBase {
	protected $content;
	protected $view;
	protected $left;
	protected $right;
	protected $exp
		= [
			'/\s+eq\s+/'  => '==',
			'/\s+neq\s+/' => '!=',
			'/\s+gt\s+/'  => '>',
			'/\s+lt\s+/'  => '<',
			'/\s+lte\s+/' => '<=',
			'/\s+gte\s+/' => '>='
		];

	/**
	 * 解析标签
	 *
	 * @param  [string] $content 模板内容
	 * @param  [object] &$view   视图对象
	 *
	 * @return [string]          解析后内容
	 */
	public function parse( $content, &$view ) {
		$this->content = $content;
		$this->view    = $view;
		$this->left    = Config::get( 'view.tag_left' );
		$this->right   = Config::get( 'view.tag_right' );

		//解析标签
		foreach ( $this->tags as $tag => $param ) {
			if ( $param['block'] ) {
				//解析块标签
				$this->block( $tag, $param );
			} else {
				//解析行标签
				$this->line( $tag, $param );
			}
		}

		return $this->content;
	}

	/**
	 * 解析块标签
	 *
	 * @param $tag
	 * @param $param
	 */
	private function block( $tag, $param ) {
		for ( $i = 1;$i <= $param['level'];$i ++ ) {
			$preg = '#' . $this->left . '(?:' . $tag . '|' . $tag . '\s+(.*?))' . $this->right . '(.*?)' . $this->left . '/' . $tag . $this->right . '#is';

			if ( preg_match_all( $preg, $this->content, $matchs, PREG_SET_ORDER ) ) {
				foreach ( $matchs as $m ) {
					//获取属性
					if ( ! empty( $m[1] ) ) {
						$attr = $this->getAttr( $m[1] );
					} else {
						$attr = [ ];
					}
					//执行标签方法
					$method  = '_' . $tag;
					$replace = $this->$method( $attr, $m[2], $this->view );
					//替换模板内容
					$this->content = str_replace( $m[0], $replace, $this->content );
				}
			} else {
				return;
			}
		}

	}

	/**
	 * 解析行标签
	 *
	 * @param $tag
	 */
	private function line( $tag ) {
		$preg = '#' . $this->left . '(?:' . $tag . '|' . $tag . '\s+(.*?))\s*/?' . $this->right . '#is';
		if ( preg_match_all( $preg, $this->content, $matchs, PREG_SET_ORDER ) ) {
			foreach ( $matchs as $m ) {
				//获取属性
				if ( ! empty( $m[1] ) ) {
					$attr = $this->getAttr( $m[1] );
				} else {
					$attr = [ ];
				}
				//执行标签方法
				$method = '_' . $tag;

				$replace = $this->$method( $attr, '', $this->view );
				//替换模板内容
				$this->content = str_replace( $m[0], $replace, $this->content );
			}
		}
	}

	/**
	 * 获取属性
	 *
	 * @param $con
	 *
	 * @return array
	 */
	private function getAttr( $con ) {
		$attr = [ ];
		$preg = '#([\w\-]+)\s*=\s*([\'"])(.*?)\2#i';
		if ( preg_match_all( $preg, $con, $matches ) ) {
			foreach ( $matches[1] as $i => $name ) {
				//$attr[$name] = $this->ReplaceConst($matches[3][$i]);
				//替换eq neq 等
				$attr[ $name ] = preg_replace( array_keys( $this->exp ), array_values( $this->exp ), $matches[3][ $i ] );
			}
		}

		return $attr;
	}

	/**
	 * 替换常量
	 *
	 * @param $content 内容
	 *
	 * @return mixed
	 */
	protected function replaceConst( $content ) {
		$const = get_defined_constants( TRUE );

		foreach ( $const['user'] as $k => $v ) {
			$content = str_replace( $k, $v, $content );
		}

		return $content;
	}
}