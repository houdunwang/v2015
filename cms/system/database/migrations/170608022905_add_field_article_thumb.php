<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class add_field_article_thumb extends Migration
{
    //执行
    public function up()
    {
        Schema::table('article', function (Blueprint $table) {
            $table->string('thumb')->add();
        });
    }

    //回滚
    public function down()
    {
        Schema::dropField('article', 'thumb');
    }
}