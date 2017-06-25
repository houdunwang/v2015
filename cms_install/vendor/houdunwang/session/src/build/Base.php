<?php namespace houdunwang\session\build;

use houdunwang\arr\Arr;
use houdunwang\config\Config;
use houdunwang\cookie\Cookie;

/**
 * Trait Base
 *
 * @package houdunwang\session\build
 */
trait Base
{
    //session_id
    protected $session_id;

    //session_name
    protected $session_name;

    //过期时间
    protected $expire;

    //session 数据
    protected $items = [];

    //开始时间
    static protected $startTime;

    public function bootstrap()
    {
        $this->session_name = Config::get('session.name');
        $this->expire       = intval(Config::get('session.expire'));
        $this->session_id   = $this->getSessionId();

        $this->connect();
        $content     = $this->read() ?: [];
        $this->items = is_array($content) ? $content : [];

        if (is_null(self::$startTime)) {
            self::$startTime = microtime(true);
        }

        return $this;
    }

    /**
     * 设置SESSION_ID
     *
     * @return string
     */
    final protected function getSessionId()
    {
        $id = Cookie::get($this->session_name);
        if ( ! $id) {
            $id = 'hdphp'.md5(microtime(true).mt_rand(1, 6));
        }
        Cookie::set($this->session_name, $id, $this->expire, '/', Config::get('session.domain'));

        return $id;
    }

    /**
     * 检测数据是否存在
     *
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->items[$name]);
    }

    /**
     * 批量设置
     *
     * @param $data
     */
    public function batch($data)
    {
        foreach ($data as $k => $v) {
            $this->set($k, $v);
        }
    }

    /**
     * 设置数据
     *
     * @param string $name  名称
     * @param mixed  $value 值
     *
     * @return mixed
     */
    public function set($name, $value)
    {
//        $this->items = Arr::set($this->items,$name,$value);
        $tmp  =& $this->items;
        $exts = explode('.', $name);
        if (is_array($exts) && ! empty($exts)) {
            foreach ($exts as $d) {
                if ( ! isset($tmp[$d])) {
                    $tmp[$d] = [];
                }
                $tmp = &$tmp[$d];
            }

            $tmp = $value;

            return true;
        }
    }

    /**
     * 获取指定的session数据
     *
     * @param string $name
     * @param string $value
     *
     * @return null
     */
    public function get($name = '', $value = null)
    {
        $tmp = $this->items;
        $arr = explode('.', $name);
        foreach ((array)$arr as $d) {
            if (isset($tmp[$d])) {
                $tmp = $tmp[$d];
            } else {
                return $value;
            }
        }

        return $tmp;
    }

    /**
     * 按名子删除
     *
     * @param $name
     *
     * @return bool
     */
    public function del($name)
    {
        if (isset($this->items[$name])) {
            unset($this->items[$name]);
        }

        return true;
    }

    /**
     * 获取所有数据
     *
     * @return mixed
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * 清除所有数据
     *
     * @return bool
     */
    public function flush()
    {
        $this->items = [];

        return true;
    }

    /**
     * 闪存
     *
     * @param        $name
     * @param string $value
     *
     * @return bool|mixed|void
     */
    public function flash($name = null, $value = '[get]')
    {
        if (is_null($name)) {
            return $this->get('_FLASH_') ?: [];
        }

        //删除所有闪存
        if ($name == '[del]') {
            return $this->del('_FLASH_');
        }
        switch ($value) {
            case '[del]':
                if (isset($this->items['_FLASH_'][$name])) {
                    unset($this->items['_FLASH_'][$name]);
                }

                break;
            case '[get]':
                if ($data = $this->get('_FLASH_.'.$name)) {
                    return $data[0];
                }
                break;
            default:
                return $this->set('_FLASH_.'.$name, [$value, self::$startTime]);
        }
    }

    /**
     * 删除无效闪存
     */
    public function clearFlash()
    {
        foreach ($this->flash() as $k => $v) {
            if ($v[1] != self::$startTime) {
                $this->flash($k, '[del]');
            }
        }
    }

    /**
     * 关闭写入会话数据
     * 同时执行垃圾清理
     */
    public function close()
    {
        //储存数据
        $this->write();
        if (mt_rand(1, 5) == 5) {
            $this->gc();
        }
    }

    //析构函数
    public function __destruct()
    {
        $this->clearFlash();
        $this->close();
    }
}