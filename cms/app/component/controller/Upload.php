<?php namespace app\component\controller;

use houdunwang\route\Controller;
use Request;
use File;
use Config;

/**
 * 上传处理
 * Class Upload
 *
 * @package app\component\controller
 */
class Upload extends Controller
{
    /**
     * 上传图片webuploader
     *
     * @return mixed
     */
    public function uploader()
    {
        $path = Request::post('uploadDir', Config::get('upload.path').'/'.date('Y/m/d'));
        $file = File::path($path)->upload();
        if ($file) {
            $data = [
                //用户编号请自行设置
                'uid'        => 0,
                'name'       => $file[0]['name'],
                'filename'   => $file[0]['filename'],
                'path'       => $file[0]['path'],
                'extension'  => strtolower($file[0]['ext']),
                'createtime' => time(),
                'size'       => $file[0]['size'],
                'status'     => 0,
            ];
            $data = array_merge($data, Request::post(), []);
            Db::table('attachment')->insert($data);

            return ['valid' => 1, 'message' => $file[0]['path']];
        } else {
            return ['valid' => 0, 'message' => \File::getError()];
        }
    }

    /**
     * 获取文件列表webuploader
     *
     * @return array
     */
    public function filesLists()
    {
        $Res  = Db::table('attachment')
                  ->whereIn('extension', explode(',', strtolower(Request::post('extensions'))))
                  ->orderBy('id', 'DESC')->paginate(32);
        $data = [];
        if ($Res->toArray()) {
            foreach ($Res as $k => $v) {
                $data[$k]['createtime'] = date('Y/m/d', $v['createtime']);
                $data[$k]['size']       = \Tool::getSize($v['size']);
                $data[$k]['url']        = __ROOT__.'/'.$v['path'];
                $data[$k]['path']       = $v['path'];
                $data[$k]['name']       = $v['name'];
            }
        }

        return ['data' => $data, 'page' => $Res->links()];
    }

    /**
     * 删除图片
     * delWebuploader
     *
     * @return array
     */
    public function removeImage()
    {
        $db   = Db::table('attachment');
        $file = $db->where('id', $_POST['id'])->first();
        if (is_file($file['path'])) {
            unlink($file['path']);
        }
        $db->where('id', $_POST['id'])->where('uid', v('user.info.uid'))->delete();

        return ['valid' => 1, 'message' => '删除成功'];
    }
}