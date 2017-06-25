<?php namespace {{NAMESPACE}};
use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
class {{className}} extends Migration {
    //执行
	public function up() {
		Schema::table( '{{TABLE}}', function ( Blueprint $table ) {
			//$table->string('name', 50)->add();
        });
    }

    //回滚
    public function down() {
            //Schema::dropField('{{TABLE}}', 'name');
    }
}