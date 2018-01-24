<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;

class hd180122174502_change_member_token extends Migration
{
    //执行
    public function up()
    {
        Schema::table('member_token', function (Blueprint $table) {
            $table->string('token', 50)->index()->add();
        });
    }

    //回滚
    public function down()
    {
        //Schema::dropField('member_token', 'name');
    }
}