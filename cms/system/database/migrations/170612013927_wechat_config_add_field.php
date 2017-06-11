<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class wechat_config_add_field extends Migration
{
    //执行
    public function up()
    {
        Schema::table('wechat_config', function (Blueprint $table) {
            //$table->string('name', 50)->add();
            $table->string('token', 100)->add();
            $table->string('encodingaeskey', 100)->add();
        });
    }

    //回滚
    public function down()
    {
        Schema::dropField('wechat_config', 'token');
        Schema::dropField('wechat_config', 'encodingaeskey');
    }
}