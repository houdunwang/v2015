<?php namespace system\tag;

use houdunwang\view\build\TagBase;

class Tag extends TagBase
{
    /**
     * 标签声明
     *
     * @var array
     */
    public $tags
        = [
            'line'     => ['block' => false],
            'category' => ['block' => true, 'level' => 4],
        ];

    //line 标签
    public function _line($attr, $content, &$view)
    {
        return 'link标签 测试内容';
    }

    //栏目列表
    public function _category($attr, $content, &$view)
    {
        return 'category';
    }
}