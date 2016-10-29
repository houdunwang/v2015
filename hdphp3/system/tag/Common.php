<?php namespace system\tag;

use hdphp\view\TagBase;

class Common extends TagBase {
	/**
	 * 标签声明
	 * @var array
	 */
	public $tags
		= [
			'bootstrap' => [ 'block' => false ],
			'user' => [ 'block' => true, 'level' => 4 ],
		];

	//line 标签
	public function _bootstrap( $attr, $content, &$view ) {
		return <<<str
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">

<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
str;

	}

	//tag 标签
	public function _user( $attr, $content, &$view ) {
		$row   = isset( $attr['row'] ) ? $attr['row'] : 10;
		$order = isset( $attr['order'] ) ? $attr['order'] : 'desc';
		$php
		       = <<<php
		<?php
			\$_data= Db::table('user')->limit($row)->orderBy('id','$order')->get();
			foreach(\$_data as \$field):?>
php;
		$php .= $content;
		$php .= '<?php endforeach;?>';

		return $php;
	}
}