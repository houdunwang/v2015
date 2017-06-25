<?php namespace system\tag;
use houdunwang\view\build\TagBase;

class {{NAME}} extends TagBase {
	/**
	 * 标签声明
	 * @var array
	 */
	public $tags = [
			'line' => [ 'block' => false ],
			'tag'  => [ 'block' => true, 'level' => 4 ],
	];
	//line 标签
	public function _line( $attr, $content, &$view ) {
		return 'link标签 测试内容';
	}

	//tag 标签
	public function _tag( $attr, $content, &$view ) {
		return 'tag标签 测试内容';
	}
}