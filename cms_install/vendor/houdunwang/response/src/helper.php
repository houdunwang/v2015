<?php
if ( ! function_exists('ajax')) {
    /**
     * Ajax输出
     *
     * @param  mixed $data 数据
     * @param string $type 数据类型 text html xml json
     */
    function ajax($data, $type = "JSON")
    {
        return \houdunwang\response\Response::ajax($data, $type);
    }
}