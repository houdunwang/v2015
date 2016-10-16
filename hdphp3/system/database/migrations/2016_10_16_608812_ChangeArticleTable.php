<?php
/** .-------------------------------------------------------------------
* |  Software: [HDPHP framework]
* |      Site: www.hdphp.com
* |-------------------------------------------------------------------
* |    Author: 向军 <2300071698@qq.com>
* |    WeChat: aihoudun
* | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
* '-------------------------------------------------------------------*/
use hdphp\database\Migration;
use hdphp\database\Blueprint;
class ChangeArticleTable extends Migration {
    //执行
	public function up() {
		Schema::table( 'article', function ( Blueprint $table ) {
			$table->string('title', 50)->change();
        });
    }
    //回滚
    public function down() {

    }
}