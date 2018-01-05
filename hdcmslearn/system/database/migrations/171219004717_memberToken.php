<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class memberToken extends Migration
{
    //执行
    public function up()
    {
        Schema::create('member_token', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('siteid')->comment('站点编号');
            $table->integer('uid')->comment('会员编号');
            $table->datetime('expire_time')->comment('到期时间');
        });
    }

    //回滚
    public function down()
    {
        Schema::drop('member_token');
    }
}