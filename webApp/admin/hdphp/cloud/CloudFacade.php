<?php namespace hdphp\cloud;

use hdphp\kernel\ServiceFacade;

/**
 * 云接口
 * Class CloudFacade
 * @package hdphp\cloud
 */
class CloudFacade extends ServiceFacade {
	public static function getFacadeAccessor() {
		return 'Cloud';
	}
}