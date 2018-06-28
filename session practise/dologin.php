<?php
session_start();

$username = $_POST['username'];
$pwd = $_POST['pwd'];

$c_name = 'zhangsan';
$c_pwd = '12345678';

if ($username === $c_name && $pwd === $c_pwd) {
    echo '登录成功';
    // setcookie('username', 'zhangsan', time()+60*5, '/');

    $_SESSION['zhangsan'] = '12345678';
} else {
    echo '用户密码登录错误';
}
