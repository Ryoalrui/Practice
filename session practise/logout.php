<?php
session_start();
// setcookie('username', 'zhangsan', time()-1, '/');

$_SESSION['zhangsan']=null;
session_destroy();
