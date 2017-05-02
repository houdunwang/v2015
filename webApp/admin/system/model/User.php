<?php namespace system\model;

use hdphp\Model\Model;

class User extends Model {

	//数据表
	protected $table = "user";

	//完整表名
	protected $full = FALSE;

	//自动验证
	protected $validate
		= [
			//['字段名','验证方法','提示信息',验证条件,验证时间]
		];

	//自动完成
	protected $auto
		= [
			//['字段名','处理方法','方法类型',验证条件,验证时机]
		];

	//自动过滤
	protected $filter
		= [
			//[表单字段名,过滤条件,处理时间]
		];

	//登录
	public function login() {
		$user = $this->where( 'username', $_POST['username'] )->first();
		if ( ! $user ) {
			$this->error = '帐号不存在';

			return FALSE;
		}
		if ( $user['password'] != md5( $_POST['password'] ) ) {
			$this->error = '密码错误';

			return FALSE;
		}
		Session::set( 'user', $user );

		return TRUE;
	}


}