<?php

namespace app\Index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

class Reg extends Controller
{
    /**
     * 加载注册模板方法
     */
    public function create()
    {
        //加载注册模板
        return view();
    }

    public function post(Request $request){
        //获取post数据
        $post = $request->post();
        //对post数据进行验证,定义一个验证规则
        $validate = Validate::make([
            //键名代表定义需要验证的字段名
            //键值代表验证规则
            'username' => 'require|min:3|max:30',
            'nick' => 'require|min:5',
            'password' => 'require|min:6|max:20|confirm',
        ]);
        //用定义的验证规则来对post数据进行验证
        $status = $validate->check($post);
        //根据验证的返回结果来判断,如果返回真,代表验证是通过的,如果返回假,代表验证是不通过
        if ($status){
            //如果为真,走进if,继续下面的操作
            $result = Db::table('users')->insert([
                'username' => $post['username'],
                'nick' => $post['nick'],
                'password' => md5($post['password']),
            ]);
            //判断,如果返回的受影响条数不是0,代表添加数据成功
            if ($result){
                return $this->success('注册成功,请登录','/');
            }else{
                return $this->error('注册失败');
            }
        }else{
            //如果为假,我们来获取一下验证不通过的错误信息
            return $this->error($validate->getError());
        }
    }




}
