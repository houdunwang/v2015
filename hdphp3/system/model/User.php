<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system\model;

use hdphp\Model\Model;

class User extends Model {
	//数据表
	protected $table = "user";

	//允许填充字段
	protected $allowFill = ['*'];

	//禁止填充字段
	protected $denyFill = [ ];

	//自动验证
	protected $validate
		= [
			//['字段名','验证方法','提示信息',验证条件,验证时间]
//						[ 'username', 'required', '用户名不能为空', self::MUST_VALIDATE, self::MODEL_INSERT ],
			//			[ 'username', 'unique', '用户名已经存在', self::MUST_VALIDATE, self::MODEL_INSERT ],
			//			[ 'password', 'required', '密码不能为空', self::MUST_VALIDATE, self::MODEL_INSERT ],
			//			[ 'password', 'confirm:password2', '两次密码不一致', self::MUST_VALIDATE, self::MODEL_INSERT ],
			//			[ 'email', 'email', '邮箱格式错误', self::NOT_EMPTY_VALIDATE, self::MODEL_INSERT ],
		];
	//以下是自定义的验证规则
	//$field 字段名
	//$value 字段值
	//$params 参数比如 maxlen:10 10就是参数
	//$data 所有表单数据
	public function checkUser( $field, $value, $params, $data ) {
		//		return Db::table( 'user' )->where( 'username', $value )->get() ? false : true;
	}

	//自动完成
	protected $auto
		= [
			//['字段名','处理方法','方法类型',验证条件,验证时机]
			//			[ 'groupid', 'getGroupId', 'method', self::EMPTY_AUTO, self::MODEL_INSERT ],
			//			[ 'age', 'intval', 'function', self::MUST_AUTO, self::MODEL_BOTH ],
			//			[ 'password', 'md5', 'function', self::EXIST_AUTO, self::MODEL_BOTH ],
			//			[ 'email', 'md5', 'string', self::MUST_AUTO, self::MODEL_BOTH ],
		];

	//获取默认用户组
	protected function getGroupId( $field, $val, $data = [ ] ) {
		return Db::table( 'group' )->where( 'is_default', 1 )->pluck( 'id' );
	}

	//自动过滤
	protected $filter
		= [
			//[表单字段名,过滤条件,处理时间]
			//			[ 'password', self::EMPTY_FILTER, self::MODEL_BOTH ]
		];

	//时间操作,需要表中存在created_at,updated_at字段
	protected $timestamps = false;
}