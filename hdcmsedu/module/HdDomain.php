<?php namespace module;

/**
 * 模块独立域名设置
 * Class HdDomain
 * @package module
 */
abstract class HdDomain {
	//模板目录
	protected $template;
	//配置项
	protected $config;

	public function __construct() {
		auth( 'system_domain' );
		$this->config   = \Module::getModuleConfig();
		$this->template = ( v( 'module.is_system' ) ? "module/" : "addons/" ) . v( 'module.name' ) . '/system/template';
		template_path( $this->template );
		template_url( __ROOT__ . '/' . $this->template );
	}

	//保存方法
	abstract function set();

	//保存域名
	protected function save() {
		$res            = Db::table( 'module_domain' )->where( 'siteid', SITEID )->where( 'module', v( 'module.name' ) )->first() ?: [ ];
		$data           = Request::post();
		$data['module'] = v( 'module.name' );
		$data['siteid'] = SITEID;
		if ( $res ) {
			$data['id'] = $res['id'];
		}

		return Db::table( 'module_domain' )->replace( $data );
	}

	//获取域名
	protected function get() {
		return Db::table( 'module_domain' )->where( 'siteid', SITEID )->where( 'module', v( 'module.name' ) )->pluck( 'domain' ) ?: '';
	}
}