<?php
if ( ! function_exists('collect')) {
    /**
     * 集合
     *
     * @param $data
     *
     * @return mixed
     */
    function collect(array $data)
    {
        return (new \houdunwang\collection\Collection())->make($data);
    }
}