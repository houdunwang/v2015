<?php namespace module\news\system;

use module\HdProcessor;
use houdunwang\db\Db;

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
        $news = Db::table('reply_news')->where('rid', $rid)->get() ?: [];
        $data = [];
        if ($news) {
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
                        $d['url'] = preg_match('/^http/i', $f['url']) ? $f['url']
                            : __ROOT__.'/'.$f['url'];
                }
                $data[] = $d;
            }
        }
        if ($data) {
            $this->news($data);
        }
    }
}