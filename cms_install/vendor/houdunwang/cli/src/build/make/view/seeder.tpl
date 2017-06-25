<?php namespace {{NAMESPACE}};
use houdunwang\database\build\Seeder;
use houdunwang\db\Db;
class {{className}} extends Seeder {
    //执行
	public function up() {
		//Db::table('news')->insert(['title'=>'后盾人']);
    }
    //回滚
    public function down() {

    }
}