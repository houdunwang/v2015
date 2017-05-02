<?php
/** .-------------------------------------------------------------------
* |  Software: [HDPHP framework]
* |      Site: www.hdphp.com
* |-------------------------------------------------------------------
* |    Author: 向军 <2300071698@qq.com>
* |    WeChat: aihoudun
* | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
* '-------------------------------------------------------------------*/

use hdphp\database\Seeder;
class a extends Seeder {
    //执行
	public function up() {
		Db::table('a')->insert(['title'=>'后盾人']);
    }
    //回滚
    public function down() {
		Db::table('a')->where('id','>',0)->delete();
    }
}