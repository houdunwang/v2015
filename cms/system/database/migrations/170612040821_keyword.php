<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class keyword extends Migration
{
    //执行
    public function up()
    {
        Schema::create('keyword', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('module')->comment('关键词所属模块');
            $table->string('content')->comment('关键词内容');
            $table->integer('module_id')->comment('模块主键');
        });
    }

    //回滚
    public function down()
    {
        Schema::drop('keyword');
    }
}