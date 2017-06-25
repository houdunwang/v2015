<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

/**
 * 幻灯片
 * Class slide
 *
 * @package system\database\migrations
 */
class slide extends Migration
{
    //执行
    public function up()
    {
        Schema::create('slide', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title')->comment('标题');
            $table->string('url')->comment('跳转链接');
            $table->tinyInteger('displayorder')->comment('排序')->defaults(0);
            $table->string('thumb')->comment('图片地址');
        });
    }

    //回滚
    public function down()
    {
        Schema::drop('slide');
    }
}