<?php namespace system\model;

use Db;

/**
 * 公众号管理接口
 * Class SiteWeChat
 *
 * @package system\model
 */
class SiteWeChat extends Common
{
    protected $table = 'site_wechat';
    protected $validate
        = [
            ['siteid', 'required', '站点编号不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['wename', 'required', '微信名称不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT],
            ['account', 'required', '公众号帐号不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT],
            ['original', 'required', '原始ID不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT],
            ['appid', 'required', 'appid不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT],
            ['appsecret', 'required', 'appsecret不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT],
            ['token', 'required', 'token不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT],
            [
                'encodingaeskey',
                'required',
                'encodingaeskey不能为空',
                self::EXIST_VALIDATE,
                self::MODEL_INSERT,
            ],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['level', 1, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['qrcode', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['wename', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['account', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['original', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['appid', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['appsecret', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['qrcode', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['icon', 'resource/images/hd.png', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['is_connect', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['token', 'autoToken', 'method', self::EMPTY_AUTO, self::MODEL_INSERT],
            [
                'encodingaeskey',
                'autoEncodingaeskey',
                'method',
                self::EMPTY_AUTO,
                self::MODEL_INSERT,
            ],
        ];

    protected function autoToken()
    {
        return substr(md5(time()), 0, 18);
    }

    protected function autoEncodingaeskey()
    {
        return substr(md5(time()) . md5(time()), 0, 43);
    }

    /**
     * 使用微信openid自动登录
     */
    public function loginByOpenid()
    {
        //认证订阅号或服务号,并且开启自动登录时获取微信帐户openid自动登录
        if ($info = \WeChat::instance('oauth')->snsapiUserinfo()) {
            $user = $this->where('openid', $info['openid'])->first();
            if ( ! $user) {
                //帐号不存在时使用openid添加帐号
                $data['openid']   = $info['openid'];
                $data['nickname'] = $info['nickname'];
                $data['icon']     = $info['headimgurl'];
                if ($uid = ! $this->add($data)) {
                    message($this->getError(), 'back', 'error');
                }
                $user = Db::table('member')->where('uid', $uid)->first();
            }
            Session::set('member', $user);

            return true;
        }

        return false;
    }

    /**
     * 获取公众号类型
     *
     * @param $level 公众号编号
     *
     * @return mixed
     */
    public function chatNameBylevel($level)
    {
        $data = [1 => '普通订阅号', 2 => '普通服务号', 3 => '认证订阅号', 4 => '认证服务号/认证媒体/政府订阅号'];

        return $data[$level];
    }

    /**
     * 删除回复规则与回复关键字
     *
     * @param $rid
     *
     * @return bool
     */
    public static function removeRule($rid)
    {
        if ($rid) {
            $tables = [
                'rule',
                'rule_keyword',
                'reply_cover',
                'reply_basic',
                'reply_image',
                'reply_news',
            ];
            foreach ($tables as $tab) {
                Db::table($tab)->where('rid', $rid)->delete();
            }

            return true;
        }
    }

    /**
     * 保存回复规则
     *
     * @param $data         =[
     *                      rid=>'规则编号(编辑时需要设置)',
     *                      name=>'规则名称',
     *                      module=>'模块名称',
     *                      rank=>'排序',
     *                      status=>'是否开启'
     *                      keywords=>[
     *                      [
     *                      content=>'关键词内容'
     *                      type=>'关键词类型 1: 完全匹配  2:包含  3:正则',
     *                      rank=>'排序',
     *                      status=>'是否开启'
     *                      ]
     *                      ]
     *                      ];
     *
     * @return bool
     */
    public static function rule($data)
    {
        $checkKeyword = RuleKeyword::checkWxKeywordByRidAsArray($data);
        if ($checkKeyword !== true) {
            return $checkKeyword;
        }
        $Rule           = ! empty($data['rid']) ? Rule::find($data['rid']) : new Rule();
        $data['rank']   = isset($data['rank']) ? $data['rank'] : 0;
        $data['module'] = isset($data['module']) ? $data['module'] : v('module.name');
        $Rule->save($data);
        /**
         * 添加回复关键词
         * 先删除旧的回复规则
         */
        RuleKeyword::where('rid', $Rule['rid'])->delete();
        if (isset($data['keywords'])) {
            foreach ($data['keywords'] as $keyword) {
                if ( ! empty($keyword['content'])) {
                    $keyword['rid']    = $Rule['rid'];
                    $keyword['type']   = isset($keyword['type']) ? $keyword['type'] : 1;
                    $keyword['status'] = isset($keyword['status']) ? $keyword['status'] : 1;
                    $keyword['rank']   = min(255, intval($keyword['rank']));
                    $keywordModel      = new RuleKeyword();
                    $keywordModel->save($keyword);
                }
            }
        }

        return $Rule['rid'];
    }

    /**
     * 添加图文回复
     *
     * @param $data
     *
     * @return bool|string
     * @throws \Exception
     */
    public static function cover($data)
    {
        if (empty($data['keyword']) || empty($data['title'])
            || empty($data['description'])
            || empty($data['thumb'])
            || empty($data['url'])
            || empty($data['name'])) {
            return '微信图文消息需要：标题、描述、缩略图、网址，规则标识';
        }
        //检测关键词是否已经被使用
        $result = RuleKeyword::checkKeywordHByName($data['name'], $data['keyword']);
        if ($result['valid'] == 0) {
            return $result['message'];
        }
        /**
         * 添加回复规则
         * 回复规则唯一标识，用于确定唯一个图文回复
         */
        $name = v('module.name') . '#' . $data['name'];
        $rid  = Db::table('rule')->where('siteid', SITEID)->where('name', $name)->pluck('rid');
        //回复关键词
        $rule['rid']      = $rid;
        $rule['name']     = $name;
        $rule['module']   = 'cover';
        $rule['keywords'] = [['content' => $data['keyword']]];
        $rid              = self::rule($rule);
        //封面回复
        $cover                = Db::table('reply_cover')->where('siteid', SITEID)
                                  ->where('rid', $rid)->first();
        $model                = empty($cover['id']) ? new ReplyCover()
            : ReplyCover::find($cover['id']);
        $model['hash']        = '';
        $model['rid']         = $rid;
        $model['title']       = $data['title'];
        $model['description'] = $data['description'];
        $model['thumb']       = $data['thumb'];
        $model['url']         = $data['url'];
        $model['module']      = v('module.name');

        return $model->save() ? true : '图文消息添加失败';
    }

    /**
     * 删除图文消息
     *
     * @param string $url 图文消息链接地址
     *
     * @return bool
     */
    public static function removeCover($url)
    {
        $rid = Db::table('rule')->where('siteid', SITEID)->where('name', $url)->pluck('rid');

        return self::removeRule($rid);
    }

    /**
     * 根据链接获取微信关键词信息
     *
     * @param string $url 图文消息链接
     *
     * @return mixed
     */
    public static function getCoverByUrl($url)
    {
        $hash = v('module.name') . '#' . md5($url);

        return Db::table('rule')->join('rule_keyword', 'rule.rid', '=', 'rule_keyword.rid')
                 ->field('rule.rid,rule_keyword.content as keyword,rule.siteid,rule.module,rule.status')
                 ->where('rule.name', $hash)
                 ->first();
    }

    /**
     * 根据模块名称删除模块相关数据
     *
     * @param $module
     */
    public function removeRuleByModule($module)
    {
        $rids = Db::table('rule')->where('module', $module)->lists('rid');
        foreach ($rids as $rid) {
            $this->removeRule($rid);
        }
    }
}