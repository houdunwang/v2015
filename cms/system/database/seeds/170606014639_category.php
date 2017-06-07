<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;
use houdunwang\db\Db;
use system\model\Category as CategoryModel;

class category extends Seeder
{
    //执行
    public function up()
    {
        $data = [
            ['catname' => 'hdphp', 'pid' => 0, 'description' => 'hdphp 一个优秀的框架', 'linkurl' => '', 'orderby' => 0],
            [
                'catname'     => 'hdcms',
                'pid'         => 0,
                'description' => '开源免费的微信、桌面、移动内容管理系统',
                'linkurl'     => 'http://www.hdcms.com',
                'orderby'     => 0,
            ],
            ['catname' => '新闻', 'pid' => 0, 'description' => '后盾新闻', 'linkurl' => '', 'orderby' => 0],
            ['catname' => '后盾网新闻', 'pid' => 3, 'description' => '关于后盾培训的新闻', 'linkurl' => '', 'orderby' => 0],
        ];
        foreach ($data as $d) {
            $model = new CategoryModel();
            $model->save($d);
        }
    }

    //回滚
    public function down()
    {
        Schema::truncate('category');
    }
}