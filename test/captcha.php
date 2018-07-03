<?php
// header('content-type:text/html;charset=UTF-8');
/**
 * 测试中文验证码
 */
class test
{
    public $_width=80;
    public $_height=30;
    public $_im;
    public $_tcolor;
    public $str=['我','们','都','是','中','国','人'];


    public function Create()
    {
        $im=imagecreatetruecolor($this->_width, $this->_height);
        $bgcolor=imagecolorallocate($im, 200, 200, 200);
        imagefill($im, 0, 0, $bgcolor);
        $this->_im=$im;
        // return $this;
    }

    public function getCode()
    {
        $this->Create();
        $this->Bg();

        $key=array_rand($this->str, 4);
        $code=$this->str[$key[0]];
        $code.=$this->str[$key[1]];
        $code.=$this->str[$key[2]];
        $code.=$this->str[$key[3]];

        $tcolor=imagecolorallocate($this->_im, 0, 0, 0);
        imagettftext($this->_im, 13, mt_rand(-8, 8), 4, $this->_height/2, $tcolor, './simhei.ttf', $code);
        $this->_tcolor=$tcolor;
        return $this;
    }

    public function Bg()
    {
        for ($x=0;$x<150;$x++) {
            imagesetpixel($this->_im, mt_rand(0, $this->_width), mt_rand(0, $this->_height), $this->_tcolor);
        }
    }

    public function Show()
    {
        header('content-type:image/png');
        imagepng($this->_im);
        imagdestroy($this->_im);
    }
}
$T=new test();
$T->getCode()->Show();


// $im=imagecreatetruecolor(400,200);
// $bgcolor=imagecolorallocate($im,200,200,200);
// imagefill($im,0,0,$bgcolor);
//
// $str=['我','们','都','是','中','国','人'];
// // print_r($str);
// $key=array_rand($str,4);
// // print_r($key);
// $code=$str[$key[0]];
// $code.=$str[$key[1]];
// $code.=$str[$key[2]];
// $code.=$str[$key[3]];
//
// $tcolor=imagecolorallocate($im,0,0,0);
// imagettftext($im,15,mt_rand(-10,10),200,100,$tcolor,'./simhei.ttf',$code);
//
//
// header('content-type:image/png');
// imagepng($im);
// imagedestroy($im);
