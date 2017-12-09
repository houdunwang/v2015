<?php namespace module\news\system;

use module\HdProcessor;

/**
 * 图文消息处理
 * Class processor
 *
 * @package module\news
 */
class Processor extends HdProcessor
{
    public function handle($rid = 0)
    {
        $parentNews = Db::table('reply_news')->where('rid', $rid)->where('pid', 0)->orderBy('rand()')->first();
        if ($parentNews) {
            $news = Db::table('reply_news')->where('pid', $parentNews['id'])->get() ?: [];
            array_unshift($news, $parentNews);
            foreach ($news as $f) {
                $d['title']       = $f['title'];
                $d['discription'] = $f['description'];
                $d['picurl']      = __ROOT__.'/'.$f['thumb'];
                switch ($f['type']) {
                    case 1:
                        //显示内容
                        $d['url'] = url('site.show', ['id' => $f['id']], 'news');
                        break;
                    case 0:
                        //跳转链接
                        $d['url'] = preg_match('/^http/i', $f['url']) ? $f['url'] : __ROOT__.'/'.$f['url'];
                }
                $data[] = $d;
            }
            $this->news($data);
        }
    }
}