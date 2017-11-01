<?php

namespace app\Admin\controller;

use app\common\model\Group as GroupModel;
/**
 * 用户组管理
 * Class Group
 *
 * @package app\Admin\controller
 */
class Group extends Common
{

	/**
	 * 用户组管理首页
	 * @return \think\response\View
	 */
	public function index(){
    	$field = GroupModel::order('id desc')->paginate(20);
    	return view('',compact ('field'));
	}

	/**
	 * 用户组添加
	 * @param GroupModel $group
	 *
	 * @return \think\response\View|void
	 */
	public function store(GroupModel $group){
    	if(request()->isPost ()){
			$res = $group->store(input('post.'));
			if($res['valid']){
				return $this->success ($res['msg'],'index');
			}else{
				return $this->error ($res['msg']);
			}
		}
    	//获取规则
		$rules = $this->getRules();
    	return view('',compact ('rules'));
	}

	/**
	 * 获取所有规则
	 * @return array
	 */
	public function getRules(){
		$field = db('auth_rule')->select();
		$rules = [];
		foreach($field as $k=>$v){
			$rules[$v['nav']][] = $v;
		}
		return $rules;
	}

	/**
	 * 用户组编辑
	 * @param GroupModel $group
	 *
	 * @return \think\response\View|void
	 */
	public function edit(GroupModel $group){
		if(request()->isPost ()){
			$res = $group->edit(input('post.'));
			if($res['valid']){
				return $this->success ($res['msg'],'index');
			}else{
				return $this->error ($res['msg']);
			}
		}
		//接受编辑数据编号
		$id = input ('param.id');
		//1.获取规则
		$rules = $this->getRules();
		//2.获取旧数据
		$field  = db('auth_group')->where('id',$id)->find();
		$field['rules'] = explode (',',$field['rules']);
		return view('',compact ('rules','field'));
	}

	/**
	 * 用户组删除
	 */
	public function del(){
		$id = input ('param.id');
		//执行删除
		$res = GroupModel::destroy ($id);
		if($res){
			$this->success ('操作成功','index');
		}else{
			$this->error('操作失败');
		}
	}
}
