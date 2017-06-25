<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class config extends Migration
{
    //执行
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->mediumtext('content')->comment('配置项内容');
        });
    }

    //回滚
    public function down()
    {
        Schema::drop('config');
    }
}