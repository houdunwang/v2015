<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class add_field_config_default_message_welcome extends Migration
{
    //执行
    public function up()
    {
        Schema::table('config', function (Blueprint $table) {
            $table->string('default_message')->comment('微信默认回复消息')->add();
            $table->string('welcome')->comment('微信关注时的回复消息')->add();
        });
    }

    //回滚
    public function down()
    {
        Schema::dropField('default_message', 'name');
        Schema::dropField('welcome', 'name');
    }
}