<?php namespace system\database\migrations;

use houdunwang\database\build\Migration;
use houdunwang\database\build\Blueprint;
use houdunwang\database\Schema;
use houdunwang\db\Db;
class hd170602105904_seeds extends Migration
{
    //执行
    public function up()
    {
        if ( ! Schema::tableExists('seeds')) {
            $sql
                = <<<sql
CREATE TABLE `hd_seeds` (
  `seed` varchar(255) NOT NULL,
  `batch` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
sql;
            Db::execute($sql);
        }
    }

    //回滚
    public function down()
    {
    }
}