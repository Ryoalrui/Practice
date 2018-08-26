<?php
/*图片处理*/
ini_set('display_errors', 0);

//包含文件
require_once './lib/Db.php';//数据库处理类
require_once './lib/Pic.php';//图片上传类
require_once './lib/Image.php';//图片处理类


//实例化图片上传类，在检查无误情况下，才能进行添加水印和缩略大小等操作
$Pic = new Pic($_FILES);
if ($Pic->checkError()) {
    //判断用户是否添加了图片描述，否的话弹窗提示后直接跳转首页
    if (strlen($_POST['info'])<=0) {
        echo "<script>location.href='index.php'</script>";
        exit();
    } else {
        //检查无误后，将图片上传至本机保存位置，后续进行用户操作
        $Pic->upload($_POST['info']);
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
                $Image->Resize(intval($width), intval($height))->Save($Pic->address);
            // //否则，缩略以及添加水印
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
        //实例化数据库连接类，将本机的图片保存位置上传到数据库内
        $Db = new Db();
        $Db->info = $_POST['info'];
        $Db->addr = $Pic->address;
        if ($Db->insert()) {
            echo "<script>location.href='index.php'</script>";
        }
    }
}
