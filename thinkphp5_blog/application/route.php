<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
	'[c]'     => [
		':cate_id'   => ['index/lists/index', ['method' => 'get'], ['id' => '\d+']],
	],
	'[t]'     => [
		':tag_id'   => ['index/lists/index', ['method' => 'get'], ['id' => '\d+']],
	],
	'[w]'     => [
		':arc_id'   => ['index/content/index', ['method' => 'get'], ['id' => '\d+']],
	],
];
