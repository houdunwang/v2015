<?php
if ( ! function_exists('encrypt')) {
    /**
     * 加密
     *
     * @param $content
     *
     * @return mixed
     */
    function encrypt($content)
    {
        return \houdunwang\crypt\Crypt::encrypt($content);
    }
}

if ( ! function_exists('decrypt')) {
    /**
     * 解密
     *
     * @param $content
     *
     * @return mixed
     */
    function decrypt($content)
    {
        return \houdunwang\crypt\Crypt::decrypt($content);
    }
}