<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\crypt;

class Crypt {

	private $iv;

	private $securekey;

	public function __construct() {
		$this->securekey = hash( 'sha256', C( 'app.key' ), TRUE );
		$this->iv        = mcrypt_create_iv( 32 );
	}

	/**
	 * 加密
	 *
	 * @param $input 加密字符
	 * @param string $secureKey 加密key
	 *
	 * @return string
	 */
	public function encrypt( $input, $secureKey = '' ) {
		$secureKey = $secureKey ? hash( 'sha256', $secureKey, TRUE ) : $this->securekey;

		return base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $secureKey, $input, MCRYPT_MODE_ECB, $this->iv ) );
	}

	/**
	 * 解密
	 *
	 * @param $input 解密字符
	 * @param string $secureKey 加密key
	 *
	 * @return string
	 */
	public function decrypt( $input, $secureKey = '' ) {
		$secureKey = $secureKey ? hash( 'sha256', $secureKey, TRUE ) : $this->securekey;

		return trim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $secureKey, base64_decode( $input ), MCRYPT_MODE_ECB, $this->iv ) );
	}
}