<?php
header('content-type:text/html;charset=UTF-8');
/*图片处理类*/

class Image
{
    protected $_width;
    protected $_height;
    protected $_im;
    protected $_type;
    protected $_mine;
    protected $_real_path;
    protected $font = 'E:/wamp64/www/Demo/HW/UploadDemo/style/fonts/1_0.ttf';

    public function __construct($file)
    {
        $imageInfo=$this->createImageByFile($file);

        $this->_width=$imageInfo['width'];
        $this->_height=$imageInfo['height'];
        $this->_im=$imageInfo['im'];
        $this->_type=$imageInfo['type'];
        $this->_mime=$imageInfo['mime'];
        $this->_real_path=$imageInfo['real_path'];
    }

    /**
     * 根据文件来创建对象
     * @method createImageByFile
     * @param  [file] $file [文件地址]
     * @return array
     * @throws /Exception
     */
    public function createImageByFile($file)
    {
        //检查文件是否不存在
        if (!file_exists($file)) {
            throw new Exception('file is not exist');
        }
        //获取图像信息
        $imageInfo=getimagesize($file);
        $realPath=realpath($file);
        if (!$imageInfo) {
            throw new Exception('file is not an image file');
        }
        switch ($imageInfo[2]) {
          case IMAGETYPE_GIF:
          $im=imagecreatefromgif($file);
          break;
          case IMAGETYPE_JPEG:
          $im=imagecreatefromjpeg($file);
          break;
          case IMAGETYPE_PNG:
          $im=imagecreatefrompng($file);
          break;
          default:
          throw new Exception('image file must be GIF,JPEG or PNG');
        }
        return array(
          'width'=>$imageInfo[0],
          'height'=>$imageInfo[1],
          'type'=>$imageInfo[2],
          'mime'=>$imageInfo['mime'],
          'im'=>$im,
          'real_path'=>$realPath
        );
    }

    /**
     * 创建缩略图
     * @method Resize
     * @param  [int] $width [图宽]
     * @param  [int] $height [图高]
     * @throws /Exception
     * @return Image
     */
    public function Resize($width, $height)
    {
        if (!is_numeric($width) || !is_numeric($height)) {
            throw new Exception('image width or height must be number');
        }
        //根据传参的宽高获取最终图像的宽高(实际传进来的参数不见得能成功缩放图像，可能存在长宽比例失衡)
        $srcW=$this->_width;
        $srcH=$this->_height;

        $desW=$width;//缩略图高度
        $desH=$height;//缩略图宽度

        //PHP版本小于5.5
        if (version_compare(PHP_VERSION, '5.5.0', '<')) {
            $desIm=imagecreatetruecolor($desW, $desH);
            if (imagecopyresampled($desIm, $this->_im, 0, 0, 0, 0, $desW, $desH, $srcW, $srcH)) {
                imagedestroy($this->_im);
                $this->_im= $desIm;
                $this->_width= imagesx($this->_im);
                $this->_height= imagesy($this->_im);
            }
        } else {
            if ($desIm=imagescale($this->_im, $desW, $desH)) {
                $this->_im= $desIm;
                $this->_width= imagesx($this->_im);
                $this->_height= imagesy($this->_im);
            }
        }
        return $this;
    }

    public function stringMark()
    {
        $s_color = imagecolorallocate($this->_im, 255, 255, 255);
        imagettftext($this->_im, 28, 0, $this->_width/2.5, $this->_height/1.1, $s_color, $this->font, 'power By Ryo');
        return $this;
    }

    /**
     * 保存图像文件
     * @method save
     * @param  [file] $file
     * @param  [int] $quality
     * @throws /Exception
     */
    public function Save($file, $quality=60)
    {
        //获取保存目的文件的扩展名
        $ext=strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (!$ext || !in_array($ext, array('gif','jpeg','jpg','png'))) {
            throw new Exception('image file must be GIF,JPEG or PNG');
        }
        if ($ext==='gif') {
            imagegif($this->_im, $file);
            return true;
        } elseif ($ext==='jpeg' || $ext==='jpg') {
            if ($quality>0) {//如果质量参数大于0
                if ($quality<1) {//但小于1，则按1填入
                    $quality=1;
                }
                if ($quality>100) {//且大于100，则按100填入
                    $quality=100;
                }
                imagejpeg($this->_im, $file, $quality);
                return ture;
            } else {//如果没有填入质量参数，则默认按100%填写
                imagejpeg($this->_im, $file);
                return true;
            }
        } else {
            imagepng($this->_im, $file);
            return true;
        }
    }
}
