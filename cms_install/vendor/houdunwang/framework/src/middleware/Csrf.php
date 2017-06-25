<?php

namespace houdunwang\framework\middleware;

use houdunwang\middleware\build\Middleware;

/**
 * 表单令牌验证
 * Class Csrf
 *
 * @package houdunwang\middleware\middleware
 */
class Csrf implements Middleware
{
    //验证令牌
    protected $token;

    public function run($next)
    {
        $this->validate();
        $next();
    }

    /**
     * 检测令牌
     *
     * @return bool
     * @throws \Exception
     */
    protected function validate()
    {
        $status = $this->getToken() && \Request::post() && \Config::get('csrf.open');
        if ($status) {
            //比较CSRF
            if ($this->getClientToken() == $this->getToken()) {
                return true;
            }
            //存在过滤的验证时忽略验证
            $except = \Config::get('csrf.except');
            foreach ((array)$except as $f) {
                if (preg_match("@$f@i", __URL__)) {
                    return true;
                }
            }
            \Response::sendHttpStatus(403);
            throw new \Exception('CSRF表单令牌验证失败');
        }

        return true;
    }

    /**
     * 获取令牌
     *
     * @return mixed
     */
    protected function getToken()
    {
        return \Session::get('csrf_token');
    }

    /**
     * 设置令牌
     *
     * @param mixed $token
     */
    protected function setToken($token)
    {
        if (\Config::get('csrf.open')) {
            if (empty($this->getToken())) {
                $token = md5(clientIp().microtime(true));
                \Session::set('csrf_token', $token);
                /**
                 * 生成COOKIE令牌
                 * 一些框架如AngularJs等框架会自动根据COOKIE中的token提交令牌
                 */
                \Cookie::set('XSRF-TOKEN', $token);
            }
            $this->token = $token;
        }
    }

    /**
     * 获取端发送来的令牌
     *
     * @return mixed
     */
    protected function getClientToken()
    {
        $headers = \Arr::keyCase(getallheaders(), 1);
        if (isset($headers['X-CSRF-TOKEN'])) {
            return $headers['X-CSRF-TOKEN'];
        }

        return \Request::post('csrf_token');
    }
}