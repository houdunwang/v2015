<?php namespace system\model;

/**
 * Class ModuleSetting
 * @package system\model
 * @author 向军 <2300071698@qq.com>
 * @site www.houdunwang.com
 */
class ModuleSetting extends Common {
	protected $table = 'module_setting';
	protected $denyInsertFields = [ 'id' ];
	protected $validate = [
		[ 'config', 'required', '配置数据不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH ]
	];
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH ],
		[ 'status', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT ],
		[ 'config', 'json_encode', 'function', self::MUST_AUTO, self::MODEL_BOTH ],
		[ 'module', 'autoGetModule', 'method', self::MUST_AUTO, self::MODEL_BOTH ],
	];

	protected function autoGetModule() {
		return v( 'module.name' );
	}
}