<?php

namespace app\common\model;

use houdunwang\arr\Arr;
use think\Model;

class Category extends Model
{
    protected $pk = 'cate_id';
    protected $table = 'blog_cate';
	/**
	 * 获取分类数据【树状结构】
	 */
	public function getAll()
	{
		//使用方法参考hdphp手册【hdphp.com】-->搜索数组增强-->tree
		return Arr::tree(db('cate')->order('cate_sort desc,cate_id')->select(), 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
	}
	/**
	 * 添加
	 * @param $data
	 *
	 * @return array
	 */
    public function store($data)
	{
		//执行验证
		//执行添加
		$result = $this->validate(true)->save($data);
		if(false === $result){
			// 验证失败 输出错误信息
			return ['valid'=>0,'msg'=>$this->getError()];
			//dump($this->getError());
		}else{
			return ['valid'=>1,'msg'=>'添加成功'];
		}
	}
	/**
	 * 处理所属分类
	 */
	public function getCateData($cate_id)
	{
		//halt(db('cate')->select());
		//1.首先找到$cate_id子集
			$cate_ids = $this->getSon(db('cate')->select(),$cate_id);
		//2.将自己追加进去
			$cate_ids[] = $cate_id;
			//dump($cate_ids);
		//3.找到除了他们之外的数据,病变成树状结构
		$field = db('cate')->whereNotIn('cate_id',$cate_ids)->select();
		return Arr::tree($field,'cate_name','cate_id','cate_pid');
		//halt($field);
	}
	/**
	 * 找子集
	 */
	public function getSon($data,$cate_id)
	{
		static $temp = [];
		foreach($data as $k=>$v)
		{
			if($cate_id==$v['cate_pid'])
			{
				$temp[] = $v['cate_id'];
				$this->getSon($data,$v['cate_id']);
			}
		}
		return $temp;
	}
	/**
	 * 编辑栏目
	 */
	public function edit($data)
	{
		//cate_id=10
		$result = $this->validate(true)->save($data,[$this->pk=>$data['cate_id']]);
		if($result)
		{
			//执行成功
			return ['valid'=>1,'msg'=>'编辑成功'];
		}else{
			return ['valid'=>0,'msg'=>$this->getError()];
		}
	}
	/**
	 * 删除方法
	 */
	public function del($cate_id)
	{
		//获取当前要删除数据的cate_pid
		$cate_pid = $this->where('cate_id',$cate_id)->value('cate_pid');
		//halt($cate_pid);
		//将当前要删除的$cate_id的子集数据的pid修改成$cate_pid
		$this->where('cate_pid',$cate_id)->update(['cate_pid'=>$cate_pid]);
		//执行当前数据的删除
		if(Category::destroy($cate_id))
		{
			return ['valid'=>1,'msg'=>'删除成功'];
		}else{
			return ['valid'=>0,'msg'=>'删除失败'];
		}
	}
}
