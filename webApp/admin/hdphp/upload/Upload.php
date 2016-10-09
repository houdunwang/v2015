<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace hdphp\upload;

class Upload {
    //上传类型
    protected $type;
    //上传文件大小
    protected $size;
    //上传路径
    protected $path;
    //错误信息
    protected $error;

    public function __construct() {
        //上传路径
        $this->path = Config::get( 'upload.path' );
        //上传类型
        $this->type = Config::get( 'upload.type' );
        //允许大小
        $this->size = Config::get( 'upload.size' ) * 1024;
    }

    /**
     * 上传
     *
     * @param null $fieldName 字段名
     *
     * @return array|bool
     * @throws Exception
     */
    public function make( $fieldName = NULL ) {
        if ( ! $this->createDir() ) {
            return FALSE;
        }
        $files = $this->format( $fieldName );

        $uploadedFile = [ ];
        //验证文件
        if ( ! empty( $files ) ) {
            foreach ( $files as $v ) {
                $info          = pathinfo( $v ['name'] );
                $v["ext"]      = isset( $info ["extension"] ) ? $info['extension'] : '';
                $v['filename'] = isset( $info['filename'] ) ? $info['filename'] : '';

                if ( ! $this->checkFile( $v ) ) {
                    continue;
                }
                $upFile = $this->save( $v );
                if ( $upFile ) {
                    $uploadedFile[] = $upFile;
                }
            }
        }

        return $uploadedFile;
    }

    //设置上传类型
    public function type( $type ) {
        $this->type = $type;

        return $this;
    }

    //设置上传大小
    public function size( $size ) {
        $this->size = $size * 1024;

        return $this;
    }

    //设置上传目录
    public function path( $path ) {
        $this->path = $path;

        return $this;
    }

    /**
     * 储存文件
     *
     * @param string $file 储存的文件
     *
     * @return boolean
     */
    private function save( $file ) {
        $fileName = mt_rand( 1, 9999 ) . time() . "." . $file['ext'];
        $filePath = $this->path . '/' . $fileName;
        if ( ! move_uploaded_file( $file ['tmp_name'], $filePath ) && is_file( $filePath ) ) {
            $this->error( '移动临时文件失败' );

            return FALSE;
        }
        $_info            = pathinfo( $filePath );
        $arr              = [ ];
        $arr['path']      = $filePath;
        $arr['url']       = __ROOT__ . '/' . $filePath;
        $arr['uptime']    = time();
        $arr['fieldname'] = $file['fieldname'];
        $arr['basename']  = $_info['basename'];
        $arr['filename']  = $_info['filename']; //新文件名
        $arr['name']      = $file['filename']; //旧文件名
        $arr['size']      = $file['size'];
        $arr['ext']       = $file['ext'];
        $arr['dir']       = $this->path;
        $arr['image']     = getimagesize( $filePath ) ? 1 : 0;

        return $arr;
    }

    //将上传文件整理为标准数组
    private function format( $fieldName ) {
        if ( $fieldName == NULL ) {
            $files = $_FILES;
        } else if ( isset( $_FILES[ $fieldName ] ) ) {
            $files[ $fieldName ] = $_FILES[ $fieldName ];
        }

        if ( ! isset( $files ) ) {
            $this->error = '没有任何文件上传';

            return FALSE;
        }
        $info = [ ];
        $n    = 0;
        foreach ( $files as $name => $v ) {
            if ( is_array( $v ['name'] ) ) {
                $count = count( $v ['name'] );
                for ( $i = 0;$i < $count;$i ++ ) {
                    foreach ( $v as $m => $k ) {
                        $info [ $n ] [ $m ] = $k [ $i ];
                    }
                    $info [ $n ] ['fieldname'] = $name; //字段名
                    $n ++;
                }
            } else {
                $info [ $n ]               = $v;
                $info [ $n ] ['fieldname'] = $name; //字段名
                $n ++;
            }
        }

        return $info;
    }

    //创建目录
    private function createDir() {
        if ( ! is_dir( $this->path ) && ! mkdir( $this->path, 0755, TRUE ) ) {
            throw new Exception( "上传目录创建失败" );
        }

        return TRUE;
    }

    private function checkFile( $file ) {
        if ( $file ['error'] != 0 ) {
            $this->error( $file ['error'] );

            return FALSE;
        }
        if ( ! is_array( $this->type ) ) {
            $this->type = explode( ',', $this->type );
        }
        if ( ! in_array( strtolower( $file['ext'] ), $this->type ) ) {
            $this->error = '文件类型不允许';

            return FALSE;
        }
        if ( strstr( strtolower( $file['type'] ), "image" ) && ! getimagesize( $file['tmp_name'] ) ) {
            $this->error = '上传内容不是一个合法图片';

            return FALSE;
        }
        if ( $file ['size'] > $this->size ) {
            $this->error = '上传文件大于' . get_size( $this->size );

            return FALSE;
        }

        if ( ! is_uploaded_file( $file ['tmp_name'] ) ) {
            $this->error = '非法文件';

            return FALSE;
        }

        return TRUE;
    }

    private function error( $error ) {
        switch ( $error ) {
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
    public function getError() {
        return $this->error;
    }
}