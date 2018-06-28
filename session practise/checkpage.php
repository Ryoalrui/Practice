<?php
session_start();
date_default_timezone_set('Asia/shanghai');
error_reporting(E_ALL &~ E_NOTICE);

$hour = date('H');

// if ($_COOKIE['username'] === 'zhangsan') {
//     echo '欢迎你，先生！';
// } else {
//     echo '无权限查看';
// }

if ($_SESSION['zhangsan'] === '12345678') {
    if ($hour>=6 && $hour<10) {
        echo '早上好，先生！';
    } elseif ($hour>=10 && $hour<=14) {
        echo '中午好，先生！';
    } elseif ($hour>14 && $hour<=18) {
        echo '下午好，先生！';
    } else {
        echo '晚上好，先生！';
    }
} else {
    $res = '无权限查看';
    echo $res;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>欢迎界面</title>
</head>
<body>
  <?php if ($res!='无权限查看') { ?>
    <button><a href="http://localhost/Demo/01/Session/%E5%8D%83%E5%B3%B0%E5%AE%9E%E4%BE%8B/logout.php" target="_self" style="text-decoration:none">退出</a></button>
  <?php } ?>
</body>
</html>
