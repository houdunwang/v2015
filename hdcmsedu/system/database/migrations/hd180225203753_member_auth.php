<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class hd180225203753_member_auth extends Migration
{
    //执行
    public function up()
    {
        Schema::table(
            'member_auth',
            function (Blueprint $table) {
                $table->string('wechat_unionid', 50)->comment('微信开放平台唯一标识')->add();
            }
        );
    }

    //回滚
    public function down()
    {
        //Schema::dropField('member_auth', 'name');
    }
}