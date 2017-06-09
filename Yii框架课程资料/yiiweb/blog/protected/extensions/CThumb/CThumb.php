<?php
class CThumb extends CApplicationComponent {

    // @var mixed 要调整大小的图像文件
    public $image;
    // @var int 缩略图宽度
    public $width = 120;
    // @var int 缩略图高度
    public $height = 120;
    // @var string 保存缩略图的文件夹
    public $directory;
    // @var string 默认缩略图的名称
    public $defaultName = "thumb";
    // @var string 后缀名称
    public $suffix;
    // @var string 前缀名称
    public $prefix;
    // @var int 图像质量
    public $quality = 75;
    // @var int PNG文件转化率
    public $compression = 6;
    // @var int  客户端选择区域左上角X轴坐标
    public $posX = 0;
    // @var int  客户端选择区域左上角Y轴坐标
    public $posY = 0;
    public $cutX = 0;
    public $cutY = 0;
    // @var int 切割宽度
   
    public $mode = 1;
    // @var mixed 临时图像
    private $img;
    // @var mixed 输出图像
    private $thumbImage;
    // @var int 原图宽度
    private $srcWidth;
    // @var int 原图
    private $srcHeight;
    // @var int 原图类型
    private $srcType;
    // @var int 原图扩展名
    private $srcExt;

    public function init() {

        if (!function_exists("imagecreatetruecolor")) {
            throw new Exception("使用这个类,需要启用GD库", 500);
        }
        parent::init();
    }

    public function getImageSize() {
        if (!$this->thumbImage)
            $this->loadImage();
        $imageSize = array('width' => $this->srcWidth, 'height' => $this->srcHeight, 'ext' => $this->srcExt);
        return $imageSize;
    }

    private function loadImage() {
        if (!$this->image) {
            throw new Exception("必须有图片名称", 500);
        }

        list($this->srcWidth, $this->srcHeight, $this->srcType) = getimagesize($this->image);
        switch ($this->srcType) {
            case IMAGETYPE_JPEG:
                $this->img = imagecreatefromjpeg($this->image);
                $this->srcExt = 'jpg';
                break;
            case IMAGETYPE_GIF:
                $this->img = imagecreatefromgif($this->image);
                $this->srcExt = 'gif';
                break;
            case IMAGETYPE_PNG:
                $this->img = imagecreatefrompng($this->image);
                $this->srcExt = 'png';
                break;
            default:
                throw new Exception("不支持的图像类型", 500);
        }
    }

