<?php namespace module\article\system;

use Db;
use module\HdProcessor;
use system\model\Article;
use WeChat;

class Processor extends HdProcessor
{
    public function handler($kid)
    {
        $id      = $this->getModuleId($kid);
        $article = Article::find($id);
        //向用户回复消息
        $news = [
            [
                'title'       => $article['title'],
                'discription' => $article['description'],
                'picurl'      => __ROOT__.'/'.$article['thumb'],
                'url'         => __ROOT__.'/'.$id.'.html',
            ],
        ];
        $this->news($news);
    }
}