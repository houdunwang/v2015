<?php namespace app\system\controller\part;

/**
 * 模块的自定义模板标签处理
 * Class Tag
 *
 * @package app\system\controller\part
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class Tag
{
    public static function make($data)
    {
        if ($data['tag']) {
            self::php($data);
        }
    }

    protected static function php($data)
    {
        $tpl
              = <<<php
<?php namespace addons\\{$data['name']}\\system;

/**
 * 模块模板视图标签
 * 支持模块间调用
 * @author {$data['author']}
 * @url http://www.hdcms.com
 */
class Tag{
	/**
	 * 标签定义
	 *
	 * @param array \$attr 标签使用的属性
	 * @param string \$content 块标签包裹的内容
	 *
	 * @return string
	 * 调用方法: <tag action="{$data['name']}.show" id="1" name="hdphp"></tag>
	 */
	public function show( \$attr, \$content ) {
		return '这是标签内容';
	}
}
php;
        $file = "addons/{$data['name']}/system/Tag.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }
}