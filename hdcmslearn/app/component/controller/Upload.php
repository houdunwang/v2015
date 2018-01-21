<?php namespace app\component\controller;

use Request;
use Middleware;
use File;
use Config;
use system\model\Attachment;

/**
 * 上传处理
 * Class Upload
 *
 * @package app\component\controller
 */
class Upload extends Common
{
    public function __construct()
    {
        $this->auth();
    }

    /**
     * 上传文件
     *
     * @param \system\model\Attachment $attachment
     *
     * @return array
     * @throws \Exception
     */
    public function uploader(Attachment $attachment)
    {
        //中间件
        Middleware::web('upload_begin');
        $path = Request::post('uploadDir', Config::get('upload.path'));
        if ($uploadMold = Request::post('mold')) {
            Config::set('upload.mold', $uploadMold);
        }
        $file = File::path()->path($path)->upload();
        if ($file) {
            $data = [
                'uid'        => v(Request::post('user_type').'.info.uid'),
                'siteid'     => siteid(),
                'name'       => $file[0]['name'],
                'module'     => Request::get("m", ''),
                'filename'   => $file[0]['filename'],
                'path'       => $file[0]['path'],
                'extension'  => strtolower($file[0]['ext']),
                'createtime' => time(),
                'size'       => $file[0]['size'],
                'status'     => 0,
                'data'       => Request::post('data', ''),
                'content'    => Request::post('content', ''),
                'user_type'  => Request::post('user_type'),
            ];
            $attachment->save($data);

            return ['valid' => 1, 'message' => $file[0]['path']];
        } else {
            return ['valid' => 0, 'message' => File::getError()];
        }
    }

    /**
     * 获取文件列表
     *
     * @return array
     */
    public function filesLists()
    {
        $db = Db::table('attachment')
                ->where('uid', v(Request::post('user_type').'.info.uid'))
                ->whereIn('extension', explode(',', strtolower(Request::post('extensions'))))
                ->where('user_type', Request::post('user_type', 'member'))
                ->orderBy('id', 'DESC');
        if (Request::post('user_type') != 'user') {
            //前台会员根据站点编号读取数据
            $db->where('siteid', SITEID);
        }
        $Res  = $db->paginate(32);
        $data = [];
        if ($Res->toArray()) {
            foreach ($Res as $k => $v) {
                $data[$k]['createtime'] = date('Y/m/d', $v['createtime']);
                $data[$k]['size']       = \Tool::getSize($v['size']);
                $data[$k]['url']        = preg_match('/^http/i', $v['path']) ? $v['path'] : __ROOT__.'/'.$v['path'];
                $data[$k]['path']       = $v['path'];
                $data[$k]['name']       = $v['name'];
            }
        }

        return ['data' => $data, 'page' => $Res->links()->show()];
    }

    /**
     * 获取本地文件列表
     *
     * @return array
     */
    public function filesListsLocal()
    {
        $db = Db::table('attachment')
                ->where('uid', v(Request::post('user_type').'.info.uid'))
                ->whereIn('extension', explode(',', strtolower(Request::post('extensions'))))
                ->where('user_type', Request::post('user_type', 'member'))
                ->where('path', "like", "attachment%")
                ->orderBy('id', 'DESC');
        if (Request::post('user_type') != 'user') {
            //前台会员根据站点编号读取数据
            $db->where('siteid', SITEID);
        }
        $Res  = $db->paginate(32);
        $data = [];
        if ($Res->toArray()) {
            foreach ($Res as $k => $v) {
                $data[$k]['createtime'] = date('Y/m/d', $v['createtime']);
                $data[$k]['size']       = \Tool::getSize($v['size']);
                $data[$k]['url']        = preg_match('/^http/i', $v['path']) ? $v['path'] : __ROOT__.'/'.$v['path'];
                $data[$k]['path']       = $v['path'];
                $data[$k]['name']       = $v['name'];
            }
        }

        return ['data' => $data, 'page' => $Res->links()];
    }

    /**
     * 删除图片
     *
     * @return array
     */
    public function removeImage()
    {
        $db   = Db::table('attachment');
        $file = $db->where('id', $_POST['id'])->where('uid', v('user.info.uid'))->first();
        if (is_file($file['path'])) {
            unlink($file['path']);
        }
        $db->where('id', $_POST['id'])->where('uid', v('user.info.uid'))->delete();

        return $this->success('删除成功');
    }
}