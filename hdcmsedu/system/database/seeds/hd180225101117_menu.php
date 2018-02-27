<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;
use houdunwang\db\Db;

class hd180225101117_menu extends Seeder
{
    //执行
    public function up()
    {
        $data = [
            'id'         => 104,
            'pid'        => 63,
            'title'      => '支付宝',
            'permission' => 'feature_setting_alipay',
            'url'        => '?s=site/setting/alipay',
            'append_url' => '',
            'icon'       => 'fa fa-cubes',
            'orderby'    => 0,
            'is_display' => 1,
            'is_system'  => 1,
            'mark'       => 'feature',
        ];
        Db::table('menu')->replace($data);
    }

    //回滚
    public function down()
    {

    }
}