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
            'next'     => ['block' => false],
            'prev'     => ['block' => false],
            'category' => ['block' => true, 'level' => 4],
            'slide'    => ['block' => true, 'level' => 4],
            'arclist'  => ['block' => true, 'level' => 4],
            'tag'      => ['block' => true, 'level' => 4],
        ];

    //<tag action="links.link"></tag>
    public function _tag($attr, $content)
    {
        static $instance = [];
        $info   = explode('.', $attr['action']);
        $action = $info[1];
        $module = Db::table('module')->where('name', $info[0])->first();
        $class  = ($module['is_system'] == 1 ? "module" : "addons").'\\'.$info[0].'\\system\Tag';
        if ( ! isset($instance[$class])) {
            $instance[$class] = new $class;
        }

        return $instance[$class]->$action($attr, $content);
    }

    //栏目列表
    public function _category($attr, $content, &$view)
    {
        $pid = isset($attr['pid']) ? $attr['pid'] : -1;
        $php
             = <<<str
        <?php 
        \$db = Db::table('category');
        if($pid>=0){
            \$db->where('pid',$pid);
        }
        \$data = \$db->get();
        foreach (\$data as \$field):
        \$field['url'] = __ROOT__.'/c'.\$field['cid'].'.html';
        ?>
            $content
        <?php endforeach;?>
str;

        return $php;
    }

    //幻灯片
    public function _slide($attr, $content, &$view)
    {
        $php
            = <<<str
        <?php 
        \$db = Db::table('slide');
        \$data = \$db->get();
        foreach (\$data as \$field):
            \$field['thumb'] = __ROOT__.'/'.\$field['thumb'];
        ?>
            $content
        <?php endforeach;?>
str;

        return $php;
    }

    //文章列表
    public function _arclist($attr, $content, &$view)
    {
        $cid     = isset($attr['cid']) ? $attr['cid'] : -1;
        $isThumb = isset($attr['thumb']) ? $attr['thumb'] : -1;
        $php
                 = <<<str
        <?php 
        \$db = Db::table('article');
        if('$cid'!=-1){
            \$db->whereIn('category_cid',explode(',','$cid'));
        }
        if($isThumb==1){
            \$db->where('thumb','<>','');
        }
        \$data = \$db->get();
        foreach (\$data as \$field):
            \$field['thumb'] = empty(\$field['thumb'])?:__ROOT__.'/'.\$field['thumb'];
            \$field['url'] = __ROOT__.'/'.\$field['id'].'.html';
        ?>
            $content
        <?php endforeach;?>
str;

        return $php;
    }

    public function _next()
    {
        $php
            = <<<str
        <?php
            \$id = \Request::get('id');
            if(\$article = Db::table('article')->where('id','>',\$id)->first()){
                echo "<a href='/{\$article['id']}.html'>".\$article['title']."</a>";
            }else{
                echo "无";
            }
        ?>
str;

        return $php;
    }

    public function _prev()
    {
        $php
            = <<<str
        <?php
            \$id = \Request::get('id');
            if(\$article = Db::table('article')->where('id','<',\$id)->first()){
                echo "<a href='/{\$article['id']}.html'>".\$article['title']."</a>";
            }else{
                echo "无";
            }
        ?>
str;

        return $php;
    }
}