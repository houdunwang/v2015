<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class wechat_config extends Migration
{
    //执行
    public function up()
    {
        Schema::create('wechat_config', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('webname')->comment('公众号名称');
            $table->string('account')->comment('微信号');
            $table->string('appid')->comment('AppId');
            $table->string('appsecret')->comment('AppSecret');
        });
    }

    //回滚
    public function down()
    {
        Schema::drop('wechat_config');
    }
}