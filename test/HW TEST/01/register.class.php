<!-- 执行注册登录页 -->

<?php
header('content-type:text/html;charset=UTF8');
error_reporting("E_ALL&~E_NOTICE");
// print_r($_POST);
// echo '<hr/>';
// print_r($_FILES);
// echo '<hr/>';
session_start();
//定义错误号
define('UPLOAD_ERRS', [
    'UPLOAD_ERR_INI_SIZE'=>'上传的头像图片大小超出限制',
    'UPLOAD_ERR_FORM_SIZE'=>'上传的头像图片大小超过表单所能处理的范围',
    'UPLOAD_ERR_PARTIAL'=>'头像上传不完整',
    'UPLOAD_ERR_NO_FILE'=>'没有上传头像',
    'SYSTEM_ERROR'=>'系统错误'
]);

//获取错误码
$error=$_FILES['face']['error'];

//定义移动到下列路径
$dest='your dir/'.md5(microtime(true).mt_rand()).'.'.pathinfo($_FILES['face']['name'], PATHINFO_EXTENSION);
if ($error==0) {
    $store = substr($dest, strlen('your dir/'));
}
if ($error==0) {
    move_uploaded_file($_FILES['face']['tmp_name'], $dest);
} else {
    switch ($error) {
    case 1:
    $res= UPLOAD_ERRS['UPLOAD_ERR_INI_SIZE'];
    break;
    case 2:
    $res= UPLOAD_ERRS['UPLOAD_ERR_FORM_SIZE'];
    break;
    case 3:
    $res= UPLOAD_ERRS['UPLOAD_ERR_PARTIAL'];
    break;
    case 4:
    $res= UPLOAD_ERRS['UPLOAD_ERR_NO_FILE'];
    break;
    default:
    $res= UPLOAD_ERRS['SYSTEM_ERROR'];
    break;
  }
    echo $res;
}

echo '<hr/>';

//链接mysql数据库
$mysqli =new mysqli('localhost', 'root', 'your password', 'your database');
$mysqli->query('set names utf8');
// var_dump($mysqli);
$sql = "INSERT your table(name,number,email,money,info,face) VALUES(?,?,?,?,?,?)";
$stmt = $mysqli->prepare($sql);

$name = $_POST['name'];
$number = (int)$_POST['number'];
$email = $_POST['email'];
$money = (int)$_POST['money'];
$info = $_POST['info'];

if (mb_strlen($name, 'UTF-8')>10) {
    echo "<script>alert('输入姓名过长！')</script>";
    die();
}
if (!is_numeric($number) && strlen($number)>8) {
    echo "<script>alert('请输入正确格式的学号！')</script>";
    die();
}
if (!is_numeric($money)) {
    echo "<script>alert('请输入正常金钱数目！')</script>";
    die();
}
if (mb_strlen($info, 'UTF-8')>50) {
    echo "<script>alert('请输入正常金钱数目！')</script>";
    die();
}

$stmt->bind_param('sisiss', $name, $number, $email, $money, $info, $store);
if ($stmt->execute()) {
    echo "<script>alert('登录成功!');location.href='http://localhost/Demo/%E5%A4%A7%E4%BD%9C%E4%B8%9A/01/mysqldemo-%E9%9D%99%E6%80%81%E9%A1%B5%E9%9D%A2/index.php'</script>";
    $_SESSION['name'] = $name;
    $_SESSION['id'] = $number;
    setCookie('session_name()', 'session_id()', time()+86400);
};

$username = $_POST['name'];
$num = $_POST['number'];
$res1 = $mysqli->query('SELECT name,number FROM your table');
$rowset = $res1->fetch_all(MYSQLI_ASSOC);
// print_r($rowset);
foreach ($rowset as $row) {
    if ($username == $row['name'] && $num == $row['number']) {
        $_SESSION['name'] = $username;
        $_SESSION['id'] = $num;
        setCookie('session_name()', 'session_id()', time()+86400);
        echo "<script>alert('登录成功！')</script>";
        echo "<script>location.href='index.php'</script>";
    }
}
for ($x=0;$x<=count($rowset);$x++) {
    if ($username!==$rowset['name']) {
        echo "<script>alert('您还没有账号，请先注册之后再登录！')</script>";
        echo "<script>location.href='register.php?res=1'</script>";
    }
}
$keyword = $_GET['key'];
if ($keyword=="") {
    echo "<script>alert('请填写搜索内容')</script>";
    echo "<script>location.href='index.php'</script>";
}
foreach ($rowset as $row) {
    if ($keyword === $row['name']) {
        $res2 = $mysqli->query("SELECT info,face FROM your table WHERE name='".$keyword."'");
        $search = $res2->fetch_all(MYSQLI_ASSOC);
        echo '<script>location.href="index.php?username='.$keyword.'&info='.$search[0]['info'].'&face='.$search[0]['face'].'"</script>';
    }
}
for ($x=0;$x<=count($rowset);$x++) {
    if ($keyword!==$rowset['name']) {
        echo "<script>alert('用户不存在！')</script>";
        echo "<script>location.href='index.php'</script>";
    }
}
