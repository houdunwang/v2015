<?php namespace module\article\service;

use module\article\model\WebModel;
use module\HdService;
use Db;

/**
 * 初始化栏目
 * Class Init
 *
 * @package module\article\service
 */
class Init extends HdService
{
    public function make($siteId)
    {
        //设置路由器
        $sql
            = <<<str
INSERT INTO `hd_router` ( `siteid`, `module`, `title`, `router`, `url`, `status`, `createtime`, `condition`)
VALUES
	($siteId,'article','栏目静态规则','article{siteid}-{cid}-{page}.html','m=article&action=controller/entry/category&siteid={siteid}&cid={cid}&page={page}',0,1487401724,'{\"siteid\":\"[a-z0-9]+\",\"cid\":\"[a-z0-9]+\",\"page\":\"[a-z0-9]+\"}'),
	($siteId,'article','文章静态规则','article{siteid}-{aid}-{cid}-{mid}.html','m=article&action=controller/entry/content&siteid={siteid}&cid={cid}&aid={aid}',0,1487401724,'{\"siteid\":\"[a-z0-9]+\",\"aid\":\"[a-z0-9]+\",\"cid\":\"[a-z0-9]+\",\"mid\":\"[a-z0-9]+\"}');
str;
        Db::execute($sql);
        //创建模型表
        $model = new WebModel();
        $model->insertGetId(['siteid'      => $siteId,
                             'model_title' => '普通文章',
                             'model_name'  => 'news',
                             'is_system'   => 1,
        ]);
        //创建文章表
        $model->createModelTable('news', $siteId);
    }
}