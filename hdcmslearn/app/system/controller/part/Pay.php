<?php namespace app\system\controller\part;

/**
 * 支付管理
 * Class Pay
 *
 * @package app\system\controller\part
 */
class Pay
{
    public static function make($data)
    {
        if ($data['pay']) {
            return self::php($data);
        }
    }

    protected static function php($data)
    {
        $tpl
              = <<<php
<?php namespace addons\\{$data['name']}\\system;
use module\HdPay;
/**
 * 微信支付通知页面
 * Class Pay
 * @package module\ucenter\system
 */
class Pay extends HdPay {
	/**
     * 同步通知
     *
     * @param bool   \$status true 支付状态 false 支付失败
     * @param string \$tid    定单编号
     *
     * @return mixed|string
     */
	public function sync(\$status, \$tid) {
		if ( \$status ) {
			//此处书写模块业务处理
			echo '支付成功';
		} else {
			echo '支付失败';
		}
	}

	/**
     * 异步通知
     *
     * @param bool   \$status true 支付状态 false 支付失败
     * @param string \$tid    定单编号
     *
     * @return mixed|string
     */
	public function async(\$status, \$tid) {
		if ( \$status ) {
			//此处书写模块业务处理
		}
	}
}
php;
        $file = "addons/{$data['name']}/system/Pay.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }
}