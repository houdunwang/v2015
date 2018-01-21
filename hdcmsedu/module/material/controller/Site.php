<?php namespace module\material\controller;

use houdunwang\request\Request;
use module\HdController;
use module\material\model\Material;
use houdunwang\config\Config;
use houdunwang\wechat\WeChat;
use houdunwang\dir\Dir;

/**
 * 微信素材管理
 * Class site
 *
 * @package module\material
 * @author  向军
 */
class Site extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth('platform_material');
    }

    /**
     * 上传素材
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function upload_material()
    {
        $file = Request::post('file');
        if ( ! is_file($file)) {
            return message('文件不存在', '', 'error');
        }
        $type = Request::post('type');
        $data = WeChat::instance('material')->addMaterial($type, $file);
        if (isset($data['errcode'])) {
            return message($data['errmsg'], '', 'error');
        } else {
            $model             = new Material();
            $model['type']     = $type;
            $model['file']     = $_POST['file'];
            $model['media_id'] = $data['media_id'];
            $model['url']      = $data['url'];
            $model['status']   = 1;
            $model->save();

            return message('保存成功');
        }
    }

    /**
     * 删除素材
     *
     * @return mixed|string
     */
    public function delMaterial()
    {
        $model = Material::find(Request::post('id'));
        WeChat::instance('material')->delMaterial($model['media_id']);
        $model->destory();

        return message('素材删除成功');
    }

    /**
     * 图片素材
     *
     * @return mixed
     */
    public function image()
    {
        $data = Material::orderBy('id', 'DESC')->where('type', 'image')->paginate(20, 8);

        return view($this->template.'/image.php')->with(['data' => $data]);
    }

    //语音
    public function voice()
    {
        return view($this->template.'/voice.php');
    }

    //视频
    public function video()
    {
        return view($this->template.'/video.php');
    }

    /**
     * 图文消息列表
     *
     * @return mixed
     */
    public function news()
    {
        $data = Material::where('siteid', SITEID)->where('type', 'news')->orderBy('id', 'DESC')->paginate(10);
        foreach ($data as $k => $v) {
            $data[$k]['data'] = json_decode($v['data'], true);
        }

        return $this->view($this->template.'/news.php', compact('data'));
    }

    /**
     * 删除图文
     *
     * @return mixed|string
     */
    public function delNews()
    {
        if (IS_POST) {
            $data = Material::find(Request::post('id'));
            if ( ! $data) {
                return message('图文消息不存在', '', 'error');
            }
            $result = WeChat::instance('material')->delMaterial($data['media_id']);
            if ($result['errcode'] == 0) {
                Material::where('id', $data['id'])->delete();

                return message('图文消息删除成功', '', 'success');
            }

            return message("图文消息删除失败,".$result['errmsg'], '', 'error');
        }

        return view($this->template.'/post_news.php');
    }

    /**
     * 同步图文消息
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function syncNews()
    {
        if (isset($_GET['pos'])) {
            $pos    = Request::get('pos');
            $param  = [
                //素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
                "type"   => 'news',
                //从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
                "offset" => $pos,
                //返回素材的数量，取值在1到20之间
                "count"  => 10,
            ];
            $result = WeChat::instance('material')->lists($param);
            Dir::create(Config::get('upload.path'));
            if (isset($result['errcode'])) {
                return message('同步图文消息失败, '.$result['errmsg'], url('site/news'), 'error');
            } else {
                if (empty($result['item'])) {
                    return message('全部同步完毕', url('site/news'), 'success');
                }
                //创建上传目录
                foreach ($result['item'] as $k => $v) {
                    $field = Material::where('media_id', $v['media_id'])->where('siteid', SITEID)->first();
                    if (empty($field)) {
                        //保存缩略图
                        foreach ($v['content']['news_item'] as $n => $m) {
                            $imgContent = WeChat::instance('material')->getMaterial($m['thumb_media_id']);
                            if (isset($imgContent['errcode']) && $imgContent['errcode']) {
                                return message('同步图文消息失败, '.$imgContent['errmsg'], url('site/news'), 'error');
                            }
                            $pic = Config::get('upload.path')."/{$v['media_id']}_{$m['thumb_media_id']}.jpg";
                            file_put_contents($pic, $imgContent);
                            $v['content']['news_item'][$n]['pic'] = $pic;
                        }
                        $model             = new Material();
                        $model['media_id'] = $v['media_id'];
                        $model['type']     = 'news';
                        $data              = ['articles' => $v['content']['news_item']];
                        $model['data']     = json_encode($data, JSON_UNESCAPED_UNICODE);
                        $model->save();
                    }
                }
            }
            $end = $pos + $result['item_count'];

            return message("准备同步[{$pos} ~ {$end}]图文消息", url('site/syncNews', ['pos' => $end]), 'success', 2);
        }

        return message('准备同步图文消息', url('site/syncNews', ['pos' => 0]), 'success', 2);
    }

    /**
     * 添加或修改图文消息
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function postNews()
    {
        $id    = Request::get('id');
        $model = $id ? Material::find($id) : new Material();
        if (IS_POST) {
            $articles = json_decode(Request::post('data'), true);
            if ($id) {
                //修改图文消息
                foreach ($articles['articles'] as $k => $v) {
                    $article = [
                        'media_id' => $model['media_id'],
                        'index'    => $k,
                        'articles' => $v,
                    ];
                    WeChat::instance('material')->editNews($article);
                }
                $res['media_id'] = $model['media_id'];
            } else {
                //新增时推送到微信
                $res = WeChat::instance('material')->addNews($articles);
                if ( ! isset($res['media_id'])) {
                    //推送到微信失败
                    return message($res['errmsg'], '', 'error');
                }
            }
            $media_id          = $res['media_id'];
            $model['id']       = $id;
            $model['type']     = 'news';
            $model['data']     = Request::post('data');
            $model['media_id'] = $media_id;
            $model['status']   = 1;
            $model->save();

            return message('图文消息保存成功', url('site/news'), 'success');
        }
        if ($id) {
            $field = $model['data'];
            if ( ! $field) {
                return message('图文消息不存在', 'back', 'error');
            }
        } else {
            $author = v('site.info.name');
            $field
                    = <<<str
			{
                "articles": [{
                    "title": '',
                    "thumb_media_id": '',
                    "author": '$author',
                    "digest": '',
                    "show_cover_pic": 1,
                    "content": '',
                    "content_source_url": '',
                    'pic': ''
                }]
            }
str;
        }

        return view($this->template.'/post_news')->with('field', $field);
    }

    /**
     * 根据文件获取微信media_id
     *
     * @return array
     */
    public function getMediaId()
    {
        $file = Request::post('file');
        $res  = Material::where('file', $file)->first();
        if ($res) {
            return ['valid' => 1, 'media_id' => $res['media_id']];
        } else {
            //文件不存在时表示没有上传到微信,上传之哟.
            $data = WeChat::instance('material')->addMaterial('image', $file);
            if (isset($data['errcode'])) {
                return ['valid' => 0, 'message' => $data['errmsg']];
            } else {
                $model             = new Material();
                $model['type']     = 'image';
                $model['file']     = $file;
                $model['media_id'] = $data['media_id'];
                $model['url']      = $data['url'];
                $model['status']   = 1;
                $model->save();

                return ['valid' => 1, 'media_id' => $data['media_id']];
            }
        }
    }

    /**
     * 群发图文消息
     *
     * @return mixed
     */
    public function users()
    {
        $user = Db::table('member')->join('member_auth', 'member.uid', '=', 'member_auth.uid')
                  ->where('member_auth.wechat', '<>', '')
                  ->where('member.siteid', siteid())->get();

        return view($this->template.'/users.php', compact('user'));
    }

    /**
     * 群发图文消息
     */
    public function sendNews()
    {
        $id                          = q('post.id');
        $media_id                    = Material::where('id', $id)->pluck('media_id');
        $data                        = [];
        $data['filter']['is_to_all'] = true;
        $data['filter']['group_id']  = 2;
        $data['mpnews']['media_id']  = $media_id;
        $data['msgtype']             = 'mpnews';
        $res                         = WeChat::instance('message')->sendall($data);
        if (empty($res['errcode'])) {
            return message('图文消息群发成功,真正到用户手机需要些时间');
        }

        return message('图文消息群发失败,可能达到了发送次数的上限', '', 'error');
    }

    /**
     * 预览图文消息
     *
     * @return mixed|string
     */
    public function preview()
    {
        $uid                        = Request::post('uid');
        $id                         = Request::post('id');
        $user                       = Db::table('member_auth')->where('uid', $uid)->first();
        $material                   = Material::find($id);
        $data['touser']             = $user['wechat'];
        $data['mpnews']['media_id'] = $material['media_id'];
        $data['msgtype']            = 'mpnews';
        $res                        = WeChat::instance('message')->preview($data);
        if (empty($res['errcode'])) {
            return message('发送消息成功,请查看微信客户端');
        } else {
            return message('发送失败'.$res['errmsg'], '', 'error');
        }
    }
}