<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class user extends Migration
{
    //执行
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('username')->comment('后台帐号');
            $table->string('password')->comment('登录密码');
        });
    }

    //回滚
    public function down()
    {
        Schema::drop('user');
    }
}