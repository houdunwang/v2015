<?php namespace houdunwang\file\build;

use houdunwang\config\Config;
use houdunwang\oss\Oss;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
class Base
{
    //上传类型
    protected $type = 'jpg,jpeg,gif,png,zip,rar,doc,txt,pem';
    //上传文件大小
    protected $size = 100000000;
    //上传路径
    protected $path = 'attachment';
    //错误信息
    protected $error;

    public function __construct()
    {
        foreach (Config::get('upload') as $k => $v) {
            $this->$k = $v;
        }
    }

    //设置属性
    public function __call($name, $arguments)
    {
        $this->$name = current($arguments);

        return $this;
    }

    /**
     * 上传
     *
     * @param null $fieldName 字段名
     *
     * @return array|bool
     * @throws Exception
     */
    public function upload($fieldName = null)
    {
        if ( ! $this->createDir()) {
            return false;
        }
        $files        = $this->format($fieldName);
        $uploadedFile = [];
        //验证文件
        if ( ! empty($files)) {
            foreach ($files as $v) {
                $info          = pathinfo($v ['name']);
                $v["ext"]      = isset($info ["extension"]) ? $info['extension'] : '';
                $v['filename'] = isset($info['filename']) ? $info['filename'] : '';
                $v['basename'] = $info['basename'];
                //新文件名
                $v['filename'] = $info['filename'];
                if ( ! $this->checkFile($v)) {
                    continue;
                }
                $upFile = $this->save($v);
                if ($upFile) {
                    $uploadedFile[] = $upFile;
                }
            }
        }

        return $uploadedFile;
    }

    /**
     * 储存文件
     *
     * @param string $file 储存的文件
     *
     * @return boolean
     */
    private function save($file)
    {
        if (c('upload.mold') == 'oss') {
            //阿里oss
            $d = Oss::uploadFile($file['name'], $file['tmp_name']);
            if ( ! isset($d['info']) || ! isset($d['info']['url'])) {
                return false;
            }
            $filePath = $d['info']['url'];
        } else {
            $fileName = mt_rand(1, 9999).time().".".$file['ext'];
            $filePath = $this->path.'/'.$fileName;
            if ( ! move_uploaded_file($file ['tmp_name'], $filePath) && is_file($filePath)) {
                $this->error('移动临时文件失败');

                return false;
            }
        }
        $file['path']      = $filePath;
        $file['uptime']    = time();
        $file['fieldname'] = $file['fieldname'];
        $file['name']      = $file['filename']; //旧文件名
        $file['size']      = $file['size'];
        $file['ext']       = $file['ext'];
        $file['dir']       = $this->path;
        $file['image']     = preg_match('/\.(jpg|png|gif|bmp)/i',$filePath);

        return $file;
    }

    //将上传文件整理为标准数组
    private function format($fieldName)
    {
        if ($fieldName == null) {
            $files = $_FILES;
        } else if (isset($_FILES[$fieldName])) {
            $files[$fieldName] = $_FILES[$fieldName];
        }

        if ( ! isset($files)) {
            $this->error = '没有任何文件上传';

            return false;
        }
        $info = [];
        $n    = 0;
        foreach ($files as $name => $v) {
            if (is_array($v ['name'])) {
                $count = count($v ['name']);
                for ($i = 0; $i < $count; $i++) {
                    foreach ($v as $m => $k) {
                        $info [$n] [$m] = $k [$i];
                    }
                    $info [$n] ['fieldname'] = $name; //字段名
                    $n++;
                }
            } else {
                $info [$n]               = $v;
                $info [$n] ['fieldname'] = $name; //字段名
                $n++;
            }
        }

        return $info;
    }

    //创建目录
    private function createDir()
    {
        if ( ! is_dir($this->path) && ! mkdir($this->path, 0755, true)) {
            throw new Exception("上传目录创建失败");
        }

        return true;
    }

    private function checkFile($file)
    {
        if ($file ['error'] != 0) {
            $this->error($file ['error']);

            return false;
        }
        if ( ! is_array($this->type)) {
            $this->type = explode(',', $this->type);
        }
        if ( ! in_array(strtolower($file['ext']), $this->type)) {
            $this->error = '文件类型不允许';

            return false;
        }
        if (strstr(strtolower($file['type']), "image") && ! getimagesize($file['tmp_name'])) {
            $this->error = '上传内容不是一个合法图片';

            return false;
        }
        if ($file ['size'] > $this->size) {
            $this->error = '上传文件大于'.$this->size;

            return false;
        }

        if ( ! is_uploaded_file($file ['tmp_name'])) {
            $this->error = '非法文件';

            return false;
        }

        return true;
    }

    private function error($error)
    {
        switch ($error) {
            case UPLOAD_ERR_INI_SIZE :
                $this->error = '上传文件超过PHP.INI配置文件允许的大小';
                break;
            case UPLOAD_ERR_FORM_SIZE :
                $this->error = '文件超过表单限制大小';
                break;
            case UPLOAD_ERR_PARTIAL :
                $this->error = '文件只上有部分上传';
                break;
            case UPLOAD_ERR_NO_FILE :
                $this->error = '没有上传文件';
                break;
            case UPLOAD_ERR_NO_TMP_DIR :
                $this->error = '没有上传临时文件夹';
                break;
            case UPLOAD_ERR_CANT_WRITE :
                $this->error = '写入临时文件夹出错';
                break;
            default:
                $this->error = '未知错误';
        }
    }

    /**
     * 返回上传时发生的错误原因
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 下载文件
     *
     * @param        $filepath 文件地址
     * @param string $name     下载后的新文件名
     */
    public function download($filepath, $name = '')
    {
        if (is_file($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.($name ?: basename($filepath)));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: '.filesize($filepath));
            readfile($filepath);
        }
    }
}