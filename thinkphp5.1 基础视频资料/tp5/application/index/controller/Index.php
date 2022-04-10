<?php
namespace app\index\controller;

use app\common\model\Users;
use think\Db;

class Index
{
    public function index()
    {
        //获取users表中的所有数据
//        $users = Users::select();
//        halt($users);
        //获取某个主键id值的数据
//        $user = Users::find(1);
//        halt($user);
        //如果需要找到users表中nick字段值等于幸福小海豚的数据
//        $users = Users::where('nick','=','幸福小海豚')->select();
//        halt($users);
        //还可以使用Db类来获取对应表的数据
//        $user = Db::table('users')->select();
//        halt($user);
//        $user = Db::table('users')->find(3);
//        halt($user);
        //可以使用助手函数db()方法来获取表的数据
//        $user = \db('users')->select();
//        halt($user);
        return view('');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function news(){
        echo '我是新闻方法';die;
    }
}
