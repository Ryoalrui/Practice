<?php
//包含文件
require_once './lib/Db.php';//数据库处理类
require_once './lib/Pic.php';//图片上传类
require_once './lib/Image.php';//图片处理类


//实例化图片上传类，检查各类类型是否符合以及上传是否有错误
$Pic = new Pic($_FILES);
if ($Pic->checkError()->upload()!==false) {
    //在确保上传一切正常后，获取放进数据库内的完整保存地址
    $Pic->getAdress();
}


//实例化图片处理类，判断用户是否添加了图片水印以及图片比例缩放
$Image = new Image($Pic->address);
//如果上传的图片类型是gif动态图片，默认直传，不作任何处理，而其他图片类型按照用户选择进行处理
if ($Pic->type!=='image/gif') {
    //如果图片只是上传并且缩略，不添加水印
    if (!$_POST['mark']) {
        switch ($_POST['scale']) {
          case '800*600':
          $width = 800;
          $height = 600;
          break;
          case '600*450':
          $width = 600;
          $height = 450;
          break;
          case '400*300':
          $width = 400;
          $height = 300;
          break;
      }
        $Image->Resize($width, $height)->Save($Pic->address);
    //否则，缩略以及添加水印
    } else {
        switch ($_POST['scale']) {
          case '800*600':
          $width = 800;
          $height = 600;
          break;
          case '600*450':
          $width = 600;
          $height = 450;
          break;
          case '400*300':
          $width = 400;
          $height = 300;
          break;
      }
        $Image->Resize($width, $height)->stringMark()->Save($Pic->address);
    }
}


//实例化数据库连接类，初始赋值插入数据库内的参数
$Db = new Db();
//判断用户是否添加了图片描述，添加的内容将取代图片原来的名字
if ($_POST['info']!='') {
    $Db->name = $_POST['info'];//保存在数据库的图片名
} else {
    $Db->name = $Pic->name;//保存在数据库的图片名
}
$Db->addr = $Pic->address;//保存在数据库内的地址
$Db->insert();//将数据写入数据库内
