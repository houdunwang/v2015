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

class CreateCategoryTable extends Migration {
	//执行
	public function up() {
		Schema::create( 'category', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'catname', 100 );
			$table->timestamps();
		} );
	}

	//回滚
	public function down() {
		Schema::drop( 'category' );
	}
}