<?php
session_start();
// setcookie('username', 'zhangsan', time()-1, '/');

$_SESSION['zhangsan']=null;
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>退出界面</title>
</head>
<body>
  <h1>你已退出</h1>
</body>
</html>
