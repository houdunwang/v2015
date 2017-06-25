<?php
if ( ! function_exists('import')) {
    /**
     * 导入类库
     *
     * @param $class
     *
     * @return bool
     */
    function import($class)
    {
        $file = str_replace(['.', '#'], ['/', '.'], $class);
        if (is_file($file)) {
            require_once $file;
        } else {
            return false;
        }
    }
}