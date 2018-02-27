<?php
/*
|--------------------------------------------------------------------------
| HDCMS系统扩展函数库
|--------------------------------------------------------------------------
*/
/**
 * 站点编号
 *
 * @return string
 */
function siteid()
{
    return defined('SITEID') ? SITEID : \houdunwang\request\Request::get('siteid', 0);
}

/**
 * 会员编号
 *
 * @return array|mixed|null|string
 */
function memberuid()
{
    return v('member.info.uid');
}

/**
 * 头像
 *
 * @param        $file
 * @param string $pic 图片不存在
 *
 * @return string
 */
function icon($file, $pic = 'resource/images/user.jpg')
{
    if (preg_match('@^http@i', $file)) {
        return $file;
    } elseif (empty($file) || ! is_file($file)) {
        return __ROOT__ . '/' . $pic;
    } else {
        return __ROOT__ . '/' . $file;
    }
}

/**
 * 站点缓存处理
 * 和站点有关的数据都要使用这个函数处理
 * 就是所有与站点相关的缓存数据必须使用这个函数
 *
 * @param string $name   缓存名称
 * @param string $value  缓存数据
 * @param int    $expire 过期时间
 * @param array  $field  附加字段
 * @param int    $siteid 站点编号
 *
 * @return mixed
 */
function cache($name, $value = '[get]', $expire = 0, $field = [], $siteid = 0)
{
    $siteid          = $siteid ?: siteid();
    $name            = $name . ':' . $siteid;
    $field['siteid'] = $siteid;
    $field['module'] = $field['module'] ?: \Request::get('module', '');
    $field['type']   = $field['type'] ?: '';

    return d($name, $value, $expire, $field);
}


/**
 * 记录日志
 *
 * @param string $message 日志内容
 *
 * @return bool
 * @throws \Exception
 */
function record($message)
{
    $data['uid']           = v('user.info.uid');
    $data['content']       = $message;
    $data['url']           = __URL__;
    $data['system_module'] = defined('MODULE') ? (MODULE == 'system' ? 1 : 2) : 0;

    return (new \system\model\Log())->save($data);
}

/**
 * 会员中心通知
 *
 * @param $data
 *
 * @return bool
 * @throws \Exception
 */
function notification($data)
{
    if ($uid = v('member.info.uid')) {
        $model       = new \system\model\Notification();
        $data['uid'] = $uid;

        return $model->save($data);
    }

    return false;
}

/**
 * 验证后台管理员帐号在当前站点的权限
 * 超级管理员不受限制
 * 创建模块时添加的控制器等动作不需要指定权限标识，系统会自动验证。
 * 在创建模块时自定义的权限需要指定权限标识
 *
 * @param string $permission 权限标识
 */
function auth($permission = '')
{
    if ( ! \system\model\User::auth($permission)) {
        die(message('没有访问权限', \system\model\User::getLoginUrl()));
    }
}

/**
 * 验证会员是否登录
 *
 * @param bool $return
 * true返回验证状态 false 时验证失败时直接跳转到登录页面
 *
 * @return mixed
 */
function memberIsLogin($return = false)
{
    $status = boolval(v('member.info.uid'));
    if ( ! $status && $return === false) {
        die(go(web_url() . "?m=ucenter&action=controller/entry/login&siteid=".SITEID."&from=" . urlencode(__URL__)));
    }

    return $status;
}

/**
 * 生成模块动作链接
 *
 * @param string $action 动作标识
 * @param array  $args   GET参数
 * @param string $module 模块标识 为空时使用当前模块
 * @param bool   $merge
 *
 * @return mixed
 */
function url($action, $args = [], $module = '', $merge = false)
{
    $info   = preg_split('#\.|/#', $action);
    $module = $module ? $module : v('module.name');
    if (count($info) == 2) {
        array_unshift($info, 'controller');
    }
    $args['siteid'] = siteid();
    if ($mark = \houdunwang\request\Request::get('mark')) {
        $args['mark'] = $mark;
    }
    //菜单编号
    if ($mi = \houdunwang\request\Request::get('mi')) {
        $args['mi'] = $mi;
    }
    //模块菜单的 默认/系统/组合的类型
    if ($mt = \houdunwang\request\Request::get('mt')) {
        $args['mt'] = $mt;
    }

    return u(web_url() . "?m=" . $module . "&action=" . implode('/', $info), $args, $merge);
}

/**
 * 站点系统链接
 *
 * @param       $action
 * @param array $args
 *
 * @return string
 */
function site_url($action, $args = [])
{
    $args['mark']   = \houdunwang\request\Request::get('mark');
    $args['siteid'] = siteid();
    if ($mi = \houdunwang\request\Request::get('mi')) {
        $args['mi'] = $mi;
    }
    //模块菜单的 默认/系统/组合的类型
    if ($mt = \houdunwang\request\Request::get('mt')) {
        $args['mt'] = $mt;
    }
    if ($model = v('module.name')) {
        $args['m'] = $model;
    }

    return u($action, $args);
}

/**
 * 调用模块服务
 * service('article.field.make')
 *
 * @return mixed
 */
function service()
{
    $args   = func_get_args();
    $info   = explode('.', array_shift($args));
    $module = Db::table('modules')->where('name', $info[0])->first();
    $class  = ($module['is_system'] ? 'module' : 'addons') . '\\' . $info[0] . '\\service\\'
              . ucfirst($info[1]);

    return call_user_func_array([new $class, $info[2]], $args);
}

/**
 * 执行模块控制器动作
 * controller_action('article.entry.aa',2,5),第二个参数开始为方法参数
 *
 * @return mixed
 */
function controller_action()
{
    $args       = func_get_args();
    $info       = explode('.', array_shift($args));
    $moduleName = array_shift($info);
    $method     = array_pop($info);
    array_push($info, ucfirst(array_pop($info)));
    $module = Db::table('modules')->where('name', $moduleName)->first();
    if (count($info) > 2) {
        $class = ($module['is_system'] ? 'module' : 'addons') . '\\' . $moduleName
                 . '\\' . implode('\\', $info);
    } else {
        $class = ($module['is_system'] ? 'module' : 'addons') . '\\' . $moduleName
                 . '\\controller\\' . implode('\\', $info);
    }

    return call_user_func_array([new $class, $method], $args);
}

/**
 * 上传文件到阿里云OSS
 *
 * @param string $file 本地文件
 *
 * @return string
 */
function oss($file)
{
    $info = pathinfo($file);
    $res  = \houdunwang\oss\Oss::uploadFile($info['basename'], $file);
    if (isset($res['oss-request-url'])) {
        return $res['oss-request-url'];
    }
}