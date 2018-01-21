<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;
use houdunwang\db\Db;

class hd170602112255_profile_fields extends Seeder
{
    //执行
    public function up()
    {
        if (Db::table('profile_fields')->find(1)) {
            return;
        }
        $sql
            = <<<str
INSERT INTO `hd_profile_fields` (`id`, `field`, `title`, `orderby`, `status`, `required`, `showinregister`)
VALUES
	(1,'qq','QQ号',0,0,1,1),
	(2,'realname','真实姓名',0,0,1,1),
	(3,'nickname','昵称',0,1,1,1),
	(4,'mobile','手机号码',0,1,1,1),
	(5,'telephone','固定电话',0,1,0,0),
	(6,'vip','VIP级别',0,1,0,0),
	(7,'address','居住地址',0,1,0,0),
	(8,'zipcode','邮编',0,1,0,0),
	(9,'alipay','阿里帐号',0,1,0,0),
	(10,'msn','msn帐号',0,1,0,0),
	(11,'taobao','淘宝帐号',0,1,0,0),
	(12,'email','邮箱',0,1,1,1),
	(13,'site','个人站点',0,1,0,0),
	(14,'nationality','国籍',0,1,0,0),
	(15,'introduce','自我介绍',0,1,0,0),
	(16,'gender','性别',0,1,0,0),
	(17,'graduateschool','毕业学校',0,1,0,0),
	(18,'height','身高',0,1,0,0),
	(19,'weight','体重',0,1,0,0),
	(20,'bloodtype','血型',0,1,0,0),
	(21,'birthyear','出生日期',0,1,0,0);
str;
        Db::execute($sql);
    }

    //回滚
    public function down()
    {

    }
}