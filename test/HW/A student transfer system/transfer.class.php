<?php
//开启会话
session_start();

$Payee = $_POST['Payee'];//收款人ID
$money = $_POST['Amount'];//转账数额

//连接数据库
$mysqli = new mysqli('localhost', 'root', '你的密码', '你的数据库');
//设置字符集
$result = $mysqli->query('set names utf8');
//查找当前登录用户的现有金额
$sql = "select money from 你的数据表 where name='".$_SESSION['name']."'";
$data = $mysqli->query($sql);
$res = $data->fetch_all(MYSQLI_ASSOC);

//判断转账金额是否是整型数字
if (!is_numeric($money)) {
    //非整型数字则弹出提示，并跳转回首页
    echo "<script type='text/JavaScript'>alert('请好好转账，谢谢！');</script>";
    // echo "<script>location.href='index.php';</script>";
    die();
}
//判断当前登录用户金额是否足够转账
if ($res[0]['money'] <= $money) {
    //不够则弹出提示，并跳转回首页
    echo "<script type='text/JavaScript'>alert('金额不足，请重新调整转账金额!');</script>";
    echo "<script>location.href='index.php';</script>";
    die();
}
//开启事务处理
$mysqli->autocommit(false);
//执行sql语句
$sql1 = "update 你的数据表 set money = money+$money where id = $Payee";//收款人收钱
$mysqli->query($sql1);
$r1 = $mysqli->affected_rows;

$sql2 = "update 你的数据表 set money = money-$money where name ='".$_SESSION['name']."'";//发款人转钱
$mysqli->query($sql2);
$r2 = $mysqli->affected_rows;

//事务判断
if ($r1>0 && $r2>0) {
    /*转账成功，跳转到首页*/
    $mysqli->commit();//事物提交
    echo "<script type='text/JavaScript'>alert('转账成功!');</script>";
    echo "<script>location.href='index.php';</script>";
} else {
    /*转账失败，跳转回首页*/
    $mysqli->rollBack();//事物回滚
    echo "<script type='text/JavaScript'>alert('转账失败!');</script>";
    echo "<script>location.href='index.php';</script>";
}
