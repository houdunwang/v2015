<?php

namespace app\Index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Validate;
class Login extends Controller
{
    public function create(){

        //加载登录模板
        return view();
    }


    public function post(Request $request){
        //获取post数据
        $post = $request->post();
        //定义验证规则
        $validate = Validate::make([
            //键名代表定义需要验证的字段名
            //键值代表验证规则
            'username' => 'require|min:3|max:30',
            'password' => 'require|min:6|max:20',
        ]);
        //用定义的规则验证post数据
        $status = $validate->check($post);
        if ($status){
            //如果为真,代表填写的登录用户名和密码要求满足,但是不一定有该用户
            //用post数据的用户名和密码去数据库中查询是否有数据,如果找得到,就代表登录成功,如果找不到,登录失败的
            $user = Db::table('users')->where('username',$post['username'])->where('password',md5($post['password']))->find();
            if ($user){
                //能找到用户数据,登录成功
                //返回之前,在session中存入用户的id和username
                session('uid',$user['id']);
                session('username',$user['username']);
                return $this->success('登录成功!!','/');
            }else{
                //找不到填写的用户名和密码的数据,登录失败
                return $this->error('用户名或密码错误');
            }
        }else{
            return $this->error($validate->getError());
        }
    }

    public function logout(){
        //退出其实就是删除session数据
        session(null);
        //返回并提示退出成功
        return $this->success('退出成功','/');
    }
}
