<?php

namespace app\common\model;

use think\Model;

class Groupaccess extends Model
{
    protected $table = 'blog_auth_group_access';

    public function setAuth($data){
    	//验证
    	if(!isset($data['group_id'])){
    		return ['valid'=>0,'msg'=>'请选择用户组'];
		}
		//判断数据表中是否已经存在当前设置权限用户数据
		if($this->where('uid',$data['admin_id'])->find()){
			//将原先数据先删除
			$this->where('uid',$data['admin_id'])->delete ();
		}
		//执行数据添加
    	foreach($data['group_id'] as $k=>$v){
    		$model = new Groupaccess();
    		$model->uid = $data['admin_id'];
    		$model->group_id = $v;
    		$model->save();
		}
		return ['valid'=>1,'msg'=>'操作成功'];
	}
}
