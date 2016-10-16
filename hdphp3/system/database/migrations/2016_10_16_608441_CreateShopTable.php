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
class CreateShopTable extends Migration {
    //执行
	public function up() {
		Schema::create( 'shop', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string('name', 100)->nullable()->defaults('后盾')->comment('商品标题');
            $table->timestamps();
        });
    }

    //回滚
    public function down() {
        Schema::drop( 'shop' );
    }
}