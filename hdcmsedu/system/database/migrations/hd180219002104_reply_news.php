<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class hd180219002104_reply_news extends Migration
{
    //执行
    public function up()
    {
        Schema::table(
            'reply_news',
            function (Blueprint $table) {
                $table->tinyInteger('type')->comment('内容类型')->add();
            }
        );
    }

    //回滚
    public function down()
    {
        //Schema::dropField('reply_news', 'name');
    }
}