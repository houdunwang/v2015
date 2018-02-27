<?php namespace module\news\controller;

use module\HdController;
use houdunwang\request\Request;
use houdunwang\db\Db;
use houdunwang\view\View;

/**
 * 图文消息管理
 *
 * @author 向军
 * @url http://open.hdcms.com
 */
class Site extends HdController
{
    //图文消息回复
    public function show()
    {
        $id      = Request::get('id');
        $article = Db::table('reply_news')->where('id', $id)->first();
        View::with('hdcms', $article);

        return view($this->template.'/show.php');
    }
}