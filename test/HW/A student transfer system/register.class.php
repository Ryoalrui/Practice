<?php
header('content-type:text/html;charset=UTF-8');
error_reporting('E_ALL&~E_NOTICE');//过滤notice通知
session_start();//开启会话
//使用第三方方法库
require_once 'lib/Db.php';
require_once 'lib/File.php';


/*处理头像保存*/
//实例化头像图片处理类,进行初始参数赋值
$File = new File($_FILES);
//上传头像到本机指定地址
$File->checkError()->upload();
//获取数据库头像存储地址
$File->getAdress();


/*将注册信息写入数据库*/
//实例化数据库类，并进行初始化连接
$Db = new Db();
// 对表单参数进行校验、赋值，并写入数据库
if ($_POST['rname']!='') {
    //字数不超过5位,超过则跳转到注册界面
    if (mb_strlen($_POST['rname'], 'UTF-8')<=5) {
        $Db->rname = $_POST['rname'];
        //检测学号是否为标量,不是则跳转到注册界面
        if (is_numeric($_POST['rnumber'])) {
            $Db->rnumber = $_POST['rnumber'];
            //正则校验邮箱格式,格式符合则跳转到注册界面
            if (preg_match('/^[\da-z]+([\._\-]*[\da-z]+)*@[\da-z]+([\.\-][\da-z]+)*\.[a-z]+$/', $_POST['email'])) {
                $Db->email = $_POST['email'];
                //检测金钱是否为标量,不是则跳转到注册界面
                if (is_numeric($_POST['money'])) {
                    $Db->money = $_POST['money'];
                    //检测个人简介字数是否超过50字,超过则跳转到注册界面
                    if (mb_strlen($_POST['info'], 'UTF-8')<=50) {
                        $Db->face = $File->address;
                        $Db->info = $_POST['info'];
                    } else {
                        echo "<script>alert('填写字数超出限制')</script>";
                        echo "<script>location.href='register.php?jump=register'</script>";
                    }
                } else {
                    echo "<script>alert('请填写正确的注册金额')</script>";
                    echo "<script>location.href='register.php?jump=register'</script>";
                }
            } else {
                echo "<script>alert('注册邮箱格式有误')</script>";
                echo "<script>location.href='register.php?jump=register'</script>";
            }
        } else {
            echo "<script>alert('注册学号格式有误')</script>";
            echo "<script>location.href='register.php?jump=register'</script>";
        }
    } else {
        echo "<script>alert('注册姓名超出限制')</script>";
        echo "<script>location.href='register.php?jump=register'</script>";
    }
}

//往数据库插入注册信息，成功时开启会话，实现自动登录
if ($Db->insert()) {
    $_SESSION['name'] = $Db->rname;
    $_SESSION['id'] = $Db->rnumber;
    setcookie(session_name(), session_id(), time()+86400);
};


/*登录校验*/
//对登录框界面的表单参数进行校验、取值
if ($_POST['lname']!='') {
    //检测登录姓名是否超过5个字符,超过则跳转到注册界面
    if (mb_strlen($_POST['lname'])<=5) {
        $lname = $_POST['lname'];
        //检测登录学号是否为标量,不是则跳转到注册界面
        if (is_numeric($_POST['lnumber'])) {
            $lnumber = $_POST['lnumber'];
        } else {
            echo "<script>alert('学号填写错误')</script>";
            echo "<script>location.href='register.php?jump=login'</script>";
        }
    } else {
        echo "<script>alert('用户名错误')</script>";
        echo "<script>location.href='register.php?jump=login'</script>";
    }
}

//对数据库进行对应参数匹配
if ($Db->query()) {
    //进行数据库校验查找用户，登录成功则跳转到首页
    foreach ($Db->data as $user) {
        if ($lname===$user['name'] && $lnumber===$user['number']) {
            $_SESSION['name'] = $lname;
            $_SESSION['id'] = $lnumber;
            setcookie(session_name(), session_id(), time()+86400);
            echo '<script>location.href="index.php"</script>';
        }
    }
    //数据库查找不到用户，进行相应提示并跳转到注册页面
    for ($x=0;$x<=count($Db->data);$x++) {
        if ($lname!==$Db->data['name']) {
            echo "<script>alert('您还没有账号，请先注册之后再登录！')</script>";
            echo "<script>location.href='register.php?jump=register'</script>";
        }
    }
}


/*搜索用户关键字展示*/
//通过表单获取搜索关键字
$keyword = $_GET['key'];
//如果关键字为空，则进行相应提示并跳转回首页
if ($keyword=="") {
    echo "<script>alert('请填写搜索内容')</script>";
    echo "<script>location.href='index.php'</script>";
}
//如果关键字不为空，则进行数据库校验查找用户，用过get表单链接传递从数据库查找出来的信息
foreach ($Db->data as $row) {
    if ($keyword === $row['name']) {
        $res2 = $Db->mysqli->query("SELECT info,face FROM 你的数据表 WHERE name='".$keyword."'");
        $search = $res2->fetch_all(MYSQLI_ASSOC);
        echo '<script>location.href="index.php?username='.$keyword.'&info='.$search[0]['info'].'&face='.$search[0]['face'].'"</script>';
    }
}
//校验数据库内，发现没有匹配用户，进行相应提示，并跳转回首页
for ($x=0;$x<=count($Db->data);$x++) {
    if ($keyword!==$Db->data['name']) {
        echo "<script>alert('用户不存在！')</script>";
        echo "<script>location.href='index.php'</script>";
    }
}
