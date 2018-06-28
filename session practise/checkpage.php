<?php
session_start();

error_reporting(E_ALL &~ E_NOTICE);
// if ($_COOKIE['username'] === 'zhangsan') {
//     echo '欢迎你，先生！';
// } else {
//     echo '无权限查看';
// }

if ($_SESSION['zhangsan'] === '12345678') {
    echo '晚上好，先生！';
} else {
    echo '无权限查看';
}
