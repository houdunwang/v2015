<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class notification extends Migration
{
    //执行
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->comment('会员编号');
            $table->integer('siteid')->comment('站点编号');
            $table->string('content', 300)->comment('内容');
            $table->string('url')->comment('链接');
            $table->tinyInteger('status')->comment('已阅');
            $table->timestamps();
        });
    }

    //回滚
    public function down()
    {
//        Schema::drop('notification');
    }
}