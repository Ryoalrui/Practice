<?php
header('content-type:text/html;charset=UTF-8');
/*图片上传类*/

class Pic
{
    public $pic;//上传图片参数属性
    public $error;//上传错误码
    public $name;//上传的图片名
    public $address;//放进数据库内的完整保存地址
    public $type;//上传图片的类型
    protected $allowExt = ['gif','jpeg','jpg','png'];//允许上传的图片格式
    protected $dest = 'E:/wamp64/www/Demo/HW/UploadDemo/upload/';//本机保存位置


    public function __construct($param)
    {
        //获取上传图片的参数属性
        $this->pic = $param;

        //定义错误信息
        define('UPLOAD_ERRS', [
            'UPLOAD_ERR_INI_SIZE'=>'上传的图片大小超出限制',
            'UPLOAD_ERR_FORM_SIZE'=>'上传的图片大小超出限制',
            'UPLOAD_ERR_PARTIAL'=>'图片上传不完整',
            'SYSTEM_ERROR'=>'没有图片上传'
        ]);

        //获取错误码
        $this->error = $param['upload']['error'];
        //获取上传图片名
        $this->name = $param['upload']['name'];
        //获取上传的类型
        $this->type = strtolower($param['upload']['type']);
    }

    /**
     * [检查图片上传情况]
     * @method checkError
     * @return mixed [string|object]
     */
    public function checkError()
    {
        if ($this->error!=0) {
            switch ($this->error) {
              case 1:
              echo "<script>alert('".UPLOAD_ERRS['UPLOAD_ERR_INI_SIZE']."')</script>";
              echo "<script>location.href='index.php'</script>";
              break;
              case 2:
              echo "<script>alert('".UPLOAD_ERRS['UPLOAD_ERR_FORM_SIZE']."')</script>";
              echo "<script>location.href='index.php'</script>";
              break;
              case 3:
              echo "<script>alert('".UPLOAD_ERRS['UPLOAD_ERR_PARTIAL']."')</script>";
              echo "<script>location.href='index.php'</script>";
              break;
              default:
              echo "<script>alert('".UPLOAD_ERRS['SYSTEM_ERROR']."')</script>";
              echo "<script>location.href='index.php'</script>";
              break;
            }
        } else {
            return $this->checkType($this->pic['upload']['name'], $this->pic['upload']['size']);
        }
    }
    public function checkType($file, $size)
    {
        if (!in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $this->allowExt)) {
            echo "<script>alert('格式不能被识别，请上传gif、jpeg、png类型的图片')</script>";
            echo "<script>location.href='index.php'</script>";
            exit();
        }
        if ($size<=1024) {
            echo "<script>alert('格式不能被识别，请上传真实图片')</script>";
            echo "<script>location.href='index.php'</script>";
            exit();
        }
        return $this;
    }
    /**
     * [上传头像，保存在本机指定位置]
     * @method upload
     * @return [string]
     */
    public function upload()
    {
        if (move_uploaded_file($this->pic['upload']['tmp_name'], $this->dest.$this->pic['upload']['name'])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * [获取数据库头像存储地址]
     * @method getAdress
     */
    public function getAdress()
    {
        $this->address = $this->dest.$this->pic['upload']['name'];
    }
}
