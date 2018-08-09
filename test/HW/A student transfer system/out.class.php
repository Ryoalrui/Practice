<?php
header('content-type:text/html;charset=UTF-8');
//开启会话
session_start();
//注销当前登录账号
setcookie(session_name(), session_id(), time()-1);
$_SESSION['name']=null;
$_SESSION['id']=null;
//跳转首页
echo '<script>location.href="index.php"</script>';
