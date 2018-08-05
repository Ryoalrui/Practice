<?php
header('content-type:text/html;charset=UTF-8');

class File
{
    public $pic;//上传头像参数属性
    public $error;//上传错误码
    protected $dest = 'E:/wamp64/www/Demo/HW/MysqlDemo/upload/';//本机保存位置
    public $address;//放进数据库内的完整保存地址

    public function __construct($param)
    {
        //获取头像参数属性
        $this->pic = $param;

        //定义错误信息
        define('UPLOAD_ERRS', [
            'UPLOAD_ERR_INI_SIZE'=>'上传的图片大小超出限制',
            'UPLOAD_ERR_FORM_SIZE'=>'上传的图片大小超过表单所能处理的范围',
            'UPLOAD_ERR_PARTIAL'=>'图片上传不完整',
            'UPLOAD_ERR_NO_FILE'=>'没有上传头像',
            'SYSTEM_ERROR'=>'系统错误'
        ]);

        //获取错误码
        $this->error=$param['face']['error'];
    }

    /**
     * [检查头像上传情况]
     * @method checkError
     * @return mixed [string|object]
     */
    public function checkError()
    {
        if ($this->error!=0) {
            switch ($this->error) {
              case 1:
              echo "<script>alert('".UPLOAD_ERRS['UPLOAD_ERR_INI_SIZE']."')</script>";
              echo "<script>location.href='register.php?jump=register'</script>";
              break;
              case 2:
              echo "<script>alert('".UPLOAD_ERRS['UPLOAD_ERR_FORM_SIZE']."')</script>";
              echo "<script>location.href='register.php?jump=register'</script>";
              break;
              case 3:
              echo "<script>alert('".UPLOAD_ERRS['UPLOAD_ERR_PARTIAL']."')</script>";
              echo "<script>location.href='register.php?jump=register'</script>";
              break;
              case 4:
              echo "<script>alert('".UPLOAD_ERRS['UPLOAD_ERR_NO_FILE']."')</script>";
              echo "<script>location.href='register.php?jump=register'</script>";
              break;
              default:
              echo "<script>alert('".UPLOAD_ERRS['SYSTEM_ERROR']."')</script>";
              echo "<script>location.href='register.php?jump=register'</script>";
              break;
            }
        } else {
            return $this;
        }
    }

    /**
     * [上传头像，保存在本机指定位置]
     * @method upload
     * @return [string]
     */
    public function upload()
    {
        if (move_uploaded_file($this->pic['face']['tmp_name'], $this->dest.$this->pic['face']['name'])) {
            return true;
        } else {
            return false;
        }
        // echo move_uploaded_file($this->pic['face']['tmp_name'], $this->dest.$this->pic['face']['name']) ? '头像上传成功<br/>':'头像上传失败<br/>';
    }
    /**
     * [获取数据库头像存储地址]
     * @method getAdress
     */
    public function getAdress()
    {
        $this->address = $this->dest.$this->pic['face']['name'];
    }
}
