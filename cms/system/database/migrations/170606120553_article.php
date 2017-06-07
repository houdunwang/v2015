<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class article extends Migration
{
    //执行
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('category_cid')->comment('栏目编号');
            $table->string('title', 100)->comment('文章标题');
            $table->mediumint('click')->comment('点击次数');
            $table->string('description')->comment('描述');
            $table->text('content')->comment('文章内容');
            $table->string('source')->comment('文章来源');
            $table->string('author', 50)->comment('文章作者');
            $table->tinyInteger('orderby')->comment('文章排序')->defaults(0);
            $table->string('linkurl')->comment('外部链接');
            $table->string('keyword')->comment('微信回复关键词');
            $table->tinyInteger('iscommend')->comment('推荐文章')->defaults(0);
            $table->tinyInteger('ishot')->comment('热门文章')->defaults(0);
        });
    }

    //回滚
    public function down()
    {
        Schema::drop('article');
    }
}