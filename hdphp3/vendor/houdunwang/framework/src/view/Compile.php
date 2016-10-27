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

/**
 * 模板编译
 * Class Compile
 * @package hdphp\view
 * @author 向军
 */
class Compile {
	//视图对象
	private $view;

	//模板编译内容
	private $content;

	//构造函数
	function __construct( &$view ) {
		$this->view = $view;
	}

	/**
	 * 运行编译
	 * @return string
	 */
	public function run() {
		//模板内容
		$this->content = file_get_contents( $this->view->tpl );
		//解析标签
		$this->tags();
		//解析全局变量与常量
		$this->globalParse();

		//保存编译文件
		return $this->content;
	}

	/**
	 * 解析全局变量与常量
	 */
	private function globalParse() {
		//处理{{}}
		$this->content = preg_replace( '/(?<!@)\{\{(.*?)\}\}/i', '<?php echo \1?>', $this->content );
		//处理@{{}}
		$this->content = preg_replace( '/@(\{\{.*?\}\})/i', '\1', $this->content );
	}

	/**
	 * 解析标签
	 */
	private function tags() {
		//标签库
		$tags   = Config::get( 'view.tags' );
		$tags[] = 'hdphp\view\HdphpTag';
		//解析标签
		foreach ( $tags as $class ) {
			$obj           = new $class();
			$this->content = $obj->parse( $this->content, $this->view );
		}
	}
}