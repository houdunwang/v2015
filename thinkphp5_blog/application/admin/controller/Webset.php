<?php

namespace app\admin\controller;



class Webset extends Common
{
    //首页
	public function index()
	{
		//获取数据
		$field = db('webset')->select();
		$this->assign('field',$field);
		return $this->fetch();
	}
	/**
	 * 编辑
	 */
	public function edit()
	{
		if(request()->isAjax())
		{
			$res = (new \app\common\model\Webset())->edit(input('post.'));
			if($res['valid'])
			{
				$this->success($res['msg'],'index');exit;
			}else{
				$this->error($res['msg']);exit;
			}

		}
	}
}
