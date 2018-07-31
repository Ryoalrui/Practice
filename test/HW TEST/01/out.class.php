<!-- 执行退出页 -->
<?php
session_start();
// print_r($_SESSION);
function logout()
{
    setCookie('session_name()', 'session_id()', time()-1);
    $_SESSION['name']=null;
}
logout();
echo "<script>location.href='index.php'</script>";
