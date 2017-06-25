<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class category extends Migration
{
    //执行
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('cid');
            $table->timestamps();
            $table->string('catname')->comment('栏目名称');
            $table->integer('pid')->comment('父级栏目');
            $table->string('description')->comment('栏目描述');
            $table->string('linkurl')->comment('栏目链接');
            $table->tinyInteger('orderby')->comment('排序')->defaults(0);
        });
    }

    //回滚
    public function down()
    {
        Schema::drop('category');
    }
}