    public function createThumb() {
        $this->loadImage();

        $this->thumbImage = imagecreatetruecolor($this->width, $this->height);

        $bg = imagecolorallocatealpha($this->thumbImage, 255, 255, 255, 127);
        imagefill($this->thumbImage, 0, 0, $bg);
        imagecolortransparent($this->thumbImage, $bg);

        $ratio_w = 1.0 * $this->width / $this->srcWidth;
        $ratio_h = 1.0 * $this->height / $this->srcHeight;
        $ratio = 1.0;
        switch ($this->mode) {
            case 1:        // 强制裁剪，生成图片严格按照需要，不足放大，超过裁剪，图片始终铺满
                if (($ratio_w < 1 && $ratio_h < 1) || ($ratio_w > 1 && $ratio_h > 1)) {
                    $ratio = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
                    $tmp_w = (int) ($this->width / $ratio);
                    $tmp_h = (int) ($this->height / $ratio);
                    $tmp_img = imagecreatetruecolor($tmp_w, $tmp_h);
                    $src_x = (int) (($this->srcWidth - $tmp_w) / 2);
                    $src_y = (int) (($this->srcHeight - $tmp_h) / 2);
                    imagecopy($tmp_img, $this->img, 0, 0, $src_x, $src_y, $tmp_w, $tmp_h);
                    imagecopyresampled($this->thumbImage, $tmp_img, 0, 0, 0, 0, $this->width, $this->height, $tmp_w, $tmp_h);
                    imagedestroy($tmp_img);
                } else {
                    $ratio = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
                    $tmp_w = (int) ($this->srcWidth * $ratio);
                    $tmp_h = (int) ($this->srcHeight * $ratio);
                    $tmp_img = imagecreatetruecolor($tmp_w, $tmp_h);
                    imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $tmp_w, $tmp_h, $this->srcWidth, $this->srcHeight);
                    $src_x = (int) ($tmp_w - $this->width) / 2;
                    $src_y = (int) ($tmp_h - $this->height) / 2;
                    imagecopy($this->thumbImage, $tmp_img, 0, 0, $src_x, $src_y, $this->width, $this->height);
                    imagedestroy($tmp_img);
                }
                break;
            case 2:        // 和1类似，但不足的时候不放大 会产生补白，可以用png消除
                if ($ratio_w < 1 && $ratio_h < 1) {
                    $ratio = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
                    $tmp_w = (int) ($this->width / $ratio);
                    $tmp_h = (int) ($this->height / $ratio);
                    $tmp_img = imagecreatetruecolor($tmp_w, $tmp_h);
                    $src_x = (int) ($this->srcWidth - $tmp_w) / 2;
                    $src_y = (int) ($this->srcHeight - $tmp_h) / 2;
                    imagecopy($tmp_img, $this->img, 0, 0, $src_x, $src_y, $tmp_w, $tmp_h);
                    imagecopyresampled($this->thumbImage, $tmp_img, 0, 0, 0, 0, $this->width, $this->height, $tmp_w, $tmp_h);
                    imagedestroy($tmp_img);
                } elseif ($ratio_w > 1 && $ratio_h > 1) {
                    $dst_x = (int) abs($this->width - $this->srcWidth) / 2;
                    $dst_y = (int) abs($this->height - $this->srcHeight) / 2;
                    imagecopy($this->thumbImage, $this->img, $dst_x, $dst_y, 0, 0, $this->srcWidth, $this->srcHeight);
                } else {
                    $src_x = 0;
                    $dst_x = 0;
                    $src_y = 0;
                    $dst_y = 0;
                    if (($this->width - $this->srcWidth) < 0) {
                        $src_x = (int) ($this->srcWidth - $this->width) / 2;
                        $dst_x = 0;
                    } else {
                        $src_x = 0;
                        $dst_x = (int) ($this->width - $this->srcWidth) / 2;
                    }

                    if (($this->height - $this->srcHeight) < 0) {
                        $src_y = (int) ($this->srcHeight - $this->height) / 2;
                        $dst_y = 0;
                    } else {
                        $src_y = 0;
                        $dst_y = (int) ($this->height - $this->srcHeight) / 2;
                    }
                    imagecopy($this->thumbImage, $this->img, $dst_x, $dst_y, $src_x, $src_y, $this->srcWidth, $this->srcHeight);
                }
                break;
            case 3:        // 只缩放，不裁剪，保留全部图片信息，会产生补白
                if ($ratio_w > 1 && $ratio_h > 1) {
                    $dst_x = (int) (abs($this->width - $this->srcWidth) / 2);
                    $dst_y = (int) (abs($this->height - $this->srcHeight) / 2);
                    imagecopy($this->thumbImage, $this->img, $dst_x, $dst_y, 0, 0, $this->srcWidth, $this->srcHeight);
                } else {
                    $ratio = $ratio_w > $ratio_h ? $ratio_h : $ratio_w;
                    $tmp_w = (int) ($this->srcWidth * $ratio);
                    $tmp_h = (int) ($this->srcHeight * $ratio);
                    $tmp_img = imagecreatetruecolor($tmp_w, $tmp_h);
                    imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $tmp_w, $tmp_h, $this->srcWidth, $this->srcHeight);
                    $dst_x = (int) (abs($tmp_w - $this->width) / 2);
                    $dst_y = (int) (abs($tmp_h - $this->height) / 2);
                    imagecopy($this->thumbImage, $tmp_img, $dst_x, $dst_y, 0, 0, $tmp_w, $tmp_h);
                    imagedestroy($tmp_img);
                }
                break;
            case 4:        // 只缩放，不裁剪，保留全部图片信息，生成图片大小为最终缩放后的图片有效信息的实际大小，不产生补白
                if ($ratio_w > 1 && $ratio_h > 1) {
                    $this->thumbImage = imagecreatetruecolor($this->srcWidth, $this->srcHeight);
                    imagecopy($this->thumbImage, $this->img, 0, 0, 0, 0, $this->srcWidth, $this->srcHeight);
                } else {
                    $ratio = $ratio_w > $ratio_h ? $ratio_h : $ratio_w;
                    $tmp_w = (int) ($this->srcWidth * $ratio);
                    $tmp_h = (int) ($this->srcHeight * $ratio);
                    $this->thumbImage = imagecreatetruecolor($tmp_w, $tmp_h);
                    imagecopyresampled($this->thumbImage, $this->img, 0, 0, 0, 0, $tmp_w, $tmp_h, $this->srcWidth, $this->srcHeight);
                }
                break;
            case 5:        // 根据posX、posY定位裁剪
                $this->thumbImage = imagecreatetruecolor($this->width, $this->height);
                imagecopyresampled($this->thumbImage, $this->img, 0, 0, $this->posX, $this->posY, $this->width, $this->height, $this->cutX, $this->cutY);
                break;
        }
    }

    public function save() {
        if (!$this->directory) {
            throw new Exception("输入保存缩略图目录", 500);
        }
 
          switch ($this->srcType) {
          case IMAGETYPE_JPEG:
          imagejpeg($this->thumbImage, $this->directory . $this->prefix . $this->defaultName . $this->suffix . "." . $this->srcExt, $this->quality);
          break;
          case IMAGETYPE_GIF:
          imagegif($this->thumbImage, $this->directory . $this->prefix . $this->defaultName . $this->suffix . "." . $this->srcExt, $this->quality);
          break;
          case IMAGETYPE_PNG:
          imagepng($this->thumbImage, $this->directory . $this->prefix . $this->defaultName . $this->suffix . "." . $this->srcExt, $this->compression);
          break;
          }
    }

    public function show() {
        switch ($this->srcType) {
            case IMAGETYPE_JPEG :
                header('Content-type: image/jpeg');
                imagejpeg($this->thumbImage);
                break;
            case IMAGETYPE_PNG :
                header('Content-type: image/png');
                imagepng($this->thumbImage);
                break;
            case IMAGETYPE_GIF :
                header('Content-type: image/gif');
                imagegif($this->thumbImage);
                break;
        }
    }

    function __destruct() {
        imagedestroy($this->img);
        imagedestroy($this->thumbImage);
    }

}

?>