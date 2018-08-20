<?php
/*搜索处理*/

//包含文件
require_once './lib/Db.php';//数据库连接类

//通过表单获取搜索关键字
$keyword = $_GET['key'];

//如果关键字为空，则进行相应提示并跳转回首页
if (strlen($keyword)<=0) {
    echo "<script>alert('请先填写搜索内容')</script>";
    echo "<script>location.href='index.php'</script>";
}

//实例化数据库连接类
$Db = new Db();
//如果关键字不为空，则进行数据库校验查找图片地址，用过get表单链接传递从数据库查找出来的信息
$Db->query();
foreach ($Db->data as $row) {
    if ($keyword === $row['info']) {
        $res2 = $Db->mysqli->query("SELECT addr FROM pic_upload_system WHERE info='".$keyword."'");
        $search = $res2->fetch_all(MYSQLI_ASSOC);
        echo '<script>location.href="index.php?search='.$keyword.'&addr='.$search[0]['addr'].'"</script>';
    }
}
//校验数据库内，发现没有匹配图片，进行相应提示，并跳转回首页
for ($x=0;$x<=count($Db->data);$x++) {
    if ($keyword!==$Db->data['name']) {
        echo "<script>alert('图片不存在！')</script>";
        echo "<script>location.href='index.php'</script>";
    }
}
